<?php
require_once 'app/models/AnnouncementModel.php';

class Home extends Controller
{
    public function index()
    {
        $posts = [
            (new AnnouncementModel)->getFrontPage(),
            [], //TODO: Services
            [], //TODO: Projects
            []  //TODO: Events
        ];
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha',['posts' => $posts],
            styles:['Home/index','Components/slideshow']);
    }

    public function downloads()
    {
        $this->view('Home/downloads',styles:['Home/downloads']);
    }

    public function emergency()
    {
        $data = ['emergency_details' => $this->model('EmergencyModel')->getAllEmergencyDetails()];
        $this->view('Home/emergency', 'Emergency Details', $data, ['main','emergency']);
    }

    public function portal()
    {
        // TODO: Add Pictures of Library
        $this->view('Home/portal', 'Library Portal',styles:['Home/portal','Components/slideshow']);
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
            $this->view('Home/bookRequest', 'Book Request', $data, ['Components/form']);
        } 
        else {
            $this->view('Home/bookRequest', 'Book Request', styles:['Components/form']);
        }
    }

    public function bookCatalogue()
    {
        $model = $this->model('BookModel');
        $this->view('Home/bookCatalogue', 'Book Catalogue', ['Books' => $model->getBooks()], styles:['LibraryStaff/index', 'Home/portal', 'Components/table', 'posts']);
    }
    
    public function addComplaint()
    {
        // TODO: Use Form Input components
        $this->view('Home/AddComplaint', 'Complaint Form',$data=[],['main','Components/form']);
    }
}
