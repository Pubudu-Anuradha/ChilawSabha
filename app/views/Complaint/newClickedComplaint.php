<div class="content">
    <h2 class="topic">New Complaint</h2>

    <?php
    [$complaint, $images] = $data['newComplaint'] ?? [false, false];
    ?>
    <!-- Delete the below and style the data !! DONT USE A TABLE -->
    <pre><?php var_dump($complaint); ?></pre>
    <pre><?php var_dump($images); ?></pre>
    <?php foreach ($images as $image) : ?>
        <!-- path is important -->
        <img src="<?= URLROOT . '/Access/confidential/Complaint/' . $image['name'] ?>" alt="<?= $image['orig'] ?>" width="200px">
    <?php endforeach; ?>
</div>