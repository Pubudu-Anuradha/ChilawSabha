<?php

class LibraryMember extends Controller
{
  public function __construct()
  {
    $this->authenticateRole('LibraryMember');
  }

  public function index()
  {
    $user_id = $_SESSION['user_id'];
    $member_id = $this->model('LibraryMemberModel')->getMemberDetails($user_id)['member_id'];
    $membership_id = $this->model('LibraryMemberModel')->getMemberDetails($user_id)['membership_id'];
    $fav_comp_precedence = $this->model('LibraryMemberModel')->getFavCompPrecedence($member_id);
    $this->view('LibraryMember/index', 'Dashboard Library Member', [
      'books' => $this->model('BookModel')->getBorrowedBooks($user_id),
      'userStat' => $this->model('BookModel')->getUserDetails($membership_id),
      'newBooks' => $this->model('BookModel')->getNewBooks(),
      'sugBooks' => $this->model('BookModel')->getSuggestedBooks($fav_comp_precedence,$member_id),
    ], [
      'main', 
      'posts',
      'LibraryMember/libraryMember',
      'LibraryMember/dashboard',
      'Components/form',
      'Components/table',
      'Components/modal'
    ]);
  }

  public function getFine(){
    $response = $this->model('BookModel')->getFineDetails();
    $this->returnJSON([
      $response,
    ]);
  }

  public function bookRequest()
  {
    $model = $this->model('BookRequestModel');

        if (isset($_POST['Add'])) {

            [$valid, $err] = $this->validateInputs($_POST, [
                    'email|l[:255]|e',
                    'title|l[:255]',
                    'author|l[:255]',
                    'isbn|l[10:13]',
                    'reason|l[:255]',
                    ], 'Add');

            $data['errors'] = $err;

            $data = array_merge(count($err) > 0 ? ['errors' => $err] : ['Add' => $model->addBookRequest($valid)], $data);
            $this->view('LibraryMember/bookRequest', 'Book Request', $data, ['Components/form']);
        } 
        else {
            $this->view('LibraryMember/bookRequest', 'Book Request', styles:['Components/form']);
        }
  }

