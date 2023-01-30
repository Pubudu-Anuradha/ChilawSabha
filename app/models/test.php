<?php
class test extends Model
{
    public function updatebooks($id,$address)
    {
        return $this->updateprep('test', ["address" => $address], "id = $id");

    }
    public function deletebooks($id)
    {
        return $this->deleteprep('test', "id = $id");

    }
    public function insertbooks($id,$name,$address,$age)
    {
        return $this->insertprep('test', ["id" => $id, "name" => $name, "address" => $address, "age" => $age]);

    }
    public function searchbooks()
    {
        return $this->selectprep('test', "*");

    }
}