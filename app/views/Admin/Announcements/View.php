<div class="content">
<?php // TODO: Make Single announcement view
[$announcement,$images,$attachments,$ann_e,$post_e] = $data['announcement'] !== false ? $data['announcement'] : [false,false,false,false,false];
$types = $data['types'] ?? [];
if(empty($announcement)): ?>
    <h1>
        Announcement not found
    </h1>
<?php else: ?>
    <h1>
        Announcement : <?= $announcement['title'] ?>
    </h1>
    <div class="btn-column">
        <a href="<?= URLROOT . '/Admin/Announcements/Edit/' . $announcement['post_id']?>" class="btn edit bg-yellow">Edit</a>
    </div>
    <hr>
    <div class="post-details">
        <div class="field">
            Announcement type
        </div>
        <div class="detail">
            <?php $type_id = $announcement['ann_type_id'];
                $type = false;
                for($i=0;$i<count($types);++$i) {
                    if($types[$i]['ann_type_id'] == $type_id) {
                        $type = $types[$i]['ann_type'];
                        break;
                    }
                }
                echo $type !== false ? $type : 'not found';
            ?>
        </div>
        <div class="field">
            Short Summary
        </div>
        <div class="detail">
            <?= $announcement['short_description'] ?? 'Not found' ?>
        </div>
        <div class="field">
            Announcement Content
        </div>
        <div class="detail">
            <?= $announcement['content'] ?? 'Not found' ?>
        </div>
        <div class="field">
            Pinned to front page?
        </div>
        <div class="detail">
            <?= (($announcement['pinned'] ?? 0) == 1) ? 'Yes' : 'No' ?>
        </div>
        <div class="field">
            Hidden from public view
        </div>
        <div class="detail">
            <?= (($announcement['hidden'] ?? 0) == 1) ? 'Yes' : 'No' ?>
        </div>
        <div class="field">
            Posted by
        </div>
        <div class="detail">
            <?= $announcement['posted_by'] ?? 'Not found'?>
        </div>
        <div class="field">
            Posted time
        </div>
        <div class="detail">
            <?= $announcement['posted_time'] ?? 'Not found'?>
        </div>
    </div>
    <hr>
<?php endif;
if(!empty($attachments)): ?>
    <h3>Attached Files</h3>
    <div class="attachments">
        <?php foreach($attachments as $attachment):
            $name = $attachment['name'] ?? '';
            $orig = $attachment['orig'] ?? ''; ?>
            <a href="<?= URLROOT . '/Downloads/file/' . $name?>"><?=$orig?></a>
        <?php endforeach; ?>
    </div>
    <hr>
<?php endif;
if(!empty($images)):?>
    <h3>Attached Images</h3>
    <div class="photos">
    <?php foreach($images as $image):
        $name = $image['name'] ?? '';
        $orig = $image['orig'] ?? ''; ?>
        <div class="photo-card shadow">
            <div class="row">
                <div class="orig-name">
                    <?= $orig ?>
                </div>
            </div>
            <div class="preview">
                <img src="<?= URLROOT . '/public/upload/' . $name ?>"
                        alt="<?= $orig ?>" height="150" , width="300">
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>
<pre><?php
    $edits = array_merge($ann_e,$post_e);
    usort($edits,function ($a ,$b) {
     return IntlCalendar::fromDateTime($a['edited_time'],null)->before(IntlCalendar::fromDateTime($b['edited_time'],null));
    });
    var_dump($edits);
?></pre>
</div>