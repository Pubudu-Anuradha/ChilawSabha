<?php

class LibraryUserManageModel extends Model
{
    public function getUsers($state=1)
    {
        $conditions = ["u.state_id=$state"];
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $search_term = mysqli_real_escape_string($this->conn,$_GET['search']);
            $search_fields = [
                'l.membership_id',
                'u.email',
                'u.name',
                'u.address',
                'u.contact_no',
                'l.nic',
            ];
            for($i = 0;$i<count($search_fields);++$i){
                $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
            }
            array_push($conditions,'('.implode(' || ',$search_fields).')');
        }
        
        $conditions = implode(' && ',$conditions);

        if($state==2){
            $conditions = $conditions . '&& m.re_enabled_desscription IS NULL && m.re_enabled_by IS NULL && m.re_enabled_time IS NULL';
            return $this->selectPaginated(
                'users u join library_member l on u.user_id=l.user_id join disabled_members m on m.user_id=l.member_id',
            'l.membership_id as membership_id,u.email as email,u.name as name,u.address as address,u.contact_no as contact_no,l.nic as nic,m.disable_description as disable_description',
            $conditions);
        }
        
        return $this->selectPaginated(
            'users u join library_member l on u.user_id=l.user_id',
        'l.membership_id as membership_id,u.email as email,u.name as name,u.address as address,u.contact_no as contact_no,l.nic as nic',
        $conditions);
    }

    public function getUserbyID($id)
    {
        return $this->select('users u join library_member l on u.user_id=l.user_id',
            'u.user_id,u.name,u.email,u.contact_no,u.address,l.member_id,l.membership_id,l.nic',"u.user_type=2 && l.membership_id=$id");
    }

    public function changeState($id,$state, $data =[])
    {
        $id = mysqli_real_escape_string($this->conn,$id);
        date_default_timezone_set('Asia/Colombo');
        if($state == 2){
            $count = $this->select('disabled_members','count(user_id) as count',"user_id=$id && re_enabled_desscription IS NULL");
            if(isset($count['result']) && $count['result'][0]['count']==0){
                $res = $this->insert('disabled_members', [
                    'user_id' => $id,
                    'disable_description' => $data['disable_description'],
                    'disabled_by' => $_SESSION['user_id'],
                    'disabled_time' => date("Y-m-d H:i:s")
                ]);

                if ($res) {
                    return $this->update('users', [
                        'state_id' => 2,
                    ], "user_id='".$data['user_id']."'");
                }
                return false; 
            }
        
        }
        else if($state ==1){
            $res = $this->update('disabled_members', [
                're_enabled_desscription' => $data['enable_description'],
                're_enabled_by' => $_SESSION['user_id'],
                're_enabled_time' => date("Y-m-d H:i:s")
            ],"user_id=$id && re_enabled_desscription IS NULL && re_enabled_by IS NULL && re_enabled_time IS NULL");

            if ($res) {
                return $this->update('users', [
                    'state_id' => 1,
                ], "user_id='".$data['user_id']."'");
            }
            return false;  
        }
    }
}
