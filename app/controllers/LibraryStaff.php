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
        if(isset($_POST['search-btn'])){
          $search = $_POST['search'];
          preg_match('/\d+/',$search,$match);
          $searchKey = $match[0] ?? null;
          if($searchKey == null){
            $searchKey = $search;
          }
          $this->view('LibraryStaff/index','Chilaw Pradeshiya Sabha',['userStat' => $model->getUserDetails($searchKey)], styles:['Components/table', 'Components/form', 'Components/modal', 'LibraryStaff/index']);
        }

        else if(isset($_POST['confirm'])){
            //to check if user searched before
            $search = $_POST['search'];
            preg_match('/\d+/', $search, $match);
            $searchKey = $match[0] ?? null;
            if ($searchKey == null) {
                $searchKey = $search;
            }

            $userStat = $model->getUserDetails($searchKey);
            // var_dump($_POST);

            //for lending
            if(!isset($userStat['result'][0]['due_date']) || isset($userStat['result'][0]['recieved_date'])){

                //get member ID
                $memberID = $userStat['result'][0]['member_id'];
                $_POST['memberID'] = $memberID;
                //to get bookIDs of books
                preg_match('/\d+/', $_POST['acc1'], $matchacc1);
                $acc1 = $matchacc1[0] ?? null;
                if($acc1){
                    $acc1BookId = $model->getBookbyID($acc1)['result'][0]['book_id'];
                    $_POST['acc1BookId'] = $acc1BookId;
                }

                preg_match('/\d+/', $_POST['acc2'], $matchacc2);
                $acc2 = $matchacc2[0] ?? null;
                if($acc2){
                    $acc2BookId = $model->getBookbyID($acc2)['result'][0]['book_id'];
                    $_POST['acc2BookId'] = $acc2BookId;
                }

                $error = false;
                [$valid, $err] = $this->validateInputs($_POST, [
                        'memberID|i[0:]',
                        'acc1BookId|i[0:]',
                        'acc2BookId|i[0:]',
                        'search-btn|?',
                        'acc1|l[:150]',
                        'acc2|l[:150]',
                        'search|l[:150]|?',
                    ], 'confirm');
                    $data['errors'] = $err;
                    if(count($err) == 0){
                            $result = $model->lendBook($_POST['memberID'], $_POST['acc1BookId'], $_POST['acc2BookId']);
                            if($result){
                                if ($result[0]['error']==true || $result[1]['error']==true) {
                                    $_POST['memberID'] = null;
                                    $_POST['acc1BookId'] = null;
                                    $_POST['acc2BookId'] = null;
                                    $error = true;
                                }
                            }
                    }
                $this->view('LibraryStaff/index', 'Chilaw Pradeshiya Sabha', ['userStat' => $model->getUserDetails($searchKey), 'lend_error' => $error], styles:['Components/table', 'Components/form', 'Components/modal', 'LibraryStaff/index']);
            }

            //for extending and recieving
            else if(isset($userStat['result'][0]['due_date']) && !isset($userStat['result'][0]['recieved_date'])){
                //extend function

                if(!isset($_POST['recieveFlag'])){
                    $model->extendDueDate($userStat['result']);
                }
                //recieve related funtion
                else if(isset($_POST['recieveFlag'])){
                    $_POST['recievedcheck1'] = boolval($_POST['recievedcheck1'] ?? false) ? 1 : 0;
                    $_POST['recievedcheck2'] = boolval($_POST['recievedcheck2'] ?? false) ? 1 : 0;
                    $_POST['damagedcheck1'] = boolval($_POST['damagedcheck1'] ?? false) ? 1 : 0;
                    $_POST['damagedcheck2'] = boolval($_POST['damagedcheck2'] ?? false) ? 1 : 0;
                    $_POST['recieveFlag'] = intval($_POST['recieveFlag']);
                    $_POST['memberID'] = $userStat['result'][0]['member_id'];

                    $acc1BookId = $model->getBookbyID(intval($userStat['result'][0]['accession_no']))['result'][0]['book_id'];
                    $_POST['acc1BookId'] = $acc1BookId;
                    $acc2BookId = $model->getBookbyID(intval($userStat['result'][1]['accession_no']))['result'][0]['book_id'];
                    $_POST['acc2BookId'] = $acc2BookId;


                    $error = false;
                    [$valid, $err] = $this->validateInputs($_POST, [
                        'recievedcheck1|i[0:1]',
                        'recievedcheck2|i[0:1]',
                        'damagedcheck1|i[0:1]',
                        'damagedcheck2|i[0:1]',
                        'search-btn|?',
                        'memberID|i[0:]',
                        'acc1|?',
                        'acc2|?',
                        'acc1BookId|i[0:]',
                        'acc2BookId|i[0:]',
                        'recieveFlag|i[0:]',
                        'search|l[:150]|?',
                    ], 'confirm');
                    $data['errors'] = $err;
                    if(count($err) == 0){

                        $result = $model->recieveBook($valid);
                        if($result){
                            if($result[0]['error']==true || $result[1]['error']==true){
                                $_POST['memberID'] = null;
                                $_POST['acc1BookId'] = null;
                                $_POST['acc2BookId'] = null;
                                $_POST['recieveFlag'] = null;
                                $error=true;
                            }
                        }
                        $this->view('LibraryStaff/index', 'Chilaw Pradeshiya Sabha',
                        ['userStat' => $model->getUserDetails($searchKey),
                        'recieveError' => $error],
                        styles:['Components/table', 'Components/form', 'Components/modal', 'LibraryStaff/index']);
                    }
                }

                $this->view('LibraryStaff/index', 'Chilaw Pradeshiya Sabha', ['userStat' => $model->getUserDetails($searchKey)], styles:['Components/table', 'Components/form', 'Components/modal', 'LibraryStaff/index']);

            }
        }

        else{
            $reqJSON = file_get_contents('php://input');
            if($reqJSON){
                $reqJSON = json_decode($reqJSON, associative:true);

                if($reqJSON && ($reqJSON['searchID'] == 'bookSearch')){
                    $response = $model->getBookbyID($reqJSON['value']);
                    if(isset($response['result'][0])){
                        $this->returnJSON([
                            $response['result'][0]['title'],
                            $response['result'][0]['state'],
                        ]);
                    }else{
                        $this->returnJSON([
                            'error' => 'No Data Found',
                        ]);
                    }
                    die();
                }
                else if($reqJSON && ($reqJSON['searchID'] == 'userSearch')){
                    $response = $model->searchUser($reqJSON['value']);
                    $this->returnJSON([
                        $response['result'],
                    ]);
                    die();
                }
                else if($reqJSON && ($reqJSON['searchID'] == 'countPlanToRead')){
                    $response = $model->countPlanToRead($reqJSON['value1'],$reqJSON['value2']);
                    $this->returnJSON([
                        $response,
                    ]);
                    die();
                }
                else if($reqJSON && ($reqJSON['searchID'] == 'extendedCount')){
                    $response['extendCount'] = $model->getExtendedCount($reqJSON['value1'],$reqJSON['value2']);
                    $response['planToReadCount']  = $model->countPlanToRead($reqJSON['value1'],$reqJSON['value2']);
                    $this->returnJSON([
                        $response,
                    ]);
                    die();
                }
                else if($reqJSON && ($reqJSON['searchID'] == 'fineInfo')){
                    $response = $model->getFineDetails();
                    $this->returnJSON([
                        $response,
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
                if(isset($reqJSON['range'])){
                    $response = $model->getBorrowStat($reqJSON);
                }
                else if(isset($reqJSON['fromDate']) && isset($reqJSON['toDate'])){
                    $response = $model->getCustomBorrowStat($reqJSON);
                }

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

        $this->view('LibraryStaff/Analytics', styles:['LibraryStaff/index', 'LibraryStaff/analytics','Components/modal','Components/table']);
    }

    public function bookcatalog()
    {
        $model = $this->model('BookModel');

        if (isset($_GET['confirm'])) {
            $error = false;
            if ($_GET['lost_description'] != null && $_GET['lost_accession_no'] != null) {
              $_GET['lost_accession_no'] = intval($_GET['lost_accession_no']);
                [$valid, $err] = $this->validateInputs($_GET, [
                    'lost_accession_no|i[0:]',
                    'lost_description|l[:255]',
                    'url',
                    'search|?',
                    'category_name',
                    'page|?',
                    'size',
                    'delist_description|?',
                    'delist_accession_no|?'
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_GET['lost_accession_no'], 4, $valid) == false) {
                        $_GET['lost_accession_no'] = null;
                        $_GET['lost_description'] = null;
                        $error = true;
                    }
                }
            }
            else if ($_GET['delist_description'] != null && $_GET['delist_accession_no'] != null) {
              $_GET['delist_accession_no'] = intval($_GET['delist_accession_no']);
                [$valid, $err] = $this->validateInputs($_GET, [
                    'delist_accession_no|i[0:]',
                    'delist_description|l[:255]',
                    'url',
                    'search|?',
                    'category_name',
                    'page|?',
                    'size',
                    'lost_description|?',
                    'lost_accession_no|?'
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_GET['delist_accession_no'], 3, $valid) == false) {
                        $_GET['delist_accession_no'] = null;
                        $_GET['delist_description'] = null;
                        $error = true;
                    }
                }
            }
            $this->view('LibraryStaff/Bookcatalog', 'Book Catalogue', [
                'Lost' => ($_GET['lost_description'] != null && $_GET['lost_accession_no'] != null) ?
                $model->getBookbyID($_GET['lost_accession_no']) : false,
                'lost_error' => $error,

                'Delist' => ($_GET['delist_description'] != null && $_GET['delist_accession_no'] != null) ?
                $model->getBookbyID($_GET['delist_accession_no']) : false,
                'delist_error' => $error,

                'Books' => $model->getBooks(), 'Category' => $model->get_categories()
            ], ['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        } else {
            $this->view('LibraryStaff/Bookcatalog', 'Book Catalogue', ['Books' => $model->getBooks(),'Category' => $model->get_categories()], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);

        }
    }

    public function bookrequest()
    {
        $model = $this->model('BookModel');

        //if rejected
        if(isset($_GET['confirm'])){
            $error = false;
                $_GET['request_id'] = intval($_GET['confirm']);
                [$valid, $err] = $this->validateInputs($_GET, [
                    'request_id|i[0:]',
                    'url',
                    'search|?',
                    'page|?',
                    'size',
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeBookRequestState($_GET['request_id'], 3) == false) {
                        $_GET['request_id'] = null;
                        $error = true;
                    }
                }

            $this->view('LibraryStaff/Bookrequest', 'Book Requests', [
                'book_request_error' => $error,
                'BookRequest' => $model->getBookRequests(),
            ], ['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        }
        else{
            $this->view('LibraryStaff/Bookrequest','Book Requests',['BookRequest' => $model->getBookRequests()], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        }

    }

    public function lostbooks()
    {
        $model = $this->model('BookModel');

        if(isset($_GET['confirm'])){
            $error = false;
            if ($_GET['found_description'] != null && $_GET['found_accession_no'] != null) {
                $_GET['type'] = 'found';
                $_GET['found_accession_no'] = intval($_GET['found_accession_no']);
                [$valid, $err] = $this->validateInputs($_GET, [
                    'found_accession_no|i[0:]',
                    'found_description|l[:255]',
                    'url',
                    'search|?',
                    'category_name',
                    'page|?',
                    'size',
                    'type|l[5:5]'
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_GET['found_accession_no'], 1, $valid) == false) {
                        $_GET['found_accession_no'] = null;
                        $_GET['found_description'] = null;
                        $error = true;
                    }
                }
            }

            $this->view('LibraryStaff/Lostbooks', 'Lost Books', [
                'Lost' => ($_GET['found_description'] != null && $_GET['found_accession_no'] != null) ?
                $model->getBookbyID($_GET['found_accession_no']) : false,
                'found_error' => $error,
                'Books' => $model->getBooks([4]), 'Category' => $model->get_categories()
            ], ['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        }
        else{
            $this->view('LibraryStaff/Lostbooks', 'Lost Books', ['Books' => $model->getBooks([4]),'Category' => $model->get_categories()], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        }
    }

    public function delistedbooks()
    {
        $model = $this->model('BookModel');

        $this->view('LibraryStaff/Delistedbooks','De-Listed Books', ['Books' => $model->getBooks([3]),'Category' => $model->get_categories()], styles:['LibraryStaff/index', 'Components/table','posts']);
    }

    public function damagedbooks()
    {
        $model = $this->model('BookModel');

        if(isset($_GET['confirm'])){
            $error = false;
            if ($_GET['recondition_description'] != null && $_GET['recondition_accession_no'] != null) {
                $_GET['type'] = 'conditioned';
                $_GET['recondition_accession_no'] = intval($_GET['recondition_accession_no']);
                [$valid, $err] = $this->validateInputs($_GET, [
                    'recondition_accession_no|i[0:]',
                    'recondition_description|l[:255]',
                    'url',
                    'search|?',
                    'category_name',
                    'page|?',
                    'size',
                    'type|l[11:11]'
                ], 'confirm');
                var_dump($err);
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_GET['recondition_accession_no'], 1, $valid) == false) {
                        $_GET['recondition_accession_no'] = null;
                        $_GET['recondition_description'] = null;
                        $error = true;
                    }
                }
            }

            $this->view('LibraryStaff/Damagedbooks', 'Damaged Books', [
                'Lost' => ($_GET['recondition_description'] != null && $_GET['recondition_accession_no'] != null) ?
                $model->getBookbyID($_GET['recondition_accession_no']) : false,
                'recondition_error' => $error,
                'Books' => $model->getBooks([5]),'Category' => $model->get_categories()
            ], ['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        }
        else{
          $this->view('LibraryStaff/Damagedbooks','Damaged Books', ['Books' => $model->getBooks([5]),'Category' => $model->get_categories()], styles:['LibraryStaff/index', 'Components/table','posts', 'Components/modal']);
        }
    }

    public function users()
    {
        $model = $this->model('LibraryUserManageModel');

        if (isset($_GET['confirm'])) {
            $error = false;
            if ($_GET['disable_description'] != null && $_GET['disabled_member_ID'] != null) {
              $_GET['disabled_member_ID'] = intval($_GET['disabled_member_ID']);
              $_GET['member_id'] = $model->getUserbyID($_GET['disabled_member_ID'])['result'][0]['member_id'] ?? false;
              $_GET['user_id'] = $model->getUserbyID($_GET['disabled_member_ID'])['result'][0]['user_id'] ?? false;

                [$valid, $err] = $this->validateInputs($_GET, [
                    'disabled_member_ID|i[0:]',
                    'member_id|i[0:]',
                    'user_id|i[0:]',
                    'disable_description|l[:255]',
                    'url',
                    'search|?',
                    'page|?',
                    'size',
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_GET['member_id'], 2, $valid) == false) {
                        $_GET['disabled_member_ID'] = null;
                        $_GET['member_id'] = null;
                        $_GET['disable_description'] = null;
                        $error = true;
                    }
                }
                $this->view('LibraryStaff/Users', 'Library User Management', ['Disabled' => ($_GET['disable_description'] != null && $_GET['disabled_member_ID'] != null) ?
                    $model->getUserbyID($_GET['disabled_member_ID']) : false, 'disable_error' => $error, 'Users' => $model->getUsers()],
                    styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);

            }
            else{
                $this->view('LibraryStaff/Users', 'Library User Management', ['Users' => $model->getUsers()], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
            }
        }
        else{
            $this->view('LibraryStaff/Users','Library User Management', ['Users'=> $model->getUsers()], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        }
    }

    public function disabledusers()
    {
        $model = $this->model('LibraryUserManageModel');

        if (isset($_GET['confirm'])) {
            $error = false;
            if ($_GET['enable_description'] != null && $_GET['enabled_member_ID'] != null) {
              $_GET['enabled_member_ID'] = intval($_GET['enabled_member_ID']);
              $_GET['member_id'] = $model->getUserbyID($_GET['enabled_member_ID'])['result'][0]['member_id'] ?? false;
              $_GET['user_id'] = $model->getUserbyID($_GET['enabled_member_ID'])['result'][0]['user_id'] ?? false;

                [$valid, $err] = $this->validateInputs($_GET, [
                    'enabled_member_ID|i[0:]',
                    'member_id|i[0:]',
                    'user_id|i[0:]',
                    'enable_description|l[:255]',
                    'url',
                    'search|?',
                    'page|?',
                    'size',
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_GET['member_id'], 1, $valid) == false) {
                        $_GET['enabled_member_ID'] = null;
                        $_GET['member_id'] = null;
                        $_GET['enable_description'] = null;
                        $error = true;
                    }
                }

                $this->view('LibraryStaff/Disabledusers', 'Disabled Library Users', ['Enabled' => ($_GET['enable_description'] != null && $_GET['enabled_member_ID'] != null) ?
                    $model->getUserbyID($_GET['enabled_member_ID']) : false, 'enable_error' => $error, 'Users' => $model->getUsers(2)],
                    styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);

            }
            else{
                $this->view('LibraryStaff/Disabledusers', 'Disabled Library Users', ['Users' => $model->getUsers(2)], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
            }
        }

        else{
            $this->view('LibraryStaff/Disabledusers', 'Disabled Library Users', ['Users' => $model->getUsers(2)], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        }
    }

    public function addusers()
    {
        $model = $this->model('LibraryUserManageModel');

        if (isset($_POST['Add'])) {

            $_POST['membership_id'] = intval($_POST['membership_id']);

            [$valid, $err] = $this->validateInputs($_POST, [
                    'membership_id|i[0:]',
                    'email|l[:255]|e|u[users]',
                    'name|l[:255]',
                    'password|l[5:]',
                    'address|l[:255]',
                    'contact_no|l[10:12]',
                    'nic|l[10:12]',
                    ], 'Add');

            $data['errors'] = $err;

            $data = array_merge(count($err) > 0 ? ['errors' => $err] : ['Add' => $model->addLibraryUser($valid)], $data);
            $this->view('LibraryStaff/Addusers', 'Add New Library User', $data, ['LibraryStaff/index', 'Components/form']);
        } 
        else {
            $this->view('LibraryStaff/Addusers', 'Add New Library User', styles:['LibraryStaff/index', 'Components/form']);
        }
    }

    public function addbooks($requestID=null)
    {
        $model = $this->model('BookModel');

        $data = ['categories' => $model->get_categories()['result'],'subcategories' => $model->get_sub_categories()['result']];

        if($requestID){
            $data['reqInfo'] =  $model->getBookRequestByID($requestID);
            $reqEmail = $data['reqInfo']['result'][0]['email'];
            $reqTitle = $data['reqInfo']['result'][0]['title'];
        }

        if (isset($_POST['Add'])) {

            //if sub catergory selected
            if(is_numeric($_POST['category'])){
              $_POST['category_code'] = $model->getCategoryCode($_POST['category'],'Sub')['result'][0]["category_id"];
              $_POST['sub_category_code'] = $_POST['category'];
              unset($_POST['category']);
            }
            else{
              $_POST['category_code'] = $model->getCategoryCode($_POST['category'],'Main')['result'][0]["category_id"];
              unset($_POST['category']);
            }

            [$valid, $err] = $this->validateInputs($_POST, [
                    'title|l[:255]',
                    'author|l[:255]',
                    'publisher|l[:255]',
                    'place_of_publication|l[:255]',
                    'date_of_publication',
                    'category_code',
                    'sub_category_code|?',
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

            //to send a mail if this is a book requested by an user
            if($data['Add']['success'] == true && $reqEmail && $reqTitle){
                $model->changeBookRequestState($requestID, 2);
                Email::send($reqEmail,'Book Request Added',"Book Request for Book Titled $reqTitle has been added to the library.");
            }
            $this->view('LibraryStaff/Addbooks', 'Add New Book', $data, ['LibraryStaff/index', 'Components/form']);
        } else {
            $this->view('LibraryStaff/Addbooks', 'Add New Book',$data, styles:['LibraryStaff/index', 'Components/form']);
        }
    }

    public function editbooks($id = null)
    {
        $model = $this->model('BookModel');

        if(isset($_POST['Edit'])){
            //if mark damage ticked
          if(isset($_POST['mark_damaged'])){
            $model->changeState($id,5,["damaged_description" =>"Damged in Library"]);
            $this->view('LibraryStaff/Bookcatalog', 'Book Catalogue', ['Books' => $model->getBooks()], ['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
          }
          else{
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
                        'recieved_method|l[:255]'
            ], 'Edit');
              $this->view('LibraryStaff/Editbooks', 'Edit Book', ['edit' =>  count($err) == 0 ? $model->editBook($id, $valid) : null,
              'books' => $id != null ? $model->getBookbyID($id) : false, 'errors' => $err], ['LibraryStaff/index', 'Components/form']);
          }

        }else{
            $this->view('LibraryStaff/Editbooks', 'Edit Book', ['books' => $id != null ? $model->getBookbyID($id) : false], ['LibraryStaff/index', 'Components/form']);
        }

    }

    public function editusers($id = null)
    {
        $model = $this->model('LibraryUserManageModel');

        if(isset($_POST['Edit'])){

            $_POST['user_id'] = $model->getUserbyID($id)['result'][0]['user_id'] ?? false;

            [$valid, $err] = $this->validateInputs($_POST, [
                    'user_id|i[0:]',
                    'email|l[:255]|e',
                    'name|l[:255]',
                    'address|l[:255]',
                    'contact_no|l[10:12]',
            ], 'Edit');
              $this->view('LibraryStaff/Editusers', 'Edit Library User', ['edit' =>  count($err) == 0 ? $model->editLibraryUser($_POST['user_id'], $valid) : null,
              'Users' => $id != null ? $model->getUserbyID($id) : false, 'errors' => $err], ['LibraryStaff/index', 'Components/form']);

        }else{
            $this->view('LibraryStaff/Editusers', 'Edit Library User', ['Users' => $id != null ? $model->getUserbyID($id) : false], ['LibraryStaff/index', 'Components/form']);
        }
    }

    public function booktransactions()
    {
        $model = $this->model('BookModel');
        $this->view('LibraryStaff/Booktransactions', 'Book Transactions', ['Books' => $model->getBookTransactions()], styles:['LibraryStaff/index', 'Components/table','Components/modal','posts']);

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
