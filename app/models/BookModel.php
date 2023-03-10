<?php
class BookModel extends Model
{
    public function getBooks($state=['Available','Lent'])
    {
        if(count($state) == 2){
            $condidions = ["(s.status='$state[0]' || s.status='$state[1]')"];
        }
        else{
            $condidions = ["s.status='$state[0]'"];
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

        return $this->selectPaginated('book_status s join books b on b.state=s.status_id join category_codes c on b.category_code=c.category_id',
            'b.accession_no as accession_no,b.title as title,b.author as author,b.publisher as publisher, c.category_name as category_name',
            $condidions);

    }

    public function get_categories(){
        return $this->select('category_codes');
    }

    public function addBook($book)
    {
        return $this->insert('books',[
            'title'=>$book['title'],
            'author'=>$book['author'],
            'publisher'=>$book['publisher'],
            'place_of_publication'=>$book['place_of_publication'],
            'date_of_publication'=>$book['date_of_publication'],
            'category_code'=>$book['category_code'],
            'accession_no'=>$book['accession_no'],
            'price'=>$book['price'],
            'pages'=>$book['pages'],
            'recieved_date'=>$book['recieved_date'],
            'recieved_method'=>$book['recieved_method'],
            'state'=>1,
            'isbn'=>$book['isbn'],
            'recieved_by'=>$_SESSION['user_id']
        ]);
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
}
