<?php
class paginationModel extends Model
{
    public function getTestTable()
    {
        return $this->selectPaginated('test');
    }
}
