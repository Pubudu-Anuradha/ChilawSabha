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
                    //only allow extending at the due date for 3 times max
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
                            $response['result'][0]['author'],
                            $response['result'][0]['accession_no'],
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
                    'delist_accession_no|?',
                    'damage_accession_no|?',
                    'damage_description|?'
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
                    'lost_accession_no|?',
                    'damage_accession_no|?',
                    'damage_description|?'
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
            else if ($_GET['damage_description'] != null && $_GET['damage_accession_no'] != null) {
              $_GET['damage_accession_no'] = intval($_GET['damage_accession_no']);
                [$valid, $err] = $this->validateInputs($_GET, [
                    'damage_accession_no|i[0:]',
                    'damage_description|l[:255]',
                    'url',
                    'search|?',
                    'category_name',
                    'page|?',
                    'size',
                    'lost_description|?',
                    'lost_accession_no|?',
                    'delist_description|?',
                    'delist_accession_no|?',
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_GET['damage_accession_no'], 5, $valid) == false) {
                        $_GET['damage_accession_no'] = null;
                        $_GET['damage_description'] = null;
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

                'Damaged' => ($_GET['damage_description'] != null && $_GET['damage_accession_no'] != null) ?
                $model->getBookbyID($_GET['damage_accession_no']) : false,
                'damage_error' => $error,

                'Books' => $model->getBooks(), 'Category' => $model->get_categories(), 'SubCategory' => $model->get_sub_categories()
            ], ['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        } else {
            $this->view('LibraryStaff/Bookcatalog', 'Book Catalogue', ['Books' => $model->getBooks(),'Category' => $model->get_categories(), 'SubCategory' => $model->get_sub_categories()], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);

        }
    }

    public function bookrequest()
    {
        $model = $this->model('BookRequestModel');

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
                'Found' => ($_GET['found_description'] != null && $_GET['found_accession_no'] != null) ?
                $model->getBookbyID($_GET['found_accession_no']) : false,
                'found_error' => $error,
                'Books' => $model->getBooks([4]), 'Category' => $model->get_categories(), 'SubCategory' => $model->get_sub_categories()
            ], ['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        }
        else{
            $this->view('LibraryStaff/Lostbooks', 'Lost Books', ['Books' => $model->getBooks([4]),'Category' => $model->get_categories(), 'SubCategory' => $model->get_sub_categories()], styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        }
    }

    public function delistedbooks()
    {
        $model = $this->model('BookModel');

        $this->view('LibraryStaff/Delistedbooks','De-Listed Books', ['Books' => $model->getBooks([3]),'Category' => $model->get_categories(), 'SubCategory' => $model->get_sub_categories()], styles:['LibraryStaff/index', 'Components/table','posts']);
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
                'Reconditioned' => ($_GET['recondition_description'] != null && $_GET['recondition_accession_no'] != null) ?
                $model->getBookbyID($_GET['recondition_accession_no']) : false,
                'recondition_error' => $error,
                'Books' => $model->getBooks([5]),'Category' => $model->get_categories(), 'SubCategory' => $model->get_sub_categories()
            ], ['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal']);
        }
        else{
          $this->view('LibraryStaff/Damagedbooks','Damaged Books', ['Books' => $model->getBooks([5]),'Category' => $model->get_categories(), 'SubCategory' => $model->get_sub_categories()], styles:['LibraryStaff/index', 'Components/table','posts', 'Components/modal']);
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
                    'password|l[8:15]',
                    'address|l[:255]',
                    'contact_no|l[10:12]'
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
        $Requestmodel = $this->model('BookRequestModel');

        $data = ['categories' => $model->get_categories()['result'],'subcategories' => $model->get_sub_categories()['result']];

        if($requestID){
            $data['reqInfo'] =  $Requestmodel->getBookRequestByID($requestID);
            $reqEmail = $data['reqInfo']['result'][0]['email'];
            $reqTitle = $data['reqInfo']['result'][0]['title'];
        }

        if (isset($_POST['Add'])) {
var_dump($_POST);
            $_POST['sub_category_code'] = $model->getCategoryCode($_POST['subcategory'])['result'][0]["sub_category_code"];
            unset($_POST['subcategory']);
            unset($_POST['category']);

            [$valid, $err] = $this->validateInputs($_POST, [
                    'title|l[:255]',
                    'author|l[:255]',
                    'publisher|l[:255]',
                    'place_of_publication|l[:255]',
                    'date_of_publication',
                    'sub_category_code|i[0:]',
                    'accession_no|i[0:]',
                    'price|d[0:]',
                    'pages|i[1:]',
                    'recieved_date',
                    'isbn|l[10:13]',
                    'recieved_method|l[:255]',
                    ],
                'Add');
            $data['errors'] = $err;

            $data['old'] = $_POST;
            $data = array_merge(count($err) > 0 ? ['errors' => $err] : ['Add' => $model->addbook($valid)], $data);

            //to send a mail if this is a book requested by an user
            if($data['Add']['success'] == true && $reqEmail && $reqTitle){
                $Requestmodel->changeBookRequestState($requestID, 2);
                $emailContent = "<div class=\"main-container\" style=\"margin: 0; padding: 0; box-sizing: border-box; font-family: poppins; background-color: #ffffff;\">";
                $emailContent .= "<div class='reset-content-div' style=\"margin: 5rem auto; padding: 2rem 2rem; width: 40rem; display:block; justify-content: center; align-items: center; border: 1px solid #93B4F2; background-color: #F0F5FE; border-radius: 1rem;\">";
                $emailContent .= "<h1 style=\"font-size: 2rem; font-weight: 700; color: #000000; margin-bottom: 2rem;\">Book Request Status</h1><p style=\"font-size: 1.2rem; font-weight: 500; color: #000000;\">
                 Your request for the book titled $reqTitle has been successfully added to the library’s collection.</p><p style=\"font-size: 1.2rem; font-weight: 500; color: #000000;\">
                 You are welcome to visit the library and read the book at your convenience.</p>
                 <p style=\"font-size: 1.2rem; font-weight: 500; color: #000000;\">Thanks You,<br/>
                 Chilaw Pradeshiya Sabha </p>";
                $emailContent .= "</div></div>";

                Email::send($reqEmail,'Book Request Added',$emailContent);
            }
            $this->view('LibraryStaff/Addbooks', 'Add New Book', $data, ['LibraryStaff/index', 'Components/form']);
        } else {
            $this->view('LibraryStaff/Addbooks', 'Add New Book',$data, styles:['LibraryStaff/index', 'Components/form']);
        }
    }

    public function editbooks($id = null)
    {
        $model = $this->model('BookModel');
        $data = [];
        if(isset($_POST['Edit'])){
                $changes = [];
                $current_book = $model->getBookbyID($id)['result'][0];
                $validator = [
                    'title' => 'title|l[:255]',
                    'author' => 'author|l[:255]',
                    'publisher' => 'publisher|l[:255]',
                    'price' => 'price|d[0:]',
                    'pages' => 'pages|i[1:]',
                ];

                foreach ($current_book as $field => $value){
                    if(isset($_POST[$field])){
                        if($_POST[$field] !== $value){
                            if ($validator[$field] ?? false) {
                                $changes[] = $validator[$field];
                            }
                        }
                        else{
                            unset($_POST[$field]);
                        }
                    }
                }

                if(count($changes) > 0){
                    [$valid, $err] = $this->validateInputs($_POST, $changes, 'Edit');
                    $data['errors'] = $err;

                    if (count($err) == 0) {
                        $data = array_merge(['edit' => !is_null($id) ? $model->editBook($id, $valid) : null], $data);

                        if (($data['edit']['success'] ?? false) == true) {
                            $edit_history = [];
                            foreach ($valid as $field => $value) {
                                $edit_history[$field] = $current_book[$field];
                            }

                            $edit_history = array_merge($edit_history, [
                                'accession_no' => $current_book['accession_no'],
                                'edited_by' => $_SESSION['user_id'],
                            ]);
                            if (isset($edit_history['Edit'])) {
                                unset($edit_history['Edit']);
                            }
                            $model->putBookEditHistory($edit_history);
                        }
                    }
                }
        }
        if ($id != null) {
            $res = $model->getBookEditHistory($id)['result'] ?? false;
            if (!($res['nodata'] ?? false)) {
                $data['edit_history'] = $res;
            }
        }
        $this->view('LibraryStaff/Editbooks', 'Edit Book', array_merge(['books' => $id != null ? $model->getBookbyID($id) : false ],$data), ['LibraryStaff/index', 'Components/form','Admin/index']);
    }

    public function viewbooks($id=null)
    {
        $model = $this->model('BookModel');

        if (isset($_POST['confirm'])) {
            $error = false;

            if (isset($_POST['lost_description']) && isset($_POST['lost_accession_no']) && $_POST['lost_description'] != null && $_POST['lost_accession_no'] != null) {

              $_POST['lost_accession_no'] = intval($_POST['lost_accession_no']);

                [$valid, $err] = $this->validateInputs($_POST, [
                    'lost_accession_no|i[0:]',
                    'lost_description|l[:255]',
                    'delist_description|?',
                    'delist_accession_no|?',
                    'damage_accession_no|?',
                    'damage_description|?'
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_POST['lost_accession_no'], 4, $valid) == false) {
                        $_POST['lost_accession_no'] = null;
                        $_POST['lost_description'] = null;
                        $error = true;
                    }
                }

                //create the order of state changes
                $state_history = ($id != null) ? ($model->getBookStateHistory($id) ?? false) : false;
                if($state_history){
                    $date = [];
                    foreach ($state_history as $value){
                        if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                            if($value['dm_time'] ?? false){
                                $date[] = $value['dm_time'];
                            }
                            else if($value['l_time'] ?? false){
                                $date[] = $value['l_time'];
                            }
                            else if($value['de_time'] ?? false){
                                $date[] = $value['de_time'];
                            }
                        }
                    }
                    if(rsort($date) ?? false){
                        $state_order = [];
                        foreach($date as $val){
                            foreach ($state_history as $value){
                                if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                                    if(($value['dm_time'] ?? false) && $value['dm_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                    else if(($value['l_time'] ?? false) && $value['l_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                    else if(($value['de_time'] ?? false) && $value['de_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                }
                            }
                        }
                    }
                }

                $this->view('LibraryStaff/Viewbooks', 'View Book', [
                    'Lost' => ($_POST['lost_description'] != null && $_POST['lost_accession_no'] != null) ? $model->getBookbyID($_POST['lost_accession_no']) : false,
                    'lost_error' => $error,
                    'acc' => $id,
                    'books' => ($id != null) ? ($model->getBookbyID($id)['result'][0] ?? false) : false,
                    'edit_history' => ($id != null) ? ($model->getBookEditHistory($id)['result'] ?? false) : false,
                    'state_history' => ($id != null) ? ($state_order ?? false) : false],
                    styles:['LibraryStaff/index', 'Components/modal', 'Components/table', 'Admin/index']);
            }

            else if (isset($_POST['delist_description']) && isset($_POST['delist_accession_no']) && $_POST['delist_description'] != null && $_POST['delist_accession_no'] != null) {

              $_POST['delist_accession_no'] = intval($_POST['delist_accession_no']);

                [$valid, $err] = $this->validateInputs($_POST, [
                    'delist_accession_no|i[0:]',
                    'delist_description|l[:255]',
                    'lost_description|?',
                    'lost_accession_no|?',
                    'damage_accession_no|?',
                    'damage_description|?'
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_POST['delist_accession_no'], 3, $valid) == false) {
                        $_POST['delist_accession_no'] = null;
                        $_POST['delist_description'] = null;
                        $error = true;
                    }
                }

                //create the order of state changes
                $state_history = ($id != null) ? ($model->getBookStateHistory($id) ?? false) : false;
                if($state_history){
                    $date = [];
                    foreach ($state_history as $value){
                        if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                            if($value['dm_time'] ?? false){
                                $date[] = $value['dm_time'];
                            }
                            else if($value['l_time'] ?? false){
                                $date[] = $value['l_time'];
                            }
                            else if($value['de_time'] ?? false){
                                $date[] = $value['de_time'];
                            }
                        }
                    }
                    if(rsort($date) ?? false){
                        $state_order = [];
                        foreach($date as $val){
                            foreach ($state_history as $value){
                                if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                                    if(($value['dm_time'] ?? false) && $value['dm_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                    else if(($value['l_time'] ?? false) && $value['l_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                    else if(($value['de_time'] ?? false) && $value['de_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                }
                            }
                        }
                    }
                }


                $this->view('LibraryStaff/Viewbooks', 'View Book', [
                    'Delist' => ($_POST['delist_description'] != null && $_POST['delist_accession_no'] != null) ? $model->getBookbyID($_POST['delist_accession_no']) : false,
                    'delist_error' => $error,
                    'acc' => $id,
                    'books' => ($id != null) ? ($model->getBookbyID($id)['result'][0] ?? false) : false,
                    'edit_history' => ($id != null) ? ($model->getBookEditHistory($id)['result'] ?? false) : false,
                    'state_history' => ($id != null) ? ($state_order ?? false) : false],
                    styles:['LibraryStaff/index', 'Components/modal', 'Components/table', 'Admin/index']);
            }

            else if (isset($_POST['found_description']) && isset($_POST['found_accession_no']) && $_POST['found_description'] != null && $_POST['found_accession_no'] != null) {

              $_POST['found_accession_no'] = intval($_POST['found_accession_no']);
              $_POST['type'] = 'found';

                [$valid, $err] = $this->validateInputs($_POST, [
                    'found_accession_no|i[0:]',
                    'found_description|l[:255]',
                    'type|l[5:5]'
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_POST['found_accession_no'], 1, $valid) == false) {
                        $_POST['found_accession_no'] = null;
                        $_POST['found_description'] = null;
                        $error = true;
                    }
                }

                //create the order of state changes
                $state_history = ($id != null) ? ($model->getBookStateHistory($id) ?? false) : false;
                if($state_history){
                    $date = [];
                    foreach ($state_history as $value){
                        if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                            if($value['dm_time'] ?? false){
                                $date[] = $value['dm_time'];
                            }
                            else if($value['l_time'] ?? false){
                                $date[] = $value['l_time'];
                            }
                            else if($value['de_time'] ?? false){
                                $date[] = $value['de_time'];
                            }
                        }
                    }
                    if(rsort($date) ?? false){
                        $state_order = [];
                        foreach($date as $val){
                            foreach ($state_history as $value){
                                if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                                    if(($value['dm_time'] ?? false) && $value['dm_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                    else if(($value['l_time'] ?? false) && $value['l_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                    else if(($value['de_time'] ?? false) && $value['de_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                }
                            }
                        }
                    }
                }

                $this->view('LibraryStaff/Viewbooks', 'View Book', [
                    'Found' => ($_POST['found_description'] != null && $_POST['found_accession_no'] != null) ? $model->getBookbyID($_POST['found_accession_no']) : false,
                    'found_error' => $error,
                    'acc' => $id,
                    'books' => ($id != null) ? ($model->getBookbyID($id)['result'][0] ?? false) : false,
                    'edit_history' => ($id != null) ? ($model->getBookEditHistory($id)['result'] ?? false) : false,
                    'state_history' => ($id != null) ? ($state_order ?? false) : false],
                    styles:['LibraryStaff/index', 'Components/modal', 'Components/table', 'Admin/index']);
            }

            else if (isset($_POST['recondition_description']) && isset($_POST['recondition_accession_no']) && $_POST['recondition_description'] != null && $_POST['recondition_accession_no'] != null) {

              $_POST['recondition_accession_no'] = intval($_POST['recondition_accession_no']);
              $_POST['type'] = 'conditioned';

                [$valid, $err] = $this->validateInputs($_POST, [
                    'recondition_accession_no|i[0:]',
                    'recondition_description|l[:255]',
                    'type|l[11:11]'
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_POST['recondition_accession_no'], 1, $valid) == false) {
                        $_POST['recondition_accession_no'] = null;
                        $_POST['recondition_description'] = null;
                        $error = true;
                    }
                }

                //create the order of state changes
                $state_history = ($id != null) ? ($model->getBookStateHistory($id) ?? false) : false;
                if($state_history){
                    $date = [];
                    foreach ($state_history as $value){
                        if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                            if($value['dm_time'] ?? false){
                                $date[] = $value['dm_time'];
                            }
                            else if($value['l_time'] ?? false){
                                $date[] = $value['l_time'];
                            }
                            else if($value['de_time'] ?? false){
                                $date[] = $value['de_time'];
                            }
                        }
                    }
                    if(rsort($date) ?? false){
                        $state_order = [];
                        foreach($date as $val){
                            foreach ($state_history as $value){
                                if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                                    if(($value['dm_time'] ?? false) && $value['dm_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                    else if(($value['l_time'] ?? false) && $value['l_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                    else if(($value['de_time'] ?? false) && $value['de_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                }
                            }
                        }
                    }
                }

                $this->view('LibraryStaff/Viewbooks', 'View Book', [
                    'Reconditioned' => ($_POST['recondition_description'] != null && $_POST['recondition_accession_no'] != null) ? $model->getBookbyID($_POST['recondition_accession_no']) : false,
                    'recondition_error' => $error,
                    'acc' => $id,
                    'books' => ($id != null) ? ($model->getBookbyID($id)['result'][0] ?? false) : false,
                    'edit_history' => ($id != null) ? ($model->getBookEditHistory($id)['result'] ?? false) : false,
                    'state_history' => ($id != null) ? ($state_order ?? false) : false],
                    styles:['LibraryStaff/index', 'Components/modal', 'Components/table', 'Admin/index']);
            }

            else if (isset($_POST['damage_description']) && isset($_POST['damage_accession_no']) && $_POST['damage_description'] != null && $_POST['damage_accession_no'] != null) {

              $_POST['damage_accession_no'] = intval($_POST['damage_accession_no']);

                [$valid, $err] = $this->validateInputs($_POST, [
                    'damage_accession_no|i[0:]',
                    'damage_description|l[:255]',
                    'lost_description|?',
                    'lost_accession_no|?',
                    'delist_description|?',
                    'delist_accession_no|?'
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_POST['damage_accession_no'], 5, $valid) == false) {
                        $_POST['damage_accession_no'] = null;
                        $_POST['damage_description'] = null;
                        $error = true;
                    }
                }

                //create the order of state changes
                $state_history = ($id != null) ? ($model->getBookStateHistory($id) ?? false) : false;
                if($state_history){
                    $date = [];
                    foreach ($state_history as $value){
                        if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                            if($value['dm_time'] ?? false){
                                $date[] = $value['dm_time'];
                            }
                            else if($value['l_time'] ?? false){
                                $date[] = $value['l_time'];
                            }
                            else if($value['de_time'] ?? false){
                                $date[] = $value['de_time'];
                            }
                        }
                    }
                    if(rsort($date) ?? false){
                        $state_order = [];
                        foreach($date as $val){
                            foreach ($state_history as $value){
                                if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                                    if(($value['dm_time'] ?? false) && $value['dm_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                    else if(($value['l_time'] ?? false) && $value['l_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                    else if(($value['de_time'] ?? false) && $value['de_time'] == $val){
                                        $state_order[] = $value;
                                    }
                                }
                            }
                        }
                    }
                }

                $this->view('LibraryStaff/Viewbooks', 'View Book', [
                    'Damaged' => ($_POST['damage_description'] != null && $_POST['damage_accession_no'] != null) ? $model->getBookbyID($_POST['damage_accession_no']) : false,
                    'damage_error' => $error,
                    'acc' => $id,
                    'books' => ($id != null) ? ($model->getBookbyID($id)['result'][0] ?? false) : false,
                    'edit_history' => ($id != null) ? ($model->getBookEditHistory($id)['result'] ?? false) : false,
                    'state_history' => ($id != null) ? ($state_order ?? false) : false],
                    styles:['LibraryStaff/index', 'Components/modal', 'Components/table', 'Admin/index']);
            }

        }
        else{

            //create the order of state changes
            $state_history = ($id != null) ? ($model->getBookStateHistory($id) ?? false) : false;
            if($state_history){
                $date = [];
                foreach ($state_history as $value){
                    if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                        if($value['dm_time'] ?? false){
                            $date[] = $value['dm_time'];
                        }
                        else if($value['l_time'] ?? false){
                            $date[] = $value['l_time'];
                        }
                        else if($value['de_time'] ?? false){
                            $date[] = $value['de_time'];
                        }
                    }
                }
                if(rsort($date) ?? false){
                    $state_order = [];
                    foreach($date as $val){
                        foreach ($state_history as $value){
                            if(isset($value['dm_time']) || isset($value['l_time']) || isset($value['de_time'])){
                                if(($value['dm_time'] ?? false) && $value['dm_time'] == $val){
                                    $state_order[] = $value;
                                }
                                else if(($value['l_time'] ?? false) && $value['l_time'] == $val){
                                    $state_order[] = $value;
                                }
                                else if(($value['de_time'] ?? false) && $value['de_time'] == $val){
                                    $state_order[] = $value;
                                }
                            }
                        }
                    }
                }
            }

            $data = [
                'acc' => $id,
                'books' => ($id != null) ? ($model->getBookbyID($id)['result'][0] ?? false) : false,
                'edit_history' => ($id != null) ? ($model->getBookEditHistory($id)['result'] ?? false) : false,
                'state_history' => ($id != null) ? ($state_order ?? false) : false,
            ];

            $this->view('LibraryStaff/Viewbooks', 'View Book', $data, styles:['LibraryStaff/index', 'Components/modal', 'Components/table', 'Admin/index']);
        }
    }

    public function editusers($id = null)
    {
        $model = $this->model('LibraryUserManageModel');
        $data = [];
        if(isset($_POST['Edit'])){
            $changes = [];
            $current_user = $model->getUserbyID($id)['result'][0];
            $_POST['user_id'] = $current_user['user_id'] ?? false;
            $validator = [
                'user_id' => 'user_id|i[0:]',
                'email' => 'email|l[:255]|e',
                'name' => 'name|l[:255]',
                'address' => 'address|l[:255]',
                'contact_no' => 'contact_no|l[10:12]',
            ];

            foreach ($current_user as $field => $value){
                if(isset($_POST[$field])){
                    if($_POST[$field] !== $value){
                        if ($validator[$field] ?? false) {
                            $changes[] = $validator[$field];
                        }
                    }
                    else{
                        unset($_POST[$field]);
                    }
                }
            }

            if(count($changes) > 0){
                [$valid, $err] = $this->validateInputs($_POST, $changes, 'Edit');
                $data['errors'] = $err;

                if (count($err) == 0) {
                    $data = array_merge(['edit' => !is_null($id) ? $model->editLibraryUser($current_user['user_id'], $valid) : null], $data);

                    if (($data['edit']['success'] ?? false) == true) {
                        $edit_history = [];
                        foreach ($valid as $field => $value) {
                            $edit_history[$field] = $current_user[$field];
                        }

                        $edit_history = array_merge($edit_history, [
                            'user_id' => $current_user['user_id'],
                            'edited_by' => $_SESSION['user_id'],
                        ]);
                        if (isset($edit_history['Edit'])) {
                            unset($edit_history['Edit']);
                        }
                        $model->putMemberEditHistory($edit_history);
                    }
                }
            }
        }
        if ($id != null) {
            $res = $model->getMemberEditHistory($model->getUserbyID($id)['result'][0]['user_id'])['result'] ?? false;
            if (!($res['nodata'] ?? false)) {
                $data['edit_history'] = $res;
            }
        }
        $this->view('LibraryStaff/Editusers', 'Edit Library User', array_merge(['Users' => $id != null ? $model->getUserbyID($id) : false], $data), ['LibraryStaff/index', 'Components/form','Admin/index']);
    }

    public function booktransactions()
    {
        $model = $this->model('BookModel');
        $this->view('LibraryStaff/Booktransactions', 'Book Transactions', ['Books' => $model->getBookTransactions()], styles:['LibraryStaff/index', 'Components/table','Components/modal','posts']);

    }

    public function viewusers($id=null)
    {
        $model = $this->model('LibraryUserManageModel');
        $current_user = $model->getUserbyID($id)['result'][0];

        if (isset($_POST['confirm'])) {
            $error = false;
            if (isset($_POST['enable_description']) && isset($_POST['enabled_member_ID']) && $_POST['enable_description'] != null && $_POST['enabled_member_ID'] != null) {

              $_POST['enabled_member_ID'] = intval($_POST['enabled_member_ID']);
              $_POST['member_id'] = $model->getUserbyID($_POST['enabled_member_ID'])['result'][0]['member_id'] ?? false;
              $_POST['user_id'] = $model->getUserbyID($_POST['enabled_member_ID'])['result'][0]['user_id'] ?? false;

                [$valid, $err] = $this->validateInputs($_POST, [
                    'enabled_member_ID|i[0:]',
                    'member_id|i[0:]',
                    'user_id|i[0:]',
                    'enable_description|l[:255]',
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_POST['member_id'], 1, $valid) == false) {
                        $_POST['enabled_member_ID'] = null;
                        $_POST['member_id'] = null;
                        $_POST['enable_description'] = null;
                        $error = true;
                    }
                }

                $this->view('LibraryStaff/Viewusers', 'View User', [
                    'Enabled' => ($_POST['enable_description'] != null && $_POST['enabled_member_ID'] != null) ? $model->getUserbyID($_POST['enabled_member_ID']) : false,
                    'enable_error' => $error,
                    'user_id' => $id,
                    'user' => ($id != null) ? ($model->getUserbyID($id)['result'][0] ?? false) : false,
                    'edit_history' => ($id != null) ? ($model->getMemberEditHistory($current_user['user_id'])['result'] ?? false) : false,
                    'state_history' => ($id != null) ? ($model->getMemberStateHistory($current_user['user_id'])['result'] ?? false) : false],
                    styles:['LibraryStaff/index', 'Components/modal','Components/table','Admin/index']);
            }

            else if (isset($_POST['disable_description']) && isset($_POST['disabled_member_ID']) &&$_POST['disable_description'] != null && $_POST['disabled_member_ID'] != null) {

              $_POST['disabled_member_ID'] = intval($_POST['disabled_member_ID']);
              $_POST['member_id'] = $model->getUserbyID($_POST['disabled_member_ID'])['result'][0]['member_id'] ?? false;
              $_POST['user_id'] = $model->getUserbyID($_POST['disabled_member_ID'])['result'][0]['user_id'] ?? false;

                [$valid, $err] = $this->validateInputs($_POST, [
                    'disabled_member_ID|i[0:]',
                    'member_id|i[0:]',
                    'user_id|i[0:]',
                    'disable_description|l[:255]',
                ], 'confirm');
                $data['errors'] = $err;
                if(count($err) == 0){
                    if ($model->changeState($_POST['member_id'], 2, $valid) == false) {
                        $_POST['disabled_member_ID'] = null;
                        $_POST['member_id'] = null;
                        $_POST['disable_description'] = null;
                        $error = true;
                    }
                }

                $this->view('LibraryStaff/Viewusers', 'View User', [
                    'Disabled' => ($_POST['disable_description'] != null && $_POST['disabled_member_ID'] != null) ? $model->getUserbyID($_POST['disabled_member_ID']) : false,
                    'disable_error' => $error,
                    'user_id' => $id,
                    'user' => ($id != null) ? ($model->getUserbyID($id)['result'][0] ?? false) : false,
                    'edit_history' => ($id != null) ? ($model->getMemberEditHistory($current_user['user_id'])['result'] ?? false) : false,
                    'state_history' => ($id != null) ? ($model->getMemberStateHistory($current_user['user_id'])['result'] ?? false) : false],
                    styles:['LibraryStaff/index', 'Components/modal','Components/table','Admin/index']);
            }
        }
        else{
            $data = [
                'user_id' => $id,
                'user' => ($id != null) ? ($model->getUserbyID($id)['result'][0] ?? false) : false,
                'edit_history' => ($id != null) ? ($model->getMemberEditHistory($current_user['user_id'])['result'] ?? false) : false,
                'state_history' => ($id != null) ? ($model->getMemberStateHistory($current_user['user_id'])['result'] ?? false) : false,
            ];

            $this->view('LibraryStaff/Viewusers', 'View User', $data, styles:['LibraryStaff/index', 'Components/modal', 'Components/table', 'Admin/index']);
        }
    }

    public function finance()
    {
        $model = $this->model('LibraryStatModel');
        $fineModel = $this->model('BookModel');

        if (isset($_POST['Edit'])) {
                $changes = [];
                $current_fine = $fineModel->getFineDetails()['result'][0];
                $validator = [
                    'delay_month_fine' => 'delay_month_fine|d[0:]',
                    'delay_after_fine' => 'delay_after_fine|d[0:]',
                ];

                foreach ($current_fine as $field => $value){
                    if(isset($_POST[$field])){
                        if($_POST[$field] !== $value){
                            if ($validator[$field] ?? false) {
                                $changes[] = $validator[$field];
                            }
                        }
                        else{
                            unset($_POST[$field]);
                        }
                    }
                }

                if(count($changes) > 0){
                    [$valid, $err] = $this->validateInputs($_POST, $changes, 'Edit');
                    $data['errors'] = $err;

                    if (count($err) == 0) {
                        $data = array_merge(['Edit' => $fineModel->editFineDetails($valid)], $data);

                        if (($data['Edit']['success'] ?? false) == true) {
                            $edit_history = [];
                            foreach ($valid as $field => $value) {
                                $edit_history[$field] = $current_fine[$field];
                            }

                            $edit_history = array_merge($edit_history, [
                                'fine_id' => $current_fine['fine_id'],
                                'edited_by' => $_SESSION['user_id'],
                            ]);
                            if (isset($edit_history['Edit'])) {
                                unset($edit_history['Edit']);
                            }
                            $fineModel->putFineEditHistory($edit_history);
                        }
                    }
                }
        }
        else if(file_get_contents('php://input')){
            $reqJSON = file_get_contents('php://input');
            if ($reqJSON) {
                $reqJSON = json_decode($reqJSON, associative:true);
                if ($reqJSON) {
                    if (isset($reqJSON['range'])) {
                        $response = $model->getFineStat($reqJSON);
                    } else if (isset($reqJSON['fromDate']) && isset($reqJSON['toDate'])) {
                        $response = $model->getCustomFineStat($reqJSON);
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
        }

        $res = $fineModel->getFineEditHistory()['result'] ?? false;
        if (!($res['nodata'] ?? false)) {
            $data['edit_history'] = $res;
        }

        $this->view('LibraryStaff/Finance', 'Finance', array_merge(['Fine' => $fineModel->getFineDetails(),'fine_details' => $fineModel->getFinePayments()],$data), styles:['LibraryStaff/index', 'Components/table', 'posts', 'Components/modal','LibraryStaff/finance','Admin/index']);
    }

    public function userreport()
    {

        $model = $this->model('BookModel');
        $data = [];

        if(isset($_POST['search-btn'])){
            $search = $_POST['search'];
            preg_match('/\d+/',$search,$match);
            $searchKey = $match[0] ?? null;
            if($searchKey == null){
                $searchKey = $search;
            }
            $_SESSION['searchKey'] = $searchKey;
            $_SESSION['clicked'] = 'transactions';

            $user = $model->getUserDetails($searchKey)['result'][0]['member_id'] ?? false;
            if($user){
                $data = ['UserFine' => $model->getFinebyId($user) ?? false, 'Damage' => $model->getDamagebyId($user) ?? false, 'Lost' => $model->getLostbyId($user) ?? false, 'transaction' => $model->getBookTransactions($user) ?? false, 'fine_details' => $model->getFinePayments($user) ?? false];
            }

            $this->view('LibraryStaff/Userreport', 'User Report', array_merge(['userStat' => ($searchKey != null) ? $model->getUserDetails($searchKey) : false],$data), styles:['Components/table', 'posts',  'LibraryStaff/index', 'LibraryStaff/userreport', 'LibraryStaff/finance','Components/modal']);

        }

        else if(isset($_GET['search']) || isset($_GET['type']) ||isset($_GET['timeframe']) ||isset($_GET['fromDate']) ||isset($_GET['toDate']) ||isset($_GET['page']) ||isset($_GET['size']) || isset($_GET['timeframefine']) ){
            if(isset($_SESSION['searchKey']) && !empty($_SESSION['searchKey'])){
                $searchKey = $_SESSION['searchKey'];
                if(isset($_GET['timeframe'])){
                    $_SESSION['clicked'] = 'transactions';
                }
                else if(isset($_GET['timeframefine'])){
                    $_SESSION['clicked'] = 'finepayments';
                }
                $user = $model->getUserDetails($searchKey)['result'][0]['member_id'] ?? false;
                $data = ['UserFine' => $model->getFinebyId($user) ?? false, 'Damage' => $model->getDamagebyId($user) ?? false, 'Lost' => $model->getLostbyId($user) ?? false, 'transaction' => $model->getBookTransactions($user) ?? false, 'fine_details' => $model->getFinePayments($user) ?? false];
                $this->view('LibraryStaff/Userreport', 'User Report', array_merge(['userStat' => ($searchKey != null) ? $model->getUserDetails($searchKey) : false], $data), styles:['Components/table', 'posts', 'LibraryStaff/index', 'LibraryStaff/userreport', 'LibraryStaff/finance', 'Components/modal']);
            }

        }

        else{
            $reqJSON = file_get_contents('php://input');

            if($reqJSON){
                $reqJSON = json_decode($reqJSON, associative:true);

                if($reqJSON && ($reqJSON['searchID'] == 'userSearch')){
                    $response = $model->searchUser($reqJSON['value']);
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

        $this->view('LibraryStaff/Userreport','User Report',[], styles:['Components/table', 'posts','LibraryStaff/index','LibraryStaff/userreport','LibraryStaff/finance','Components/modal']);
    }
}
