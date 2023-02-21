<?php class Exp extends Controller{
  public function index()
  {
    $model = $this->model('ExpModel');
    $this->view('Exp/index',data:['tt' => $model->getTest()],styles:['main','table']);
  }
  public function Api($method){
    $reqJSON = file_get_contents('php://input');
    if($reqJSON){
      $reqJSON = json_decode($reqJSON);
      if($reqJSON)
        switch($method){
          case "test":
            $this->returnJSON([
                'Its'=>'Working',
                'inp'=>$reqJSON
              ]);
            break;
        }
      else $this->returnJSON([
        'error'=>'Error Parsing JSON'
      ]);
    }else{
      $this->returnJSON([
        'error' => 'Error getting request'
      ]);
    }
  }
}