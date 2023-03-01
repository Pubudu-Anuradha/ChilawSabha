<div class="content">
    <div class="page">
        <h2 class="topic">Edit Books</h2>
        <form action="<?= URLROOT . "/LibraryStaff/editbooks" ?>" class="fullForm">
            <div class="inputfield">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" maxlength="255" required>
            </div>
            <div class="inputfield">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" maxlength="255" required>
            </div>
            <div class="inputfield">
                <label for="publisher">Publisher</label>
                <input type="text" name="publisher" id="publisher" maxlength="255" required>
            </div>
            <div class="inputfield">
                <label for="placeofpub">Place of Publication</label>
                <input type="text" name="placeofpub" id="placeofpub" maxlength="255" required>
            </div>
            <div class="inputfield">
                <label for="dateofpub">Date of Publication</label>
                <input type="date" name="dateofpub" id="dateofpub" max="<?php echo date("Y-m-d"); ?>" required>
            </div>
            <div class="inputfield">
                <label for="bookcategory">Book Category</label>
                <select name="categoryFill">
                    <option value="Null">Choose Category</option>
                    <option value="Philosophy">Philosophy</option>
                    <option value="Languages">Languages</option>
                    <option value="Natural Sciences">Natural Sciences</option>
                    <option value="Literature">Literature</option>
                </select>
            </div>
            <div class="inputfield">
                <label for="accno">Accession No</label>
                <input type="text" name="accno" id="accno" required >
            </div>
            <div class="inputfield">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" step="0.01" min="0" required>
            </div>
            <div class="inputfield">
                <label for="pages">Pages</label>
                <input type="number" name="pages" id="pages" min="1" required>
            </div>
            <div class="inputfield">
                <label for="recdate">Recieved Date</label>
                <input type="date" name="recdate" id="recdate" max="<?php echo date("Y-m-d"); ?>" required>
            </div>
            <div class="inputfield">
                <label for="recmethod">Recieved Method</label>
                <input type="text" name="recmethod" id="recmethod" maxlength="255" required>
            </div>
            <div class="submitButtonContainer">
                <label for="markdamaged">Mark As Damaged</label><input type="checkbox" name="damagedcheck" id="damagedcheck">
                <input type="submit" name="Submit" value="Confirm" class="submit-btn">
            </div>
        </form>
    </div>
</div>