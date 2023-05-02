<div class="content">
    <h2 class="topic">My Working Complaints</h2>

    <?php
    $table = $data['workingComplaints'];
    ?>
    <?php Table::Table(
        [
            'complaint_id' => 'Complaint ID', 'complainer_name' => 'Complainer Name',
            'category_name' => "Category", 'complaint_time' => "Date"
        ],
        $table['result'],
        'resolvedComplaint',
        actions: [
            'View' => [[URLROOT . '/Complaint/viewComplaint/%s', 'complaint_id'], 'btn view bg-yellow white', ['#']],
        ],
        empty: $table['nodata']

    ); ?>
    <?php Pagination::bottom('filter-form', $data['workingComplaints']['page'], $data['workingComplaints']['count']); ?>

</div>