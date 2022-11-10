<?php

class Controller
{

    //A function for child classes to get an instance of a defined model
    public function model($model)
    {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    //Render a defined view and pass the data provided by the caller
    public function view($view, $data = [])
    {
        require_once 'app/views/' . $view . '.php'; 
    }
}
