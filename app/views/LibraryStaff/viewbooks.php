<?php require_once 'Header.php';?>

<div class="sidebar">
    <a href="<?=URLROOT . "/LibraryStaff/index"?>" class="option">LEND/RECIEVE BOOKS</a>
    <a href="<?=URLROOT . "/LibraryStaff/viewbooks"?> " class="option">BOOK CATALOGUE</a>
    <a href="#" class="option">USER MANAGEMENT</a>
    <a href="#" class="option">ANALYTICS</a>
    <a href="#" class="option">LOST BOOKS</a>
    <a href="#" class="option">DE-LISTED BOOKS</a>
    <a href="#" class="option">BOOK REQUESTS</a>
</div>

<div class="view-books">
    <h1 class="catalog">BOOK CATALOGUE</h1>
    <form action="<?=URLROOT . '/Login/Logout'?>" method="post">
        <input type="submit" value="Logout" name = "logout" class="btn-logout" />
    </form>
    <hr class="h-ruler" />
    <div>
        <a href="#" class="damagelist-btn">DAMAGED LIST</a>
        <a href="<?=URLROOT . "/LibraryStaff/insertbooks"?>" class="addbook-btn">ADD BOOK</a>
    </div>

    <div class="book-list">
        <table class="bookcatalogue">
            <tr>
              <th>Accession No</th>
              <th>Title</th>
              <th>Author</th>
              <th>Publisher</th>
              <th>Date of Publication</th>
              <th>Place of Publication</th>
              <th>Price</th>
              <th>Pages</th>
              <th class="action">Action</th>
            </tr>

            <?php
if (isset($data['books'])) {
    while ($book = $data['books']->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $book['accno'] . '</td>';
        echo '<td>' . $book['title'] . '</td>';
        echo '<td>' . $book['author'] . '</td>';
        echo '<td>' . $book['publisher'] . '</td>';
        echo '<td>' . $book['dateofpub'] . '</td>';
        echo '<td>' . $book['placeofpub'] . '</td>';
        echo '<td>' . $book['price'] . '</td>';
        echo '<td>' . $book['page'] . '</td>';
        echo '<td><input type="submit" class="edit-btn" name=edit value="Edit"/>
              <input type="submit" class="lost-btn" name=lost value="Lost"/>
              <input type="submit" class="delist-btn" name=delist value="De-List"/></td>';
        echo '</tr>';
    }
}
?>
        </table>
    </div>
</div>


<?php require_once 'Footer.php';?>