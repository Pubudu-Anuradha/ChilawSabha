<?php require_once 'PostModel.php';
class ProjectModel extends PostModel{
    private $UNPINNED_DEFAULT_COUNT = 5;

    public function putProject($data) {
        // Separate Post and Project data
        $project = [
            'status' => $data['status'],
        ];
        unset($data['status']);


        if(isset($data['start_date']) || is_null($data['start_date'])) {
            $project['start_date'] = $data['start_date'];
            unset($data['start_date']);
        }

        if(isset($data['expected_end_date']) || is_null($data['expected_end_date'])) {
            $project['expected_end_date'] = $data['expected_end_date'];
            unset($data['expected_end_date']);
        }

        if(isset($data['budget']) || is_null($data['budget'])) {
            $project['budget'] = $data['budget'];
            unset($data['budget']);
        }

        if(isset($data['other_parties']) || is_null($data['other_parties'])) {
            $project['other_parties'] = $data['other_parties'];
            unset($data['other_parties']);
        }

        $post_data = $data;
        $post = $this->putPost($post_data, 3);
        if ($post !== false) {
            $project['post_id'] = $post['put'][0];
            var_dump($project);
            var_dump($this->insert('projects', $project));
        } else {
            var_dump(mysqli_error($this->conn));
        }
        return $post['put'] ?? false;
    }

