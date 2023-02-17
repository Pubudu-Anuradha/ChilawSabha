<?php
class AdminStatModel extends Model
{
    public function getEventStat()
    {
        return $this->select(
            'events ORDER BY views DESC LIMIT 4',
            'name,views'
        );
    }
}
