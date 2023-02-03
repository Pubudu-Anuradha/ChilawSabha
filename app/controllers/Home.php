<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('Home/index');
    }
    public function file(){
        if(isset($_POST['Upload'])){
            echo "<pre>";
            // var_dump($_POST);
            // var_dump($_FILES);
            var_dump(Upload::storeUploadedImages('upload','img'));
            echo "</pre>";
        }
        $this->view('Home/file',[]);
    }
}
