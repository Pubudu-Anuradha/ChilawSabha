<div class="content">
<?php [$project, $images, $attachments, $edits] = $data['project'] !== false ? $data['project'] : [false, false, false, false];
$formatter = new IntlDateFormatter(
    'en_US',
    IntlDateFormatter::LONG,
    IntlDateFormatter::SHORT
);

$dates = new IntlDateFormatter(
    'en_US',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE
);
?>
<?php if (empty($project)): ?>
    <h1>
        Project not found
    </h1>
<?php else: ?>
    <h1>
        Project : <?=$project['title']?>
    </h1>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Projects'?>" class="btn view bg-blue">Go to Projects</a>
        <a href="<?=URLROOT . '/Admin/Projects/Edit/' . $project['post_id']?>" class="btn edit bg-yellow">Edit</a>
        <a href="<?=URLROOT . '/Posts/Project/' . $project['post_id']?>" class="btn view bg-green">Go to Public View Mode</a>
    </div>
    <hr>
    <div class="post-details">
        <div class="field">
            Views
        </div>
        <div class="detail">
            <?=$project['views'] ?? 'Not found'?>
        </div>
        <div class="field">
            Project Status
        </div>
        <div class="detail">
            <?php
$status = $project['status'] ?? 'Not found';
foreach ($data['status'] ?? [] as $state) {
    if ($state['status_id'] == $status) {
        $status = $state['project_status'];
        break;
    }
}
echo $status;
?>
        </div>
        <div class="field">
            Short Description
        </div>
        <div class="detail">
            <?=$project['short_description'] ?? 'Not found'?>
        </div>
        <div class="field">
            Project Description
        </div>
        <div class="detail">
            <?=$project['content'] ?? 'Not found'?>
        </div>
        <div class="field">
            Pinned to front page?
        </div>
        <div class="detail">
            <?=(($project['pinned'] ?? 0) == 1) ? 'Yes' : 'No'?>
        </div>
        <div class="field">
            Hidden from public view
        </div>
        <div class="detail">
            <?=(($project['hidden'] ?? 0) == 1) ? 'Yes' : 'No'?>
        </div>
        <div class="field">
            Budget
        </div>
        <div class="detail">
            <span class="rupees"><?php
$budget = $project['budget'] ?? 'Not found';
if ($budget != 'Not found') {
    $budget = number_format($budget, 2);
    echo $budget;
} else {
    echo 'TBA';
}
?></span>
        </div>
        <?php if ($project['other_parties']): ?>
        <div class="field">
            Other Parties involved
        </div>
        <div class="detail">
            <?=$project['other_parties'] ?? 'Not found'?>
        </div>
        <?php endif;?>
        <div class="field">
            Start Date
        </div>
        <div class="detail">
            <?php
$time = $project['start_date'] ?? 'Not found';
if ($time != 'Not found') {
    echo $dates->format(new DateTime($time));
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
$time = $project['expected_end_date'] ?? 'Not found';
if ($time != 'Not found') {
    echo $dates->format(new DateTime($time));
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
$time = $project['posted_time'] ?? 'Not found';
echo $formatter->format(new DateTime($time));
?>
        </div>
        <div class="field">
            Posted by
        </div>
        <div class="detail">
            <?=$project['posted_by'] ?? 'Not found'?>
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
    <?php endforeach;
endif;?>
<?php if (!empty($edits)): ?>
<hr>
<h3>Content Edit History</h3>
<?php $current = $project;
$current['status'] = $status;
$aliases = [
    'title' => 'Project title',
    'short_description' => 'Summary',
    'content' => 'Project Description',
    'status' => 'Project Status',
    'budget' => 'Budget',
    'other_parties' => 'Other Parties involved',
    'start_date' => 'Start Date',
    'expected_end_date' => 'End Date',
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
<?php endif;?>
</div>
</div>