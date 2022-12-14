<?php

class Storage extends Controller{
    public function __construct(){
        $this->authenticateRole('Storage');
    }

    public function index(){
        $this->view('Storage/index');
    }

    public function AddNewItemType(){
        $data = [];
        if(isset($_POST['Submit'])){
            unset($_POST['Submit']);
            if(isset($_POST['item_name']) && !empty($_POST['item_name']) && isset($_POST['item_category']) && !empty($_POST['item_category']) && isset($_POST['min_stock']) && !empty($_POST['min_stock']) && isset($_POST['max_stock']) && !empty($_POST['max_stock'])){
                $model = $this->model('ItemModel');
                $result = $model->AddNewItemType($_POST['item_id'], $_POST['item_name'], $_POST['item_category'], $_POST['min_stock'], $_POST['max_stock']);
                if($result){
                    $data['message'] = 'New item type added successfully!';
                }else{
                    $data['message'] = 'Failed to add New item type!';
                }
            }else{
                $data['message'] = 'Invalid Parameters';
            }
        }
        $this->view('Storage/AddNewItemType', $data);
    }

    public function ViewItems()
    {
        $data = ['items' => $this->model('ItemModel')->ViewItems()];
        $this->view('Storage/ViewItems', $data);
    }
}