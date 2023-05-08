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
                'u.contact_no'
            ];
            for($i = 0;$i<count($search_fields);++$i){
                $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
            }
            array_push($conditions,'('.implode(' || ',$search_fields).')');
        }

        $conditions = implode(' && ',$conditions);

        if($state==2){
            $conditions = $conditions . '&& m.re_enabled_description IS NULL && m.re_enabled_by IS NULL && m.re_enabled_time IS NULL ORDER BY l.membership_id';
            return $this->selectPaginated(
                'users u join library_member l on u.user_id=l.user_id join disabled_members m on m.user_id=l.member_id',
            'l.membership_id as membership_id,u.email as email,u.name as name,u.address as address,u.contact_no as contact_no,m.disable_description as disable_description',
            $conditions);
        }

        $conditions = $conditions . ' ORDER BY l.membership_id';
        return $this->selectPaginated(
            'users u join library_member l on u.user_id=l.user_id',
        'l.membership_id as membership_id,u.email as email,u.name as name,u.address as address,u.contact_no as contact_no',
        $conditions);
    }

    public function getUserbyID($id)
    {
        return $this->select('users u join library_member l on u.user_id=l.user_id join user_state s on s.state_id=u.state_id',
            'u.user_id,u.name,u.email,u.contact_no,u.address,l.member_id,l.membership_id,s.state',"u.user_type=2 && l.membership_id=$id");
    }

    public function changeState($id,$state, $data =[])
    {
        $id = mysqli_real_escape_string($this->conn,$id);
        date_default_timezone_set('Asia/Colombo');
        if($state == 2){
            $count = $this->select('disabled_members','count(user_id) as count',"user_id=$id && re_enabled_description IS NULL");
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
                're_enabled_description' => $data['enable_description'],
                're_enabled_by' => $_SESSION['user_id'],
                're_enabled_time' => date("Y-m-d H:i:s")
            ],"user_id=$id && re_enabled_description IS NULL && re_enabled_by IS NULL && re_enabled_time IS NULL");

            if ($res) {
                return $this->update('users', [
                    'state_id' => 1,
                ], "user_id='".$data['user_id']."'");
            }
            return false;
        }
    }

    public function addLibraryUser($user)
    {
        $pw = strlen((string)$user['membership_id']);
        $password = $user['membership_id'];

        while($pw < 8){
          $password .= '0';
          $pw++;
        }
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        date_default_timezone_set('Asia/Colombo');

        $res = $this->insert('users',[
            'email' => $user['email'],
            'user_type' => 2,
            'state_id' => 1,
            'name' => $user['name'],
            'contact_no' => $user['contact_no'],
            'address' => $user['address'],
            'password_hash' => $pass_hash
        ]);

        if($res){
            $user_id = $this->select('users','user_id',"email='".$user['email']."'")['result'][0]['user_id'];
            if(isset($user_id) && !empty($user_id)){
                return $this->insert('library_member',[
                    'membership_id' => $user['membership_id'],
                    'user_id' => $user_id,
                    'added_by' => $_SESSION['user_id'],
                    'added_time' => date("Y-m-d H:i:s")
                ]);
            }
            else{
                return false;
            }
        }
        return false;
    }

    public function editLibraryUser($id,$user)
    {
        $user_id = mysqli_real_escape_string($this->conn, $id);
        return $this->update('users',$user,"user_id=$user_id and user_type=2");
    }

    public function putMemberEditHistory($history)
    {
        return $this->insert('edit_library_member', $history);
    }

    public function getMemberEditHistory($id)
    {
        $user_id = mysqli_real_escape_string($this->conn,$id);

        return $this->select('edit_library_member e join users u on u.user_id=e.edited_by',
        'e.name as name,e.email as email,e.address as address,e.contact_no as contact_no,u.name as changed_by,e.edited_time as time',
        "e.user_id='$user_id' ORDER BY e.edited_time DESC");
    }

    public function getMemberStateHistory($id) {

        $user_id = mysqli_real_escape_string($this->conn,$id);

        return $this->select('disabled_members dm join library_member l on l.member_id=dm.user_id join users u on u.user_id=l.user_id join users u2 on u2.user_id=dm.disabled_by LEFT JOIN users u3 on dm.re_enabled_by=u3.user_id',
        'dm.disable_description as d_reason,u2.name as d_name,dm.disabled_time as d_time, dm.re_enabled_description as r_reason, u3.name as r_name, dm.re_enabled_time as r_time',
        "l.user_id='$user_id' and u.user_type=2 ORDER BY dm.disabled_time DESC");
    }
}
