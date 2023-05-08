<?php

class PlanToReadModel extends Model
{
  public function getPlanToReadBooks($member_id)
  {
    $id = mysqli_real_escape_string($this->conn, $member_id);
    return $this->selectPaginated(
      'plan_to_read_books p JOIN books b ON p.accession_no=b.book_id JOIN book_status s ON b.state=s.status_id',
      'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher,s.status as status', "p.membership_id='.$id.' ORDER BY p.priority"
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

  public static function addPlanToReadBook($accession_no, $membership_id)
  {
    $model = new self();
    $book = new BookModel();
    $count = $book->select(
      'plan_to_read_books',
      'COUNT(*) as count',
      "membership_id='$membership_id'"
    )['result'][0]['count'];
    return $model->insert(
      'plan_to_read_books', [
        'accession_no' => $accession_no,
        'membership_id' => $membership_id,
        'priority' => $count + 1
      ]
    );
  }

  public function removePlanToReadBook($accession_no, $membership_id)
  {
    return $this->delete(
      'plan_to_read_books',
      "accession_no='$accession_no' AND membership_id='$membership_id'"
    );
  }
}
