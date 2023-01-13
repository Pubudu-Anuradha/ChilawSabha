<?php
class LoginModel extends Model
{
    public function getUserCredentials($email)
    {
        return $this->select('staff', '*', "email='$email'");
    }
}
