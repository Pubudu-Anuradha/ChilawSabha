<?php
class LibraryStatModel extends Model
{

    public function getBorrowStat($timeframe)
    {

        if($timeframe['range'] == 'all'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5',
                'c.category_name as category_name, count(l.accession_no) as borrow_count'
            );
        }
        else if($timeframe['range'] == 'today'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'DATE(l.lent_date) = DATE(NOW()) GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'yesterday'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'DATE(l.lent_date) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last_7_days'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'DATE(l.lent_date) >= DATE(DATE_SUB(NOW(), INTERVAL 7 DAY)) GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last_30_days'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'DATE(l.lent_date) >= DATE(DATE_SUB(NOW(), INTERVAL 30 DAY)) GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'this month'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'MONTH(l.lent_date) = MONTH(NOW()) AND YEAR(l.lent_date) = YEAR(NOW())  GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last month'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'MONTH(l.lent_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.lent_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH)) GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'this year'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'YEAR(l.lent_date) = YEAR(NOW()) GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last year'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'YEAR(l.lent_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR)) GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }

    }

    public function getCustomBorrowStat($custom)
    {
      return $this->select(
          'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
          'c.category_name as category_name, count(l.accession_no) as borrow_count',
          "l.lent_date >='".$custom["fromDate"]."' and l.lent_date <='".$custom["toDate"]."' GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5"
      );
    }


    public function getFavouriteStat($timeframe)
    {

        if($timeframe['range'] == 'all'){
            return $this->select(
                'favourite_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id GROUP by c.category_name ORDER BY fav_count DESC LIMIT 5',
                'c.category_name as category_name, count(f.accession_no) as fav_count'
            );
        }
        else if($timeframe['range'] == 'today'){
            return $this->select(
                'favourite_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as fav_count',
                'DATE(f.added_date) = DATE(NOW()) GROUP by c.category_name ORDER BY fav_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'yesterday'){
            return $this->select(
                'favourite_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as fav_count',
                'DATE(f.added_date) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) GROUP by c.category_name ORDER BY fav_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last_7_days'){
            return $this->select(
                'favourite_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as fav_count',
                'DATE(f.added_date) >= DATE(DATE_SUB(NOW(), INTERVAL 7 DAY)) GROUP by c.category_name ORDER BY fav_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last_30_days'){
            return $this->select(
                'favourite_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as fav_count',
                'DATE(f.added_date) >= DATE(DATE_SUB(NOW(), INTERVAL 30 DAY)) GROUP by c.category_name ORDER BY fav_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'this month'){
            return $this->select(
                'favourite_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as fav_count',
                'MONTH(f.added_date) = MONTH(NOW()) AND YEAR(f.added_date) = YEAR(NOW()) GROUP by c.category_name ORDER BY fav_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last month'){
            return $this->select(
                'favourite_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as fav_count',
                'MONTH(f.added_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(f.added_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH)) GROUP by c.category_name ORDER BY fav_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'this year'){
            return $this->select(
                'favourite_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as fav_count',
                'YEAR(f.added_date) = YEAR(NOW()) GROUP by c.category_name ORDER BY fav_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last year'){
            return $this->select(
                'favourite_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as fav_count',
                'YEAR(f.added_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR)) GROUP by c.category_name ORDER BY fav_count DESC LIMIT 5'
            );
        }

    }

    public function getCustomFavouriteStat($custom)
    {
      return $this->select(
          'favourite_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
          'c.category_name as category_name, count(f.accession_no) as fav_count',
          "f.added_date >='".$custom["fromDate"]."' and f.added_date <='".$custom["toDate"]."' GROUP by c.category_name ORDER BY fav_count DESC LIMIT 5"
      );
    }

    public function getPlrStat($timeframe)
    {

        if($timeframe['range'] == 'all'){
            return $this->select(
                'plan_to_read_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id GROUP by c.category_name ORDER BY plr_count DESC LIMIT 5',
                'c.category_name as category_name, count(f.accession_no) as plr_count'
            );
        }
        else if($timeframe['range'] == 'today'){
            return $this->select(
                'plan_to_read_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as plr_count',
                'DATE(f.added_date) = DATE(NOW()) GROUP by c.category_name ORDER BY plr_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'yesterday'){
            return $this->select(
                'plan_to_read_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as plr_count',
                'DATE(f.added_date) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY)) GROUP by c.category_name ORDER BY plr_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last_7_days'){
            return $this->select(
                'plan_to_read_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as plr_count',
                'DATE(f.added_date) >= DATE(DATE_SUB(NOW(), INTERVAL 7 DAY)) GROUP by c.category_name ORDER BY plr_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last_30_days'){
            return $this->select(
                'plan_to_read_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as plr_count',
                'DATE(f.added_date) >= DATE(DATE_SUB(NOW(), INTERVAL 30 DAY)) GROUP by c.category_name ORDER BY plr_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'this month'){
            return $this->select(
                'plan_to_read_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as plr_count',
                'MONTH(f.added_date) = MONTH(NOW()) AND YEAR(f.added_date) = YEAR(NOW()) GROUP by c.category_name ORDER BY plr_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last month'){
            return $this->select(
                'plan_to_read_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as plr_count',
                'MONTH(f.added_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(f.added_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH)) GROUP by c.category_name ORDER BY plr_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'this year'){
            return $this->select(
                'plan_to_read_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as plr_count',
                'YEAR(f.added_date) = YEAR(NOW()) GROUP by c.category_name ORDER BY plr_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last year'){
            return $this->select(
                'plan_to_read_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
                'c.category_name as category_name, count(f.accession_no) as plr_count',
                'YEAR(f.added_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR)) GROUP by c.category_name ORDER BY plr_count DESC LIMIT 5'
            );
        }

    }

    public function getCustomPlrStat($custom)
    {
      return $this->select(
          'plan_to_read_books f JOIN books b ON f.accession_no=b.book_id JOIN sub_category_codes sb on b.category_code=sb.sub_category_id JOIN category_codes c ON sb.category_id = c.category_id',
          'c.category_name as category_name, count(f.accession_no) as plr_count',
          "f.added_date >='".$custom["fromDate"]."' and f.added_date <='".$custom["toDate"]."' GROUP by c.category_name ORDER BY plr_count DESC LIMIT 5"
      );
    }

    public function getFineStat($timeframe)
    {

        if($timeframe['range'] == 'all'){
            return $this->select(
                'lend_recieve_books l',
                'ROUND(sum(l.fine_amount)/2,2) as fine_amount'
            );
        }
        else if($timeframe['range'] == 'today'){
            return $this->select(
                'lend_recieve_books l',
                'ROUND(sum(l.fine_amount)/2,2) as fine_amount',
                'DATE(l.recieved_date) = DATE(NOW())'
            );
        }
        else if($timeframe['range'] == 'yesterday'){
            return $this->select(
                'lend_recieve_books l',
                'ROUND(sum(l.fine_amount)/2,2) as fine_amount',
                'DATE(l.recieved_date) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))'
            );
        }
        else if($timeframe['range'] == 'last_7_days'){
            return $this->select(
                'lend_recieve_books l',
                'ROUND(sum(l.fine_amount)/2,2) as fine_amount',
                'DATE(l.recieved_date) >= DATE(DATE_SUB(NOW(), INTERVAL 7 DAY))'
            );
        }
        else if($timeframe['range'] == 'last_30_days'){
            return $this->select(
                'lend_recieve_books l',
                'ROUND(sum(l.fine_amount)/2,2) as fine_amount',
                'DATE(l.recieved_date) >= DATE(DATE_SUB(NOW(), INTERVAL 30 DAY))'
            );
        }
        else if($timeframe['range'] == 'this month'){
            return $this->select(
                'lend_recieve_books l',
                'ROUND(sum(l.fine_amount)/2,2) as fine_amount',
                'MONTH(l.recieved_date) = MONTH(NOW()) AND YEAR(l.recieved_date) = YEAR(NOW())'
            );
        }
        else if($timeframe['range'] == 'last month'){
            return $this->select(
                'lend_recieve_books l',
                'ROUND(sum(l.fine_amount)/2,2) as fine_amount',
                'MONTH(l.recieved_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.recieved_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))'
            );
        }
        else if($timeframe['range'] == 'this year'){
            return $this->select(
                'lend_recieve_books l',
                'ROUND(sum(l.fine_amount)/2,2) as fine_amount',
                'YEAR(l.recieved_date) = YEAR(NOW())'
            );
        }
        else if($timeframe['range'] == 'last year'){
            return $this->select(
                'lend_recieve_books l',
                'ROUND(sum(l.fine_amount)/2,2) as fine_amount',
                'YEAR(l.recieved_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR))'
            );
        }

    }

    public function getCustomFineStat($custom)
    {
      return $this->select(
            'lend_recieve_books l',
            'ROUND(sum(l.fine_amount)/2,2) as fine_amount',
            "l.recieved_date >='".$custom["fromDate"]."' and l.recieved_date <='".$custom["toDate"]."'"
      );
    }

}
