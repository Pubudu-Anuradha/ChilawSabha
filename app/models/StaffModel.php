<?php 
class StaffModel extends Model{
    public function getStaff($state=1)
    {
        $conditions = ["us.state_id=$state"];
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $search_term = mysqli_real_escape_string($this->conn,$_GET['search']);
            $search_fields = [
                'u.email',
                'u.name',
                'u.address',
                'u.contact_no',
                's.nic',
            ];
            for($i = 0;$i<count($search_fields);++$i){
                $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
            }
            array_push($conditions,'('.implode(' || ',$search_fields).')');
        }

        if(isset($_GET['role']) && !empty($_GET['role']) && $_GET['role']!='0'){
            $role = mysqli_real_escape_string($this->conn,$_GET['role']);
            array_push($conditions,"st.staff_type_id = '$role'");
        }
        
        $conditions = implode(' && ',$conditions);
        
        return $this->selectPaginated(
            'users u join user_state us join staff s join staff_type st
             on u.user_id=s.user_id and us.state_id=u.state_id and u.user_type=1 and st.staff_type_id=s.staff_type',
        'u.user_id as user_id,u.email as email,u.name as name,u.address as address,u.contact_no as contact_no,us.state as state,s.nic as nic,st.staff_type as role',
        $conditions);
    }

    public function get_roles(){
        return $this->select('staff_type');
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
            $_SESSION['user_id']
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