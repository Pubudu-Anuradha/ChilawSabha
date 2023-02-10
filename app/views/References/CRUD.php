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
if (isset($data['test'])):
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
endif;
?>
     </table>
 </div>
 <h2>
     INSERT
 </h2>
 <form action="<?=URLROOT . "/References/CRUD"?>" method="post">
     <?php
if (isset($data['Add'])):
    if ($data['Add']['success']): ?>
	<div class="success">
	    Added Record
	</div>
	<?php else: ?>
     <div class="Failure">
         Failed to add Record <br>
         <?=$data['Add']['errmsg']?>
     </div>
     <?php endif;
endif;?>
     <label for="title">
         ID
     </label>
     <input type="number" name="id" /> <br />
     <label for="author">
         Name
     </label>
     <input type="text" name="name" /> <br />
     <label for="publisher">
         Address
     </label>
     <input type="text" name="address" /> <br />
     <label for="placeofpub">
         age
     </label>
     <input type="number" name="age" /> <br />
     <input type="submit" value="Add" name="Add" id="add" />
 </form>

 <h2>
     UPDATE
 </h2>

 <form action="<?=URLROOT . "/References/CRUD"?>" method="post">
<?php
if (isset($data['Update'])):
    if ($data['Update']['success']): ?>
	<div class="success">
	    Updated Record! Affected Rows : <?=$data['Update']['rows']?>
	</div>
	<?php else: ?>
<div class="Failure">
    Failed to Update Record <br>
    <?=$data['Update']['rows'] . ' records affected', $data['Update']['errmsg']?>
</div>
     <?php endif;
endif;?>
     <input type="number" name="id"><br>
     <input type="text" name="address"><br>
     <input type="submit" name="Update" value="Update">
 </form>

 <h2>
     DELETE
 </h2>

 <form action="<?=URLROOT . "/References/CRUD"?>" method="post">
<?php
if (isset($data['Delete'])):
    if ($data['Delete']['success']): ?>
	<div class="success">
	    Deleted Record! Affected Rows : <?=$data['Delete']['rows']?>
	</div>
	<?php else: ?>
<div class="Failure">
    Failed to Delete Record <br>
    <?=$data['Delete']['rows'] . ' records affected', $data['Delete']['errmsg']?>
</div>
     <?php endif;
endif;?>
     <input type="number" name="id"><br>
     <input type="submit" name="Delete" value="Delete">
 </form>