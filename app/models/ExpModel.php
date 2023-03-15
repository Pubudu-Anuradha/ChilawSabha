<?php class ExpModel extends Model{
  public function getTest()
  {
    return $this->select('test');
  }
  public function addRecord($data)
  {
    return $this->insert('test',$data);
  }
  public function UpdateRecord($id,$data)
  {
    $id = mysqli_real_escape_string($this->conn,$id);
    $update = $this->update('test',$data,"id='$id'");
    if($update['success']){
      $update['new'] = $this->select('test',conditions:"id='$id'")['result'][0];
    }
    return $update;
  }
}