<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha');
    }

    public function test()
    {
        // To insert
        if (isset($_POST['Submit'])) {
            if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['age'])) {
                $model = $this->model('test');
                $model->insertbooks($_POST['id'], $_POST['name'], $_POST['address'], $_POST['age']);

            }

        }

        // To search
        // $data = ['test' => $this->model('test')->searchbooks()];

        // To update
        // if (isset($_POST['Submit'])) {
        //     if (isset($_POST['id']) && isset($_POST['address'])) {
        //         $model = $this->model('test');
        //         $model->updatebooks($_POST['id'], $_POST['address']);
        //     }
        // }

        // To delete
        // if (isset($_POST['Submit'])) {
        //     if (isset($_POST['id'])) {
        //         $model = $this->model('test');
        //         $model->deletebooks($_POST['id']);
        //     }
        // }


        $this->view('Home/testmodelsview');
    }

}
