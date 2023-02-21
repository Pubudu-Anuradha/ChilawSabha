<?php class Exp extends Controller{
  public function index()
  {
    $model = $this->model('ExpModel');
    $this->view('Exp/index',data:['tt' => $model->getTest()],styles:['main','table']);
  }
  public function Api($method,$id=null){
    $model = $this->model('ExpModel');
    $reqJSON = file_get_contents('php://input');
    if($reqJSON){
      $reqJSON = json_decode($reqJSON,associative:true);
      if($reqJSON){
        switch($method){
          case 'test':
            $this->returnJSON([
                'Its'=>'Working',
                'inp'=>$reqJSON
              ]);
            break;
          case 'add':
            $validated = $this->validateInputs($reqJSON,['name','address','age'],'add');
            if($validated)
            $this->returnJSON($model->addRecord($validated));
            else $this->returnJSON($reqJSON);
            break;
          case 'update':
            if(!is_null($id)){
              $this->returnJSON($model->updateRecord($id,$reqJSON));
            }else $this->returnJSON(['error'=>'please specify id']);
            break;
        }
        die();
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