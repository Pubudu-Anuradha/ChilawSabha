<div class="content">
<?php
[$announcement, $images, $attachments, $edits] = $data['announcement'] !== false ? $data['announcement'] : [false, false, false, false];
$types = $data['types'] ?? [];
if (empty($announcement)): ?>
    <h1>
        Announcement not found
    </h1>
<?php else: ?>
    <h1>
        Announcement : <?=$announcement['title']?>
    </h1>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Announcements/Edit/' . $announcement['post_id']?>" class="btn edit bg-yellow">Edit</a>
        <a href="<?=URLROOT . '/Posts/Announcement/' . $announcement['post_id']?>" class="btn view bg-green">Go to Public View Mode</a>
    </div>
    <hr>
    <div class="post-details">
        <div class="field">
            Announcement type
        </div>
        <div class="detail">
            <?php $type_id = $announcement['ann_type_id'];
$type = false;
for ($i = 0; $i < count($types); ++$i) {
    if ($types[$i]['ann_type_id'] == $type_id) {
        $type = $types[$i]['ann_type'];
        break;
    }
}
$announcement['ann_type'] = $type !== false ? $type : 'not found';
echo $announcement['ann_type'];
?>
        </div>
        <div class="field">
            Summary
        </div>
        <div class="detail">
            <?=$announcement['short_description'] ?? 'Not found'?>
        </div>
        <div class="field">
            Announcement Content
        </div>
        <div class="detail">
            <?=$announcement['content'] ?? 'Not found'?>
        </div>
        <div class="field">
            Pinned to front page?
        </div>
        <div class="detail">
            <?=(($announcement['pinned'] ?? 0) == 1) ? 'Yes' : 'No'?>
        </div>
        <div class="field">
            Hidden from public view
        </div>
        <div class="detail">
            <?=(($announcement['hidden'] ?? 0) == 1) ? 'Yes' : 'No'?>
        </div>
        <div class="field">
            Posted by
        </div>
        <div class="detail">
            <?=$announcement['posted_by'] ?? 'Not found'?>
        </div>
        <div class="field">
            Posted time
        </div>
        <div class="detail">
            <?=$announcement['posted_time'] ?? 'Not found'?>
        </div>
    </div>
<?php endif;
if (!empty($attachments)): ?>
    <hr>
    <h3>Attached Files</h3>
    <div class="attachments">
        <?php foreach ($attachments as $attachment):
    $name = $attachment['name'] ?? '';
    $orig = $attachment['orig'] ?? '';?>
	            <a href="<?=URLROOT . '/Downloads/file/' . $name?>"><?=$orig?></a>
	        <?php endforeach;?>
    </div>
<?php endif;
if (!empty($images)): ?>
    <hr>
    <h3>Pictures</h3>
    <div class="photos">
    <?php foreach ($images as $image):
    $name = $image['name'] ?? '';
    $orig = $image['orig'] ?? '';?>
	        <div class="photo-card shadow">
	            <div class="row">
	                <div class="orig-name">
	                    <?=$orig?>
	                </div>
	            </div>
	            <div class="preview">
	                <img src="<?=URLROOT . '/public/upload/' . $name?>"
	                        alt="<?=$orig?>" height="150" , width="300">
	            </div>
	        </div>
	    <?php endforeach;?>
    </div>
<?php endif;
if (!empty($edits)): ?>
<hr>
<h3>Content Edit History</h3>
<?php $current = $announcement;
$aliases = [
    'ann_type' => 'Announcement type',
    'title' => 'Announcement title',
    'short_description' => 'Summary',
    'content' => 'Announcement content',
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

$formatter = new IntlDateFormatter(
    'en_US',
    IntlDateFormatter::LONG,
    IntlDateFormatter::SHORT,
);
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
</div>
<script>
    const edits = document.querySelectorAll('.edit-container')
    if(edits.length > 3){
        const check = {
            container:document.createElement('div'),
            children:document.createElement('div')
        };
        check.container.innerHTML = "See more"
        check.container.classList.add('toggle');
        check.children.classList.add('invisible');
        edits[3].parentNode.insertBefore(check.children,edits[3]);
        edits[3].parentNode.insertBefore(check.container,edits[3]);
        // Add see more option instead of printing all
        edits.forEach((edit,index)=>{
            if(index > 2) {
                check.children.appendChild(edit);
            }
        });
        const changeVisibility = () => {
            check.children.classList.toggle('invisible')
            if(!check.children.classList.contains('invisible')) {
                check.container.innerHTML = "See less";
            } else {
                check.container.innerHTML = "See more";
            }
        }
        check.container.addEventListener('click',changeVisibility)
    }
</script>
<style>
    .content * {
        transition: transform .2s ease-in-out;
        transform-origin: top;
    }
    .toggle {
        width: 60%;
        text-align: right;
        color: var(--black);
        text-decoration: underline;
        background:linear-gradient(to right,rgba(255,255,255,0),var(--blue));
        border-radius: 1rem;
        padding: .2rem 1rem;
    }
    .invisible {
        height: 0;
        transform: scaleY(0);
    }
</style>