<?php

class LibraryMember extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('LibraryMember');
    }
    public function index()
    {
        $this->view('LibraryMember/index', 'Dashboard Library Member', [], ['main', 'libraryUsers']);
    }

    public function bookRequest()
    {
        $this->view('LibraryMember/bookRequest', 'Book Request', [], ['main', 'libraryUsers']);
    }

    public function bookCatalogue()
    {
        $this->view('LibraryMember/bookCatalogue', 'Book Catalogue', [], ['main', 'libraryUsers']);
    }

    public function planToRead()
    {
        $model = $this->model('PlanToReadModel');
        //adding to db
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            unset($_SERVER['HTTP_X_REQUESTED_WITH']);
            $order = 1;
            foreach ($_POST as $val) {
                $model->updatePlanToReadBooks($order, $val);
                $order++;
            }
        }
        else{
            $this->view('LibraryMember/planToRead', 'Plan to Read List', ['PlantoRead' => $model->getPlanToReadBooks()], ['main', 'LibraryMember/something','Components/table']);
        }
    }

    public function favourite()
    {
        $this->view('LibraryMember/favourite', 'Favourite List', [], ['main', 'libraryUsers']);
    }

    public function completed()
    {
        $this->view('LibraryMember/completed', 'Completed List', [], ['main', 'libraryUsers']);
    }
}
