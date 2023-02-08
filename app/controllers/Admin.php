<?php

class Admin extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('Admin');
    }

    public function index()
    {
        $this->view('Admin/index');
    }
    public function Announcements($page='index')
    {
        $model = $this->model('AnnouncementModel');
        switch($page){
            default:
                $this->view('Admin/Announcements/index','Manage Announcements',['announcements' => $model->getAnnouncements()],['main','table','posts']);
        }
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
}
