<?php class Components extends Controller
{
  public function index()
  {
    $this->view('Components/index','Components test',[],['main','form']);
  }
}