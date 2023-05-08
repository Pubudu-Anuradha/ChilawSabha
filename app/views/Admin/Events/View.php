<div class="content">
<?php [$event, $images, $attachments, $edits] = $data['event'] !== false ? $data['event'] : [false, false, false, false];
$formatter = new IntlDateFormatter(
    'en_US',
    IntlDateFormatter::LONG,
    IntlDateFormatter::SHORT
);
if (empty($event)): ?>
    <h1>
        Event not found
    </h1>
<?php else: ?>
    <h1>
        Event : <?= $event['title'] ?>
    </h1>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Events'?>" class="btn view bg-blue">Go to events</a>
        <a href="<?=URLROOT . '/Admin/Events/Edit/' . $event['post_id']?>" class="btn edit bg-yellow">Edit</a>
        <?php if(!($event['hidden'] ?? 0)): ?>
        <a href="<?=URLROOT . '/Posts/Event/' . $event['post_id']?>" class="btn view bg-green">Go to Public View Mode</a>
        <?php endif; ?>
    </div>
    <hr>
    <div class="post-details">
        <div class="field">
            Views
        </div>
        <div class="detail">
            <?=$event['views'] ?? 'Not found'?>
        </div>
        <div class="field">
            Short Description
        </div>
        <div class="detail">
            <?=$event['short_description'] ?? 'Not found'?>
        </div>
        <div class="field">
            event Description
        </div>
        <div class="detail">
            <?=$event['content'] ?? 'Not found'?>
        </div>
        <div class="field">
            Pinned to front page?
        </div>
        <div class="detail">
            <?=(($event['pinned'] ?? 0) == 1) ? 'Yes' : 'No'?>
        </div>
        <div class="field">
            Hidden from public view
        </div>
        <div class="detail">
            <?=(($event['hidden'] ?? 0) == 1) ? 'Yes' : 'No'?>
        </div>
        <div class="field">
            Start time
        </div>
        <div class="detail">
            <?php
$time = $event['start_time'] ?? 'Not found';
if ($time != 'Not found') {
    echo $formatter->format(new DateTime($time));
} else {
    echo 'TBA';
}
?>
        </div>
        <div class="field">
            End Date
        </div>
        <div class="detail">
            <?php
$time = $event['end_time'] ?? 'Not found';
if ($time != 'Not found') {
    echo $formatter->format(new DateTime($time));
} else {
    echo 'TBA';
}
?>
        </div>
        <div class="field">
            Posted on
        </div>
        <div class="detail">
            <?php
$time = $event['posted_time'] ?? 'Not found';
echo $formatter->format(new DateTime($time));
?>
        </div>
        <div class="field">
            Posted by
        </div>
        <div class="detail">
            <?=$event['posted_by'] ?? 'Not found'?>
        </div>
    </div>
<?php if (!empty($images)): ?>
    <hr>
    <h3>Images</h3>
    <div class="photos">
    <?php foreach ($images as $image): ?>
        <div class="photo-card shadow">
            <div class="row">
                <div class="orig-name">
                    <?=$image['orig']?>
                </div>
            </div>
            <div class="preview">
                <img src="<?=URLROOT . '/public/upload/' . $image['name']?>"
                    alt="<?=$image['orig']?>" height="150" width="300">
            </div>
        </div>
    <?php endforeach;?>
    </div>
    <?php endif;
if (!empty($attachments)): ?>
    <hr>
    <h3>Attachments</h3>
    <div class="attachments">
    <?php foreach ($attachments as $attachment): ?>
        <a href="<?=URLROOT . '/Downloads/file/' . $attachment['name']?>">
            <?=$attachment['orig']?>
        </a>
    <?php endforeach; ?>
    </div>
<?php endif;?>
<?php if (!empty($edits)): ?>
<hr>
<h3>Content Edit History</h3>
<?php $current = $event;
$current['status'] = $status;
$aliases = [
    'title' => 'event title',
    'short_description' => 'Summary',
    'content' => 'event Description',
    'status' => 'event Status',
    'start_time' => 'Start Time',
    'end_time' => 'End Time',
];
$hide_pin = [
    'hidden' => [
        1 => '<b>Unhid</b> the announcement from public',
        0 => '<b>Hid</b> the announcement from public',
    ],
    'pinned' => [
        1 => '<b>Unpinned</b> the announcement from the frontpage',
        0 => '<b>Pinned</b> the announcement to the frontpage',
    ],
];

foreach ($edits as $edit):
    $edited_by = $edit['edited_by'] ?? 'Not found';
    $edited_time = $edit['edited_time'] ?? false;
    if ($edited_time !== false) {
        $date = IntlCalendar::fromDateTime($edited_time, null);
        $edited_time = $formatter->format($date);
    } else {
        $edited_time = 'ERROR RETRIEVING DATE';
    }
    unset($edit['edited_by']);
    unset($edit['edited_time']);?>
		    <div class="edit-container">
		        <div class="edit">
		            Edited On <span class="time"><?=$edited_time?></span> by
		            <?=$edited_by?>
		        </div>
		        <ul>
		        <?php
    foreach ($edit as $field => $value):
        if (!is_null($value) && $current[$field] != $value): ?>
				            <li>
				                <?php if ($field != 'hidden' && $field != 'pinned'): ?>
				                    changed
				                    <b><?=$aliases[$field] ?? 'UNDEFINED'?></b>
				                    from
				                    "<?=$value?>"
				                    to
				                    "<?=$current[$field]?>".
				                <?php else: ?>
		                    <?=$hide_pin[$field][$value] ?? 'UNDEFINED ACTION'?>
		                <?php endif;?>
            </li>
                <?php $current[$field] = $value;
endif;
endforeach;?>
        </ul>
    </div>
    <?php endforeach;?>
<?php endif;?>
<?php endif; ?>
</div>