<?php
class BookModel extends Model
{
    public function getBooks($state = [1, 2])
    {
        if (count($state) == 2) {
            $conditions = ["(b.state='$state[0]' || b.state='$state[1]')"];
        } else {
            $conditions = ["b.state='$state[0]'"];
        }
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search_term = mysqli_real_escape_string($this->conn, $_GET['search']);
            $search_fields = [
                'b.accession_no',
                'b.title',
                'b.author',
                'b.publisher',
            ];
            for ($i = 0; $i < count($search_fields); ++$i) {
                $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
            }

            array_push($conditions, '(' . implode(' || ', $search_fields) . ')');
        }

        if (isset($_GET['category_name']) && !empty($_GET['category_name']) && $_GET['category_name'] != 'All') {
            $category = mysqli_real_escape_string($this->conn, $_GET['category_name']);
            array_push($conditions, "c.category_id = '$category'");
        }

        $conditions = implode(' && ', $conditions);

        if ($state[0] == 4) {
            $conditions = $conditions . ' && l.found_description IS NULL && l.found_record_time IS NULL && l.found_record_by IS NULL';
            return $this->selectPaginated('category_codes c join books b on b.category_code=c.category_id join lost_books l on b.accession_no=l.accession_no',
                'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, c.category_name as category_name, l.lost_description as lost_description',
                $conditions);
        }

        if ($state[0] == 5) {
            $conditions = $conditions . ' && d.re_list_description IS NULL && d.re_list_record_time IS NULL && d.re_listed_recorded_by IS NULL';
            return $this->selectPaginated('category_codes c join books b on b.category_code=c.category_id join damaged_books d on b.accession_no=d.accession_no',
                'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, c.category_name as category_name, d.damaged_description as damaged_description',
                $conditions);
        }

        if ($state[0] == 3) {
            return $this->selectPaginated('category_codes c join books b on b.category_code=c.category_id join delisted_books d on b.accession_no=d.accession_no',
                'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, c.category_name as category_name, d.delist_description as delist_description',
                $conditions);
        }

