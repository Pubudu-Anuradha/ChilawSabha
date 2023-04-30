<?php require_once 'app/models/PostModel.php';
class EventModel extends PostModel{
    private $UNPINNED_DEFAULT_COUNT = 5;

    public function putEvent($data) {
        $event_fields = [
            'start_time','end_time'
        ];
        $event = [];
        foreach($event_fields as $field) {
            if(isset($data[$field]) || is_null($data[$field])) {
                $event[$field] = $data[$field];
                unset($data[$field]);
            }
        }

        $post_data = $data;

        $post = $this->putPost($post_data, 4);
        if ($post !== false) {
            $event['post_id'] = $post['put'][0];
            $this->insert('events', $event);
        } else {
            var_dump(mysqli_error($this->conn));
            die();
        }
        return $post['put'] ?? false;
    }

    public function getEvents($get_hidden = false) {
        $images = [];
        $conditions = ['p.post_type=4'];

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
        $events = $this->selectPaginated(
            'post p join events a join users u on 
            p.post_id=a.post_id and u.user_id=p.posted_by',
            'p.post_id as post_id,
             p.title as title,
             p.short_description as short_description,
             p.content as content,
             p.pinned as pinned,
             p.hidden as hidden,
             p.views as views,
             u.name as posted_by,
             p.posted_time as posted_time,
             a.start_time as start_time,
             a.end_time as end_time',
            "$conditions ORDER BY p.posted_time $sort" );
        if (!($events['error'] ?? true)) {
            foreach ($events['result'] as $event) {
                $images_tmp = $this->select(
                    'post_images pi JOIN file_original_names orn ON pi.image_file_name=orn.name',
                    'orn.name as name,
                     orn.orig as orig',
                    "pi.post_id='{$event['post_id']}'")['result'] ?? [];
                $images[$event['post_id']] = $images_tmp;
            }
        }
        return [$events,$images] ?? [];
    }

    public function getEvent($id,$hidden_allowed = false) {
        $id = mysqli_real_escape_string($this->conn, $id);
        $event = $this->select(
            'post p join events a join users u on 
            p.post_id=a.post_id and u.user_id=p.posted_by',
            'p.post_id as post_id,
             p.title as title,
             p.short_description as short_description,
             p.content as content,
             p.pinned as pinned,
             p.hidden as hidden,
             p.views as views,
             u.name as posted_by,
             p.posted_time as posted_time,
             a.start_time as start_time,
             a.end_time as end_time',
            "p.post_id='$id' and p.post_type=4" . ($hidden_allowed ? '' : ' and p.hidden=0'));
        if (!($event['error'] ?? true)) {
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
            $event_edit_history = $this->select(
                'events_edit e join users u
                 on e.edited_by=u.user_id',
                'e.start_time as start_time,
                 e.end_time as end_time,
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
                $event_edit_history,
                $post_edit_history
            );

            usort($edits, function($a, $b) {
                return 
                IntlCalendar::fromDateTime($a['edited_time'], null)
                    ->before(IntlCalendar::fromDateTime($b['edited_time'], null));
            });
            return [$event['result'][0], $images, $attachments,$edits];
        }
        return false;
    }

    public function editEvent($id,$post_data,$event_data) {
        $post = true;
        if(count($post_data) > 0) {
            $post = $this->editPost($id,$post_data);
        }
        if($post) {
            $current_event = $this->select('events','*',"post_id='$id'")['result'][0] ?? false;
            if($current_event !== false) {
                if($this->update('events',$event_data,"post_id='$id'")) { 
                    foreach($event_data as $field => $_) {
                        $event_data[$field] = $current_event[$field];
                    }
                    $event_data['post_id'] = $current_event['post_id'];
                    $event_data['edited_by'] = $_SESSION['user_id'];
                    return $this->insert('events_edit',$event_data)['success'] ?? false;
                }
                return false;
            }
            return false;
        }
        return $post;
    }
}