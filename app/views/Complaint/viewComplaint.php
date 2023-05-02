<div class="content">
    <h2 class="topic">Complaint Details</h2>

    <?php
    [$complaint, $images] = $data['viewComplaint'] ?? [false, false];
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
            <div><?php echo "<p class='complaint_label'>Complainer Name: <span class='complaint-data'>" . $complaintData['complainer_name'] . "</p>"; ?></div>
            <div><?php echo "<p class='complaint_label'>Email: <span class='complaint-data'>" . $complaintData['email'] . "</p>"; ?></div>
            <div><?php echo "<p class='complaint_label'>Mobile No: <span class='complaint-data'>" . $complaintData['contact_no'] . "</p>"; ?></div>
            <div><?php echo "<p class='complaint_label'>Address: <span class='complaint-data'>" . $complaintData['address'] . "</p>"; ?></div>
            <div><?php echo "<p class='complaint_label'>Date: <span class='complaint-data'>" . $complaintData['complaint_time'] . "</p>"; ?></div>
            <div><?php echo "<p class='complaint_label'>Category: <span class='complaint-data'>" . $complaintData['category_name'] . "</p>"; ?></div>
            <div>
                <p class="complaint_label">Description:</p><textarea readonly class="complaint-data des" name="description" rows="5" cols="10"><?php echo  $complaintData['description']; ?></textarea>
            </div>

        </div>
    <?php
    } else {
        echo "No complaints found.";
    }
    ?>
    <div class="topic-img">
        <h2 class="topic">Photos</h2>
    </div>
    <div class="complaint-photos">
        <?php foreach ($images as $image) : ?>
            <!-- image path -->
            <img src="<?= URLROOT . '/Access/confidential/Complaint/' . $image['name'] ?>" alt="<?= $image['orig'] ?>" width="200px">
        <?php endforeach; ?>
    </div>

    <div class="notes">
        <div class="topic-note" style="display: <?php echo ($complaintData['handle_by'] == $_SESSION['user_id'] || $complaintData['complaint_state'] == '1') ? 'flex' : 'none'; ?>; align-items: center;">
            <h2 class="topic" style="margin-right: 10px;">Notes</h2>
            <?php if ($complaintData['handle_by'] == $_SESSION['user_id'] || $complaintData['complaint_state'] == 1) : ?>
                <a href="#" class="btn btn accept bg-green white">Add Note</a>
            <?php endif; ?>
        </div>
    </div>


</div>