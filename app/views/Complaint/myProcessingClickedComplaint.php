<div class="content">
    <h2 class="topic">My working Complaint</h2>

    <?php
    $table = $data['workingComplaint'];
    ?>
    <?php Table::Table(
        [
            'complaint_id' => 'Complaint ID', 'complainer_name' => 'Complainer Name', 'email' => 'Email', 'address' => 'Address',
            'contact_no' => "Mobile No", 'category_name' => "Complaint Category", 'complaint_time' => "Date", 'description' => "Description", 'complaint_status' => "Status"
        ],
        $table['result'],
        'working_Complaint',
        actions: [
            'Accept' => [['#'], 'btn accept bg-red white', ["openModal(%s,'lost_description')", 'complaint_id']], //TODO 
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