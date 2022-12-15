<?php require_once 'Header.php';?>
<?php require_once 'Sidebar.php';?>

<div class="add-books">
    <h1 class="add-book-topic">ADD BOOKS</h1>
    <?php require_once 'Logout.php';?>
    <hr class="h-ruler" />

    <div class="insert-bookform">
        <form action="<?=URLROOT . "/LibraryStaff/Insertbooks"?>" method="post">
            <label for="title">Title</label><input type="text" name="title" required /><br />
            <label for="author">Author</label><input type="text" name="author" required /><br />
            <label for="publisher">Publisher</label><input type="text" name="publisher" required /><br />
            <label for="placeofpub">Place of Publication</label><input type="text" name="placeofpub" required /><br />
            <label for="dateofpub">Date of Publication</label><input type="date"  name="dateofpub" class="dateofpub-input" required />
            <label for="bookCategory" class="bookCategory-label">Book Category</label><select name="bookCategory" id="bookCategory" class="bookCategory-input">
                <option value="Fantacy">Fantacy</option>
                <option value="Thriller">Thriller</option>
                <option value="Horror">Horror</option>
            </select><br />
            <label for="accno">Accession No</label><input type="text" name="accno" class="accno" required />
            <label for="price" class="price-label">Price</label><input type="number" name="price" min="1" class="price" step="any" required/><br />
            <label for="page">Pages</label><input type="number" name="page" class="page" required />
            <label for="recdate" class="recdate-label">Recieved Date</label><input type="date" class="recdate-input" name="recdate" required /><br />
            <label for="recmethod">Recieved Method</label><input type="text" name="recmethod" required /><br />

            <input type="submit" value="Add" name="Submit" id="add" />
            <?php warn($data); ?>
        </form>
    </div>
</div>

<?php require_once 'Footer.php';?>
