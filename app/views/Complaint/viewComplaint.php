<div class="content">
    <h2 class="topic">My working Complaint</h2>
    <div class="table-form">

        <?php
        $table = $data['complaint'];
        ?>
        <?php Table::Table(
            [
                'complaint_id' => 'Complaint ID', 'complainer_name' => 'Complainer Name', 'email' => 'Email', 'address' => 'Address',
                'contact_no' => "Mobile No", 'category_name' => "Complaint Category", 'complaint_time' => "Date", 'description' => "Description", 'complaint_status' => "Status"
            ],
            $table['result'],
            'view_Complaint',
            actions: [],
            empty: $table['nodata']

        ); ?>
    </div>
</div>