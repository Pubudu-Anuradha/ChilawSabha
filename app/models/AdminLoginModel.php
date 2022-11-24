<?php
class AdminLoginModel extends Model
{
    public function getStaffUserCredentials($email)
    {
        return $this->select('staff', '*', "email='$email'");
    }
}
