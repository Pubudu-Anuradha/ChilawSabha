 <h2>
    TABLE
 </h2>
<div>
        <table>
            <tr>
              <th>id</th>
              <th>name</th>
              <th>address</th>
              <th>age</th>
            </tr>
<?php
if (isset($data['test'])) {
    if (!$data['test']['error'] && !$data['test']['nodata']):
        foreach ($data['test']['result'] as $book): ?>
				        <tr>
				            <td>
				                <?=$book['id']?>
				            </td>
				            <td>
				                <?=$book['name']?>
				            </td>
				            <td>
				                <?=$book['address']?>
				            </td>
				            <td>
				                <?=$book['age']?>
				            </td>
				        </tr>
				<?php endforeach;
    else: ?>
        <tr>
            <td colspan="4">
                <?=$data['test']['error'] ? $data['test']['errmsg'] : 'NO DATA AVAILABLE'?>
            </td>
        </tr>
    <?php endif;
}
?>
    </table>
</div>
<h2>
    INSERT
</h2>
<form action="<?=URLROOT . "/Home/test"?>" method="post">
            <label for="title">
                ID
            </label>
            <input type="number" name="id" /> <br />
            <label for="author">
                Name
            </label>
            <input type="text" name="name"  /> <br />
            <label for="publisher">
                Address
            </label>
            <input type="text" name="address"  /> <br />
            <label for="placeofpub">
                age
            </label>
            <input type="number" name="age"  /> <br />
            <input type="submit" value="Add" name="Add" id="add" />
        </form>

<h2>
    UPDATE
</h2>

<form action="<?=URLROOT . "/Home/test"?>" method="post">
    <input type="number" name="id"><br>
    <input type="text" name="address"><br>
    <input type="submit" name="Update" value="Submit">
</form>

<h2>
    DELETE
</h2>

<form action="<?=URLROOT . "/Home/test"?>" method="post">
    <input type="number" name="id"><br>
    <input type="submit" name="Delete" value="Submit">
</form>