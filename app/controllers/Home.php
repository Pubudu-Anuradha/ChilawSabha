<?php
require_once 'app/models/AnnouncementModel.php';
require_once 'app/models/ProjectModel.php';

class Home extends Controller
{
    public function index()
    {
        $posts = [
            (new AnnouncementModel)->getFrontPage(),
            [], //TODO: Services
            (new ProjectModel)->getFrontPage(),
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
        // TODO: Use Form Input components
        $this->view('Home/bookRequest', 'Book Request', [], ['form']);
    }

    public function bookCatalogue()
    {
        // TODO: Use table component and Pagination components
        $this->view('Home/bookCatalogue', 'Book Catalogue', [], ['LibraryStaff/catalogue','LibraryStaff/index','Home/portal','Components/table']);
    }
    public function addComplaint()
    {
        // TODO: Use Form Input components
        $this->view('Home/AddComplaint', 'Complaint Form',$data=[],['main','Components/form']);
    }
}
