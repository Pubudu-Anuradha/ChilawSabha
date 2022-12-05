<?php

class LibraryStaff extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('LibraryStaff');
    }

    public function index()
    {
        $this->view('LibraryStaff/index');
    }

    public function Insertbooks()
    {
        $data = [];
        if (isset($_POST['submit'])) {
            if (
                isset($_POST['title']) && !empty($_POST['title'])
                && isset($_POST['author']) && !empty($_POST['author'])
                && isset($_POST['publisher']) && !empty($_POST['publisher'])
                && isset($_POST['dateofpub']) && !empty($_POST['dateofpub'])
                && isset($_POST['placeofpub']) && !empty($_POST['placeofpub'])
                && isset($_POST['bookCategory']) && !empty($_POST['bookCategory'])
                && isset($_POST['accno']) && !empty($_POST['accno'])
                && isset($_POST['price']) && !empty($_POST['price'])
                && isset($_POST['page']) && !empty($_POST['page'])
                && isset($_POST['recdate']) && !empty($_POST['recdate'])
                && isset($_POST['recmethod']) && !empty($_POST['recmethod'])

            ) {
                $model = $this->model('BookModel');
                $res = $model->AddBook($_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['dateofpub'], $_POST['placeofpub'],
                    $_POST['bookCategory'], $_POST['accno'], $_POST['price'], $_POST['page'], $_POST['recdate'], $_POST['recmethod']);
                if ($res) {
                    $data['message'] = 'Added Book successfully';
                } else {
                    $data['message'] = 'Failed to add book';
                }
            } else {
                $data['message'] = 'Invalid Parameters';
            }
        }

        $this->view('LibraryStaff/Insertbooks', $data);
    }
    public function Viewbooks()
    {
        $data = ['books' => $this->model('BookModel')->GetBookList()];
        $this->view('LibraryStaff/Viewbooks', $data);
    }
}