  public function bookCatalog($page = 'index', $id = null)
  {
    $user_id = $_SESSION['user_id'];
    $member_id = $this->model('LibraryMemberModel')->getMemberDetails($user_id)['member_id'];
    $model = $this->model('BookModel');
    $ptr = $this->model('PlanToReadModel');
    switch ($page){
      case 'favourite':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $model->addFavoriteBook($book_id, $member_id);
        $this->view('LibraryMember/bookCatalogue', 'Book Catalogue', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books'=>$model->getBooks(),
          'fav'=>$model->getFavoriteBooks($member_id),
          'comp'=>$model->getCompletedBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
        break;
      case 'completed':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $model->addCompletedBook($book_id, $member_id);
        $this->view('LibraryMember/bookCatalogue', 'Book Catalogue', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books'=>$model->getBooks(),
          'fav'=>$model->getFavoriteBooks($member_id),
          'comp'=>$model->getCompletedBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
        break;
      case 'planToRead':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $ptr = $this->model('PlanToReadModel');
        $ptr::addPlanToReadBook($book_id, $member_id);
        $this->planToReads();
        break;
      case 'unfav':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $model->removeFavBook($book_id, $member_id);
        $this->view('LibraryMember/bookCatalogue', 'Book Catalogue', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books'=>$model->getBooks(),
          'fav'=>$model->getFavoriteBooks($member_id),
          'comp'=>$model->getCompletedBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
        break;
      case 'nplanToRead':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $ptr = $this->model('PlanToReadModel');
        $ptr->removePlanToReadBook($book_id, $member_id);
        $this->planToReads();
        break;
      case 'incomplete':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $model->removeCompBook($book_id, $member_id);
        $this->view('LibraryMember/bookCatalogue', 'Book Catalogue', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books'=>$model->getBooks(),
          'fav'=>$model->getFavoriteBooks($member_id),
          'comp'=>$model->getCompletedBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
        break;
      default:
        $this->view('LibraryMember/bookCatalogue', 'Book Catalogue', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books'=>$model->getBooks(),
          'fav'=>$model->getFavoriteBooks($member_id),
          'comp'=>$model->getCompletedBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
    }
  }

  public function planToReads($page = 'index', $id = null)
  {
    $user_id = $_SESSION['user_id'];
    $member_id = $this->model('LibraryMemberModel')->getMemberDetails($user_id)['member_id'];
    $model = $this->model('PlanToReadModel');
    switch($page){
      case 'remove':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $model->removePlanToReadBook($book_id, $member_id);
        //adding to db
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
          unset($_SERVER['HTTP_X_REQUESTED_WITH']);
          $order = 1;
          foreach ($_POST as $val) {
            $model->updatePlanToReadBooks($order, $val);
            $order++;
          }
        } else {
          $book = $this->model('BookModel');
          $this->view('LibraryMember/planToRead', 'Plan to Read List', [
            'categories'=>$book->get_categories(),
            'sub_categories'=>$book->get_sub_categories(),
            'PlantoRead' => $model->getPlanToReadBooks($member_id),
            'fav'=>$book->getFavoriteBooks($member_id),
            'comp'=>$book->getCompletedBooks($member_id),
          ], [
            'main', 
            'posts',
            'LibraryMember/libraryMember',
            'Components/form',
            'Components/table'
          ]);
        }
        break;
      case 'completed':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $this->model('BookModel')->addCompletedBook($book_id, $member_id);
        //adding to db
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
          unset($_SERVER['HTTP_X_REQUESTED_WITH']);
          $order = 1;
          foreach ($_POST as $val) {
            $model->updatePlanToReadBooks($order, $val);
            $order++;
          }
        } else {
          $book=$this->model('BookModel');
          $this->view('LibraryMember/planToRead', 'Plan to Read List', [
            'categories'=>$book->get_categories(),
            'sub_categories'=>$book->get_sub_categories(),
            'PlantoRead' => $model->getPlanToReadBooks($member_id),
            'fav'=>$book->getFavoriteBooks($member_id),
            'comp'=>$book->getCompletedBooks($member_id),
          ], [
            'main', 
            'posts',
            'LibraryMember/libraryMember',
            'Components/form',
            'Components/table'
          ]);
        }
        break;
      case 'favourite':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $this->model('BookModel')->addFavoriteBook($book_id, $member_id);
        //adding to db
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
          unset($_SERVER['HTTP_X_REQUESTED_WITH']);
          $order = 1;
          foreach ($_POST as $val) {
            $model->updatePlanToReadBooks($order, $val);
            $order++;
          }
        } else {
          $book=$this->model('BookModel');
          $this->view('LibraryMember/planToRead', 'Plan to Read List', [
            'categories'=>$book->get_categories(),
            'sub_categories'=>$book->get_sub_categories(),
            'PlantoRead' => $model->getPlanToReadBooks($member_id),
            'fav'=>$book->getFavoriteBooks($member_id),
            'comp'=>$book->getCompletedBooks($member_id),
          ], [
            'main', 
            'posts',
            'LibraryMember/libraryMember',
            'Components/form',
            'Components/table'
          ]);
        }
        break;
      case 'incomplete':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $this->model('BookModel')->removeCompBook($book_id, $member_id);
        //adding to db
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
          unset($_SERVER['HTTP_X_REQUESTED_WITH']);
          $order = 1;
          foreach ($_POST as $val) {
            $model->updatePlanToReadBooks($order, $val);
            $order++;
          }
        } else {
          $book=$this->model('BookModel');
          $this->view('LibraryMember/planToRead', 'Plan to Read List', [
            'categories'=>$book->get_categories(),
            'sub_categories'=>$book->get_sub_categories(),
            'PlantoRead' => $model->getPlanToReadBooks($member_id),
            'fav'=>$book->getFavoriteBooks($member_id),
            'comp'=>$book->getCompletedBooks($member_id),
          ], [
            'main', 
            'posts',
            'LibraryMember/libraryMember',
            'Components/form',
            'Components/table'
          ]);
        }
        break;
      case 'removeFav':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $this->model('BookModel')->removeFavBook($book_id, $member_id);
        //adding to db
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
          unset($_SERVER['HTTP_X_REQUESTED_WITH']);
          $order = 1;
          foreach ($_POST as $val) {
            $model->updatePlanToReadBooks($order, $val);
            $order++;
          }
        } else {
          $book=$this->model('BookModel');
          $this->view('LibraryMember/planToRead', 'Plan to Read List', [
            'categories'=>$book->get_categories(),
            'sub_categories'=>$book->get_sub_categories(),
            'PlantoRead' => $model->getPlanToReadBooks($member_id),
            'fav'=>$book->getFavoriteBooks($member_id),
            'comp'=>$book->getCompletedBooks($member_id),
          ], [
            'main', 
            'posts',
            'LibraryMember/libraryMember',
            'Components/form',
            'Components/table'
          ]);
        }
        break;
      default:
        //adding to db
        $book = $this->model('BookModel');
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
          unset($_SERVER['HTTP_X_REQUESTED_WITH']);
          $order = 1;
          foreach ($_POST as $val) {
            $model->updatePlanToReadBooks($order, $val);
            $order++;
          }
        } else {
          $this->view('LibraryMember/planToRead', 'Plan to Read List', [
            'categories'=>$book->get_categories(),
            'sub_categories'=>$book->get_sub_categories(),
            'PlantoRead' => $model->getPlanToReadBooks($member_id),
            'fav'=>$book->getFavoriteBooks($member_id),
            'comp'=>$book->getCompletedBooks($member_id),
          ], [
            'main', 
            'posts',
            'LibraryMember/libraryMember',
            'Components/form',
            'Components/table'
          ]);
        }
    }
  }

  public function favourites($page = 'index', $id = null)
  {
    $user_id = $_SESSION['user_id'];
    $member_id = $this->model('LibraryMemberModel')->getMemberDetails($user_id)['member_id'];
    $model = $this->model('BookModel');
    switch($page){
      case 'remove':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $model->removeFavBook($book_id, $member_id);
        $ptr = $this->model('PlanToReadModel');
        $this->view('LibraryMember/favourite', 'Favourite List', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books'=>$model->getFavoriteBooks($member_id),
          'comp'=>$model->getCompletedBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
        break;
      case 'completed':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $model->addCompletedBook($book_id, $member_id);
        $ptr = $this->model('PlanToReadModel');
        $this->view('LibraryMember/favourite', 'Favourite List', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books'=>$model->getFavoriteBooks($member_id),
          'comp'=>$model->getCompletedBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
        break;
      case 'planToRead':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $ptr = $this->model('PlanToReadModel');
        $ptr::addPlanToReadBook($book_id, $member_id);
        $this->planToReads();
        break;
      case 'nplanToRead':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $ptr = $this->model('PlanToReadModel');
        $ptr->removePlanToReadBook($book_id, $member_id);
        $this->planToReads();
        break;
      case 'incomplete':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $model->removeCompBook($book_id, $member_id);
        $ptr = $this->model('PlanToReadModel');
        $this->view('LibraryMember/favourite', 'Favourite List', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books'=>$model->getFavoriteBooks($member_id),
          'comp'=>$model->getCompletedBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
        break;
      default:
        $ptr = $this->model('PlanToReadModel');
        $this->view('LibraryMember/favourite', 'Favourite List', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books'=>$model->getFavoriteBooks($member_id),
          'comp'=>$model->getCompletedBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
    }
  }

  public function completeds($page = 'index', $id = null)
  {
    $user_id = $_SESSION['user_id'];
    $member_id = $this->model('LibraryMemberModel')->getMemberDetails($user_id)['member_id'];
    $model = $this->model('BookModel');
    switch($page){
      case 'remove':
        $book_id = $this->model('BookModel')->getBookDetails($id)['result'][0]['book_id'];
        $model->removeCompBook($book_id, $member_id);
        $ptr = $this->model('PlanToReadModel');
        $this->view('LibraryMember/completed', 'Completed List', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books' => $model->getCompletedBooks($member_id),
          'fav'=>$model->getFavoriteBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
        break;
      default:
      $ptr = $this->model('PlanToReadModel');
        $this->view('LibraryMember/completed', 'Completed List', [
          'categories'=>$model->get_categories(),
          'sub_categories'=>$model->get_sub_categories(),
          'books' => $model->getCompletedBooks($member_id),
          'fav'=>$model->getFavoriteBooks($member_id),
          'ptr'=>$ptr->getPlanToReadBooks($member_id)
        ], [
          'main', 
          'posts',
          'LibraryMember/libraryMember',
          'Components/form',
          'Components/table'
        ]);
    }
  }
}
