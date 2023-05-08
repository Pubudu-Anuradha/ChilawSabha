<div class="content">
    <h2 class="topic">New Complaints</h2>

    <?php
    $table = $data['newComplaints'];
    $categories = $data['Category']['result'] ?? [];
    $category_arr = ['0' => "All"];
    foreach ($categories as $category) {
        $category_arr[$category['category_id']] = $category['category_name'];
    }
    ?>

    <?php Pagination::Top('/Complaint/newComplaints', select_filters: [
        'category' => [
            'Choose by Category', $category_arr
        ]
    ]); ?>
    <?php Table::Table(
        [
            'complaint_id' => 'Complaint ID', 'complainer_name' => 'Complainer Name',
            'category_name' => "Category", 'complaint_time' => "Date"
        ],
        $table['result'],
        'newComplaint',
        actions: [
            'Accept' => [['#'], 'btn accept bg-red white', ["openForm('acceptForm',%s)", 'complaint_id']],
            'View' => [[URLROOT . '/Complaint/viewComplaint/%s', 'complaint_id'], 'btn view bg-yellow white', ['#']],
        ],
        empty: $table['nodata']

    ); ?>
    <?php Pagination::bottom('filter-form', $data['newComplaints']['page'], $data['newComplaints']['count']); ?>


    <!-- For Accept Button -->
    <div class="form-popup-accept" id="acceptForm">
        <div class="form-container-accept">
            <div class="accept-input">
                <label class="label-text"><b>Please Confirm ?</b></label>
            </div>

            <div class="button-group-accept">
                <a href="#" class="btn btn-accept bg-green white">Confirm</a>
                <button type="button" class="btn btn-accept bg-red white" onclick="closeForm('acceptForm')">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    function openForm(formId,complaint_id) {
        document.getElementById(formId).querySelector('a.btn-accept').href = "<?= URLROOT . '/Complaint/acceptComplaint/' ?>" + complaint_id;
        document.getElementById(formId).style.display = "block";
    }

    function closeForm(formId) {
        document.getElementById(formId).style.display = "none";
    }
</script>