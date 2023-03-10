<?php

class LibraryStaff extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('LibraryStaff');
    }

    public function index()
    {
        // TODO: USE COMPONENTS AND REDO
        $this->view('LibraryStaff/index', styles:['Components/table', 'Components/form', 'Components/modal', 'LibraryStaff/index']);
    }

    public function analytics()
    {
        $this->view('LibraryStaff/Analytics', styles:['LibraryStaff/index', 'LibraryStaff/analytics', 'Components/form']);
    }

    public function bookcatalog()
    {
        $model = $this->model('BookModel');

        $this->view('LibraryStaff/Bookcatalog', 'Book Catalogue',['Books' =>$model->getBooks()],styles:['LibraryStaff/index', 'LibraryStaff/catalogue', 'Components/table','posts','Components/modal']);
    }

    public function bookrequest()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Bookrequest', styles:['LibraryStaff/index', 'LibraryStaff/catalogue', 'Components/table']);
    }

    public function lostbooks()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Lostbooks', styles:['LibraryStaff/index', 'LibraryStaff/catalogue', 'Components/table']);
    }

    public function delistedbooks()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Delistedbooks', styles:['LibraryStaff/index', 'LibraryStaff/catalogue', 'Components/table']);
    }

    public function damagedbooks()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Damagedbooks', styles:['LibraryStaff/index', 'LibraryStaff/catalogue', 'Components/table']);
    }

    public function users()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Users', styles:['LibraryStaff/index', 'LibraryStaff/catalogue', 'Components/table']);
    }

    public function disabledusers()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Disabledusers', styles:['LibraryStaff/index', 'LibraryStaff/catalogue', 'Components/table']);
    }

    public function addusers()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Addusers', styles:['LibraryStaff/index', 'Components/form']);
    }

    public function addbooks()
    {
        $model = $this->model('BookModel');

        $data = ['categories' => $model->get_categories()['result']];
        
        if (isset($_POST['Add'])) {
            [$valid, $err] = $this->validateInputs($_POST, [
                    'title|l[:255]',
                    'author|l[:255]',
                    'publisher|l[:255]',
                    'place_of_publication|l[:255]',
                    'date_of_publication',
                    'category_code',
                    'accession_no|l[:100]',
                    'price|d[0:]',
                    'pages|i[1:]',
                    'recieved_date',
                    'isbn|l[:50]',
                    'recieved_method|l[:255]',
                    ], 
                'Add');
            $data['errors'] = $err;

            $data['old'] = $_POST;
            $data = array_merge(count($err) > 0 ?

                ['errors' => $err] : ['Add' => $model->addbook($valid)], $data);
            $this->view('LibraryStaff/Addbooks', 'Add New Book', $data, ['LibraryStaff/index', 'Components/form']);
        } else {
            $this->view('LibraryStaff/Addbooks', 'Add New Book',$data, styles:['LibraryStaff/index', 'Components/form']);
        }
    }

    public function editbooks($id)
    {
        $model = $this->model('BookModel');
        

        $this->view('LibraryStaff/Editbooks', 'Edit Book', ['edit' => isset($_POST['Edit']) ? $model->editBook($id, $this->validateInputs($_POST, [
                    'title|l[:255]',
                    'author|l[:255]',
                    'publisher|l[:255]',
                    'place_of_publication|l[:255]',
                    'date_of_publication',
                    'accession_no|l[:100]',
                    'price|d[0:]',
                    'pages|i[1:]',
                    'recieved_date',
                    'isbn|l[:50]',
                    'recieved_method|l[:255]',
        ], 'Edit')) : null, 'books' => $id != null ? $model->getBookbyID($id) : false], ['LibraryStaff/index', 'Components/form']);

        // $this->view('LibraryStaff/Editbooks', styles:['LibraryStaff/index', 'Components/form']);
    }

    public function editusers()
    {
        // TODO: REDO USING COMPONENTS
        $this->view('LibraryStaff/Editusers', styles:['LibraryStaff/index', 'Components/form']);
    }
}
