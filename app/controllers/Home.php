<?php

class Home extends Controller
{
    public function index()
    {
        $this->view('Home/index', 'Chilaw Pradeshiya Sabha');
    }

    public function test()
    {
        $data = [];
        // To insert
        if (isset($_POST['Add'])) {
            $validated = $this->validateInputs($_POST, [
                'id', 'name', 'address', 'age',
            ], 'Add');
            if ($validated) {
                $data['Add'] = $this->model('test')->insertbooks($validated);
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
                $data['Update'] = $this->model('test')->updatebooks($validated);
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
                $data['Delete'] = $this->model('test')->deletebooks($validated);
            } else {
                $data['Delete'] = ['error' => true, 'errmsg' => 'Invalid Input detected']; // Should handle better
            }
        }

        // To search
        $data['test'] = $this->model('test')->searchbooks();

        $this->view('Home/testmodelsview', $data);
    }

    public function PaginationTest()
    {
        $model = $this->model('paginationModel');
        $this->view('Home/pagination', ['test' => $model->getTestTable()]);
    }
}
