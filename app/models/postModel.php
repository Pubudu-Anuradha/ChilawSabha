<?php 
class postModel extends Model{
    public function getPosts($type='announcement')
    {
        return $this->select('post p join announcement a on p.id=a.id',
        'p.id as id,p.title as title,a.shortdesc as shortdesc,p.content as desctiption,p.date as date,a.category as category,a.author as author',
        "p.type='$type'"
        )->fetch_all(MYSQLI_ASSOC);
    }    
}