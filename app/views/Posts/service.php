<script>
    setTimeout(()=>fetch('<?=URLROOT . '/Posts/Viewed/' . $data['event'][0]['post_id'] ?? '0'?>').then(res=>res.json()).then(console.log).catch(console.log),2000);
</script>
<div class="content">
<?php
[$service, $images, $attachments, $edits, $steps] = $data['service'] !== false ? $data['service'] : [false, false, false, false, false];
$types = $data['types'] ?? [];
$formatter = new IntlDateFormatter(
    'en_US',
    IntlDateFormatter::LONG,
    IntlDateFormatter::SHORT,
);
if (empty($service)): ?>
    <h1>
        Service not found
    </h1>
<?php else: ?>
    <h1 <?=(($service['pinned'] ?? 0) == 1) ? 'class="pinned"' : ''?>>
        Service : <?=$service['title']?>
    </h1>
    <hr>
    <div class="row">
        <div class="author">
            <?=$service['posted_by'] ?? 'Not found'?>
        </div>
        <div class="date">
            <?=$formatter->format(IntlCalendar::fromDateTime($service['posted_time'] ?? '2022-01-01', null))?>
        </div>
        <a class="category"
        href="<?=URLROOT . '/Posts/Services?category=' . ($service['category_id'] ?? '0')?>"
        > <?=$service['service_category'] ?? 'Not Found'?> </a>
        <div class="views">
            <?=$service['views'] ?? 'Not found'?>
        </div>
    </div>
    <?php if (($_SESSION['role'] ?? 'visitor') == 'Admin'): ?>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Services/View/' . $service['post_id']?>" class="btn views bg-blue">Go to Admin View Mode</a>
        <a href="<?=URLROOT . '/Admin/Services/Edit/' . $service['post_id']?>" class="btn edit bg-yellow">Edit</a>
    </div>
    <?php endif;?>
    <div class="post-details">
        <summary class="shadow">
            <?=$service['short_description'] ?? 'Not found'?>
        </summary>
        <p>
           &emsp;&emsp;&emsp;&emsp;<?=$service['content'] ?? 'Not found'?>
        </p>
        <?php if(count($steps) > 0): ?>
        <div class="steps">
            To receive the service, you can follow the steps below.
            <ol>
                <?php foreach($steps as $step): ?>
                    <li><?= $step['step'] ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
        <?php endif;
        if($service['contact_no'] ?? false): ?>
        <div class="contact">
            For more information, you can contact <?= ($service['contact_name'] ?? false) ? ( $service['contact_name'] . ' on '):'' ?> <span class="phone"><?= $service['contact_no'] ?></span>.
        </div>
        <?php endif; ?>
    </div>
<?php endif;
if (!empty($attachments)): ?>
    <div class="attachments-container shadow">
        <h4>Attached Files</h4>
        <div class="attachments">
            <?php foreach ($attachments as $attachment):
    $name = $attachment['name'] ?? '';
    $orig = $attachment['orig'] ?? '';?>
	                <a href="<?=URLROOT . '/Downloads/file/' . $name?>"><?=$orig?></a>
	            <?php endforeach;?>
        </div>
    </div>
<?php endif;
if (!empty($images)):
    $photos = [];
    foreach ($images as $image):
        $name = $image['name'] ?? '';
        $orig = $image['orig'] ?? '';
        $photos[] = URLROOT . '/public/upload/' . $name;
    endforeach;
    Slideshow::Slideshow($photos, 'shadow');
endif;
if (!empty($edits)): ?>
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
</div>
<script>
    const edits = document.querySelectorAll('.edit-container')
    const check = {
        container:document.createElement('div'),
        children:document.createElement('div')
    };
    check.container.innerHTML = "This service's information has been edited. Click here to view the edit history."
    check.container.classList.add('toggle');
    check.children.classList.add('invisible');
    edits[0].parentNode.insertBefore(check.children,edits[0]);
    edits[0].parentNode.insertBefore(check.container,edits[0]);
    // Add see more option instead of printing all
    edits.forEach((edit,index)=>{
        check.children.appendChild(edit);
    });
    const changeVisibility = () => {
        check.children.classList.toggle('invisible')
        if(!check.children.classList.contains('invisible')) {
            check.container.innerHTML = "See less";
        } else {
            check.container.innerHTML = "This service's information has been edited. Click here to view the edit history.";
        }
    }
    check.container.addEventListener('click',changeVisibility)
</script>
<style>
    .content * {
        transition: transform .2s ease-in-out;
        transform-origin: top;
    }
    .toggle {
        box-sizing: border-box;
        width: 100%;
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
    .phone {
        font-weight: 600;
    }
</style>