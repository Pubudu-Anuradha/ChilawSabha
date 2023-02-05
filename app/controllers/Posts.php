<?php
class Posts extends Controller{
    public function index()
    {
        $this->view('Posts/announcements','Posts Test',[],['main','posts']);
    }
    public function single()
    {
        $this->view('Posts/announcement','Posts Test',[],['main','posts']);
    }
}