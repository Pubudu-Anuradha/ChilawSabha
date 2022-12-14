<?php
class StorageLoginModel extends Model
{
    public function getStaffUserCredentials($email)
    {
        return $this->select('staff', '*', "email='$email'");
    }
}