    public function getProject($id,$hidden_allowed = false) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $project = $this->select(
            // 'post p join projects a on p.post_id=a.post_id',
            'post p join projects a join project_status ps join users u
             on p.post_id=a.post_id and ps.status_id=a.status and u.user_id=p.posted_by',
            'p.post_id as post_id,
             p.title as title,
             p.short_description as short_description,
             p.content as content,
             ps.project_status as status,
             a.status as status_id,
             p.pinned as pinned,
             p.hidden as hidden,
             p.views as views,
             u.name as posted_by,
             p.posted_time as posted_time,
             a.start_date as start_date,
             a.expected_end_date as expected_end_date,
             a.budget as budget,
             a.other_parties as other_parties',
            "p.post_id='$id' and p.post_type=3" . ($hidden_allowed ? '' : ' and p.hidden=0'));
        if (!($project['error'] ?? true)) {
            $images = $this->select(
                'post_images pi JOIN file_original_names orn ON pi.image_file_name=orn.name',
                'orn.name as name,
                 orn.orig as orig',
                "pi.post_id='$id'")['result'] ?? [];
            $attachments = $this->select(
                'post_attachments pa JOIN file_original_names orn ON pa.attach_file_name=orn.name',
                'orn.name as name,
                 orn.orig as orig',
                "pa.post_id='$id'")['result'] ?? [];
            $proj_edit_history = $this->select(
                'projects_edit e join project_status ps join users u
                 on e.edited_by=u.user_id and e.status=ps.status_id',
                'ps.project_status as status,
                 e.start_date as start_date,
                 e.expected_end_date as expected_end_date,
                 e.budget as budget,
                 e.other_parties as other_parties,
                 u.name as edited_by,
                 e.edited_time as edited_time',
                "e.post_id='$id'")['result'] ?? [];
            $post_edit_history = $this->select(
                'post_edit e join users u
                 on e.edited_by=u.user_id',
                'e.post_type as post_type,
                 e.title as title,
                 e.short_description as short_description,
                 e.content as content,
                 e.pinned as pinned,
                 e.hidden as hidden,
                 u.name as edited_by,
                 e.edited_time as edited_time',
                "e.post_id='$id'")['result'] ?? [];
            $edits = array_merge(
                $proj_edit_history,
                $post_edit_history
            );

            usort($edits, function($a, $b) {
                return 
                IntlCalendar::fromDateTime($a['edited_time'], null)
                    ->before(IntlCalendar::fromDateTime($b['edited_time'], null));
            });
            return [$project['result'][0], $images, $attachments,$edits];
        }
        return false;
    }

    public function getProjects($get_hidden = false) {
        $images = [];
        $conditions = ['p.post_type=3'];

        if($get_hidden) {
            if(isset($_GET['hidden']) && $_GET['hidden'] != 2) {
                $hidden = mysqli_real_escape_string($this->conn, $_GET['hidden']);
                $conditions[] = "p.hidden='$hidden'";
            }
        } else {
            $conditions[] = "p.hidden=0";
        }

        if(isset($_GET['pinned']) && $_GET['pinned'] != 2) {
            $pinned = mysqli_real_escape_string($this->conn, $_GET['pinned']);
            $conditions[] = "p.pinned='$pinned'";
        }

        if(isset($_GET['status']) && $_GET['status'] != 0) {
            $status = mysqli_real_escape_string($this->conn, $_GET['status']);
            $conditions[] = "a.status='$status'";
        }

        if(isset($_GET['search']) && !empty($_GET['search'])) {
            $search = mysqli_real_escape_string($this->conn, $_GET['search']);
            $search_fields = [
                'p.title',
                'p.short_description',
                'p.content',
                'a.other_parties'
            ];
            for($i = 0; $i < count($search_fields); ++$i) {
                $search_fields[$i] = $search_fields[$i] . " LIKE '%$search%'";
            }
            $conditions[] = '(' . implode(' || ', $search_fields) . ')';
        }

        $sort = 'DESC';
        if(isset($_GET['sort'])) {
            $sort = mysqli_real_escape_string($this->conn, $_GET['sort']);
            if($sort != 'ASC' && $sort != 'DESC') {
                $sort = 'DESC';
            }
        }

        $conditions = implode(' && ', $conditions);
        $projects = $this->selectPaginated(
            'post p join projects a join project_status ps join users u on 
            p.post_id=a.post_id and u.user_id=p.posted_by and ps.status_id=a.status',
            'p.post_id as post_id,
             p.title as title,
             p.short_description as short_description,
             p.content as content,
             a.status as status_id,
             ps.project_status as status,
             p.pinned as pinned,
             p.hidden as hidden,
             p.views as views,
             u.name as posted_by,
             p.posted_time as posted_time,
             a.start_date as start_date,
             a.expected_end_date as expected_end_date,
             a.budget as budget,
             a.other_parties as other_parties',
            "$conditions ORDER BY p.posted_time $sort" );
        if (!($projects['error'] ?? true)) {
            foreach ($projects['result'] as $project) {
                $images_tmp = $this->select(
                    'post_images pi JOIN file_original_names orn ON pi.image_file_name=orn.name',
                    'orn.name as name,
                     orn.orig as orig',
                    "pi.post_id='{$project['post_id']}'")['result'] ?? [];
                $images[$project['post_id']] = $images_tmp;
            }
        }
        return [$projects,$images] ?? [];
    }

    public function editProject($id,$post_data,$project_data) {
        $post = true;
        if(count($post_data) > 0) {
            $post = $this->editPost($id,$post_data);
        }
        if($post) {
            $current_project = $this->select('projects','*',"post_id='$id'")['result'][0] ?? false;
            if($current_project !== false) {
                if($this->update('projects',$project_data,"post_id='$id'")) { 
                    foreach($project_data as $field => $_) {
                        $project_data[$field] = $current_project[$field];
                    }
                    $project_data['post_id'] = $current_project['post_id'];
                    $project_data['edited_by'] = $_SESSION['user_id'];
                    return $this->insert('projects_edit',$project_data)['success'] ?? false;
                }
                return false;
            }
            return false;
        }
        return $post;
    }

    public function getFrontPage() {
        $table = 'post p join projects a join users u join project_status ps
             on p.post_id=a.post_id and u.user_id=p.posted_by and ps.status_id=a.status';
        $columns = 'p.post_id as post_id,
             p.title as title,
             p.short_description as short_description,
             p.content as content,
             a.status as status_id,
             ps.project_status as status,
             p.pinned as pinned,
             p.views as views,
             u.name as posted_by,
             p.posted_time as posted_time,
             a.start_date as start_date,
             a.expected_end_date as expected_end_date,
             a.budget as budget,
             a.other_parties as other_parties';
        $pinned = $this->select($table,$columns,"p.pinned=1 ORDER BY p.posted_time DESC")['result'] ?? [];
        $unpinned = $this->select($table,$columns,"p.pinned=0 ORDER BY p.posted_time DESC LIMIT " .$this->UNPINNED_DEFAULT_COUNT . ' OFFSET 0')['result'] ?? [];
        return array_merge($pinned,$unpinned);
    }

    public function getStatus() {
        return $this->select('project_status')['result'] ?? [];
    }
}