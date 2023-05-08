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

        return $this->selectPaginated(' category_codes c join books b on b.category_code=c.category_id join book_status s on b.state=s.status_id',
            'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, c.category_name as category_name, s.status as status',
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
        return $this->update('books', $data, "accession_no=$id");
    }

    public function getBookbyID($id)
    {
        return $this->select('book_status s join books b on b.state=s.status_id join category_codes c on b.category_code=c.category_id join sub_category_codes sb on b.sub_category_code=sb.sub_category_id',
            'b.book_id as book_id,b.title as title,b.author as author,b.publisher as publisher,b.place_of_publication as place_of_publication,b.date_of_publication as date_of_publication,
         b.accession_no as accession_no,b.isbn as isbn,b.price as price,b.pages as pages,b.recieved_date as recieved_date, c.category_name as category_name,sb.sub_category_name as sub_category_name,
         b.recieved_method as recieved_method,b.state as state,s.status as status',
            "b.accession_no=$id");
    }

    public function putBookEditHistory($history)
    {
        return $this->insert('edit_book', $history);
    }

    public function getBookEditHistory($id)
    {
        $acc = mysqli_real_escape_string($this->conn,$id);

        return $this->select('edit_book e join users u on u.user_id=e.edited_by',
        'e.title as title,e.author as author,e.publisher as publisher,e.price as price,e.pages as pages,u.name as changed_by,e.edited_time as time',
        "e.accession_no='$acc' ORDER BY e.edited_time DESC");
    }

    public function getBookStateHistory($id) {

        $acc = mysqli_real_escape_string($this->conn,$id);

        $damage = $this->select('damaged_books db join books b on b.accession_no=db.accession_no join users u1 on u1.user_id=db.damage_recorded_by LEFT JOIN users u2 on db.re_listed_recorded_by=u2.user_id',
        'db.damaged_description as dm_reason,u1.name as dm_name,db.damaged_record_time as dm_time,db.re_list_description as rc_reason,u2.name as rc_name,db.re_list_record_time as rc_time',
        "db.accession_no=$acc ORDER BY db.damaged_record_time DESC");

        $lost = $this->select('lost_books lb join books b on b.accession_no=lb.accession_no join users u3 on u3.user_id=lb.lost_record_by LEFT JOIN users u4 on lb.found_record_by=u4.user_id',
        'lb.lost_description as l_reason,u3.name as l_name,lb.lost_record_time as l_time, lb.found_description as f_reason,u4.name as f_name,lb.found_record_time as f_time',
        "lb.accession_no=$acc ORDER BY lb.lost_record_time DESC");

        $delist = $this->select('delisted_books deb join books b on b.accession_no=deb.accession_no join users u5 on u5.user_id=deb.delist_record_by',
        'deb.delist_description as de_reason,u5.name as de_name, deb.delist_record_time as de_time',
        "deb.accession_no=$acc ORDER BY deb.delist_record_time DESC");

        if(isset($damage['result']) && isset($lost['result']) && isset($delist['result'])){
            $res = array_merge($damage['result'], $lost['result'], $delist['result']);
            return $res;
        }
        return false;
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
                'damaged_description' => $reason['damage_description'],
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
            'l.member_id,l.membership_id,u.name,l.no_of_books_damaged,l.no_of_books_lost,r.due_date, r.extended_time,b.accession_no, b.title,b.author,b.publisher,c.category_name,r.extended_time,r.recieved_date,
            u.email,u.contact_no,u.address',
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

    public function getBookTransactions($id=null)
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
                    array_push($conditions, "(DATE(l.lent_date)=Date(NOW()) || DATE(l.recieved_date)=Date(NOW()))");
                }
            }
            else if($timeframe == 'yesterday'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "DATE(l.recieved_date)=Date(DATE_SUB(NOW(), INTERVAL 1 DAY))");
                }
                else{
                    array_push($conditions, "(DATE(l.recieved_date)=Date(DATE_SUB(NOW(), INTERVAL 1 DAY)) || DATE(l.lent_date)=Date(DATE_SUB(NOW(), INTERVAL 1 DAY)))");
                }
            }
            else if($timeframe == 'last_7_days'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 7 DAY))");
                }
                else{
                    array_push($conditions, "(DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 7 DAY)) || DATE(l.lent_date) >= Date(DATE_SUB(NOW(), INTERVAL 7 DAY)))");
                }
            }
            else if($timeframe == 'last_30_days'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 30 DAY))");
                }
                else{
                    array_push($conditions, "(DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 30 DAY)) || DATE(l.lent_date) >= Date(DATE_SUB(NOW(), INTERVAL 30 DAY)))");
                }
            }
            else if($timeframe == 'this_month'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "MONTH(l.recieved_date)=MONTH(NOW()) && YEAR(l.recieved_date)=YEAR(NOW())");
                }
                else{
                    array_push($conditions, "((MONTH(l.recieved_date)=MONTH(NOW()) && YEAR(l.recieved_date)=YEAR(NOW())) || (MONTH(l.lent_date)=MONTH(NOW()) && YEAR(l.lent_date)=YEAR(NOW())))");
                }
            }
            else if($timeframe == 'last_month'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "MONTH(l.recieved_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.recieved_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))");
                }
                else{
                    array_push($conditions, "((MONTH(l.recieved_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.recieved_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))) || (MONTH(l.lent_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.lent_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))))");
                }
            }
            else if($timeframe == 'this_year'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "YEAR(l.recieved_date)=YEAR(NOW())");
                }
                else{
                    array_push($conditions, "(YEAR(l.recieved_date)=YEAR(NOW()) || YEAR(l.lent_date)=YEAR(NOW()))");
                }
            }
            else if($timeframe == 'last_year'){
                if(isset($_GET['type']) &&  $_GET['type'] == 'recieve'){
                    array_push($conditions, "YEAR(l.recieved_date)=YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR))");
                }
                else{
                    array_push($conditions, "(YEAR(l.recieved_date)=YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR)) || YEAR(l.lent_date)=YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR)))");
                }
            }
        }

        if($id == null){
          if(isset($conditions) && !empty($conditions)){

              $conditions = implode(' && ', $conditions);
              $conditions = $conditions . ' ORDER BY l.lent_date DESC';

              return $this->selectPaginated('users u join library_member m  on u.user_id=m.user_id join lend_recieve_books l on m.member_id=l.membership_id join books b on l.accession_no=b.book_id join users usr on usr.user_id=l.lent_by LEFT join users usrrec on usrrec.user_id=l.recieved_by',
                  'b.accession_no as accession_no,b.title as title,b.author as author,l.lent_date,l.due_date,u.name as borrowed_by,
                  l.recieved_date,usrrec.name as recieved_by,usr.name as lent_by,l.damaged as damage,l.lost as lost',
                  $conditions);
          }
          else if (empty($conditions)){
              return $this->selectPaginated('users u join library_member m  on u.user_id=m.user_id join lend_recieve_books l on m.member_id=l.membership_id join books b on l.accession_no=b.book_id join users usr on usr.user_id=l.lent_by LEFT join users usrrec on usrrec.user_id=l.recieved_by ORDER BY l.lent_date DESC',
                  'b.accession_no as accession_no,b.title as title,b.author as author,l.lent_date,l.due_date,u.name as borrowed_by,
                  l.recieved_date,usrrec.name as recieved_by,usr.name as lent_by,l.damaged as damage,l.lost as lost');
          }
        }
        else if ($id != null){
          if(isset($conditions) && !empty($conditions)){

              $conditions = implode(' && ', $conditions);
              $conditions = $conditions . " && l.membership_id=$id ORDER BY l.lent_date DESC";

              return $this->selectPaginated('users u join library_member m  on u.user_id=m.user_id join lend_recieve_books l on m.member_id=l.membership_id join books b on l.accession_no=b.book_id join users usr on usr.user_id=l.lent_by LEFT join users usrrec on usrrec.user_id=l.recieved_by',
                  'b.accession_no as accession_no,b.title as title,b.author as author,l.lent_date,l.due_date,u.name as borrowed_by,
                  l.recieved_date,usrrec.name as recieved_by,usr.name as lent_by,l.damaged as damage,l.lost as lost',
                  $conditions);
          }
          else if (empty($conditions)){
              return $this->selectPaginated('users u join library_member m  on u.user_id=m.user_id join lend_recieve_books l on m.member_id=l.membership_id join books b on l.accession_no=b.book_id join users usr on usr.user_id=l.lent_by LEFT join users usrrec on usrrec.user_id=l.recieved_by',
                  'b.accession_no as accession_no,b.title as title,b.author as author,l.lent_date,l.due_date,u.name as borrowed_by,
                  l.recieved_date,usrrec.name as recieved_by,usr.name as lent_by,l.damaged as damage,l.lost as lost',
                  "l.membership_id=$id ORDER BY l.lent_date DESC");
          }
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
            "b.accession_no = $acc1 and l.recieved_date IS NULL and l.recieved_by IS NULL"
        );

        $count2 = $this->select('lend_recieve_books l join books b on l.accession_no=b.book_id',
            'l.extended_time',
            "b.accession_no = $acc2 and l.recieved_date IS NULL and l.recieved_by IS NULL"
        );

        return [$count1, $count2];

    }

    public function extendDueDate($data)
    {
        date_default_timezone_set('Asia/Colombo');

        if($data[0]['extended_time'] <3 && $data[1]['extended_time']<3){
            if((!isset($data[0]['extended_date']) && !isset($data[1]['extended_date']) && date("Y-m-d") == $data[0]['due_date']) || (date("Y-m-d") == date('Y-m-d', strtotime($data[0]['extended_date'] . ' +2 weeks')))){
                $book1 = $this->update('lend_recieve_books l join books b on l.accession_no=b.book_id',
                    ['l.due_date' => date('Y-m-d', strtotime($data[0]['due_date'] . ' +2 weeks')),
                    'l.extended_time' => $data[0]['extended_time'] + 1,
                    'l.extended_date' => date("Y-m-d H:i:s")],
                    "b.accession_no = " . $data[0]['accession_no'] . " and l.recieved_date IS NULL and l.recieved_by IS NULL"
                );

                $book2 = $this->update('lend_recieve_books l join books b on l.accession_no=b.book_id',
                    ['l.due_date' => date('Y-m-d', strtotime($data[1]['due_date'] . ' +2 weeks')),
                    'l.extended_time' => $data[1]['extended_time'] + 1,
                    'l.extended_date' => date("Y-m-d H:i:s")],
                    "b.accession_no = " . $data[1]['accession_no'] . " and l.recieved_date IS NULL and l.recieved_by IS NULL"
                );

                return [$book1, $book2];
            }
            return false;
        }
        return false;
    }

    public function getFineDetails()
    {
        return $this->select('fine_details',
        'damaged_fine,lost_fine,delay_month_fine,delay_after_fine,fine_id',
        'added_date=(select MAX(added_date) from fine_details)'
        );
    }

    public function editFineDetails($details)
    {
      return $this->update('fine_details', $details , 'fine_id=1');
    }

    public function putFineEditHistory($details)
    {
      return $this->insert('edit_fine_details', $details);
    }

    public function getFineEditHistory()
    {
      return $this->select('edit_fine_details e join users u on e.edited_by=u.user_id',
      'e.damaged_fine as damaged_fine, e.lost_fine as lost_fine, e.delay_month_fine as delay_month_fine, e.delay_after_fine as delay_after_fine,e.edited_time as time,u.name as changed_by',
      'e.fine_id=1 ORDER BY e.edited_time DESC');
    }

    public function getFinebyId($id)
    {
      return $this->select('lend_recieve_books','ROUND(sum(fine_amount)/2,2) as fine_amount',"membership_id=$id");
    }

    public function getDamagebyId($id)
    {
      return $this->select('lend_recieve_books l join books b on l.accession_no=b.book_id','b.title,b.author,l.recieved_date',"membership_id=$id and l.damaged=1 ORDER BY l.recieved_date DESC");
    }

    public function getLostbyId($id)
    {
      return $this->select('lend_recieve_books l join books b on l.accession_no=b.book_id','b.title,b.author,l.recieved_date',"membership_id=$id and l.lost=1 ORDER BY l.recieved_date DESC");
    }

    public function getFinePayments($id=null)
    {
        $conditions = [];

        if(isset($_GET['timeframe'])){
          if (isset($_GET['search']) && !empty($_GET['search'])) {
              $search_term = mysqli_real_escape_string($this->conn, $_GET['search']);
              $search_fields = [
                  'u.name',
              ];
              for ($i = 0; $i < count($search_fields); ++$i) {
                  $search_fields[$i] = $search_fields[$i] . " LIKE '%$search_term%'";
              }

              array_push($conditions, '(' . implode(' || ', $search_fields) . ')');
          }


          if (isset($_GET['timeframe']) && !empty($_GET['timeframe']) && $_GET['timeframe'] != 'all') {
              $timeframe = mysqli_real_escape_string($this->conn, $_GET['timeframe']);

              if($timeframe == 'custom' && !empty($_GET['fromDate']) && !empty($_GET['toDate']) && isset($_GET['fromDate']) && isset($_GET['toDate'])){
                  array_push($conditions, "l.recieved_date >= '{$_GET['fromDate']}' && l.recieved_date <= '{$_GET['toDate']}'");
                  unset($_GET['fromDate']);
                  unset($_GET['toDate']);
              }
              else if($timeframe == 'today'){
                  array_push($conditions, "DATE(l.recieved_date)=Date(NOW())");
              }
              else if($timeframe == 'yesterday'){
                  array_push($conditions, "DATE(l.recieved_date)=Date(DATE_SUB(NOW(), INTERVAL 1 DAY))");
              }
              else if($timeframe == 'last_7_days'){
                  array_push($conditions, "DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 7 DAY))");
              }
              else if($timeframe == 'last_30_days'){
                  array_push($conditions, "DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 30 DAY))");
              }
              else if($timeframe == 'this_month'){
                  array_push($conditions, "MONTH(l.recieved_date)=MONTH(NOW()) && YEAR(l.recieved_date)=YEAR(NOW())");
              }
              else if($timeframe == 'last_month'){
                  array_push($conditions, "MONTH(l.recieved_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.recieved_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))");
              }
              else if($timeframe == 'this_year'){
                  array_push($conditions, "YEAR(l.recieved_date)=YEAR(NOW())");
              }
              else if($timeframe == 'last_year'){
                  array_push($conditions, "YEAR(l.recieved_date)=YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR))");
              }
          }

        }

        else if(isset($_GET['timeframefine'])){
          if (isset($_GET['timeframefine']) && !empty($_GET['timeframefine']) && $_GET['timeframefine'] != 'all') {
              $timeframefine = mysqli_real_escape_string($this->conn, $_GET['timeframefine']);

              if($timeframefine == 'custom' && !empty($_GET['fromDate']) && !empty($_GET['toDate']) && isset($_GET['fromDate']) && isset($_GET['toDate'])){
                  array_push($conditions, "l.recieved_date >= '{$_GET['fromDate']}' && l.recieved_date <= '{$_GET['toDate']}'");
                  unset($_GET['fromDate']);
                  unset($_GET['toDate']);
              }
              else if($timeframefine == 'today'){
                  array_push($conditions, "DATE(l.recieved_date)=Date(NOW())");
              }
              else if($timeframefine == 'yesterday'){
                  array_push($conditions, "DATE(l.recieved_date)=Date(DATE_SUB(NOW(), INTERVAL 1 DAY))");
              }
              else if($timeframefine == 'last_7_days'){
                  array_push($conditions, "DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 7 DAY))");
              }
              else if($timeframefine == 'last_30_days'){
                  array_push($conditions, "DATE(l.recieved_date) >= Date(DATE_SUB(NOW(), INTERVAL 30 DAY))");
              }
              else if($timeframefine == 'this_month'){
                  array_push($conditions, "MONTH(l.recieved_date)=MONTH(NOW()) && YEAR(l.recieved_date)=YEAR(NOW())");
              }
              else if($timeframefine == 'last_month'){
                  array_push($conditions, "MONTH(l.recieved_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.recieved_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))");
              }
              else if($timeframefine == 'this_year'){
                  array_push($conditions, "YEAR(l.recieved_date)=YEAR(NOW())");
              }
              else if($timeframefine == 'last_year'){
                  array_push($conditions, "YEAR(l.recieved_date)=YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR))");
              }
          }
        }

        if($id==null){
          if(isset($conditions) && !empty($conditions)){

              $conditions = implode(' && ', $conditions);
              $conditions = $conditions . ' && l.fine_amount > 0 && l.transaction_id%2=1 ORDER BY l.recieved_date DESC';

              return $this->selectPaginated('lend_recieve_books l join library_member m on l.membership_id=m.member_id join users u on m.user_id=u.user_id join users usr on usr.user_id=l.recieved_by',
              'u.name as name,l.fine_amount as fine_amount,l.recieved_date as recieved_date,usr.name as recieved_by',
              $conditions);
          }
          else if (empty($conditions)){
              return $this->selectPaginated('lend_recieve_books l join library_member m on l.membership_id=m.member_id join users u on m.user_id=u.user_id join users usr on usr.user_id=l.recieved_by',
              'u.name as name,l.fine_amount as fine_amount,l.recieved_date as recieved_date,usr.name as recieved_by',
              "l.fine_amount > 0 && l.transaction_id%2=1 ORDER BY l.recieved_date DESC");
          }
        }

        else if($id != null){
          if(isset($conditions) && !empty($conditions)){

              $conditions = implode(' && ', $conditions);
              $conditions = $conditions . " && l.membership_id=$id && l.fine_amount > 0 && l.transaction_id%2=1 ORDER BY l.recieved_date DESC";

              return $this->selectPaginated('lend_recieve_books l join library_member m on l.membership_id=m.member_id join users u on m.user_id=u.user_id join users usr on usr.user_id=l.recieved_by',
              'u.name as name,l.fine_amount as fine_amount,l.recieved_date as recieved_date,usr.name as recieved_by',
              $conditions);
          }
          else if (empty($conditions)){
              return $this->selectPaginated('lend_recieve_books l join library_member m on l.membership_id=m.member_id join users u on m.user_id=u.user_id join users usr on usr.user_id=l.recieved_by',
              'u.name as name,l.fine_amount as fine_amount,l.recieved_date as recieved_date,usr.name as recieved_by',
              "l.membership_id=$id && l.fine_amount > 0 && l.transaction_id%2=1 ORDER BY l.recieved_date DESC");
          }
        }
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

    public function getCompletedBooks($member_id){
        $id = mysqli_real_escape_string($this->conn, $member_id);
        return $this->selectPaginated('completed_books c join books b on b.book_id=c.accession_no JOIN book_status s ON b.state=s.status_id',
        'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, s.status as status',
        "c.membership_id='.$id.'");
    }

    public function getFavoriteBooks($member_id){
        $id = mysqli_real_escape_string($this->conn, $member_id);
        return $this->selectPaginated('favourite_books f join books b on b.book_id=f.accession_no JOIN book_status s ON b.state=s.status_id',
            'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, s.status as status',
            "f.membership_id='.$id.'");
    }

    public function getBorrowedBooks($user_id){
        $id = mysqli_real_escape_string($this->conn, $user_id);
        return $this->select('lend_recieve_books l join books b on b.book_id=l.accession_no join library_member m on m.member_id=l.membership_id AND m.user_id='.$id,
        'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, l.due_date as due_date',
        'l.recieved_date IS NULL'
        );
    }

    public function getNewBooks(){
        return $this->select('books', 
        'title, author', 
        'state=1 OR state=2 ORDER BY recieved_date DESC LIMIT 5'
        );
    }

    public function getSuggestedBooks($precedence, $membership_id){
        if(empty($precedence)):
            return [];
        else:
            $case = '';
            $i = 1;
            foreach($precedence as $key=>$value):
                $case .= 'WHEN b.category_code = '. $key.' THEN '.$i.' ';
                $i++;
            endforeach;
            $case .= 'ELSE '.$i.' END';
            return $this->select('books b' , 'b.title as title, b.author as author, b.category_code as category_code', 'NOT EXISTS (SELECT * FROM completed_books c JOIN library_member l ON c.membership_id=l.member_id WHERE c.accession_no = b.book_id AND c.membership_id = '.$membership_id.' ) ORDER BY CASE '.$case.' ASC LIMIT 5')['result']??[];
        endif;
    }

    public function addFavoriteBook($id, $membership_id){
        $id = mysqli_real_escape_string($this->conn, $id);
        $member_id = mysqli_real_escape_string($this->conn, $membership_id);
        return $this->insert('favourite_books',['accession_no'=>$id, 
        'membership_id'=>$membership_id
        ]);
    }

    public function removeFavBook($id, $membership_id){
        $id = mysqli_real_escape_string($this->conn, $id);
        $member_id = mysqli_real_escape_string($this->conn, $membership_id);
        return $this->delete('favourite_books', 'accession_no='.$id.' AND membership_id='.$membership_id);
    }

    public function addCompletedBook($id, $membership_id){
        $id = mysqli_real_escape_string($this->conn, $id);
        $member_id = mysqli_real_escape_string($this->conn, $membership_id);
        return $this->insert('completed_books', [            'accession_no'=>$id, 
        'membership_id'=>$membership_id
        ]);
    }

    public function removeCompBook($id, $membership_id){
        $id = mysqli_real_escape_string($this->conn, $id);
        $member_id = mysqli_real_escape_string($this->conn, $membership_id);
        return $this->delete('completed_books', 'accession_no='.$id.' AND membership_id='.$membership_id);
    }

    public function getBookDetails($accession_no){
        $id = mysqli_real_escape_string($this->conn, $accession_no);
        return $this->select('books b join category_codes c on b.category_code=c.category_id', 
        'b.book_id as book_id,b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher,b.state as state, c.category_name as category_name', 
        'b.accession_no='.$id
        );
    }
}
