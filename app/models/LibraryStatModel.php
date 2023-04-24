<?php
class LibraryStatModel extends Model
{

    public function getBorrowStat($timeframe)
    {

        if($timeframe['range'] == 'all'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN category_codes c ON b.category_code = c.category_id GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5',
                'c.category_name as category_name, count(l.accession_no) as borrow_count'
            );
        }
        else if($timeframe['range'] == 'this month'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN category_codes c ON b.category_code = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'MONTH(l.lent_date) = MONTH(NOW()) AND YEAR(l.lent_date) = YEAR(NOW())  GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last month'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN category_codes c ON b.category_code = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'MONTH(l.lent_date) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH)) AND  YEAR(l.lent_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH)) GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'this year'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN category_codes c ON b.category_code = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'YEAR(l.lent_date) = YEAR(NOW()) GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }
        else if($timeframe['range'] == 'last year'){
            return $this->select(
                'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN category_codes c ON b.category_code = c.category_id',
                'c.category_name as category_name, count(l.accession_no) as borrow_count',
                'YEAR(l.lent_date) = YEAR(DATE_SUB(NOW(), INTERVAL 1 YEAR)) GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5'
            );
        }

    }

    public function getCustomBorrowStat($custom)
    {
      return $this->select(
          'lend_recieve_books l JOIN books b ON l.accession_no=b.book_id JOIN category_codes c ON b.category_code = c.category_id',
          'c.category_name as category_name, count(l.accession_no) as borrow_count',
          "l.lent_date >='".$custom["fromDate"]."' and l.lent_date <='".$custom["toDate"]."' GROUP by c.category_name ORDER BY borrow_count DESC LIMIT 5"
      );
    }
}
