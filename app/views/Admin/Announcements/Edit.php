<?php require_once 'common.php';
$old = $data['ann'][0] ?? [];
$images = $data['ann'][1] ?? [];
$attachments = $data['ann'][2] ?? [];
$old = $data['ann'][0] ?? [];
$old = $data['ann'][0] ?? [];
$errors = $data['errors'] ?? [];?>
<div class="content">
    <h1>
        Edit Announcement : <?=$old['title'] ?? 'Not Found'?>
    </h1>
        <div class="btn-column">
            <a href="<?=URLROOT . '/Admin/Announcements/View/' . $old['post_id']?>" class="btn view bg-blue">Go to View Mode</a>
            <a href="<?=URLROOT . '/Posts/Announcement/' . $old['post_id']?>" class="btn view bg-green">Go to Public View Mode</a>
        </div>
    <hr>

    <form class="fullForm" method="post" enctype="multipart/form-data">
    <?php
Errors::validation_errors($errors, [
    'title' => 'Announcement title',
    'short_description' => 'Short description',
    'content' => 'Text content of announcement',
    'visible_start_date' => 'Scheduled public visible date',
]);
Text::text($alias[0][1], $alias[0][0], $alias[0][0], $alias[0][2], spellcheck:true,
    required:false,
    value:$old[$alias[0][0]] ?? null);
$types_assoc = [];
foreach ($data['types'] ?? [] as $type) {
    if ($type['ann_type'] !== 'All') {
        $types_assoc[$type['ann_type_id']] = $type['ann_type'];
    }

}
Group::select('Announcement Category', 'ann_type_id', $types_assoc,
    selected:$old['ann_type_id'] ?? null);
Text::text($alias[1][1], $alias[1][0], $alias[1][0], $alias[1][2], spellcheck:true,
    value:$old[$alias[1][0]] ?? null);
Text::textarea($alias[2][1], $alias[2][0], $alias[2][0], $alias[2][2], spellcheck:true,
    value:$old[$alias[2][0]] ?? null);
?>
            <div class="input-field">
                <label for="pin">Pin to front Page</label>
                <div class="input-wrapper" style="display:block;">
                    <input type="checkbox" name="pinned" id="pin" style="height:1.2rem;
                    aspect-ratio:1/1;" <?=(($old['pinned'] ?? 0) == 1) ? 'checked' : ''?>>
                </div>
            </div>
            <div class="input-field">
                <label for="hide">Hidden</label>
                <div class="input-wrapper" style="display:block;">
                    <input type="checkbox" name="hidden" id="hide" style="height:1.2rem;
                    aspect-ratio:1/1;" <?=(($old['hidden'] ?? 0) == 1) ? 'checked' : ''?>>
                </div>
            </div>
            <?php
Other::submit('Edit', value:'Save changes')
?>
    </form>

        <hr>
        <h3>Pictures</h3>
    <?php if (!empty($images)): ?>
        <div class="photos">
        <?php foreach ($images as $image):
    $name = $image['name'] ?? '';
    $orig = $image['orig'] ?? '';?>
	            <div class="photo-card shadow">
	                <div class="row">
	                    <div class="orig-name">
	                        <?=$orig?>
	                    </div>
	                    <button class="remove" aria-label="remove picture"></button>
	                </div>
	                <div class="preview">
	                    <img src="<?=URLROOT . '/public/upload/' . $name?>"
	                            alt="<?=$orig?>" height="150" , width="300">
	                </div>
	            </div>
	        <?php endforeach;?>
        </div>
        <script>
            const photosContainer = document.querySelector('.photos');
            if(photosContainer){
                const cards = photosContainer.querySelectorAll('.photo-card');
                if(cards) cards.forEach((card) => {
                    const filename = card.querySelector('img').src.replace(/^.*\/public\/upload\//,'').trim();
                    const originalName = card.querySelector('img').alt;
                    card.querySelector('button').addEventListener('click',(e)=> {
                        e.preventDefault();
                        if(confirm('Are you sure you want to remove the image : '+originalName+'?')){
                            fetch('<?=URLROOT . '/Admin/postsApi/delPhoto/' . $old['post_id']?>',{
                                method:'POST',
                                headers: {
                                    "Content-type":"application/json"
                                },
                                body:JSON.stringify({
                                    filename:filename
                                })
                            }).then(res=>res.json()).then(response => {
                                if(response.success == true) {
                                    alert('Deleted image : ' + originalName)
                                    card.parentNode.removeChild(card);
                                } else {
                                    alert('Failed to delete ' + originalName);
                                }
                            }).catch(console.log)
                        }
                    });
                });
            }
        </script>
    <?php endif;if (count($images) < 20): ?>
        <form class="fullForm" method="post" enctype="multipart/form-data">
            <?php
if (($data['AddPhotos']['error'] ?? false) == 'more_than_10') {
    $message = "You cannot add more than 10 pictures to an announcement";
    Errors::generic($message);
}
Files::images('Add more pictures', 'photos', 'photos-input');
Other::submit('AddPhotos', value:'Add more pictures');
?>
        </form>
    <?php endif;?>
        <hr>
        <h3>Attached Files</h3>
    <?php if (!empty($attachments)): ?>
        <div class="attachments">
            <?php foreach ($attachments as $attachment):
    $name = $attachment['name'] ?? '';
    $orig = $attachment['orig'] ?? '';?>
	                <div class="attachment">
	                    <a href="<?=URLROOT . '/Downloads/file/' . $name?>"><?=$orig?></a>
	                    <button class="remove" aria-label="remove picture"></button>
	                </div>
	            <?php endforeach;?>
        </div>
        <script>
            document.querySelectorAll('.attachments > .attachment').forEach(attachment => {
                const a = attachment.querySelector('a');
                const originalName = a.innerHTML.trim();
                const filename = a.href.trim().
                    replace(/^.*\/Downloads\/file\//,'').trim();
                attachment.querySelector('button').addEventListener('click',(e) => {
                    e.preventDefault();
                    if(confirm('Are you sure you want to remove the attachment : ' + originalName + '?')){
                        fetch('<?=URLROOT . '/Admin/postsApi/delAttach/' . $old['post_id']?>',{
                            method:'POST',
                            headers: {
                                "Content-type":"application/json"
                            },
                            body:JSON.stringify({
                                filename:filename
                            })
                        }).then(res=>res.json()).then(response => {
                            if(response.success == true) {
                                alert('Deleted attachment : ' + originalName)
                                attachment.parentNode.removeChild(attachment);
                            } else {
                                alert('Failed to delete ' + originalName);
                            }
                        }).catch(console.log)
                    }
                });
            })
        </script>
<?php endif;?>
    <form class="fullForm" method="post" enctype="multipart/form-data">
        <?php
Files::any('Add more Attachments', 'attachments');
Other::submit('AddAttach', value:'Add more attachments');
?>
    </form>
</div>
<script src="<?=URLROOT . '/public/js/upload_previews.js'?>"></script>
