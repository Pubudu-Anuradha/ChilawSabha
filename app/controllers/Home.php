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
        if (isset($_POST['Add'])) {
            $validated = $this->validateInputs($_POST, [
                'id', 'name', 'address', 'age',
            ], 'Add');
            if ($validated) {
                $model = $this->model('test');
                $res = $model->insertbooks($validated);
                if ($res) {
                    echo "Added record";
                } else {
                    echo "Failed to add record";
                }
            }
        }

        // To update
        if (isset($_POST['Update'])) {
            if (isset($_POST['id']) && isset($_POST['address'])) {
                $model = $this->model('test');
                $model->updatebooks($_POST['id'], $_POST['address']);
            }
        }

        // To delete
        if (isset($_POST['Delete'])) {
            if (isset($_POST['id'])) {
                $model = $this->model('test');
                $model->deletebooks($_POST['id']);
            }
        }

        // To search
        $data = ['test' => $this->model('test')->searchbooks()];

        $this->view('Home/testmodelsview', $data);
    }

    public function PaginationTest()
    {

    }
}
