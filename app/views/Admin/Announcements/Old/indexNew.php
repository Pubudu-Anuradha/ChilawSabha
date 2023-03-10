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
]);
Table::Table(columns:[
    'id'=>'ID',
    'title'=>'Announcement Title',
    'shortdesc'=>'Short Description',
    'author'=>'Author',
    'date'=>'Date',
    'category'=>'Category',
],row_data:$data['announcements']['result'],
actions:[
    'View' => [[URLROOT . '/Admin/Announcements/View/%s','id'],'view bg-green'],
    'Edit' => [[URLROOT . '/Admin/Announcements/Edit/%s','id'],'edit'],
]);
Pagination::bottom('filter-form', $data['announcements']['page'], $data['announcements']['count']);
?>
</div>