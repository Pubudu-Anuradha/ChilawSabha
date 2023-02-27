<?php

class Controller
{
    //Flag used to render the relevant sidebar when a user logged in
    protected $logged_in_user = false;

    //A function for child classes to get an instance of a defined model
    public function model($model)
    {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    public function pdf()
    {
        require_once 'app/TCPDF/TCPDF-main/tcpdf.php';
        return new TCPDF();
    }

    //Render a defined view and pass the data provided by the caller
    public function view($view, $title = 'Chilaw Pradeshiya Sabha', $data = [], $styles = [])
    {
        if($this->logged_in_user){
            array_push($styles,'loggedin_layout');
        }
        require_once 'app/views/Header.php';
        if($this->logged_in_user){
            require_once 'app/views/' . $_SESSION['role'] . '/Sidebar.php';
        }
        require_once 'app/views/' . $view . '.php';
        require_once 'app/views/Footer.php';
    }

    //Check authenitation for a role by seeing if session variables are set properly.
    //If not, redirect to appropriate page using $redir parameter
    public function authenticateRole($role, $redir = '/Home/')
    {
        if (!isset($_SESSION['login'])) {
            header('location:' . URLROOT . $redir);
            die();
        } else if ($_SESSION['role'] != $role) {
            header('location:' . URLROOT . '/Other/Forbidden');
            die();
        } else{
            $this->logged_in_user = true;
        }
    }

    // A function for ensuring that all fields in $fields and only those fields are in the $data array as keys,
    // And ensuring that their values aren't empty. If valid the valid array will be returned, false otherwise.
    protected function validateInputs($data, $fields, $submitMethod = 'Submit')
    {
        if (isset($data[$submitMethod])) {
            unset($data[$submitMethod]);
        }
        $validated = [];
        foreach ($fields as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                // Add fields with non empty value to validated array
                $validated[$field] = $data[$field];
                unset($data[$field]); // remove the field from original array
            } else {
                // false if either field isn't set or value is empty
                return false;
            }
        }

        if ($data) {
            // False if more data is left on $data
            return false;
        }

        // return the valid data
        return $validated;
    }
}
