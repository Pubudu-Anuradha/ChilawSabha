<?php class Exp extends Controller{
  // EXAMPLE ONLY. DELETE WHEN DONE
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
            $validated = $this->validateInputs($reqJSON,['name|e|l[:255]','address','age|i[10:20]','time','test|?','test1|l[1:]','test2|?|l[:100]','test2|?|l[1:100]',],'add');
            // if(!$validated['error'])
            // $this->returnJSON($model->addRecord($validated));
            // else $this->returnJSON($reqJSON);
            $this->returnJSON($validated);
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