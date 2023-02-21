<?php class ExpModel extends Model{
  public function getTest()
  {
    return $this->select('test');
  }
  public function addRecord($data)
  {
    return $this->insert('test',$data);
  }
}