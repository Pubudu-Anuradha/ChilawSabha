<?php
class ReferenceModel extends Model
{
    public function updateBooks($data)
    {
        $id = mysqli_real_escape_string($this->conn, $data['id']);
        $conditions = "id = $id"; // use real escaped strings if string
        unset($data['id']);
        return $this->update('test', $data, $conditions);
    }

    public function deleteBooks($data)
    {
        $id = mysqli_real_escape_string($this->conn, $data['id']);
        $conditions = "id = $id"; // use real escaped strings if string
        unset($data['id']);
        return $this->delete('test', $conditions);
    }

    public function insertBooks($data)
    {
        return $this->insert('test', $data);
    }

    public function searchBooks()
    {
        return $this->select('test');
    }

    public function getPaginatedTable()
    {
        return $this->selectPaginated('test');
    }
}
