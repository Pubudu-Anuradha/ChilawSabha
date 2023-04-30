<div class="content">
    <h2 class="topic">All Accepted Complaints</h2>

    <?php
    $table = $data['allComplaints'];
    ?>
    <?php Table::Table(
        [
            'complaint_id' => 'Complaint ID', 'complainer_name' => 'Complainer Name',
            'category_name' => "Category", 'complaint_time' => "Date", 'complaint_state' => "Status",
            'complaint_state' => "Status", 'handle_by' => "Handler"
        ],
        $table['result'],
        'allComplaint',
        actions: [ //TODO
            'View' => [[URLROOT . '/Complaint/newClickedComplaint/%s', 'complaint_id'], 'btn view bg-yellow white', ['#']],
        ],
        empty: $table['nodata']

    ); ?>
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