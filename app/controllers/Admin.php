<?php

class Admin extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('Admin');
    }

    public function index()
    {
        $this->view('Admin/index','Admin DashBoard',[],['main','chart']);
    }
    public function Users($page='index')
    {
        $model = $this->model('UserModel');
        switch($page){
            case 'Add':
                $this->view('Admin/User/Add','Add a new User',['Add' => isset($_POST['Add'])? $model->addUser(
                    $this->validateInputs($_POST,[
                        'email','name','password','address','contact_no','nic','role'
                    ],'Add')
                ) : false],['main','form']);
                break;
            case 'Disabled':
                $this->view('Admin/User/Disabled','Manage Disabled Users',['Users' => $model->getUsers('disabled')],['main','table','posts']);
                break;
            default:
                $this->view('Admin/User/index','Manage Users',['Users' => $model->getUsers()],['main','table','posts']);
        }
    }
    public function Announcements($page='index',$id=NULL)
    {
        $model = $this->model('AnnouncementModel');

        switch($page){
            case 'Add':
                $this->view('Admin/Announcements/Add','Add Announcement',
                ['Add'=>isset($_POST['Add'])?$model->addAnnouncement($this->validateInputs($_POST,[
                   'title','category','shortdesc','author','content'
                ],'Add')):NULL],['main','form']);
                break;
            case 'Edit':
                $this->view('Admin/Announcements/Edit','Edit Announcement',['announcement' => $id!=NULL ? $model->getAnnouncement($id):false,
                'edit'=>isset($_POST['Edit'])?$model->editAnnouncement($this->validateInputs($_POST,[
                   'id','title','content','category','shortdesc','author' 
                ],'Edit')):NULL],['main','table','posts']);
                break;
            case 'View':
                $this->view('Admin/Announcements/View','View Announcement',['announcement' => $id!=NULL ? $model->getAnnouncement($id):false],['main','table','posts']);
                break;
            default:
                $this->view('Admin/Announcements/index','Manage Announcements',['announcements' => $model->getAnnouncements()],['main','table','posts']);
        }
    }
    public function Services($page='index')
    {
        $model = $this->model('ServiceModel');
        switch($page){
            default:
                $this->view('Admin/Services/index','Manage Announcements',['services' => []],['main','table','posts']);
        }
    }
    public function Projects($page='index')
    {
        $model = $this->model('ProjectModel');
        switch($page){
            default:
                $this->view('Admin/Projects/index','Manage Projects',['projects' => []],['main','table','posts']);
        }
    }
    public function Events($page='index')
    {
        $model = $this->model('EventModel');
        switch($page){
            default:
                $this->view('Admin/Events/index','Manage Events',['events' => []],['main','table','posts']);
        }
    }
}