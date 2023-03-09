<?php

class Admin extends Controller
{
    public function __construct()
    {
        $this->authenticateRole('Admin');
    }

    public function index()
    {
        // TODO: overhaul the statistics
        $model = $this->model('AdminStatModel');

        $this->view('Admin/index', 'Admin DashBoard', ['EventStat' => $model->getEventStat()], ['main', 'chart']);
    }

    public function Users($page = 'index', $id = null)
    {
        $model = $this->model('StaffModel');
        switch ($page) {
            case 'Add':
                $data = ['roles' => $model->get_roles()['result'] ?? [0 => 'error getting roles']];
                if (isset($_POST['Add'])) {
                    [$valid, $err] = $this->validateInputs($_POST, [
                        'email|l[:255]|e|u[users]',
                        'name|l[:255]',
                        'password|l[5:]',
                        'address|l[:255]',
                        'contact_no|l[10:12]',
                        'nic|l[10:12]',
                        'role|i[1:4]',
                    ], 'Add');
                    $data['errors'] = $err;
                    $data['old'] = $_POST;
                    if (count($err) == 0) {
                        $data = array_merge(
                            ['Add' => $model->addStaff($valid)],
                            $data
                        );
                    }
                    $this->view('Admin/User/Add', 'Add a new User', $data,
                        ['Components/form']);
                } else {
                    $this->view('Admin/User/Add', 'Add a new User',
                        $data, ['Components/form']);
                }
                break;
            case 'Edit':
                $data = [];
                if (isset($_POST['Edit'])) {
                    $changes = [];
                    $current_user = $model->getStaffByID($id)['result'][0];
                    $validator = [
                        'email' => 'email|u[users]|l[:255]|e',
                        'name' => 'name|l[:255]',
                        'address' => 'address|l[:255]',
                        'contact_no' => 'contact_no|l[10:12]',
                    ];
                    foreach ($current_user as $field => $value) {
                        if (isset($_POST[$field])) {
                            if ($_POST[$field] !== $value) {
                                if ($validator[$field] ?? false) {
                                    $changes[] = $validator[$field];
                                }
                            } else {
                                unset($_POST[$field]);
                            }
                        }
                    }

                    if (count($changes) > 0) {
                        [$valid, $err] = $this->validateInputs($_POST, $changes, 'Edit');
                        $data['errors'] = $err;
                        $data['old'] = $_POST;
                        if (count($err) == 0) {
                            $data = array_merge(
                                ['Edit' => !is_null($id) ? $model->editStaff($id, $valid) : null],
                                $data
                            );
                            if (($data['Edit']['success'] ?? false) == true) {
                                $edit_history = [];
                                foreach($valid as $field => $value) {
                                    $edit_history[$field] = $current_user[$field];
                                }
                                $edit_history = array_merge($edit_history, [
                                    'user_id' => $id,
                                    'edited_by' => $_SESSION['user_id'],
                                ]);
                                if (isset($edit_history['Edit'])) {
                                    unset($edit_history['Edit']);
                                }

                                $model->putEditHistory($edit_history);
                            }
                        }
                    }
                }
                if ($id != null) {
                    $res = $model->getEditHistory($id)['result'] ?? false;
                    if (!($res['nodata'] ?? false)) {
                        $data['edit_history'] = $res;
                    }
                }
                $this->view('Admin/User/Edit', 'Edit user', array_merge(
                    ['staff' => $id != null ? $model->getStaffByID($id) : false], $data),
                    ['Components/form','Admin/index']);
                break;
            case 'Disable':
                if(isset($_POST['confirm'])){
                    $error = false;
                    if($id != null && $id!=$_SESSION['user_id']) {
                        [$valid,$err] = $this->validateInputs($_POST,[
                            'disable_reason|l[:255]'
                        ],'confirm');
                        if($model->changeState($id, 2, $valid) == false){
                            $id = null;
                            $error = true;
                        }
                    }
                    $this->view('Admin/User/index', 'Manage Users', [
                        'disabled' => ($id != null && $id != $_SESSION['user_id']) ?
                        $model->getStaffByID($id) : false,
                        'disable_error' => $error,
                        'self_disable_error' => ($id != null && $id == $_SESSION['user_id']),
                        'Users' => $model->getStaff(),
                        'roles' => $model->get_roles()['result'] ?? [0 => 'error getting roles']
                    ], ['Components/table', 'posts']);
                } else {
                    $this->view('Admin/User/Disable', 'Disable User' ,[
                    'disabled' => ($id != null && $id != $_SESSION['user_id']) ?
                    $model->getStaffByID($id) : false,
                    ],['Components/form']);
                }
                break;
            case 'Enable':
                if(isset($_POST['confirm'])) {
                    $error = false;
                    if($id != null && $id!=$_SESSION['user_id']) {
                        [$valid,$err] = $this->validateInputs($_POST,[
                            're_enabled_reason|l[:255]'
                        ],'confirm');
                        if($model->changeState($id, 1, $valid) == false){
                            $id = null;
                            $error = true;
                        }
                    }
                    $this->view('Admin/User/Disabled', 'Manage Disabled Users', [
                        'enabled' => $id != null ? $model->getStaffByID($id) : false,
                        'enable_error' => $error,
                        'Users' => $model->getStaff(2),
                        'roles' => $model->get_roles()['result'] ?? [0 => 'error getting roles']
                    ], ['Components/table', 'posts']);
                }else{
                    $this->view('Admin/User/Enable', 'Re-Enable User' ,[
                    'enable' => ($id != null && $id != $_SESSION['user_id']) ?
                    $model->getStaffByID($id) : false,
                    ],['Components/form']);
                }
                break;
            case 'Disabled':
                $this->view('Admin/User/Disabled', 'Manage Disabled Users',
                    ['Users' => $model->getStaff(2),
                     'roles' => $model->get_roles()['result'] ?? [0 => 'error getting roles']],
                    ['Components/table', 'posts']
                );
                // $this->view('Admin/User/Disabled', 'Manage Disabled Users', ['Users' => $model->getStaff('disabled')], ['Components/table', 'posts']);
                break;
            default:
                $this->view('Admin/User/index', 'Manage Users',
                    ['Users' => $model->getStaff(),
                        'roles' => $model->get_roles()['result'] ?? [0 => 'error getting roles']],
                    ['Components/table', 'posts']
                );
        }
    }
    public function Announcements($page = 'index', $id = null)
    {
        $model = $this->model('AnnouncementModel');

        switch ($page) {
            case 'Add':
                $this->view('Admin/Announcements/Add', 'Add Announcement',
                    ['Add' => isset($_POST['Add']) ? $model->addAnnouncement($this->validateInputs($_POST, [
                        'title', 'category', 'shortdesc', 'author', 'content',
                    ], 'Add')) : null], ['Components/form']);
                break;
            case 'Edit':
                $this->view('Admin/Announcements/Edit', 'Edit Announcement', ['edit' => isset($_POST['Edit']) ? $model->editAnnouncement($id, $this->validateInputs($_POST, [
                    'title', 'content', 'category', 'shortdesc', 'author',
                ], 'Edit')) : null, 'announcement' => $id != null ? $model->getAnnouncement($id) : false], ['Components/form']);
                break;
            case 'View':
                $this->view('Admin/Announcements/View', 'View Announcement', ['announcement' => $id != null ? $model->getAnnouncement($id) : false], ['Components/table', 'posts']);
                break;
            default:
                $this->view('Admin/Announcements/index', 'Manage Announcements', ['announcements' => $model->getAnnouncements()], ['Components/table', 'posts']);
        }
    }
    public function Services($page = 'index')
    {
        $model = $this->model('ServiceModel');
        switch ($page) {
            default:
                $this->view('Admin/Services/index', 'Manage Announcements', ['services' => []], ['Components/table', 'posts']);
        }
    }
    public function Projects($page = 'index')
    {
        $model = $this->model('ProjectModel');
        switch ($page) {
            default:
                $this->view('Admin/Projects/index', 'Manage Projects', ['projects' => []], ['Components/table', 'posts']);
        }
    }
    public function Events($page = 'index')
    {
        $model = $this->model('EventModel');
        switch ($page) {
            default:
                $this->view('Admin/Events/index', 'Manage Events', ['events' => []], ['Components/table', 'posts']);
        }
    }
}
