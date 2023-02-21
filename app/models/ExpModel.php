<?php class ExpModel extends Model{
  public function getTest()
  {
    return $this->select('test');
  }
}