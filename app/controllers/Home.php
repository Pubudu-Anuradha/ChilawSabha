<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('Home/index');
    }
    public function file(){
        if(isset($_POST['Upload'])){
            $upload_data = Upload::storeUploadedImages('public/upload/','img');
            $this->view('Home/file',['uploads'=>$upload_data]);
        }else{
            $this->view('Home/file',[]);
        }
    }
}
