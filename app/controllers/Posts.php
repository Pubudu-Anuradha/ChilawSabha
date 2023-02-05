<?php
class Posts extends Controller{
    public function index()
    {
        $this->view('Posts/index','Posts Test',[],['main','posts']);
    }
}