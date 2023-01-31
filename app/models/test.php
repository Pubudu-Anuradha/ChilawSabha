<?php
class test extends Model
{
    public function updatebooks($id, $address)
    {
        return $this->updateprep('test', ["address" => $address], "id = $id");
    }

    public function deletebooks($id)
    {
        return $this->deleteprep('test', "id = $id");
    }

    public function insertbooks($data)
    {
        return $this->insertprep('test', $data);
    }

    public function searchbooks()
    {
        return $this->selectprep('test', "*");

    }
}
