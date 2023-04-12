<div class="content">
    <!-- <pre><?php var_dump($data); ?></pre> -->
<?php [$project,$images,$attachments] = $data['project'] !== false ? $data['project'] : [false,false,false];
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
<?php if(empty($project)): ?>
    <h1>
        Project not found
    </h1>
<?php else: ?>
    <h1>
        Project : <?=$project['title']?>
    </h1>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Projects/Edit/' . $project['post_id']?>" class="btn edit bg-yellow">Edit</a>
        <a href="<?=URLROOT . '/Posts/Project/' . $project['post_id']?>" class="btn view bg-green">Go to Public View Mode</a>
    </div>
    <hr>
    <div class="post-details">
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
        <?php if($project['other_parties']): ?>
        <div class="field">
            Other Parties involved
        </div>
        <div class="detail">
            <?=$project['other_parties'] ?? 'Not found'?>
        </div>
        <?php endif; ?>
        <div class="field">
            Start Date
        </div>
        <div class="detail">
            <?php
            $time = $project['start_date'] ?? 'Not found';
            if($time != 'Not found') {
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
            if($time != 'Not found') {
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
<?php if(!empty($images)): ?>
    <hr>
    <h3>Images</h3>
    <div class="photos">
    <?php foreach($images as $image): ?>
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
    <?php endforeach; ?>
    </div>
    <?php endif;
    if(!empty($attachments)): ?>
    <hr>
    <h3>Attachments</h3>
    <div class="attachments">
    <?php foreach($attachments as $attachment): ?>
        <a href="<?= URLROOT . '/Downloads/file/' . $attachment['name'] ?>">
            <?=$attachment['orig']?>
        </a>
    <?php endforeach;
    endif; ?>
    </div>
<?php endif; ?>
</div>