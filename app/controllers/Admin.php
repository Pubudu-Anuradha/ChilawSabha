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
}
