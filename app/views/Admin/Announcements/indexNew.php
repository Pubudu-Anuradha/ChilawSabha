<div class="content">

<h1>
    Manage Announcements
</h1>
<hr>

<?php Pagination::top('/Admin/Announcements', select_filters:[
    'category' => [
        'Filter by Category', [
            'All' => 'All',
            'Financial' => 'Financial',
            'Government' => 'Government',
            'Tender' => 'Tender',
        ],
    ],
    'sort' => [
        'Sort by date', [
            'DESC' => 'Newest to Oldest',
            'ASC' => 'Oldest to Newest ',
        ],
    ],

])?>


<?php
$table = $data['announcements'];
?>
<div class="content-table">
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>Title</th>
                <th>Short Desctiption</th>
                <th>Author</th>
                <th>Date</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (!$table['nodata'] && !$table['error']):
              foreach ($table['result'] as $ann): ?>
	            <tr>
	                <td><?=$ann['id']?></td>
	                <td><?=$ann['title']?></td>
	                <td><?=$ann['shortdesc']?></td>
	                <td><?=$ann['author']?></td>
	                <td><?=$ann['date']?></td>
	                <td><?=$ann['category']?></td>
	                <td>
	                    <div  class="btn-column">
	                        <a class="btn bg-green  view"href="<?=URLROOT . '/Admin/Announcements/View/' . $ann['id']?>">View</a>
	                        <a class="btn bg-yellow edit"href="<?=URLROOT . '/Admin/Announcements/Edit/' . $ann['id']?>">Edit</a>
	                    </div>
	                </td>
	            </tr>
	            <?php endforeach;endif;?>
        </tbody>
    </table>
</div>

<?php
Pagination::bottom('filter-form', $data['announcements']['page'], $data['announcements']['count']);
?>

</div>