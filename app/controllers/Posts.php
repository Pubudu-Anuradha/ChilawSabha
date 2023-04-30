<?php
class Posts extends Controller{
    public function index()
    {
    }
    // TODO: Announcements
    public function Announcements()
    {
        $model = $this->model('AnnouncementModel');
        $this->view('Posts/announcements','Announcements',[
            'ann' => $model->getAnnouncements(), 'types' => $model->getTypes()
        ],['posts','Posts/index']);
    }
    public function Announcement($id)
    {
        $model = $this->model('AnnouncementModel');
        $announcement = $model->getAnnouncement($id);
        $this->view('Posts/announcement',$announcement[0]['title'] ?? 'Not found',[
            'ann' => $announcement, 'types' => $model->getTypes()
        ],['posts','Posts/index','Components/slideshow']);
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
        $model = $this->model('ProjectModel');
        $this->view('Posts/projects','Projects',[
            'projects' => $model->getProjects(),'status' => $model->getStatus()
        ],['posts','Posts/index']);
    }
    public function Project($id)
    {
        $model = $this->model('ProjectModel');
        $project = $model->getProject($id);
        $this->view('Posts/project',$project[0]['title'] ?? 'Not found',[
            'project' => $project, 'status' => $model->getStatus()
        ],['posts','Posts/index','Components/slideshow']);
    }
    // TODO: Events
    public function Events()
    {
        $model = $this->model('EventModel');
        $this->view('Posts/events','Events',[
            'events' => $model->getEvents()
        ],['posts','Posts/index']);
    }
    public function Event($id)
    {
        $model = $this->model('EventModel');
        $event = $model->getEvent($id);
        $this->view('Posts/event',$event[0]['title'] ?? 'Not found',[
            'event' => $event
        ],['posts','Posts/index','Components/slideshow']);
    }
    public function Viewed($id) {
        $model = $this->model('PostModel');
        $this->returnJSON($model->incrementViews($id));
    }
}