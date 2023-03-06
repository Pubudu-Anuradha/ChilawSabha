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
                $data = ['roles' => $model->get_roles()['result']];
                if (isset($_POST['Add'])) {
                    [$valid, $err] = $this->validateInputs($_POST, [
                        'email|e|u[users]', 'name|l[:255]', 'password|l[:255]', 'address|l[10:255]',
                        'contact_no', 'nic', 'role|i[1:4]'], 'Add');
                    $data['errors'] = $err;
                    $data['old'] = $_POST;
                    $data = array_merge(count($err) > 0 ?
                        // Set data according to presence of errors
                        ['errors' => $err] : ['Add' => $model->addStaff($valid)], $data);
                    $this->view('Admin/User/Add', 'Add a new User', $data,
                        ['Components/form']);
                } else {
                    $this->view('Admin/User/Add', 'Add a new User',
                        $data, ['Components/form']);
                }
                break;
            case 'Edit':
                $this->view('Admin/User/Edit', 'Edit User', ['edit' => isset($_POST['Edit']) ? $model->editStaff($id, $this->validateInputs($_POST, [
                    'email', 'name', 'address', 'contact_no',
                ], 'Edit')) : null, 'staff' => $id != null ? $model->getStaffbyID($id) : false], ['Components/form']);
                break;
            case 'Enable':
                $id != null ? $model->changestate($id, 'working') : false;
                $this->view('Admin/User/Disabled', 'Manage Disabled Users', ['Users' => $model->getStaff('disabled')], ['Components/table', 'posts']);
                break;
            case 'Disabled':
                $this->view('Admin/User/Disabled', 'Manage Disabled Users', ['Users' => $model->getStaff('disabled')], ['Components/table', 'posts']);
                break;
            case 'Disable':
                $id != null ? $model->changestate($id, 'disabled') : false;
                $this->view('Admin/User/index', 'Manage Users', ['Users' => $model->getStaff()], ['Components/table', 'posts']);
                break;
            default:
                $this->view('Admin/User/index', 'Manage Users', ['Users' => $model->getStaff()], ['Components/table', 'posts']);
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
