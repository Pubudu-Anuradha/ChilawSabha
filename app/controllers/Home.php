<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha');
    }

    public function image(){
        if(isset($_POST['Upload'])){
            $upload_data = Upload::storeUploadedImages('public/upload/','img');
            $this->view('Home/image',['uploads'=>$upload_data]);
        }else{
            $this->view('Home/image',[]);
        }
    }
    
    public function files(){
        if(isset($_POST['Upload'])){
            $upload_data = Upload::storeUploadedFiles('downloads/','testfiles',true);
            $this->view('Home/files',['uploads'=>$upload_data]);
        }else{
            $this->view('Home/files',[]);
        }
    }

    public function homeTest()
    {
        $this->view('Home/homeTest', 'Home Test', [], ['main', 'home']);
    }  
}
