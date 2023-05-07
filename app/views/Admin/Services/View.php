<div class="content">
<?php [$service, $images, $attachments, $edits, $steps] = $data['service'] !== false ? $data['service'] : [false, false, false, false, false];
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
<?php if (empty($service)): ?>
    <h1>
        Service not found
    </h1>
<?php else: ?>
    <h1>
        Service : <?=$service['title']?>
    </h1>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Services'?>" class="btn view bg-blue">Go to Services</a>
        <a href="<?=URLROOT . '/Admin/Services/Edit/' . $service['post_id']?>" class="btn edit bg-yellow">Edit</a>
        <a href="<?=URLROOT . '/Posts/Service/' . $service['post_id']?>" class="btn view bg-green">Go to Public View Mode</a>
    </div>
    <hr>
    <div class="post-details">
        <div class="field">
            Views
        </div>
        <div class="detail">
            <?=$service['views'] ?? 'Not found'?>
        </div>
        <div class="field">
            Service Category
        </div>
        <div class="detail">
            <?= $service['service_category'] ?? 'Not found' ?>
        </div>
        <div class="field">
            Short Description
        </div>
        <div class="detail">
            <?=$service['short_description'] ?? 'Not found'?>
        </div>
        <div class="field">
            Service Description
        </div>
        <div class="detail">
            <?=$service['content'] ?? 'Not found'?>
        </div>
        <div class="field">
            Pinned to front page?
        </div>
        <div class="detail">
            <?=(($service['pinned'] ?? 0) == 1) ? 'Yes' : 'No'?>
        </div>
        <div class="field">
            Hidden from public view
        </div>
        <div class="detail">
            <?=(($service['hidden'] ?? 0) == 1) ? 'Yes' : 'No'?>
        </div>
        <?php if($service['contact_no'] ?? false): ?>
        <div class="field">
            Contact Number
        </div>
        <div class="detail">
            <?=$service['contact_no'] ?? 'Not found'?>
        </div>
            <?php if($service['contact_name'] ?? false): ?>
        <div class="field">
            Contact Name
        </div>
        <div class="detail">
            <?=$service['contact_name'] ?? 'Not found'?>
        </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php if(count($steps) > 0) : ?>
        <div class="field">
            Steps to get service
        </div>
        <div class="detail">
            <ol>
            <?php foreach($steps as $step): ?>
                <li>
                    <?= $step['step'] ?>
                </li>
            <?php endforeach; ?>
            </ol>
        </div>
    <?php endif; ?>
        <div class="field">
            Posted on
        </div>
        <div class="detail">
            <?php
$time = $service['posted_time'] ?? 'Not found';
echo $formatter->format(new DateTime($time));
?>
        </div>
        <div class="field">
            Posted by
        </div>
        <div class="detail">
            <?=$service['posted_by'] ?? 'Not found'?>
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
<?php $current = $service;
$aliases = [
    'title' => 'Service title',
    'short_description' => 'Summary',
    'content' => 'Service Description',
    'status' => 'Service Status',
    'budget' => 'Budget',
    'contact_no' => 'Contact Number',
    'contact_name' => 'Contact Name',
    'service_category' => 'Service Category',
];
$hide_pin = [
    'hidden' => [
        1 => '<b>Unhid</b> the service from public',
        0 => '<b>Hid</b> the service from public',
    ],
    'pinned' => [
        1 => '<b>Unpinned</b> the service from the frontpage',
        0 => '<b>Pinned</b> the service to the frontpage',
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
    if(isset($edit['step_no'])): ?>
    <li>
        <?php if(!empty($edit['step_before']) && !empty($edit['step_after'])):?>
        changed <b>step <?= $edit['step_no'] ?></b> from "<?=
        $edit['step_before'] ?>" to "<?= $edit['step_after'] ?>".
        <?php elseif(empty($edit['step_before'])):?>
        Added Step "<?= $edit['step_after'] ?>".
        <?php else: ?>
        Removed Step "<?= $edit['step_before'] ?>".
        <?php endif; ?>
    </li>
<?php else:
    foreach ($edit as $field => $value):
        if (!is_null($value) && $current[$field] != $value): ?>
                        <?php if ($field != 'hidden' && $field != 'pinned'):  ?>
				            <li>
				                    changed
				                    <b><?=$aliases[$field] ?? 'UNDEFINED'?></b>
				                    from "<?=$value?>" to "<?=$current[$field]?>".
                            </li>
				                <?php elseif($field == 'hidden' || $field == 'pinned'): ?>
                                    <li>
                                        <?=$hide_pin[$field][$value] ?? 'UNDEFINED ACTION'?>
                                    </li>
		                <?php endif;?>
                <?php $current[$field] = $value;
    endif;
endforeach;
endif; ?>
        </ul>
    </div>
    <?php endforeach;?>
<?php endif;?>
<?php endif;?>
</div>
</div>