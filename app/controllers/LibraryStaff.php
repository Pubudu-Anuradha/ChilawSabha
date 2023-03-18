<?php

class LibraryStaff extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('LibraryStaff');
    }

    public function index()
    {
        $model = $this->model('BookModel');
        // var_dump($_POST);

        if(isset($_POST['search-btn'])){
          $search = $_POST['search'];
          preg_match('/\d+/',$search,$match);
          // var_dump($match);
          $searchKey = $match[0] ?? null;
          if($searchKey == null){
            $searchKey = $search;
          }
          // var_dump($searchKey);
          $this->view('LibraryStaff/index','Chilaw Pradeshiya Sabha',['userStat' => $model->getUserDetails($searchKey)], styles:['Components/table', 'Components/form', 'Components/modal', 'LibraryStaff/index']);

        }else{
          $reqJSON = file_get_contents('php://input');
          if($reqJSON){
              // var_dump($reqJSON);

              $reqJSON = json_decode($reqJSON, associative:true);
              if($reqJSON){
                  $response = $model->searchUser($reqJSON);

                  $this->returnJSON([
                      $response['result'],
                  ]);
              die();
              }
              else $this->returnJSON([
                  'error'=>'Error Parsing JSON'
              ]);
          }
        }


        $this->view('LibraryStaff/index','Chilaw Pradeshiya Sabha', styles:['Components/table', 'Components/form', 'Components/modal', 'LibraryStaff/index']);
    }

    public function analytics()
    {
        $model = $this->model('LibraryStatModel');

        $reqJSON = file_get_contents('php://input');

        if ($reqJSON) {

            $reqJSON = json_decode($reqJSON, associative:true);

            if ($reqJSON) {
                $response = $model->getBorrowStat($reqJSON);

                $this->returnJSON([
                    $response['result'],
                ]);
                die();
            } else {
                $this->returnJSON([
                    'error' => 'Error Parsing JSON',
                ]);
            }

        }

        $this->view('LibraryStaff/Analytics', styles:['LibraryStaff/index', 'LibraryStaff/analytics', 'Components/form']);
    }

    public function bookcatalog()
    {
        $model = $this->model('BookModel');

        if(isset($_GET['lost_description'])){
        // var_dump($_GET);
        }

        if (isset($_GET['confirm'])) {
            $error = false;
            if ($_GET['lost_description'] != null && $_GET['accession_no'] != null) {
                [$valid, $err] = $this->validateInputs($_GET, [
                    'accession_no|i[0:]',
                    'lost_description|l[:255]',
                    'url',
                    'search|?',
                    'category_name',
                    'page|?',
                    'size'
                ], 'confirm');
                // var_dump($err);
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_GET['accession_no'], 4, $valid) == false) {
                        $_GET['accession_no'] = null;
                        $_GET['lost_description'] = null;
                        $error = true;
                    }
                }

            }
            $this->view('LibraryStaff/Bookcatalog', 'Book Catalogue', [
                'Lost' => ($_GET['lost_description'] != null && $_GET['accession_no'] != null) ?
                $model->getBookbyID($_GET['accession_no']) : false,
                'lost_error' => $error,
                'Books' => $model->getBooks(),
            ], ['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        } else {
            $this->view('LibraryStaff/Bookcatalog', 'Book Catalogue', ['Books' => $model->getBooks()], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);

        }

        // $this->view('LibraryStaff/Bookcatalog', 'Book Catalogue',['Books' =>$model->getBooks()],styles:['LibraryStaff/index', 'Components/table','posts','Components/modal']);
    }

    public function bookrequest()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Bookrequest', styles:['LibraryStaff/index', 'Components/table']);
    }

    public function lostbooks()
    {
        $model = $this->model('BookModel');

        $this->view('LibraryStaff/Lostbooks', 'Lost Books', ['Books' => $model->getBooks([4])], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);

    }

    public function delistedbooks()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Delistedbooks', styles:['LibraryStaff/index', 'Components/table']);
    }

    public function damagedbooks()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Damagedbooks', styles:['LibraryStaff/index', 'Components/table']);
    }

    public function users()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Users', styles:['LibraryStaff/index', 'Components/table']);
    }

    public function disabledusers()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Disabledusers', styles:['LibraryStaff/index', 'Components/table']);
    }

    public function addusers()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Addusers', styles:['LibraryStaff/index', 'Components/form']);
    }

    public function addbooks()
    {
        $model = $this->model('BookModel');

        $data = ['categories' => $model->get_categories()['result'],'subcategories' => $model->get_sub_categories()['result']];

        if (isset($_POST['Add'])) {
            //select only return subcategory id.
            $_POST['category_code'] = $model->getCategoryCode($_POST['sub_category_code'])['result'][0]["category_id"];

            [$valid, $err] = $this->validateInputs($_POST, [
                    'title|l[:255]',
                    'author|l[:255]',
                    'publisher|l[:255]',
                    'place_of_publication|l[:255]',
                    'date_of_publication',
                    'category_code',
                    'sub_category_code',
                    'accession_no|i[0:]',
                    'price|d[0:]',
                    'pages|i[1:]',
                    'recieved_date',
                    'isbn|l[:50]',
                    'recieved_method|l[:255]',
                    ],
                'Add');
            $data['errors'] = $err;

            $data['old'] = $_POST;
            $data = array_merge(count($err) > 0 ? ['errors' => $err] : ['Add' => $model->addbook($valid)], $data);
            $this->view('LibraryStaff/Addbooks', 'Add New Book', $data, ['LibraryStaff/index', 'Components/form']);
        } else {
            $this->view('LibraryStaff/Addbooks', 'Add New Book',$data, styles:['LibraryStaff/index', 'Components/form']);
        }
    }

    public function editbooks($id = null)
    {
        $model = $this->model('BookModel');

        if(isset($_POST['Edit'])){
            [$valid, $err] = $this->validateInputs($_POST, [
                        'title|l[:255]',
                        'author|l[:255]',
                        'publisher|l[:255]',
                        'place_of_publication|l[:255]',
                        'date_of_publication',
                        'price|d[0:]',
                        'pages|i[1:]',
                        'recieved_date',
                        'isbn|l[:50]',
                        'recieved_method|l[:255]',
            ], 'Edit');

            $this->view('LibraryStaff/Editbooks', 'Edit Book', ['edit' =>  count($err) == 0 ? $model->editBook($id, $valid) : null,
            'books' => $id != null ? $model->getBookbyID($id) : false, 'errors' => $err], ['LibraryStaff/index', 'Components/form']);
        }else{
            $this->view('LibraryStaff/Editbooks', 'Edit Book', ['books' => $id != null ? $model->getBookbyID($id) : false], ['LibraryStaff/index', 'Components/form']);
        }

    }

    public function editusers()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Editusers', styles:['LibraryStaff/index', 'Components/form']);
    }
        
    public function booktransactions()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Booktransactions', styles:['LibraryStaff/index']);
    }
        
    public function finance()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Finance', styles:['LibraryStaff/index']);
    }
        
    public function userreport()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Userreport', styles:['LibraryStaff/index']);
    }
}
