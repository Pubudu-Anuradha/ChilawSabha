<div class="content">
    <h2 class="topic">Complaint Details</h2>
    <?php

    // Accessing the error passed from the controller
    if (isset($data['error'])) {
        echo $data['error'];
    }

    // Accessing the viewComplaint and notes passed from the controller
    if (isset($data['viewComplaint']) && isset($data['notes'])) {
        [$complaint, $images] = $data['viewComplaint'] ?? [false, false];
        $notes = $data['notes']['result'] ?? [];
        foreach ($complaint as $c) {
            $complaint_id = $c['complaint_id'];
        }
    }
    ?>
    <?php
    if (is_array($complaint) && count($complaint) > 0) {
        $complaintData = $complaint[0];
    ?>
        <div class="complaint-info">
            <div class="complaint-state">
                <?php echo "<p class='complaint_label'>Status: <span class='complaint-status " . strtolower($complaintData['complaint_status']) . "'>" . $complaintData['complaint_status'] . "</p>"; ?>
                <?php if ($complaintData['complaint_state'] == 1) : ?>
                    <button onclick="openForm('acceptForm')" class="btn btn accept bg-red white">Accept</button>
                <?php endif; ?>
                <?php if ($complaintData['complaint_state'] == 2 && $complaintData['handle_by'] == $_SESSION['user_id']) : ?>
                    <button onclick="openForm('finishForm')" class="btn btn accept bg-green white">Resolve</button>
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
                    <button onclick="openForm('noteForm')" class="btn btn-accept bg-green white">Add Note</button>
                <?php endif; ?>
            </div>
            <?php if (is_array($notes) && count($notes) > 0) { ?>
                <div>
                    <?php foreach ($notes as $key => $note) { ?>
                        <div class="complaint-group"><?php echo "<span class='complaint-data'> " . $note['note_time'] . " " . $note['user_name'] . "  Added<b>"." " . $note['note'] . "</b>\n" . ""; ?></div>
                    <?php } ?>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>

<!-- For Accept Button -->
<div class="form-popup-accept" id="acceptForm">
    <div class="form-container-accept">
        <div class="accept-input">
            <label class="label-text"><b>Please Confirm ?</b></label>
        </div>

        <div class="button-group-accept">
            <a href="<?php echo URLROOT . '/Complaint/acceptComplaint/' . $complaint_id; ?>" class="btn btn-accept bg-green white">Confirm</a>
            <button type="button" class="btn btn-accept bg-red white" onclick="closeForm('acceptForm')">Close</button>
        </div>
    </div>
</div>

<!-- For Finish Button -->
<div class="form-popup-accept" id="finishForm">
    <div class="form-container-accept">
        <div class="accept-input">
            <label class="label-text"><b>Please Confirm ?</b></label>
        </div>

        <div class="button-group-accept">
            <a href="<?php echo URLROOT . '/Complaint/finishComplaint/' . $complaint_id; ?>" class="btn btn-accept bg-green white">Confirm</a>
            <button type="button" class="btn btn-accept bg-red white" onclick="closeForm('finishForm')">Close</button>
        </div>
    </div>
</div>

<!-- For note -->
<div class="form-popup" id="noteForm">
    <form id=noteForm method="post" action="<?php echo URLROOT . '/Complaint/addNote/' ; ?>">
        <div class=" form-container">
            <div class="close-section"><span class="close" onclick="closeForm('noteForm')">&times;</span></div>
            <input type="hidden" name="complaint_id" value="<?php echo $complaint_id; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">


            <div class="note-input">
                <label class="label-text"><b>Enter Notes</b></label>
                <textarea placeholder="Enter notes" name="note" id="textarea-note" rows="20" cols=10 class="textarea"></textarea>
            </div>

            <div class="button-group">
                <button class="btn btn-accept bg-green white" name="Submit" id="Submit">Submit</button>
                <button class="btn btn-accept bg-red white" onclick="closeForm('noteForm')">Close</button>
            </div>
        </div>
    </form>
</div>


</body>

</html>

<script>
    function openForm(formId) {
        document.getElementById(formId).style.display = "block";
    }

    function closeForm(formId) {
        document.getElementById(formId).style.display = "none";
    }
</script>

