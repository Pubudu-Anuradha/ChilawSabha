<?php class Components extends Controller
{
  public function index()
  {
    $this->view('Components/index','Components test',[],['main','form']);
  }
  public function pagination()
  {
    $this->view('Components/pagination','Pagination test',[],['main','table','posts']);
  }
}