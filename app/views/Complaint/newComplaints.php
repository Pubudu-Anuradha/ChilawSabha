<div class="content">
    <h2 class="topic">New Complaints</h2>

    <?php
    $table = $data['newComplaints'];
    $categories = $data['Category']['result'] ?? [];
    $category_arr = ['All' => "All"];
    foreach ($categories as $category) {
        $category_arr[$category['category_id']] = $category['category_name'];
    }
    ?>

    <?php Pagination::Top('/Complaint/newComplaints', select_filters: [
        'category_name' => [
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
            'Accept' => [['#'], 'btn accept bg-red white', ["openModal(%s,'lost_description')", 'complaint_id']], //TODO 
            'View' => [[URLROOT . '/Complaint/viewComplaint/%s', 'complaint_id'], 'btn view bg-yellow white', ['#']],
        ],
        empty: $table['nodata']

    ); ?>
    <?php Pagination::bottom('filter-form', $data['newComplaints']['page'], $data['newComplaints']['count']); ?>

</div>

<script>
    expandSideBar("sub-items-serv", "see-more-bk");
    var openedModal;

    function closeModal() {
        openedModal.style.display = "none";
    }

    function openModal(id, modal) {
        event.preventDefault();
        openedModal = document.getElementById(modal);
        openedModal.querySelector('input[type="number"]').value = id;
        openedModal.style.display = "block";

        window.onclick = function(event) {
            if (event.target == openedModal) {
                openedModal.style.display = "none";
            }
        }
    }
</script>