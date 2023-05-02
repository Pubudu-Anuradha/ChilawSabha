<div class="content">
    <h2 class="topic">Complaint Details</h2>

    <?php
    [$complaint, $images] = $data['viewComplaint'] ?? [false, false];
    $notes = $data['notes']['result'] ?? [];
    $id = $notes[0]['complaint_id'];
    ?>
    <?php
    if (is_array($complaint) && count($complaint) > 0) {
        $complaintData = $complaint[0];
    ?>
        <div class="complaint-info">
            <div class="complaint-state">
                <?php echo "<p class='complaint_label'>Status: <span class='complaint-status " . strtolower($complaintData['complaint_status']) . "'>" . $complaintData['complaint_status'] . "</p>"; ?>
                <?php if ($complaintData['complaint_state'] == 1) : ?>
                    <a href="#" class="btn btn accept bg-red white">Accept</a>
                <?php endif; ?>
            </div>
            <div class="complaint-group"><?php echo "<p class='complaint_label'>Complainer Name:</p><span class='complaint-data'>" . $complaintData['complainer_name'] . ""; ?></div>
            <div class="complaint-group"><?php echo "<p class='complaint_label'>Email: </p><span class='complaint-data'>" . $complaintData['email'] . ""; ?></div>
            <div class="complaint-group"><?php echo "<p class='complaint_label'>Mobile No: </p><span class='complaint-data'>" . $complaintData['contact_no'] . ""; ?></div>
            <div class="complaint-group"><?php echo "<p class='complaint_label'>Address: </p><span class='complaint-data'>" . $complaintData['address'] . ""; ?></div>
            <div class="complaint-group"><?php echo "<p class='complaint_label'>Date: </p><span class='complaint-data'>" . $complaintData['complaint_time'] . ""; ?></div>
            <div class="complaint-group"><?php echo "<p class='complaint_label'>Category: </p><span class='complaint-data'>" . $complaintData['category_name'] . ""; ?></div>
            <div class="complaint-group"><?php echo "<p class='complaint_label'>Description: </p><span class='complaint-data'>" . $complaintData['description'] . ""; ?></div>
        </div>
    <?php
    } else {
        echo "No complaints found.";
    }
    ?>

    <div class="complaint-photo-group">
        <div>
            <h2 class="topic">Photos</h2>
        </div>
        <?php if (is_array($images) && count($images) > 0) : ?>
            <div class="complaint-photos">
                <?php foreach ($images as $image) : ?>
                    <!-- image path -->
                    <img src="<?= URLROOT . '/Access/confidential/Complaint/' . $image['name'] ?>" alt="<?= $image['orig'] ?>" width="200px">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>


    <div class="notes">
        <?php if (is_array($complaint) && count($complaint) > 0) {
            $complaintData = $complaint[0]; ?>

            <div class="topic-note">
                <h2 class="topic">Notes</h2>
                <?php if ($complaintData['handle_by'] == $_SESSION['user_id'] && $complaintData['complaint_state'] !== 3 || $complaintData['complaint_state'] == 1) : ?>
                    <!-- <a href="#" class="btn btn accept bg-green white">Add Note</a> -->
                    <button onclick="openModal(<?= $id ?>,'add_note')" class="btn btn-accept bg-green white">Add Note</button>
                    <?php Modal::Modal(textarea: true, title: "Add Note", name: 'add_note', id: 'add_note', rows: 10, cols: 50, required: true); ?>

                <?php endif; ?>
            </div>
            <?php if (is_array($notes) && count($notes) > 0) { ?>
                <div>
                    <?php foreach ($notes as $key => $note) { ?>
                        <div class="complaint-group"><?php echo "<span class='complaint-data'>" . $note['note_time'] . "  " . $note['note'] . "  Added By  " . $note['user_name'] . "\n" . ""; ?></div>
                    <?php } ?>
                </div>
        <?php
            }
        }
        ?>
    </div>
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