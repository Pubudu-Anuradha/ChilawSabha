 <h2>
    TABLE
 </h2>
<div class="book-list">
        <table class="bookcatalogue">
            <tr>
              <th>id</th>
              <th>name</th>
              <th>address</th>
              <th>age</th>

            </tr>

<?php
if (isset($data['test'])) {
    while ($book = $data['test']->fetch_assoc()) {
        echo '<tr>';
        echo '<td class="table-data">' . $book['id'] . '</td>';
        echo '<td class="table-data">' . $book['name'] . '</td>';
        echo '<td class="table-data">' . $book['address'] . '</td>';
        echo '<td class="table-data">' . $book['age'] . '</td>';

        echo '</tr>';
    }
}
?>
    </table>
</div>
<h2>
    INSERT CHECK
</h2>
<form action="<?=URLROOT . "/Home/test"?>" method="post">
            <label for="title">ID</label><input type="number" name="id" /><br />
            <label for="author">Name</label><input type="text" name="name"  /><br />
            <label for="publisher">Address</label><input type="text" name="address"  /><br />
            <label for="placeofpub">age</label><input type="number" name="age"  /><br />

            <input type="submit" value="Add" name="Add" id="add" />
        </form>

<h2>
    UPDATE CHECK
</h2>

<form action="<?=URLROOT . "/Home/test"?>" method="post">
    <input type="number" name="id"><br>
    <input type="text" name="address"><br>
    <input type="submit" name="Update" value="Submit">
</form>

<h2>
    DELETE CHECK
</h2>

<form action="<?=URLROOT . "/Home/test"?>" method="post">
    <input type="number" name="id"><br>
    <input type="submit" name="Delete" value="Submit">
</form>