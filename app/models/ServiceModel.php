<?php require_once 'app/models/PostModel.php';
class ServiceModel extends PostModel{
    private $UNPINNED_DEFAULT_COUNT = 5;

    public function getCategories($assoc = false) {
        if($assoc) {
            $res = $this->select('service_categories')['result'] ?? [];
            $ret = [];
            foreach($res as $cat) {
                $ret[$cat['category_id']] = $cat['service_category'];
            }
            return $ret;
        }
        return $this->select('service_categories');
    }

    public function putService($data) {
        $service_fields = [
            'contact_no','contact_name','service_category'
        ];

        // Separate Steps from the data
        $service = [];
        $steps = $data['steps'] ?? [];
        if(isset($data['steps'])) unset($data['steps']);
        $steps = array_filter($steps, function($step) {
            return !empty($step);
        });

        foreach($service_fields as $field) {
            if(isset($data[$field]) || is_null($data[$field])) {
                $service[$field] = $data[$field];
                unset($data[$field]);
            }
        }

        $post_data = $data;

        $post = $this->putPost($post_data, 2);
        if ($post !== false) {
            $service['post_id'] = $post['put'][0];
            $this->insert('services', $service);
            for($i = 1;$i<=count($steps);++$i) {
                $this->insert('service_steps',[
                    'post_id' => $post['put'][0],
                    'step_no' => $i,
                    'step'    => $steps[$i-1]
                ]);
            }
        } else {
            // echo"err";
            // var_dump(mysqli_error($this->conn));
            return false;
        }
        return $post['put'] ?? false;
    }

    public function getServices($get_hidden = false) {
        $images = [];
        $conditions = ['p.post_type=2'];

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
        }

        if(isset($_GET['category']) && $_GET['category'] != 0) {
            $category = mysqli_real_escape_string($this->conn,$_GET['category']);
            $conditions[] = "a.service_category='$category'";
        }

