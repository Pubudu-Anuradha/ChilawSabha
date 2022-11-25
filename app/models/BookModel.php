<?php
class BookModel extends Model
{
    public function AddBook($title, $author, $publisher,$dateofpub,$placeofpub,$bookCategory,$accno,$price,$page,$recdate,$recmethod)
    {
        return $this->insert('books', ["title" => $title,"author" => $author, "publisher" => $publisher, "dateofpub" => $dateofpub, "placeofpub" => $placeofpub,
        "bookCategory" => $bookCategory,"accno" => $accno,"price" => $price,"page" => $page,"recdate" => $recdate,"recmethod" => $recmethod]);
    }
    public function GetBookList()
    {
        return $this->select('books');
    }
}
