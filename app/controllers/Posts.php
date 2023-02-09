<?php
class Posts extends Controller{
    public function index()
    {
    }
    public function Announcements()
    {
        $model = $this->model('postModel');
        $this->view('Posts/announcements','Posts Test',['Posts'=>$model->getPosts()],['main','posts']);
    }
    public function Announcement($id)
    {
        $model = $this->model('postModel');
        $this->view('Posts/announcement','Posts Test',['Announcement'=>$model->getPost($id)],['main','posts']);
    }
}