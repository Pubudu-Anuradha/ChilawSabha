<?php
class ComplaintStatModel extends Model
{
  public function getComplaintCategories()
  {
    return $this->select('complaint c join complaint_categories p GROUP BY c.complaint_category','count(c.complaint_id) as complaint_count, p.complaint_category');
  }

  public function complaintInEachMonth()
  {
    return $this->select('complaint GROUP BY MONTH(complaint_time)','count(complaint_id) as complaint_month_count,MONTH(complaint_time) as complaint_month');
  }

}
