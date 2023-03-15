<?php

class PlanToReadModel extends Model
{

    public function getPlanToReadBooks()
    {
        return $this->select(
            'plan_to_read_books p JOIN books b ON p.accession_no=b.book_id JOIN book_status s ON b.state=s.status_id ',
            'b.accession_no,b.title,b.author,b.publisher,s.status',
            'b.state=1 OR b.state=2 ORDER BY p.priority'
        );
    }

    public function updatePlanToReadBooks($book_order, $val)
    {
        return $this->update(
            'plan_to_read_books p join books b ON p.accession_no=b.book_id ',
            ['p.priority' => $book_order],
            "b.accession_no=$val"
        );
    }
}
