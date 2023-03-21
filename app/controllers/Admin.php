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
            case 'View':
                $data = [
                        'user_id' => $id,
                        'user' => ($id != null) ? 
                                    ($model->getStaffById($id)['result'][0] ?? false) : false,
                        'edit_history' => ($id != null) ? 
                                    ($model->getEditHistory($id)['result'] ?? false) : false,
                        'state_history' => ($id != null) ?
                                    ($model->getStateHistory($id)['result'] ?? false) : false
                ];
                $this->view('Admin/User/View', 'User:' . ($data['user']['name'] ?? 'Not found'),
                            $data, ['Components/form','Admin/index','Components/table']);
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
                $this->view('Admin/User/Disabled', 'Manage Disabled Users', ['Users' => $model->getStaff('disabled')], ['Components/table', 'posts']);
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
                if(isset($_POST['Add'])) {
                    [$valid,$err] = $this->validateInputs($_POST,[
                        'title|u[post]|l[:255]',
                        'short_description|l[:1000]',
                        'content',
                        'ann_type_id|i[1:]',
                        'pinned|?',
                        'attachments|?',
                        'photos|?',
                    ],'Add');
                    if(count($err) == 0) {
                        $this->view('Admin/Announcements/Add','Add a new Announcement',
                                    [$model->putAnnouncement($valid),$valid,$err,$_FILES,'types'=>$model->getTypes()],
                                    ['Components/form']);
                    } else {
                        $this->view('Admin/Announcements/Add','Add a new Announcement',
                                    ['types'=>$model->getTypes(),'old'=>$_POST,'errors' => $err],['Components/form']);
                    }
                } else {
                    $this->view('Admin/Announcements/Add','Add a new Announcement',
                                ['types'=>$model->getTypes()],['Components/form']);
                }
                break;
            case 'Edit':
                $data = [];
                $post_changes = [];
                $ann_changes = [];
                $current_post = $model->getAnnouncement($id,true);
                if(isset($_POST['Edit'])){
                    if($current_post !== false) {
                        $post_validator = [
                            'title' => 'title|u[post]|l[:255]',
                            'short_description' => 'short_description|l[:1000]',
                            'content' => 'content',
                            'pinned' => 'pinned|i[0:1]|?',
                            'hidden' => 'hidden|i[0:1]|?',
                        ];
                        $ann_validator = [
                            'ann_type_id' => 'ann_type_id|i[1:]', // in announcement table
                        ];

                        $post_data = $_POST;
                        // Turning 'on' or 'off' to integer
                        $post_data['pinned'] = boolval($post_data['pinned'] ?? false) ? 1 : 0;
                        $post_data['hidden'] = boolval($post_data['hidden'] ?? false) ? 1 : 0;
                        $ann_data = $_POST;

                        foreach($post_validator as $field => $_) {
                            unset($ann_data[$field]);
                        }
                        foreach($ann_validator as $field => $_) {
                            unset($post_data[$field]);
                        }
                        // Keeping only changed values to pass to edit
                        foreach ($current_post[0] as $field => $value) {
                            if (isset($post_data[$field])) {
                                if ($post_data[$field] !== $value) {
                                    if ($post_validator[$field] ?? false) {
                                        $post_changes[] = $post_validator[$field];
                                    }
                                } else {
                                    unset($post_data[$field]);
                                }
                            }
                            if (isset($ann_data[$field])) {
                                if ($ann_data[$field] !== $value) {
                                    if ($ann_validator[$field] ?? false) {
                                        $ann_changes[] = $ann_validator[$field];
                                    }
                                } else {
                                    unset($ann_data[$field]);
                                }
                            }
                        }
                        [$valid_post,$err_post] = $this->validateInputs($post_data,$post_changes,'Edit');
                        [$valid_ann,$err_ann] = $this->validateInputs($ann_data,$ann_changes,'Edit');
                        $err = array_merge($err_ann,$err_post);
                        if(count($err) == 0) {
                            if($model->editAnnouncement($id,$valid_post,$valid_ann)) {
                                $data['edited'] = true;
                            } else {
                                $data['edited'] = false;
                            }
                        }else {
                            $data['errors'] = $err;
                        }
                    }
                }else if(isset($_POST['AddPhotos'])) {
                    $data['AddPhotos'] = $model->addPhotos($id,'photos');
                }else if(isset($_POST['AddAttach'])) {
                    $data['AddAttach'] = $model->addAttachments($id,'attachments');
                }
                $this->view('Admin/Announcements/Edit','Edit Announcement',array_merge($data,[
                    'ann' => $model->getAnnouncement($id,true),
                    'types' => $model->getTypes()
                    ]), ['Components/form','Components/table','Admin/post']);
                break;
            case 'View':
                $this->view('Admin/Announcements/View','Announcement',[
                    'announcement' => $model->getAnnouncement($id,true),
                    'types' => $model->getTypes()
                ],['Admin/post','Components/table']);
                break;
            default:
                $this->view('Admin/Announcements/index', 'Manage Announcements', ['announcements' => $model->getAnnouncements(true),'types'=>$model->getTypes()], ['Components/table', 'posts']);
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
    public function Projects($page = 'index',$id = null)
    {
        $model = $this->model('ProjectModel');
        switch ($page) {
            case 'Add': 
                if(isset($_POST['Add'])) {
                    [$valid,$err] = $this->validateInputs($_POST,[
                        'title|u[post]|l[:255]',
                        'short_description|l[:1000]',
                        'content',
                        'pinned|?',
                        'status|i[:]',
                        'start_date|dt[:]|?',
                        'expected_end_date|dt[:]|?',
                        'budget|d[:]|?',
                        'other_parties|?',
                        'attachments|?',
                        'photos|?',
                    ],'Add');

                    $valid['pinned'] = boolval($valid['pinned'] ?? false) ? 1 : 0;


                    if(count($err) == 0) {
                        $putProject = $model->putProject($valid);
                        if($putProject !== false) {
                            header('Location: '.URLROOT.'/Admin/Projects/View/'.$putProject[0]);
                            die();
                        }
                    }
                    $this->view('Admin/Projects/Add','Add a new Project',
                                ['errors' => $err,
                                'status' => $model->getStatus()],['Components/form']);
                } else {
                    $this->view('Admin/Projects/Add','Add a new Project',['status'=> $model->getStatus()],['Components/form']);
                }
                break;
            case 'View':
                $this->view('Admin/Projects/View','Project',[
                    'project' => $model->getProject($id,true),
                    'status' => $model->getStatus()
                ],['Admin/post','Components/table','Admin/index']);
                break;
            default:
                $this->view('Admin/Projects/index', 'Manage Projects', ['projects' => $model->getProjects(true) ], ['Components/table', 'posts']);
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

    public function postsApi($method = null,$id = null){
        $reqJSON = file_get_contents('php://input');
        if($reqJSON) {
            $body = json_decode($reqJSON,associative:true);
            if(!$body) {
                $this->returnJSON(['error' => 'JsonParse']);
            } else {
                $model = $this->model('PostModel');
                switch($method) {
                    case 'Pin':
                        [$valid,$err] = $this->validateInputs($body,[
                            'pinned|i[0:1]'
                        ],'Pin');
                        if(count($err) == 0) {
                            $this->returnJSON(['success' => ($model->editPost($id,$valid)!== false)]);
                        }else{
                            $this->returnJSON($err);
                        }
                        break;
                    case 'Hide':
                        [$valid,$err] = $this->validateInputs($body,[
                            'hidden|i[0:1]'
                        ],'Hide');
                        if(count($err) == 0) {
                            $this->returnJSON(['success' => ($model->editPost($id,$valid)!== false)]);
                        }else{
                            $this->returnJSON($err);
                        }
                        break;
                    case 'delPhoto':
                        $this->returnJSON(
                            ['success' => $model->removePhoto($id,$body['filename'] ?? '')]
                        );
                        break;
                    case 'delAttach':
                        $this->returnJSON(
                            ['success' => $model->removeAttach($id,$body['filename'] ?? '')]
                        );
                        break;
                    default:
                        $this->returnJSON(['error' => 'Method']);
                }
            }
        } else {
            $this->returnJSON(['error' => 'Request']);
        }
    }
}
