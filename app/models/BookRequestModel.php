<?php

class BookRequestModel extends Model
{

    public function changeBookRequestState($id,$state)
    {
      $request_id = mysqli_real_escape_string($this->conn, $id);
      date_default_timezone_set('Asia/Colombo');
      if ($state == 3) {
          return $this->update('book_requests', [
              '`accepted/rejected_by`' => $_SESSION['user_id'],
              '`accepted/rejected_time`' => date("Y-m-d H:i:s"),
              'request_state' => 3],
              "request_id='$request_id'"
          );
          return false;
      }
      else if ($state == 2) {
          return $this->update('book_requests', [
              '`accepted/rejected_by`' => $_SESSION['user_id'],
              '`accepted/rejected_time`' => date("Y-m-d H:i:s"),
              'request_state' => 2,],
              "request_id=$request_id"
          );
          return false;
      }
    }

    public function getBookRequests()
    {
        $conditions = [];
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search_term = mysqli_real_escape_string($this->conn, $_GET['search']);
            $search_fields = [
                'b.email',
                'b.title',
                'b.author',
                'b.isbn',
            ];
            for ($i = 0; $i < count($search_fields); ++$i) {
                $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
            }

            array_push($conditions, '(' . implode(' || ', $search_fields) . ')');
        }

        array_push($conditions, ' b.request_state=1 ');

        $conditions = implode(' && ', $conditions);
        $conditions = $conditions . "ORDER BY b.requested_time DESC";

        return $this->selectPaginated('book_requests b join book_request_state s on b.request_state=s.status_id',
            'b.request_id as request_id,b.email as email,b.title as title,b.author as author,b.isbn as isbn, b.reason as reason ,b.requested_time as requested_time',
            $conditions
        );
    }

    public function getBookRequestByID($id)
    {
      return $this->select('book_requests',
          'email,title,author,isbn',
          "request_id=$id");
    }

    public function addBookRequest($request)
    {
        date_default_timezone_set('Asia/Colombo');

        //to stop repeat insertions of same request
        $max_req = $this->select('book_requests','max(request_id) as request_id');

        if(isset($max_req['result'][0]['request_id'])){
            $res = $this->select('book_requests','email,isbn',"request_id='".$max_req['result'][0]['request_id']."'");

            if(isset($res['result']) && (($request['email'] != $res['result'][0]['email']) || ($request['isbn'] != $res['result'][0]['isbn']))){
                return $this->insert('book_requests',[
                    'email' => $request['email'],
                    'title' => $request['title'],
                    'author' => $request['author'],
                    'isbn' => $request['isbn'],
                    'reason' => $request['reason'],
                    'request_state' => 1,
                    'requested_time' => date("Y-m-d H:i:s")
                ]);
            }
        }
    }

}