        return $this->selectPaginated('books b join category_codes c on b.category_code=c.category_id',
            'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, c.category_name as category_name',
            $conditions);

    }

    public function get_categories()
    {
        return $this->select('category_codes');
    }

    public function get_sub_categories()
    {
        return $this->select('sub_category_codes');
    }

    public function addBook($book)
    {
        $book['state'] = 1;
        $book['recieved_by'] = $_SESSION['user_id'];
        return $this->insert('books', $book);
    }

    public function getCategoryCode($Category,$type)
    {
        if($type == 'Sub'){
            return $this->select('sub_category_codes', 'category_id,sub_category_id', "sub_category_id=$Category");
        }
        else if($type == 'Main'){
            return $this->select('category_codes', 'category_id', "category_name='$Category'");
        }
    }

    public function editBook($id, $data)
    {
        $book = $this->update('books', $data, "accession_no=$id");
        return [
            'book' => $book,
        ];
    }

    public function checkLent($id)
    {
        return $this->select('books','state',"accession_no=$id");
    }

    public function getBookbyID($id)
    {
        return $this->select('book_status s join books b on b.state=s.status_id',
            'b.book_id as book_id,b.title as title,b.author as author,b.publisher as publisher,b.place_of_publication as place_of_publication,b.date_of_publication as date_of_publication,
         b.accession_no as accession_no,b.isbn as isbn,b.price as price,b.pages as pages,b.recieved_date as recieved_date,
         b.recieved_method as recieved_method,b.state as state',
            "b.accession_no=$id");
    }

    public function changeState($id, $state, $reason = [])
    {
        $accession_no = mysqli_real_escape_string($this->conn, $id);
        if ($state == 4) {
            $reason['accession_no'] = $accession_no;
            $reason['lost_record_by'] = $_SESSION['user_id'];
            $res = $this->insert('lost_books', [
                'accession_no' => $reason['accession_no'],
                'lost_description' => $reason['lost_description'],
                'lost_record_by' => $reason['lost_record_by'],
            ]);
            if ($res) {
                return $this->update('books', [
                    'state' => 4,
                ], "accession_no='$accession_no'");
            }
            return false;
        } else if ($state == 3) {
            $reason['accession_no'] = $accession_no;
            $reason['delist_record_by'] = $_SESSION['user_id'];
            $res = $this->insert('delisted_books', [
                'accession_no' => $reason['accession_no'],
                'delist_description' => $reason['delist_description'],
                'delist_record_by' => $reason['delist_record_by'],
            ]);
            if ($res) {
                return $this->update('books', [
                    'state' => 3,
                ], "accession_no='$accession_no'");
            }
            return false;
        } else if ($state == 5) {
            $reason['accession_no'] = $accession_no;
            $reason['damage_record_by'] = $_SESSION['user_id'];
            $res = $this->insert('damaged_books', [
                'accession_no' => $reason['accession_no'],
                'damaged_description' => $reason['damaged_description'],
                'damage_recorded_by' => $reason['damage_record_by'],
            ]);
            if ($res) {
                return $this->update('books', [
                    'state' => 5,
                ], "accession_no='$accession_no'");
            }
            return false;
        } else if ($state == 1) {
            date_default_timezone_set('Asia/Colombo');
            $reason['accession_no'] = $accession_no;
            $reason['record_by'] = $_SESSION['user_id'];
            if($reason['type'] == 'found'){
                $res = $this->update('lost_books', [
                    'found_description' => $reason['found_description'],
                    'found_record_by' => $reason['record_by'],
                    'found_record_time' => date("Y-m-d H:i:s"),
                ], "accession_no='$accession_no' and found_description IS NULL and found_record_time IS NULL and found_record_by IS NULL");
            }

            else if($reason['type'] == 'conditioned'){
                $res = $this->update('damaged_books', [
                    're_list_description' => $reason['recondition_description'],
                    're_listed_recorded_by' => $reason['record_by'],
                    're_list_record_time' => date("Y-m-d H:i:s"),
                ], "accession_no='$accession_no' and re_list_description IS NULL and re_list_record_time IS NULL and re_listed_recorded_by IS NULL");
            }
            if ($res) {
                return $this->update('books', [
                    'state' => 1,
                ], "accession_no='$accession_no'");
            }
            return false;
        }
    }

    public function searchUser($user)
    {
        $search_term = mysqli_real_escape_string($this->conn, $user);

        return $this->select(
            'users u join library_member l on u.user_id=l.user_id',
            'l.membership_id,u.name',
            "u.name LIKE '%$search_term%' || l.membership_id LIKE '%$search_term%'"
        );
    }

    public function getUserDetails($user)
    {
        $search_term = mysqli_real_escape_string($this->conn, $user);

        return $this->select(
            'users u LEFT join library_member l on u.user_id=l.user_id LEFT join lend_recieve_books r on l.member_id=r.membership_id LEFT join books b on r.accession_no=b.book_id LEFT join category_codes c on b.category_code=c.category_id',
            'l.member_id,l.membership_id,u.name,l.no_of_books_damaged,l.no_of_books_lost,r.due_date, b.accession_no, b.title,b.author,b.publisher,c.category_name,r.extended_time,r.recieved_date',
            "(u.name = '$search_term' || l.membership_id = '$search_term') ORDER BY r.lent_date DESC"
        );
    }

    public function lendBook($memberID, $acc1, $acc2){

        date_default_timezone_set('Asia/Colombo');

        $availability_1 = $this->select(
            'books',
            'state',
            "book_id=$acc1"
        );

        $availability_2 = $this->select(
            'books',
            'state',
            "book_id=$acc2"
        );

        if($availability_1['result'][0]['state'] == 1){
            $book_one = $this->insert(
                'lend_recieve_books',
                ['accession_no' => $acc1,'membership_id' => $memberID, 'lent_date'=> date("Y-m-d H:i:s"),
                'lent_by' => $_SESSION['user_id'],'due_date'=>date("Y-m-d H:i:s", strtotime('+2 weeks'))],
            );
            $this->update(
                'books',
                ['state'=>2],
                "book_id=$acc1"
            );
        }

        if($availability_2['result'][0]['state'] == 1){
            $book_two = $this->insert(
                'lend_recieve_books',
                ['accession_no' => $acc2,'membership_id' => $memberID, 'lent_date'=> date("Y-m-d H:i:s"),
                'lent_by' => $_SESSION['user_id'],'due_date'=>date("Y-m-d H:i:s", strtotime('+2 weeks'))],
            );
            $this->update(
                'books',
                ['state' => 2],
                "book_id=$acc2"
            );

        }
        if(isset($book_one) && isset($book_two)){
            return [$book_one, $book_two];
        }
    }

    public function getBookTransactions()
    {
        $conditions = [];
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search_term = mysqli_real_escape_string($this->conn, $_GET['search']);
            $search_fields = [
                'b.accession_no',
                'b.title',
                'b.author',
            ];
            for ($i = 0; $i < count($search_fields); ++$i) {
                $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
            }

            array_push($conditions, '(' . implode(' || ', $search_fields) . ')');
        }

        if (isset($_GET['type']) && !empty($_GET['type']) && $_GET['type'] != 'all') {
            $type = mysqli_real_escape_string($this->conn, $_GET['type']);
            if($type == 'recieve'){
              array_push($conditions, "l.recieved_date IS NOT NULL");
            }
        }

        if (isset($_GET['timeframe']) && !empty($_GET['timeframe']) && $_GET['timeframe'] != 'all') {
            $timeframe = mysqli_real_escape_string($this->conn, $_GET['timeframe']);
            //add conditions according to each timeframe type (only for custom done here)
            if($timeframe == 'custom' && !empty($_GET['fromDate']) && !empty($_GET['toDate']) && isset($_GET['fromDate']) && isset($_GET['toDate'])){
                //books recieved in time range
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "l.recieved_date >= '{$_GET['fromDate']}' && l.recieved_date <= '{$_GET['toDate']}'");
                    unset($_GET['fromDate']);
                    unset($_GET['toDate']);
                }
                //all transaction in time range
                else{
                    array_push($conditions, "l.lent_date >= '{$_GET['fromDate']}' && l.lent_date <= '{$_GET['toDate']}'");
                    unset($_GET['fromDate']);
                    unset($_GET['toDate']);
                }
            }
            else if($timeframe == 'today'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "DATE(l.recieved_date)=Date(NOW())");
                }
                else{
                    array_push($conditions, "DATE(l.lent_date)=Date(NOW()) || DATE(l.recieved_date)=Date(NOW())");
                }
            }
            else if($timeframe == 'yesterday'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "DATE(l.recieved_date)=Date(DATE_SUB(NOW(), INTERVAL 1 DAY))");
                }
                else{
                    array_push($conditions, "DATE(l.recieved_date)=Date(DATE_SUB(NOW(), INTERVAL 1 DAY)) || DATE(l.lent_date)=Date(DATE_SUB(NOW(), INTERVAL 1 DAY))");
                }
            }
            else if($timeframe == 'last_7_days'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 7 DAY))");
                }
                else{
                    array_push($conditions, "DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 7 DAY)) || DATE(l.lent_date) >= Date(DATE_SUB(NOW(), INTERVAL 7 DAY))");
                }
            }
            else if($timeframe == 'last_30_days'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 30 DAY))");
                }
                else{
                    array_push($conditions, "DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 30 DAY)) || DATE(l.lent_date) >= Date(DATE_SUB(NOW(), INTERVAL 30 DAY))");
                }
            }
            else if($timeframe == 'this_month'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "MONTH(l.recieved_date)=MONTH(NOW()) && YEAR(l.recieved_date)=YEAR(NOW())");
                }
                else{
                    array_push($conditions, "(MONTH(l.recieved_date)=MONTH(NOW()) && YEAR(l.recieved_date)=YEAR(NOW())) || (MONTH(l.lent_date)=MONTH(NOW()) && YEAR(l.lent_date)=YEAR(NOW()))");
                }
            }
            else if($timeframe == 'last_month'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "MONTH(l.recieved_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.recieved_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))");
                }
                else{
                    array_push($conditions, "(MONTH(l.recieved_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.recieved_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))) || (MONTH(l.lent_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.lent_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH)))");
                }
            }
            else if($timeframe == 'this_year'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "YEAR(l.recieved_date)=YEAR(NOW())");
                }
                else{
                    array_push($conditions, "YEAR(l.recieved_date)=YEAR(NOW()) || YEAR(l.lent_date)=YEAR(NOW())");
                }
            }
            else if($timeframe == 'last_year'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "YEAR(l.recieved_date)=YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR))");
                }
                else{
                    array_push($conditions, "YEAR(l.recieved_date)=YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR)) || YEAR(l.lent_date)=YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR))");
                }
            }
        }
        if(isset($conditions) && !empty($conditions)){

            $conditions = implode(' && ', $conditions);
            $conditions = $conditions . ' ORDER BY l.lent_date DESC';

            return $this->selectPaginated('users u join library_member m  on u.user_id=m.user_id join lend_recieve_books l on m.member_id=l.membership_id join books b on l.accession_no=b.book_id join library_staff s on l.lent_by=s.user_id join users usr on usr.user_id=s.user_id LEFT join library_staff stf on l.recieved_by=stf.user_id LEFT join users usrrec on usrrec.user_id=stf.user_id',
                'b.accession_no as accession_no,b.title as title,b.author as author,l.lent_date,l.due_date,u.name as borrowed_by,
                l.recieved_date,usrrec.name as recieved_by,usr.name as lent_by',
                $conditions);
        }
        else if (empty($conditions)){
            return $this->selectPaginated('users u join library_member m  on u.user_id=m.user_id join lend_recieve_books l on m.member_id=l.membership_id join books b on l.accession_no=b.book_id join library_staff s on l.lent_by=s.user_id join users usr on usr.user_id=s.user_id LEFT join library_staff stf on l.recieved_by=stf.user_id LEFT join users usrrec on usrrec.user_id=stf.user_id ORDER BY l.lent_date DESC',
                'b.accession_no as accession_no,b.title as title,b.author as author,l.lent_date,l.due_date,u.name as borrowed_by,
                l.recieved_date,usrrec.name as recieved_by,usr.name as lent_by');
        }


    }

    public function countPlanToRead($acc1, $acc2)
    {
        $count1 = $this-> select('plan_to_read_books p join books b on p.accession_no=b.book_id',
        'count(b.accession_no) as acc1Count',
        "b.accession_no = $acc1 && (p.priority = 1 || p.priority = 2)"
        );

        $count2 = $this->select('plan_to_read_books p join books b on p.accession_no=b.book_id',
            'count(b.accession_no) as acc2Count',
            "b.accession_no = $acc2 && (p.priority = 1 || p.priority = 2)"
        );

        return [$count1,$count2];
    }

    public function getExtendedCount($acc1, $acc2)
    {
        $count1 = $this->select('lend_recieve_books l join books b on l.accession_no=b.book_id',
            'l.extended_time',
            "b.accession_no = $acc1"
        );

        $count2 = $this->select('lend_recieve_books l join books b on l.accession_no=b.book_id',
            'l.extended_time',
            "b.accession_no = $acc2"
        );

        return [$count1, $count2];

    }

    public function extendDueDate($data)
    {
        $book1 = $this->update('lend_recieve_books l join books b on l.accession_no=b.book_id',
            ['l.due_date' => date('Y-m-d', strtotime($data[0]['due_date'] . ' +2 weeks')),
            'extended_time' => $data[0]['extended_time'] + 1],
            "b.accession_no = " . $data[0]['accession_no'] . " and l.recieved_date IS NULL and l.recieved_by IS NULL"
        );

        $book2 = $this->update('lend_recieve_books l join books b on l.accession_no=b.book_id',
            ['l.due_date' => date('Y-m-d', strtotime($data[1]['due_date'] . ' +2 weeks')),
            'extended_time' => $data[1]['extended_time'] + 1],
            "b.accession_no = " . $data[1]['accession_no'] . " and l.recieved_date IS NULL and l.recieved_by IS NULL"
        );

        return [$book1, $book2];

    }

    public function getFineDetails()
    {
        return $this->select('fine_details',
        'damaged_fine,lost_fine,delay_month_fine,delay_after_fine',
        'date=(select MAX(date) from fine_details)'
        );
    }

    public function recieveBook($data)
    {
      date_default_timezone_set('Asia/Colombo');

      if($data['recievedcheck1'] == 1 && $data['damagedcheck1'] == 0){
        $recieveRecord = $this-> update('lend_recieve_books',[
          'recieved_date' => date("Y-m-d H:i:s"),
          'recieved_by' => $_SESSION['user_id'],
          'fine_amount' => $data['recieveFlag']
        ],"membership_id=".$data['memberID']." and accession_no=".$data['acc1BookId']." and recieved_date IS NULL and recieved_by IS NULL");

        if($recieveRecord){
          $result1 = $this->update('books',[
            'state'=> 1
          ],"book_id=".$data['acc1BookId']."");
        }
      }

      if($data['recievedcheck2'] == 1 && $data['damagedcheck2'] == 0){
        $recieveRecord = $this-> update('lend_recieve_books',[
          'recieved_date' => date("Y-m-d H:i:s"),
          'recieved_by' => $_SESSION['user_id'],
          'fine_amount' => $data['recieveFlag']
        ],"membership_id=".$data['memberID']." and accession_no=".$data['acc2BookId']." and recieved_date IS NULL and recieved_by IS NULL");

        if($recieveRecord){
          $result2 = $this->update('books',[
            'state'=> 1
          ],"book_id=".$data['acc2BookId']."");
        }
      }

      if($data['recievedcheck1'] == 1 && $data['damagedcheck1'] == 1){
        $recieveRecord = $this-> update('lend_recieve_books',[
          'recieved_date' => date("Y-m-d H:i:s"),
          'recieved_by' => $_SESSION['user_id'],
          'damaged' => true,
          'fine_amount' => $data['recieveFlag']
        ],"membership_id=".$data['memberID']." and accession_no=".$data['acc1BookId']." and recieved_date IS NULL and recieved_by IS NULL");

        if($recieveRecord){
          $stateChange = $this->update('books',[
            'state'=> 5
          ],"book_id=".$data['acc1BookId']."");

          if($stateChange){
            $getDamageCount = $this->select('library_member','no_of_books_damaged',"member_id=".$data['memberID']."");
            $result1 = $this->update('library_member',[
              'no_of_books_damaged' => $getDamageCount['result'][0]['no_of_books_damaged'] + 1
            ],"member_id=".$data['memberID']."");
          }
        }
      }

      if($data['recievedcheck2'] == 1 && $data['damagedcheck2'] == 1){
        $recieveRecord = $this-> update('lend_recieve_books',[
          'recieved_date' => date("Y-m-d H:i:s"),
          'recieved_by' => $_SESSION['user_id'],
          'damaged' => true,
          'fine_amount' => $data['recieveFlag']
        ],"membership_id=".$data['memberID']." and accession_no=".$data['acc2BookId']." and recieved_date IS NULL and recieved_by IS NULL");

        if($recieveRecord){
          $stateChange = $this->update('books',[
            'state'=> 5
          ],"book_id=".$data['acc2BookId']."");

          if($stateChange){
            $getDamageCount = $this->select('library_member','no_of_books_damaged',"member_id=".$data['memberID']."");
            $result2 = $this->update('library_member',[
              'no_of_books_damaged' => $getDamageCount['result'][0]['no_of_books_damaged'] + 1
            ],"member_id=".$data['memberID']."");
          }
        }
      }

      if($data['recievedcheck1'] == 0){
        $recieveRecord = $this-> update('lend_recieve_books',[
          'recieved_date' => date("Y-m-d H:i:s"),
          'recieved_by' => $_SESSION['user_id'],
          'lost' => true,
          'fine_amount' => $data['recieveFlag']
        ],"membership_id=".$data['memberID']." and accession_no=".$data['acc1BookId']." and recieved_date IS NULL and recieved_by IS NULL");

        if($recieveRecord){
          $stateChange = $this->update('books',[
            'state'=> 4
          ],"book_id=".$data['acc1BookId']."");

          if($stateChange){
            $getLostCount = $this->select('library_member','no_of_books_lost',"member_id=".$data['memberID']."");
            $result1 = $this->update('library_member',[
              'no_of_books_lost' => $getLostCount['result'][0]['no_of_books_lost'] + 1
            ],"member_id=".$data['memberID']."");
          }
        }
      }

      if($data['recievedcheck2'] == 0){
        $recieveRecord = $this-> update('lend_recieve_books',[
          'recieved_date' => date("Y-m-d H:i:s"),
          'recieved_by' => $_SESSION['user_id'],
          'lost' => true,
          'fine_amount' => $data['recieveFlag']
        ],"membership_id=".$data['memberID']." and accession_no=".$data['acc2BookId']." and recieved_date IS NULL and recieved_by IS NULL");

        if($recieveRecord){
          $stateChange = $this->update('books',[
            'state'=> 4
          ],"book_id=".$data['acc2BookId']."");

          if($stateChange){
            $getLostCount = $this->select('library_member','no_of_books_lost',"member_id=".$data['memberID']."");
            $result2 = $this->update('library_member',[
              'no_of_books_lost' => $getLostCount['result'][0]['no_of_books_lost'] + 1
            ],"member_id=".$data['memberID']."");
          }
        }
      }

      return [$result1,$result2];

    }

}
