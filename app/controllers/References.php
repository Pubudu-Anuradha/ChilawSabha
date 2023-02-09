<?php
class References extends Controller{
    public function index(){
        $data = ['links'=>[
            'CRUD',
            'Pagination',
            'fileUpload',
            'imageUpload',
            'Styled/table',
            'Styled/form',
            'Styled/chart',
        ]];
        $this->view('References/index','Reference Pages',$data);
    }
    public function CRUD(){
        $data = [];
        // To insert
        if (isset($_POST['Add'])) {
            $validated = $this->validateInputs($_POST, [
                'id', 'name', 'address', 'age',
            ], 'Add');
            if ($validated) {
                $data['Add'] = $this->model('ReferenceModel')->insertBooks($validated);
            } else {
                $data['Add'] = ['error' => true, 'errmsg' => 'Invalid Input detected']; // Should handle better
            }
        }

        // To update
        if (isset($_POST['Update'])) {
            $validated = $this->validateInputs($_POST, [
                'id', 'address',
            ], 'Update');
            if ($validated) {
                $data['Update'] = $this->model('ReferenceModel')->updateBooks($validated);
            } else {
                $data['Add'] = ['error' => true, 'errmsg' => 'Invalid Input detected']; // Should handle better
            }
        }

        // To delete
        if (isset($_POST['Delete'])) {
            $validated = $this->validateInputs($_POST, [
                'id',
            ], 'Delete');
            if ($validated) {
                $data['Delete'] = $this->model('ReferenceModel')->deleteBooks($validated);
            } else {
                $data['Delete'] = ['error' => true, 'errmsg' => 'Invalid Input detected']; // Should handle better
            }
        }

        // To search
        $data['test'] = $this->model('ReferenceModel')->searchBooks();

        $this->view('References/CRUD','CRUD Reference', $data);
    }

    public function Pagination()
    {
        $model = $this->model('ReferenceModel');
        $this->view('References/Pagination','Pagination Reference', ['test' => $model->getPaginatedTable()]);
    }

    public function Styled($name){
        $this->view('References/Styled/'.$name,$name,[],['main',$name]);
    }

    public function imageUpload(){
        if(isset($_POST['Upload'])){
            $upload_data = Upload::storeUploadedImages('public/upload/','img');
            $this->view('References/imageUpload','Upload Images',['uploads'=>$upload_data]);
        }else{
            $this->view('References/imageUpload','Upload Images',[]);
        }
    }
    
    public function fileUpload(){
        if(isset($_POST['Upload'])){
            $upload_data = Upload::storeUploadedFiles('downloads/','testfiles',true);
            $this->view('References/fileUpload','File Upload',['uploads'=>$upload_data]);
        }else{
            $this->view('References/fileUpload','File Upload',[]);
        }
    }
}