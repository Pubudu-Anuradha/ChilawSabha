<?php
require_once 'app/models/AnnouncementModel.php';
require_once 'app/models/ProjectModel.php';
require_once 'app/models/EventModel.php';
require_once 'app/models/ServiceModel.php';

class Home extends Controller
{
    public function index()
    {
        // Get all posts that should appear on the front page
        $posts = [
            (new AnnouncementModel)->getFrontPage(),
            (new ServiceModel)->getFrontPage(),
            (new ProjectModel)->getFrontPage(),
            (new EventModel)->getFrontpage()
        ];
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha',['posts' => $posts],
            styles:['Home/index','Components/slideshow']);
    }

    public function downloads()
    {
        // Redirect to Downloads page
        header('Location: ' . URLROOT .'/Downloads');
    }

    public function emergency()
    {
        $data = ['emergency_details' => $this->model('EmergencyModel')->getAllEmergencyDetails()];
        $this->view('Home/emergency', 'Emergency Details', $data, ['main','emergency']);
    }

    public function portal()
    {
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
        $this->view('Home/bookCatalogue', 'Book Catalogue', ['Books' => $model->getBooks(),'Category' => $model->get_categories(), 'SubCategory' => $model->get_sub_categories()], styles:['LibraryStaff/index', 'Home/portal', 'Components/table', 'posts']);
    }

    public function addComplaint()
    {
        $this->view('Home/AddComplaint', 'Complaint Form',$data=[],['main','Components/form']);
    }
}
