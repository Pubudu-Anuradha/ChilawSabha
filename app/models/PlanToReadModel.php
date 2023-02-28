<?php

class PlanToReadModel extends Model
{

    public function getPlanToReadBooks()
    {
        return $this->select(
            'plantoread ORDER BY book_order ASC'
        );
    }

    public function updatePlanToReadBooks($book_order, $val)
    {
        return $this->update(
            'plantoread',
            ['book_order' => $book_order],
            "accNo=$val"
        );
    }
}
