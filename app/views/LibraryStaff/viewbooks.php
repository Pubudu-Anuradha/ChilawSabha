<?php require_once 'Header.php';?>
<?php require_once 'Sidebar.php';?>

<div class="view-books">
    <h1 class="catalog">BOOK CATALOGUE</h1>
    <?php require_once 'Logout.php';?>
    <hr class="h-ruler" />
    <div>
        <a href="#" class="damagelist-btn">DAMAGED LIST</a>
        <a href="<?=URLROOT . "/LibraryStaff/Insertbooks"?>" class="addbook-btn">ADD BOOK</a>
    </div>

    <div class="book-list">
        <table class="bookcatalogue">
            <tr>
              <th>Accession No</th>
              <th>Title</th>
              <th>Author</th>
              <th>Publisher</th>
              <th>Place of Publication</th>
              <th>Date of Publication</th>
              <th>Price</th>
              <th>Pages</th>
              <th class="action">Action</th>
            </tr>

            <?php
                if (isset($data['books'])) {
                    while ($book = $data['books']->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td class="table-data">' . $book['accno'] . '</td>';
                        echo '<td class="table-data">' . $book['title'] . '</td>';
                        echo '<td class="table-data">' . $book['author'] . '</td>';
                        echo '<td class="table-data">' . $book['publisher'] . '</td>';
                        echo '<td class="table-data">' . $book['placeofpub'] . '</td>';
                        echo '<td class="table-data">' . $book['dateofpub'] . '</td>';
                        echo '<td class="table-data">' . $book['price'] . '</td>';
                        echo '<td class="table-data">' . $book['page'] . '</td>';
                        echo '<td class="action-list"><input type="submit" class="edit-btn" name=edit value="Edit"/>
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