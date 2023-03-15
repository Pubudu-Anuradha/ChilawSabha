<?php require_once 'PostModel.php';
class AnnouncementModel extends PostModel
{
    private $UNPINNED_DEFAULT_COUNT = 5;

    public function putAnnouncement($data)
    {
        // Separate Post and Announcement data
        $announcement = [
            'ann_type_id' => $data['ann_type_id'],
        ];
        unset($data['ann_type_id']);
        $data['pinned'] = boolval($data['pinned'] ?? 0);
        $post_data = $data;
        $post = $this->putPost($post_data, 1);
        if ($post !== false) {
            $announcement['post_id'] = $post['put'][0];
            $this->insert('announcements', $announcement);
        }
        return [$post];
    }

    public function getAnnouncement($id,$hidden_allowed = false)
    {
        $id = mysqli_real_escape_string($this->conn, $id);
        $announcement = $this->select(
            // 'post p join announcements a on p.post_id=a.post_id',
            'post p join announcements a join users u
             on p.post_id=a.post_id and u.user_id=p.posted_by join announcements_type at on at.ann_type_id=a.ann_type_id',
            'p.post_id as post_id,
             p.title as title,
             p.short_description as short_description,
             p.content as content,
             a.ann_type_id as ann_type_id,
             at.ann_type as ann_type,
             p.pinned as pinned,
             p.hidden as hidden,
             p.views as views,
             u.name as posted_by,
             p.posted_time as posted_time',
            "p.post_id='$id' and p.post_type=1" . ($hidden_allowed ? '' : ' and p.hidden=0'));
        if (!($announcement['error'] ?? true)) {
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
            $ann_edit_history = $this->select(
                'announcements_edit e join announcements_type at join users u
                 on e.edited_by=u.user_id and at.ann_type_id=e.ann_type_id',
                'at.ann_type as ann_type,
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
            $edits = array_merge($ann_edit_history, $post_edit_history);
            usort($edits, function ($a, $b) {
                return
                IntlCalendar::fromDateTime($a['edited_time'], null)
                    ->before(IntlCalendar::fromDateTime($b['edited_time'], null));
            });
            return [$announcement['result'][0] ?? [], $images, $attachments, $edits];
        } else {
            return false;
        }
    }

    public function getAnnouncements($get_hidden = false)
    {
        $conditions = ['p.post_type=1'];
        // search=&category=All&sort=DESC&page=1&size=50
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search_term = mysqli_real_escape_string($this->conn, $_GET['search']);
            $search_fields = [
                'p.title',
                'p.content',
                'p.short_description',
            ];

            for ($i = 0; $i < count($search_fields); ++$i) {
                $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
            }
            array_push($conditions, '(' . implode(' || ', $search_fields) . ')');
        }

        if (isset($_GET['category']) && !empty($_GET['category']) && $_GET['category'] != '0') {
            $category = mysqli_real_escape_string($this->conn, $_GET['category']);
            array_push($conditions, "a.ann_type_id = '$category'");
        }

        if($get_hidden) {
            if (isset($_GET['hidden']) && $_GET['hidden'] != 2) {
                $hidden = mysqli_real_escape_string($this->conn, $_GET['hidden']);
                array_push($conditions, "p.hidden = '$hidden'");
            }
        } else {
            array_push($conditions, "p.hidden = '0'");
        }

        if (isset($_GET['pinned']) && $_GET['pinned'] != 2) {
            $pinned = mysqli_real_escape_string($this->conn, $_GET['pinned']);
            array_push($conditions, "p.pinned = '$pinned'");
        }

        $sort = 'DESC';
        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
            if (!($sort == 'ASC' || $sort == 'DESC')) {
                $sort = 'DESC';
            }
        }

        $conditions = implode(' && ', $conditions);
        return $this->selectPaginated(
            // 'post p join announcement a on p.id=a.id',
            'post p join announcements a join announcements_type at on p.post_id=a.post_id and a.ann_type_id=at.ann_type_id left join users u on u.user_id=p.posted_by',
            'p.post_id as post_id,
            p.title as title,
            p.short_description as short_description,
            p.content as content,
            p.posted_time as posted_time,
            at.ann_type as ann_type,
            at.ann_type_id as t_id,
            p.pinned as pinned,
            p.hidden as hidden,
            p.views as views,
            u.name as posted_by',
            "$conditions ORDER BY p.pinned DESC,p.posted_time $sort"
        );
    }

    public function editAnnouncement($id, $post_data, $ann_data)
    {
        $post = true;
        if (count($post_data) > 0) {
            $post = $this->editPost($id, $post_data);
        }
        if ($post) {
            $current = $this->select('announcements', conditions:"post_id='$id'")['result'][0] ?? false;
            if ($current !== false) {
                if ($this->update('announcements', $ann_data, "post_id='$id'")['success'] ?? false) {
                    foreach ($ann_data as $field => $_) {
                        $ann_data[$field] = $current[$field];
                    }
                    $ann_data['post_id'] = $current['post_id'];
                    $ann_data['edited_by'] = $_SESSION['user_id'];
                    return $this->insert('announcements_edit', $ann_data)['success'] ?? false;
                }
            }
        }
        return $post;
    }

    public function getTypes()
    {
        return $this->select('announcements_type')['result'] ?? [];
    }

    public function getFrontPage()
    {
        $table = 'post p join announcements a join announcements_type at
             on p.post_id=a.post_id and a.ann_type_id=at.ann_type_id left join users u on u.user_id=p.posted_by';
        $columns = 'p.post_id as post_id,
                    p.title as title,
                    p.short_description as short_description,
                    p.posted_time as posted_time,
                    p.pinned as pinned,
                    a.ann_type_id as t_id,
                    at.ann_type as ann_type,
                    u.name as posted_by';

        $pinned = $this->select($table, $columns,
            "p.pinned=1 and p.hidden=0 ORDER BY p.posted_time DESC"
        )['result'] ?? [];

        $unpinned = $this->select($table, $columns,
            'p.pinned=0 and p.hidden=0 ORDER BY p.posted_time DESC LIMIT ' .
            $this->UNPINNED_DEFAULT_COUNT . ' OFFSET 0'
        )['result'] ?? [];
        return array_merge($pinned, $unpinned);
    }
}