<?php
class AdminStatModel extends Model
{
    public function getPostCounts() {
        return $this->select('post p join post_type pt on p.post_type=pt.post_type_id',
            'pt.post_type_id as post_type_id,pt.post_type as post_type,count(post_id) as post_count',
            'p.hidden=0 group by p.post_type');
    }

    public function getTop10($post_type_id,$start_date,$end_date,$limit=10) {
        $limit = mysqli_real_escape_string($this->conn,$limit);
        $post_type_id = mysqli_real_escape_string($this->conn,$post_type_id);
        return $this->select('post p join post_type pt on p.post_type=pt.post_type_id join post_views pv on p.post_id=pv.post_id',
            'RANK() OVER (ORDER BY sum(pv.views) DESC) as rank,p.post_id as post_id,p.title as title, sum(pv.views) as views',
            "p.post_type='$post_type_id' and pv.date between '".$start_date."' and '$end_date' group by p.post_id order by sum(pv.views) desc limit $limit");
    }

    public function getTotalViewsPerType($start_date,$end_date) {
        return $this->select('post p join post_type pt on p.post_type=pt.post_type_id join post_views pv on p.post_id=pv.post_id',
            'RANK() OVER (ORDER BY sum(pv.views) DESC) as rank,
             pt.post_type_id as post_type_id,
             pt.post_type as post_type,sum(pv.views) as views',
            "pv.date between '".$start_date."' and '$end_date'
             group by p.post_type");
    }

    public function getPageViews($start_date,$end_date,$limit=10) {
        return $this->select(
            'page_views',
            'RANK() OVER (ORDER BY sum(views) DESC) as rank,
            name,
            sum(views) as views',
            "date between '".$start_date."' and '$end_date'
             group by name order by sum(views) desc limit $limit");
    }
}
