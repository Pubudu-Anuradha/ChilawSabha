<?php
class Posts extends Controller{
    public function index()
    {
        $model = $this->model('postModel');
        $this->view('Posts/announcements','Posts Test',['Posts'=>$model->getPosts()],['main','posts']);
    }
    public function single()
    {
        $this->view('Posts/announcement','Posts Test',[],['main','posts']);
    }
}