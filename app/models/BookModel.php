<?php
class BookModel extends Model
{
    public function getBooks($state=[1,2])
    {
        if(count($state) == 2){
            $condidions = ["(b.state='$state[0]' || b.state='$state[1]')"];
        }
        else{
            $condidions = ["b.state='$state[0]'"];
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
            
            array_push($condidions, '(' . implode(' || ', $search_fields) . ')');
        }

        if (isset($_GET['category_name']) && !empty($_GET['category_name']) && $_GET['category_name'] != 'All') {
            $category = mysqli_real_escape_string($this->conn, $_GET['category_name']);
            array_push($condidions, "c.category_name = '$category'");
        }

        $condidions = implode(' && ', $condidions);

        if($state[0] == 4){
            return $this->selectPaginated('category_codes c join books b on b.category_code=c.category_id join lost_books l on b.accession_no=l.accession_no',
                'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, c.category_name as category_name, l.lost_description as lost_description',
                $condidions);
        }

        return $this->selectPaginated('books b join category_codes c on b.category_code=c.category_id',
            'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, c.category_name as category_name',
            $condidions);

    }

    public function get_categories(){
        return $this->select('category_codes');
    }

    public function addBook($book)
    {
        $book['state'] = 1;
        $book['recieved_by'] = $_SESSION['user_id'];
        return $this->insert('books',$book);
    }

    public function editBook($id,$data){
        $book = $this->update('books',$data[0],"accession_no=$id");
        return[
            'book'=>$book
        ];
    }

    public function getBookbyID($id)
    {
        return $this->select('book_status s join books b on b.state=s.status_id',
        'b.title as title,b.author as author,b.publisher as publisher,b.place_of_publication as place_of_publication,b.date_of_publication as date_of_publication,
         b.accession_no as accession_no,b.isbn as isbn,b.price as price,b.pages as pages,b.recieved_date as recieved_date,
         b.recieved_method as recieved_method',
        "b.accession_no=$id");
    }

    public function changeState($id,$state,$reason=[]){
        $accession_no = mysqli_real_escape_string($this->conn,$id);
        if($state == 4) {
            $reason['accession_no'] = $accession_no;
            $reason['lost_record_by'] = $_SESSION['user_id'];
            // var_dump($accession_no);
            $res = $this -> insert('lost_books',[
                'accession_no'=>$reason['accession_no'],
                'lost_description'=>$reason['lost_description'],
                'lost_record_by'=>$reason['lost_record_by']
            ]);
            if($res){
                return $this->update('books',[
                    'state'=> 4
                ],"accession_no='$accession_no'");
            }
            return false;
        }
    }
}
