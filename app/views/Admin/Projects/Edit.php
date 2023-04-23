<div class="content">
<?php [$project,$images,$attachments] = $data['project'] !== false ? $data['project'] : [false,false,false];

?>
    <h1>
        Edit Project <?= $project['title'] ? ' : ' . $project['title'] : '' ?>
    </h1>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Projects'?>" class="btn view bg-blue">Go to Projects</a>
        <a href="<?=URLROOT . '/Posts/Project/' . $project['post_id']?>" class="btn view bg-green">Go to Public View Mode</a>
        <a href="<?= URLROOT. '/Admin/Projects/View/' . $project['post_id'] ?>" class="btn view bg-blue">Go to View Mode</a>
    </div>
    <hr>
    <div class="formContainer">
        <form class="fullForm" method="post" enctype="multipart/form-data">
    <?php
    $alias = [
        ['title', 'Title', 'Enter the title of the project'],
        ['status', 'Status', 'Select the status of the project'],
        ['short_description', 'Short Description', 'Enter a short description of the project'],
        ['content', 'Content', 'Enter the content of the project post'],
        ['start_date', 'Start Date', 'Enter the start date of the project'],
        ['expected_end_date', 'Expected End Date', 'Enter the expected end date of the project'],
        ['budget', 'Budget', 'Enter the budget of the project'],
        ['other_parties', 'Other Parties', 'Enter other parties involved in the project if any'],
    ];
    $old = $data['project'][0] ?? [];
    $errors = $data['errors'] ?? [];
    Errors::validation_errors($errors, $alias);
    if(isset($errors['end_before_start'])) {
        Errors::generic($errors['end_before_start']);
    }
    if(isset($errors['end_no_start'])) {
        Errors::generic($errors['end_no_start']);
    }
    if($data['edited'] ?? false ) {
        echo '<div class="success">Project edited successfully</div>';
    } else if(($data['edited'] ?? true) === false && isset($_POST['Edit'])) {
        echo '<div class="error">Project could not be edited</div>';
    }

    Text::text($alias[0][1], $alias[0][0], $alias[0][0], $alias[0][2], spellcheck:true,
        value:$old[$alias[0][0]] ?? null);
    $statuses_assoc = [];
    foreach ($data['status'] as $status) {
        $statuses_assoc[$status['status_id']] = $status['project_status'];
    }
    Group::select($alias[1][1], $alias[1][0], $statuses_assoc,
        selected:$old[$alias[1][0]] ?? null);
    Text::text($alias[2][1], $alias[2][0], $alias[2][0], $alias[2][2], spellcheck:true,
        value:$old[$alias[2][0]] ?? null);
    Text::textarea($alias[3][1], $alias[3][0], $alias[3][0], $alias[3][2], spellcheck:true,
        value:$old[$alias[3][0]] ?? null);
    Time::date($alias[4][1], $alias[4][0], $alias[4][0], $alias[4][2],type:'date', required:false,
        value:$old[$alias[4][0]] ?? null);
    Time::date($alias[5][1], $alias[5][0], $alias[5][0], $alias[5][2],type:'date', required:false,
        value:$old[$alias[5][0]] ?? null);
    Other::number($alias[6][1], $alias[6][0], $alias[6][0], $alias[6][2], required:false,
        step:0.01, min:0,value:$old[$alias[6][0]] ?? null);
    Text::textarea($alias[7][1], $alias[7][0], $alias[7][0], $alias[7][2], spellcheck:true,
        value:$old[$alias[7][0]] ?? null,rows:2,required:false);
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
    Other::submit('Edit', value:'Save changes') ?>
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
</div>
<script src="<?=URLROOT . '/public/js/upload_previews.js'?>"></script>