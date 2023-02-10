<?php

class ContactUs extends Controller
{

    public function index()
    {
        $this->view('ContactUs/index', 'Contact Us', [], ['main', 'contactUs']);
    }

}
