<?php 
class StaffModel extends Model {
    public function getStaff($state=1)
    {
        $conditions = ["us.state_id=$state"];

        // Add Search condition if given
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

        // Add Role condition if given
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

    public function getStaffByID($id)
    {
        return $this->select('users u join user_state us join staff s join staff_type st
             on u.user_id=s.user_id and us.state_id=u.state_id and u.user_type=1 and st.staff_type_id=s.staff_type',
        'u.user_id as user_id,u.email as email,u.name as name,u.address as address,u.contact_no as contact_no,us.state as state,s.nic as nic,st.staff_type as role',
        "u.user_id=$id");
    }

    public function addStaff($user)
    {
        // Calling a pre-made procedure to add a new User
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
        $user_id = mysqli_real_escape_string($this->conn,$id);
        // Changes are filtered in the controller
        return $this->update('users',$data,"user_id='$user_id' and user_type=1");
    }

    public function changeState($id,$state,$reason=[]){
        $user_id = mysqli_real_escape_string($this->conn,$id);
        // state 1 = enabled, 2 = disabled
        if($state == 2) {
            $reason['user_id'] = $user_id;
            $reason['disabled_by'] = $_SESSION['user_id'];
            $res = $this -> insert('disabled_staff',$reason);
            if($res){
                return $this->update('users',[
                    'state_id'=> 2
                ],"user_id='$user_id' and user_type=1");
            }
            return false;
        }else if($state == 1) {
            $last_disable = $this->select(
                'disabled_staff','disable_id',"user_id='$user_id' and re_enabled_by IS NULL and re_enabled_reason IS NULL and re_enabled_time IS NULL")
                ['result'][0]['disable_id'] ?? false;
            if($last_disable !== false) {
                $re_by = $_SESSION['user_id'];
                $reason = mysqli_real_escape_string($this->conn,$reason['re_enabled_reason']);
                $query = "UPDATE disabled_staff SET re_enabled_by='$re_by', 
                          re_enabled_reason='$reason',re_enabled_time=current_timestamp() 
                          WHERE disable_id='$last_disable'";
                $result = $this->conn->query($query);
                if($result) {
                    return $this->update('users',[
                        'state_id'=> 1
                    ],"user_id='$user_id' and user_type=1");
                }
                return false;
            }
            return false;
        }
        return ($state == 1 || $state == 2) ? $this->update('users',[
            'state_id'=>$state
        ],"user_id='$user_id' and user_type=1") : false;
    }

    public function getStateHistory($id) {
        // Get HIstory of state changes
        $user_id = mysqli_real_escape_string($this->conn,$id);
        return $this->select('disabled_staff ds join users u on u.user_id=ds.user_id join users u2 on u2.user_id=ds.disabled_by LEFT JOIN users u3 on ds.re_enabled_by=u3.user_id',
        'ds.disable_reason as d_reason,u2.name as d_name,ds.disabled_time as d_time, ds.re_enabled_reason as r_reason, u3.name as r_name, ds.re_enabled_time as r_time',
        "ds.user_id='$user_id' and u.user_type=1 ORDER BY ds.disabled_time DESC");
    }

    public function putEditHistory($data){
        // Add edit history
        return $this->insert('edit_staff',$data);
    }

    public function getEditHistory($id) {
        // Get edit history
        $user_id = mysqli_real_escape_string($this->conn,$id);
        return $this->select('edit_staff e join users u on u.user_id=e.edited_by',
        'e.name as name,e.email as email,e.address as address,e.contact_no as contact_no,u.name as changed_by,e.edited_time as time',
        conditions:"e.user_id='$user_id' ORDER BY e.edited_time DESC");
    }
}