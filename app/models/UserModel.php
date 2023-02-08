<?php 
class UserModel extends Model{
    public function getUsers($state='working')
    {
        $condidions = ["s.state='$state'"];
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $search_term = mysqli_real_escape_string($this->conn,$_GET['search']);
            $search_fields = [
                'u.email',
                'u.name',
                'u.address',
                'u.contact_no',
                's.NIC',
            ];
            for($i = 0;$i<count($search_fields);++$i){
                $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
            }
            array_push($condidions,'('.implode(' || ',$search_fields).')');
        }

        if(isset($_GET['role']) && !empty($_GET['role']) && $_GET['role']!='All'){
            $role = mysqli_real_escape_string($this->conn,$_GET['role']);
            array_push($condidions,"s.role = '$role'");
        }
        
        $condidions = implode(' && ',$condidions);
        return $this->selectPaginated('user u join staff s on u.email=s.email and u.type="Staff"',
        'u.email as email,u.name as name,u.address as address,u.contact_no as contact_no,s.state as state,s.NIC as nic,s.Role as role',
        $condidions);
    }

    public function addUser($user)
    {
        $pass_hash = password_hash($user['password'],PASSWORD_DEFAULT);
        $user_data = [
            'email'=>$user['email'],
            'name'=>$user['name'],
            'password_hash'=>$pass_hash,
            'reset_code'=>NULL,
            'reset_code_time'=>NULL,
            'address'=>$user['address'],
            'contact_no'=>$user['contact_no'],
            'type'=>'Staff'
        ];
        $staff_data = [
            'email'=>$user['email'],
            'state'=>'working',
            'nic'=>$user['nic'],
            'role'=>$user['role']
        ];
        $inserted =  $this->insert('user',$user_data);
        if($inserted['success']){
            return $this->insert('staff',$staff_data);
        }else{
            return $inserted;
        }
    }
}