<?php 
class StaffModel extends Model{
    public function getStaff($state='working')
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
        
        return $this->selectPaginated('user u join staff s on u.user_id=s.user_id and u.type="Staff"',
        'u.user_id as user_id,u.email as email,u.name as name,u.address as address,u.contact_no as contact_no,s.state as state,s.nic as nic,s.role as role',
        $condidions);
    }

    public function getStaffbyID($id)
    {
        return $this->select('user u join staff s on u.user_id=s.user_id and u.type="Staff"',
        'u.user_id as user_id,u.email as email,u.name as name,u.address as address,u.contact_no as contact_no,s.state as state,s.nic as nic,s.role as role',
        "s.state='working' && u.user_id=$id");
    }

    public function addStaff($user)
    {
        $pass_hash = password_hash($user['password'],PASSWORD_DEFAULT);
        return $this->callProcedure('addStaff',[
            $user['name'],
            $user['email'],
            $pass_hash,
            $user['address'],
            $user['contact_no'],
            $user['nic'],
            $user['role'],
        ]);

    }
    public function editStaff($id,$data){
        $user = $this->update('user',$data,"user_id=$id");
        return[
            'user' =>$user,
        ];
    }
    public function changeState($id,$state){
        $user = $this->update('staff',[
            'state'=>$state
        ],"user_id=$id");
        return[
            'user' =>$user,
        ];
    }

}