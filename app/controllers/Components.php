<?php class Components extends Controller
{
  public function index()
  {
    $this->view('Components/index','Components test',[],['Components/form']);
  }
  public function pagination()
  {
    $this->view('Components/pagination','Pagination test',[],['Components/table','posts']);
  }
  public function table()
  {
    $this->view('Components/table','Table test',[],['Components/table','posts']);
  }
}