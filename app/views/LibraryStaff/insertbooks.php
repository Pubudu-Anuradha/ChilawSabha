<?php require_once 'Header.php';?>

<div class="sidebar">
    <a href="<?= URLROOT . "/LibraryStaff/index" ?>" class="option">LEND/RECIEVE BOOKS</a>
    <a href="<?= URLROOT . "/LibraryStaff/viewbooks" ?> " class="option">BOOK CATALOGUE</a>
    <a href="#" class="option">USER MANAGEMENT</a>
    <a href="#" class="option">ANALYTICS</a>
    <a href="#" class="option">LOST BOOKS</a>
    <a href="#" class="option">DE-LISTED BOOKS</a>
    <a href="#" class="option">BOOK REQUESTS</a>
</div>   

<div class="add-books">
    <h1 class="add-book-topic">ADD BOOKS</h1>
    <form action="<?= URLROOT . '/Login/Logout' ?>" method="post">
        <input type="submit" value="Logout" name = "logout" class="btn-logout" />
    </form>
    <hr class="h-ruler" />

    <div class="insert-bookform">
        <form action="<?= URLROOT . "/LibraryStaff/insertbooks" ?>" method="post">
            <label for="title">Title</label><input type="text" name="title" required /><br />
            <label for="author">Author</label><input type="text" name="author" required /><br />
            <label for="publisher">Publisher</label><input type="text" name="publisher" required /><br />
            <label for="dateofpub">Date of Publication</label><input type="date"  class="date" name="dateofpub" required /><br />
            <label for="placeofpub">Place of Publication</label><input type="text" name="placeofpub" required /><br />
            <label for="bookCategory">Book Category</label><select name="bookCategory" id="bookCategory">
                <option value="Fantacy">Fantacy</option>
                <option value="Thriller">Thriller</option>
                <option value="Horror">Horror</option>
            </select><br />
            <label for="accno">Accession No</label><input type="text" name="accno" required /><br />
            <label for="price">Price</label><input type="number" name="price" min="1" step="any" required/><br />
            <label for="page">Pages</label><input type="number" name="page" required /><br />
            <label for="recdate">Recieved Date</label><input type="date" class="date" name="recdate" required /><br />
            <label for="recmethod">Recieved Method</label><input type="text" name="recmethod" required /><br />

            <input type="submit" value="Add" name="submit" id="add" />
        </form>
    </div>
</div>

<?php require_once 'Footer.php';?>