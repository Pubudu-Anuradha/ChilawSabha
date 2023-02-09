<?php

class Admin extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('Admin');
    }

    public function index()
    {
        $this->view('Admin/index');
    }

    public function tableTest()
    {
        $this->view('Admin/tableTest', 'Tables', [], ['main', 'table']);
    }
    public function chart()
    {
        $this->view('Admin/chart', 'chart', [], ['main', 'chart']);
    }
}
