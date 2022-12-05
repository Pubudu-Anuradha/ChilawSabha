<?php
class LibraryLoginModel extends Model
{
    public function getStaffUserCredentials($email)
    {
        return $this->select('staff', '*', "email='$email'");
    }

    public function getLibraryUserCredentials($email)
    {
        return $this->select('member', '*', "email='$email'");
    }
}
