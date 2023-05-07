<?php

class AboutCity extends Controller
{

    public function index()
    {
        $this->view('AboutCity/index', 'About City', [], ['main', 'Components/slideshow']);
    }

}
