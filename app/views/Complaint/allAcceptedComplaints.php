<div class="content">
    <h2 class="topic">All Accepted Complaints</h2>

    <?php
    $table1 = $data['allWorking'] ?? false;
    $table2 = $data['allResolved'] ?? null;
    ?>

    <div class="complaint-tabs">
        <div class="tabs">
            <button class="tab-btn" id="working" onclick="openTab(event,'working-complaint')">Working Complaints</button>
            <button class="tab-btn" id="resolved" onclick="openTab(event,'resolved-complaint')">Resolved Complaints</button>
        </div>

        <div class="tab-content" id="working-complaint">
            <?php Pagination::Top('/Complaint/allAcceptedComplaints', select_filters: []); ?>
            <?php Table::Table(
                [
                    'complaint_id' => 'Complaint ID', 'complainer_name' => 'Complainer Name',
                    'category_name' => "Category", 'complaint_time' => "Date",
                    'handler_name' => "Handler Name"
                ],
                $table1['result'],
                'allComplaint',
                actions: [
                    'View' => [[URLROOT . '/Complaint/viewComplaint/%s', 'complaint_id'], 'btn view bg-yellow white', ['#']],
                ],
                empty: $table1['nodata']
            ); ?>
            <?php Pagination::bottom('filter-form', $data['allWorking']['page'], $data['allWorking']['count']); ?>
        </div>

        <div class="tab-content resolved" id="resolved-complaint">
            <?php Pagination::Top('/Complaint/allAcceptedComplaints', select_filters: []); ?>
            <?php Table::Table(
                [
                    'complaint_id' => 'Complaint ID', 'complainer_name' => 'Complainer Name',
                    'category_name' => "Category", 'complaint_time' => "Date",
                    'handler_name' => "Handler Name"
                ],
                $table2['result'],
                'allComplaint',
                actions: [
                    'View' => [[URLROOT . '/Complaint/viewComplaint/%s', 'complaint_id'], 'btn view bg-yellow white', ['#']],
                ],
                empty: $table2['nodata']
            ); ?>
            <?php Pagination::bottom('filter-form', $data['allResolved']['page'], $data['allResolved']['count']); ?>
        </div>
    </div>


</div>

<script>
    var openedModal;
    document.getElementById("working").click();


    function openTab(event, tab) {
        var i, tabs, tabBtn;

        tabs = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabs.length; i++) {
            tabs[i].style.display = "none";
        }

        tabBtn = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tabBtn.length; i++) {
            tabBtn[i].className = tabBtn[i].className.replace(" active", "");
        }

        document.getElementById(tab).style.display = "block";
        event.currentTarget.className += " active";
    }

    function closeModal() {
        openedModal.style.display = "none";
    }

    function openModal(modal) {
        event.preventDefault();
        openedModal = document.getElementById(modal);
        openedModal.style.display = "block";

        window.onclick = function(event) {
            if (event.target == openedModal) {
                openedModal.style.display = "none";
            }
        }
    }
</script>