        if(isset($_GET['search']) && !empty($_GET['search'])) {
            $search = mysqli_real_escape_string($this->conn, $_GET['search']);
            $search_fields = [
                'p.title',
                'p.short_description',
                'p.content',
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
        $services = $this->selectPaginated(
            'post p join services a join users u join service_categories c on
             p.post_id=a.post_id and u.user_id=p.posted_by and c.category_id=a.service_category',
            'p.post_id as post_id,
             p.title as title,
             p.short_description as short_description,
             p.content as content,
             p.pinned as pinned,
             p.hidden as hidden,
             p.views as views,
             c.service_category as service_category,
             c.category_id as category_id,
             u.name as posted_by,
             p.posted_time as posted_time',
            "$conditions ORDER BY p.posted_time $sort" );
        if (!($services['error'] ?? true)) {
            foreach ($services['result'] as $service) {
                $images_tmp = $this->select(
                    'post_images pi JOIN file_original_names orn ON pi.image_file_name=orn.name',
                    'orn.name as name,
                     orn.orig as orig',
                    "pi.post_id='{$service['post_id']}'")['result'] ?? [];
                $images[$service['post_id']] = $images_tmp;
            }
        }
        return [$services,$images] ?? [];
    }

    public function getService($id,$hidden_allowed = false,$cat_name = false) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $service = $this->select(
            'post p join services a join users u join service_categories c on
             p.post_id=a.post_id and u.user_id=p.posted_by and c.category_id=a.service_category',
            'p.post_id as post_id,
             p.title as title,
             p.short_description as short_description,
             p.content as content,
             p.pinned as pinned,
             p.hidden as hidden,
             p.views as views,
             u.name as posted_by,
             p.posted_time as posted_time,
             c.service_category as service_category,
             c.category_id as category_id,
             a.contact_no as contact_no,
             a.contact_name as contact_name',
            "p.post_id='$id' and p.post_type=2" . ($hidden_allowed ? '' : ' and p.hidden=0'));
        if (!($service['error'] ?? true)) {
            $steps = $this->select(
                'service_steps', '*', "post_id='$id' ORDER BY step_no"
            )['result'] ?? [];
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
            $service_edit_history = $this->select(
                'services_edit e join users u join service_categories c
                 on e.edited_by=u.user_id and c.category_id=e.service_category',
                'e.contact_no as contact_no,
                 e.contact_name as contact_name,
                 c.service_category as service_category,
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
            $steps_edit_history = $this->select('service_step_edit ss join users u on ss.edited_by=u.user_id',
                'ss.step_no as step_no,
                 ss.step_before as step_before,
                 ss.step_after as step_after,
                 u.name as edited_by,
                 ss.edited_time as edited_time',
                "ss.post_id='$id'")['result'] ?? [];
            $edits = array_merge(
                $service_edit_history,
                $post_edit_history,
                $steps_edit_history
            );

            usort($edits, function($a, $b) {
                return 
                IntlCalendar::fromDateTime($a['edited_time'], null)
                    ->before(IntlCalendar::fromDateTime($b['edited_time'], null));
            });
            return [$service['result'][0] ?? [], $images, $attachments,$edits,$steps];
        }
        return false;
    }

    public function editService($id,$post_data,$service_data,$new_steps) {
        $post = true;
        if(count($post_data) > 0) {
            $post = $this->editPost($id,$post_data);
        }
        if($post) {
            $current_service = $this->select('services','*',"post_id='$id'")['result'][0] ?? false;
            if($current_service !== false && count($service_data) > 0) {
                if($this->update('services',$service_data,"post_id='$id'")) { 
                    foreach($service_data as $field => $_) {
                        $service_data[$field] = $current_service[$field];
                    }
                    $service_data['post_id'] = $current_service['post_id'];
                    $service_data['edited_by'] = $_SESSION['user_id'];
                    $this->insert('services_edit',$service_data)['success'] ?? false;
                }
            }
        }
        $current_steps = $this->select('service_steps','*',"post_id='$id'")['result'] ?? [];
        $old_steps_numeric = [];
        $step_no = 1;
        foreach($current_steps as $step) {
            if($step['step'] !== '') {
                $old_steps_numeric[$step_no++] = $step['step'];
            }
        }
        $step_no = 1;
        $new_steps_numeric = [];
        foreach($new_steps as $step) {
            if($step !== '') {
                $new_steps_numeric[$step_no++] = $step;
            }
        }

        if(count($old_steps_numeric) > count($new_steps_numeric)) {
            $step_no = count($old_steps_numeric);
            for( ;$step_no <= count($old_steps_numeric);++$step_no) {
                $next_step = $step_no + 1;
                $this->delete('service_steps',"post_id='$id' and step_no='$step_no'");
                $this->update('service_steps',[
                    'step_no' => $step_no,
                ],"post_id='$id' and step_no='$next_step'");
                $this->insert('service_step_edit',[
                    'post_id' => $id,
                    'step_no' => $step_no,
                    'step_before' => $old_steps_numeric[$step_no],
                    'step_after' => '',
                    'edited_by' => $_SESSION['user_id']
                ]);
            }
        }
        foreach($new_steps_numeric as $step_no => $step) {
            if(($old_steps_numeric[$step_no]??null) != $step) {
                if(!isset($old_steps_numeric[$step_no])) {
                    $this->insert('service_steps',[
                        'post_id' => $id,
                        'step_no' => $step_no,
                        'step' => $step
                    ]);
                    $this->insert('service_step_edit',[
                        'post_id' => $id,
                        'step_no' => $step_no,
                        'step_before' => '',
                        'step_after' => $step,
                        'edited_by' => $_SESSION['user_id']
                    ]);
                } else if($old_steps_numeric[$step_no] != $step) {
                    $this->update('service_steps',['step' => $step],"post_id='$id' and step_no='$step_no'");
                    $this->insert('service_step_edit',[
                        'post_id' => $id,
                        'step_no' => $step_no,
                        'step_before' => $old_steps_numeric[$step_no],
                        'step_after' => $step,
                        'edited_by' => $_SESSION['user_id']
                    ]);
                }
            }
        }
        return $post;
    }

    public function getFrontPage() {
        $table = 'post p join services a join service_categories c join users u
             on p.post_id=a.post_id and u.user_id=p.posted_by and c.category_id=a.service_category';
        $columns = 'p.post_id as post_id,
             p.title as title,
             p.short_description as short_description,
             p.content as content,
             p.pinned as pinned,
             p.views as views,
             c.category_id as category_id,
             c.service_category as service_category,
             a.contact_no as contact_no,
             u.name as posted_by';
        $pinned = $this->select($table,$columns,"p.pinned=1 and p.hidden=0 ORDER BY p.posted_time DESC")['result'] ?? [];
        $unpinned = $this->select($table,$columns,"p.pinned=0 and p.hidden=0 ORDER BY p.posted_time DESC LIMIT " .$this->UNPINNED_DEFAULT_COUNT . ' OFFSET 0')['result'] ?? [];
        return array_merge($pinned,$unpinned);
    }
}