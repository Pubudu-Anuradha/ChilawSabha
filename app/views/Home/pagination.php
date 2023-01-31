<div class="content">
    <h2>
        Pagination Test
    </h2>
    <table>
        <tr>
            <th>id</th>
            <th>name</th>
            <th>address</th>
            <th>age</th>
        </tr>
        <?php
$table = $data['test'];
if (!$table['error'] && !$table['nodata']) {
    foreach ($table['result'] as $row) {?>
                <tr>
                    <td>
                        <?=$row['id']?>
                    </td>
                    <td>
                        <?=$row['name']?>
                    </td>
                    <td>
                        <?=$row['address']?>
                    </td>
                    <td>
                        <?=$row['age']?>
                    </td>
                </tr>
            <?php }
} else {?>
            <tr>
                <td colspan="2">No Data</td>
            </tr>
        <?php }?>

    </table>
    <?php
$size = $table['page'][1];
$max = $table['count'];

for ($i = 0; $i * $size < $max; $i++) {?>
         <a href="<?=URLROOT . "/Home/paginationTest?page=$i&size=$size"?>"><?=$i + 1?></a>
    <?php }?>
<form action="<?=URLROOT . "/Home/paginationTest"?>" method="get">
<select name="page" id="page">
<?php
$i = 0;
for (; $i * $size < $max; $i++) {?>
    <option value="<?=$i?>"><?=$i + 1?></option>
<?php }?>
</select>
    No.of Rows : <input type="number" name="size" id="size" value="<?=$table['page'][1]?>" min="10"> <br>
    <input type="submit" value="Submit">
</form>
</div>