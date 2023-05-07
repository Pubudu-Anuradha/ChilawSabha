<?php

class LibraryMemberModel extends Model{
    public function getMemberDetails($userId){
        $id = mysqli_real_escape_string($this->conn, $userId);
        return $this->select('library_member', 'user_id,member_id,membership_id,nic,no_of_books_lost, no_of_books_damaged', "user_id='$id'")['result'][0] ?? [];
    }

    public function getFavCompPrecedence($memberId){
        $id = mysqli_real_escape_string($this->conn, $memberId);
        $fav =  $this->select('favourite_books f JOIN books b ON f.accession_no=b.book_id', 'DISTINCT b.category_code as category_code, COUNT(*) as count', "f.membership_id='$id' GROUP BY b.category_code")['result'] ?? [];
        $comp = $this->select('completed_books c JOIN books b ON c.accession_no=b.book_id', 'DISTINCT b.category_code as category_code, COUNT(*) as count', "c.membership_id='$id' GROUP BY b.category_code")['result'] ?? [];
        $ptr = $this->select('plan_to_read_books p JOIN books b ON p.accession_no=b.book_id', 'DISTINCT b.category_code as category_code, COUNT(*) as count', "p.membership_id='$id' GROUP BY b.category_code")['result'] ?? [];
        $res = array_merge_recursive($fav, $comp, $ptr);
        $sums = [];
        foreach ($res as $item) {
            $code = $item['category_code'];
            $count = $item['count'];
            
            if (isset($sums[$code])) {
                $sums[$code] += $count;
            } else {
                $sums[$code] = $count;
            }
        }
        arsort($sums);
        return $sums;
    }
}