<div class="content">
    <h2 class="topic">All Accepted Complaints</h2>

    <?php
    $table = $data['allComplaints'];
    // if($table['handle_by'])
    // var_dump($table);
    // if ($table['handle_by'] == $_SESSION['user_id']) {
    // }
    ?>

    <?php Table::Table(
        [
            'complaint_id' => 'Complaint ID', 'complainer_name' => 'Complainer Name',
            'category_name' => "Category", 'complaint_time' => "Date", 'complaint_state' => "Status",
            'complaint_state' => "Status", 'handler_name' => "Handler Name"
        ],
        $table['result'],
        'allComplaint',
        actions: [ //TODO
            'View' => [[URLROOT . '/Complaint/myProcessingClickedComplaint/%s', 'complaint_id'], 'btn view bg-yellow white', ['#']],
        ],
        empty: $table['nodata']
    ); ?>

</div>