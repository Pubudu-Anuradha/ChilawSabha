<div class="content">
    <pre><?php var_dump($data)?></pre>
<?php // TODO: Make Single announcement view
[$announcement,$images,$attachments] = [false,false,false];
if($data['announcement'] !== false) {
    [$announcement,$images,$attachments] = $data['announcement'];
}
foreach($images as $image) {
    $name = $image['name'] ?? '';
    $orig = $image['orig'] ?? '';
    echo $name .' => '. $orig.'<br />';
    ?>
    <img src="<?= URLROOT . '/public/upload/' . $name ?>" alt="<?= $orig ?>">
    <?php
}
foreach($attachments as $attachment) {
    $name = $attachment['name'] ?? '';
    $orig = $attachment['orig'] ?? '';
    echo $name .' => '. $orig.'<br />';
    ?>
    <a href="<?= URLROOT . '/Downloads/file/' . $name?>"><?=$orig?></a>
    <?php
}
?>
</div>