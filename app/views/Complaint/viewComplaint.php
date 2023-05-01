<div class="content">
    <h2 class="topic">New Complaint</h2>

    <?php
    [$complaint, $images] = $data['viewComplaint'] ?? [false, false];
    ?>
    <?php
    if (is_array($complaint) && count($complaint) > 0) {
        $complaintData = $complaint[0]; // Get the first element of the array
    ?>
        <div class="complaint-info">
            <div class="complainer-name"><?php "<p>Complaint ID: " . $complaintData['complaint_id'] . "</p>"; ?></div>
            <div class="email"><?php echo "<p>Complainer Name: " . $complaintData['complainer_name'] . "</p>"; ?></div>
            <div class="contact-no"><?php echo "<p>Email: " . $complaintData['email'] . "</p>"; ?></div>
            <div class="complaint-time"><?php echo "<p>Contact No: " . $complaintData['contact_no'] . "</p>"; ?></div>
            <div class="address"><?php echo "<p>Address: " . $complaintData['address'] . "</p>"; ?></div>
            <div class="description"><?php echo "<p>Description: " . $complaintData['description'] . "</p>"; ?></div>
            <div class="category-name"><?php echo "<p>Category: " . $complaintData['category_name'] . "</p>"; ?></div>
            <div class="complaint-status"><?php echo "<p>Status: " . $complaintData['complaint_status'] . "</p>"; ?></div>
        </div>
    <?php
    } else {
        echo "No complaints found.";
    }
    ?>
    <?php var_dump($images); ?>


    <?php foreach ($images as $image) : ?>

        <!-- path is important -->
        <img src="<?= URLROOT . '/Access/confidential/Complaint/' . $image['name'] ?>" alt="<?= $image['orig'] ?>" width="200px">
    <?php endforeach; ?>
</div>