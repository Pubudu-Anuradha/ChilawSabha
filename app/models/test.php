<?php
class test extends Model
{
    public function updatebooks($data)
    {
        $id = mysqli_real_escape_string($this->conn, $data['id']);
        $conditions = "id = $id"; // use real escaped strings if string
        unset($data['id']);
        return $this->updateprep('test', $data, $conditions);
    }

    public function deletebooks($data)
    {
        $id = mysqli_real_escape_string($this->conn, $data['id']);
        $conditions = "id = $id"; // use real escaped strings if string
        unset($data['id']);
        return $this->deleteprep('test', $conditions);
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
