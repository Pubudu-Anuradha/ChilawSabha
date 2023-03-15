<?php
class Posts extends Controller{
    public function index()
    {
    }
    // TODO: Announcements
    public function Announcements()
    {
        $model = $this->model('AnnouncementModel');
        $model->getFrontPage();
    }
    public function Announcement($id)
    {
    }
    // TODO: Services
    public function Services()
    {
    }
    public function Service($id)
    {
    }
    // TODO: Projects
    public function Projects()
    {
    }
    public function Project($id)
    {
    }
    // TODO: Events
    public function Events()
    {
    }
    public function Event($id)
    {
    }
}