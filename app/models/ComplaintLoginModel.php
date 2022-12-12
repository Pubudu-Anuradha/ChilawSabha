<?php
class ComplaintLoginModel extends Model
{
    public function getComplainHandlerCredentials($email)
    {
        return $this->select('staff', 'password_hash,role', "email='$email'");
    }
}
