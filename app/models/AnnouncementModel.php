<?php 
class AnnouncementModel extends Model{
    public function getAnnouncements()
    {
        $condidions = ["p.type='announcement'"];
        // search=&category=All&sort=DESC&page=1&size=50
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $search_term = mysqli_real_escape_string($this->conn,$_GET['search']);
            $search_fields = [
                'p.title',
                'p.content',
                'a.shortdesc',
                'a.author',
            ];
            for($i = 0;$i<count($search_fields);++$i){
                $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
            }
            array_push($condidions,'('.implode(' || ',$search_fields).')');
        }

        if(isset($_GET['category']) && !empty($_GET['category']) && $_GET['category']!='All'){
            $category = mysqli_real_escape_string($this->conn,$_GET['category']);
            array_push($condidions,"a.category = '$category'");
        }
        
        $sort = 'DESC';
        if(isset($_GET['sort'])){
            $sort = $_GET['sort'];
            if(!($sort=='ASC' || $sort=='DESC')){
                $sort = 'DESC';
            }
        }

        $condidions = implode(' && ',$condidions);
        return $this->selectPaginated(
            'post p join announcement a on p.id=a.id',
            'p.id as id,p.title as title,a.shortdesc as shortdesc,p.content as description,p.date as date,a.category as category,a.author as author',
            "$condidions ORDER BY p.date $sort"
        );
    }
    public function addAnnouncement($data){
        return $this->callProcedure('putAnnouncement',[
            $data['title'],
            $data['content'],
            $data['category'],
            $data['shortdesc'],
            $data['author'],
        ]);
    }
}