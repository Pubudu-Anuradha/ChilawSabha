<?php

class AboutCity extends Controller
{

    public function index()
    {
        // TODO: Move this to Home controller
        $this->view('AboutCity/index', 'About City', [], ['main', 'aboutCity']);
    }

}
