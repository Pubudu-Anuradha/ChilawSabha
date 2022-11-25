<?php
class LibraryLoginModel extends Model
{
    public function getStaffUserCredentials($email)
    {
        return $this->select('staff', 'password_hash,role', "email='$email'");
    }

    public function getLibraryUserCredentials($email)
    {
        return $this->select('member', 'password_hash,role', "email='$email'");
    }
}
