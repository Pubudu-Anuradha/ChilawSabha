<?php require_once 'post/commonModel.php';
class AnnouncementModel extends PostModel {
    public function putAnnouncement($data) {
        // Separate Post and Announcement data
        // ? nothing to separate yet 
        $post_data = $data;
        $post = $this->putPost($post_data,1);
        if($post !== false) {
            // ? nothing announcement specific to do?
        }
        return [$post];
    }

    public function getAnnouncement($id) {
        $id = mysqli_real_escape_string($this->conn,$id);
        $announcement = $this->select(
            // 'post p join announcements a on p.post_id=a.post_id',
            'post p',
            'p.title as title,
             p.short_description as short_description,
             p.content as content,
             p.visible_start_date as visible_start_date',
        "p.post_id='$id'");
        if(!($announcement['error'] ?? true)) {
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
            return [$announcement['result'] ?? [],$images,$attachments];
        } else {
            return  false;
        }
    }
}
// class AnnouncementModel extends Model
// {
//     public function putAnnouncement($announcement, $images, $attachments)
//     {
//         unset($announcement['attachments']);
//         unset($announcement['photos']);
//         $announcement['post_type'] = 1;
//         $announcement['posted_by'] = $_SESSION['user_id'];
//         $announcement['views'] = 0;
//         var_dump($announcement);
//         $insert = $this->insert('post', $announcement);
//         var_dump($insert);
//         if ($insert['success'] ?? false) {
//             $id = $this->conn->query('SELECT LAST_INSERT_ID() AS id');
//             if ($id) {
//                 $id = $id->fetch_all(MYSQLI_ASSOC)[0]['id'] ?? false;
//                 if ($id !== false) {
//                     if ($images) {
//                         foreach ($images as $image) {
//                             if (!($image['error'] ?? true)) {
//                                 $this->insert('post_images',[
//                                     'post_id'=>$id,
//                                     'image_file_name'=>$image['name']
//                                 ]);
//                             }
//                         }
//                     }
//                     if ($attachments) {
//                         foreach ($attachments as $attachment) {
//                             if (!($attachment['error'] ?? true)) {
//                                 $this->insert('post_attachments',[
//                                     'post_id'=>$id,
//                                     'attach_file_name'=>$image['name']
//                                 ]);
//                             }
//                         }
//                     }
//                 }
//                 return ['id' => $id];
//             } else {
//                 return ['id' => null];
//             }
//         } else {
//             return false;
//         }
//     }

//     // public function getAnnouncements()
//     // {
//     //     $condidions = ["p.type='announcement'"];
//     //     // search=&category=All&sort=DESC&page=1&size=50
//     //     if(isset($_GET['search']) && !empty($_GET['search'])){
//     //         $search_term = mysqli_real_escape_string($this->conn,$_GET['search']);
//     //         $search_fields = [
//     //             'p.title',
//     //             'p.content',
//     //             'a.shortdesc',
//     //             'a.author',
//     //         ];
//     //         for($i = 0;$i<count($search_fields);++$i){
//     //             $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
//     //         }
//     //         array_push($condidions,'('.implode(' || ',$search_fields).')');
//     //     }

//     //     if(isset($_GET['category']) && !empty($_GET['category']) && $_GET['category']!='All'){
//     //         $category = mysqli_real_escape_string($this->conn,$_GET['category']);
//     //         array_push($condidions,"a.category = '$category'");
//     //     }

//     //     $sort = 'DESC';
//     //     if(isset($_GET['sort'])){
//     //         $sort = $_GET['sort'];
//     //         if(!($sort=='ASC' || $sort=='DESC')){
//     //             $sort = 'DESC';
//     //         }
//     //     }

//     //     $condidions = implode(' && ',$condidions);
//     //     return $this->selectPaginated(
//     //         'post p join announcement a on p.id=a.id',
//     //         'p.id as id,p.title as title,a.shortdesc as shortdesc,p.content as description,p.date as date,a.category as category,a.author as author',
//     //         "$condidions ORDER BY p.date $sort"
//     //     );
//     // }
//     // public function getAnnouncement($id)
//     // {
//     //     return $this->select(
//     //         'post p join announcement a on p.id=a.id',
//     //         'p.id as id,p.title as title,a.shortdesc as shortdesc,p.content as description,p.date as date,a.category as category,a.author as author',
//     //         "p.id=$id"
//     //     );
//     // }
//     // public function addAnnouncement($data){
//     //     return $this->callProcedure('putAnnouncement',[
//     //         $data['title'],
//     //         $data['content'],
//     //         $data['category'],
//     //         $data['shortdesc'],
//     //         $data['author'],
//     //     ]);
//     // }
//     // public function editAnnouncement($id,$data){
//     //     $posts = $this->update('post',[
//     //         'title'=>$data['title'],
//     //         'content'=>$data['content'],
//     //     ],"id=$id");
//     //     $announce = $this->update('announcement',[
//     //         'category'=>$data['category'],
//     //         'shortdesc'=>$data['shortdesc'],
//     //         'author'=>$data['author']
//     //     ],"id=$id");
//     //     return[
//     //         'posts' =>$posts,
//     //         'announce' =>$announce
//     //     ];
//     // }
// }
