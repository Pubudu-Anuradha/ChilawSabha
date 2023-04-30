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
            'View' => [[URLROOT . '/Complaint/myProcessingClickedComplaint/%s', 'complaint_id'], 'btn view bg-yellow white', ['#']],
        ],
        empty: $table['nodata']

    ); ?>
</div>



<!-- TODO -->
<!-- <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Complaint ID</th>
                    <th>Complainer Name</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>11</td>
                    <td>W.P Alwis</td>
                    <td>Garbage Disposal</td>
                    <td>2022.12.15</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn view" onclick='window.location.href="<?= URLROOT . "/Complaint/myProcessingClickedComplaint" ?>"'>View</button>
                            <button type="button" class="btn view" onclick="openModal()">Add Note</button>

                        </div>
                    </td>
                </tr>

                <tr>
                    <td>12</td>
                    <td>W.P Alwis</td>
                    <td>Garbage Disposal</td>
                    <td>2022.12.30</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn view">View</button>
                            <button type="button" class="btn view" onclick="openModal()">Add Note</button>

                        </div>

                    </td>
                </tr>

                <tr>
                    <td>13</td>
                    <td>W.P Alwis</td>
                    <td>Garbage Disposal</td>
                    <td>2022.12.31</td>
                    <td>
                        <div class="btn-column">
                            <button class="btn view">View</button>
                            <button type="button" class="btn view" onclick="openModal()">Add Note</button>

                        </div>

                    </td>
                </tr>

            </tbody>
        </table>
    </div> -->

<!-- <div class="popup popup-confirm">
        <div id="popupModal" class="popup-modal">
            <div class="popup-content">
                <div class="close-section-popup"><span class="close-popup" onclick="closeModal()">&times;</span></div>
                <div class="popup-text">
                    <p>ADD NOTE</p>
                    <div class="note-textarea">
                        <textarea id="noteInput" name="message" rows="10" cols="64"></textarea>
                    </div>
                </div>
                <div class="popup-submit-btn">
                    <button class="btn bg-blue" onclick="closeModal()">Submit</button>
                </div>
            </div>
        </div>
    </div> -->


<!-- <script>
    var modal = document.getElementById("popupModal");

    function closeModal() {
        modal.style.display = "none";
    }

    function openModal() {
        modal.style.display = "block";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script> -->

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