<div class="content">
<?php [$service,$images,$attachments,$edits,$steps] = $data['service'] !== false ? $data['service'] : [false,false,false,false];
?>
    <h1>
        Edit Service <?= $service['title'] ? ' : ' . $service['title'] : '' ?>
    </h1>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Services'?>" class="btn view bg-blue">Go to Services</a>
        <a href="<?=URLROOT . '/Posts/Service/' . $service['post_id']?>" class="btn view bg-green">Go to Public View Mode</a>
        <a href="<?= URLROOT. '/Admin/Services/View/' . $service['post_id'] ?>" class="btn view bg-blue">Go to View Mode</a>
    </div>
    <hr>
    <div class="formContainer">
        <form class="fullForm" method="post" enctype="multipart/form-data">
    <?php
    $alias = [
        ['title', 'Title', 'Enter the title of the service'],
        ['short_description', 'Short Description', 'Enter a short description of the service'],
        ['content', 'Description of the service', 'Enter the description of the service post'],
        ['contact_no', 'Contact number for more information', 'Contact number for more information'],
        ['contact_name', 'Name Associated with contact number', 'Name Associated with contact number'],
    ];
$old = $service;
$errors = $data['errors'] ?? [];
Errors::validation_errors($errors, $alias);
if(isset($errors['name_no_number'])) {
    Errors::generic($errors['name_no_number']);
}
Text::text($alias[0][1], $alias[0][0], $alias[0][0], placeholder:$alias[0][2], spellcheck:true,
    value:$old[$alias[0][0]] ?? null);
Group::select('Service Category','service_category',$data['categories'] ?? [],selected:$old['category_id'] ?? null);
Text::text($alias[1][1], $alias[1][0], $alias[1][0], placeholder:$alias[1][2], spellcheck:true,
    value:$old[$alias[1][0]] ?? null);
Text::textarea($alias[2][1], $alias[2][0], $alias[2][0], $alias[2][2], spellcheck:true,
    value:$old[$alias[2][0]] ?? null);?>
        <fieldset>
            <legend> Associated contact (Optional) </legend>
<?php
Text::text($alias[3][1], $alias[3][0], $alias[3][0], $alias[3][2],
    placeholder:'+94XXXXXXXXX or 0XXXXXXXXX', type:'tel', maxlength:12,required:false,
    pattern:"(\+94\d{9})|0\d{9}", value:$old[$alias[3][0]] ?? null);
Text::text($alias[4][1], $alias[4][0], $alias[4][0], placeholder:$alias[4][2], spellcheck:true,
    value:$old[$alias[4][0]] ?? null,required:false);
?>

        </fieldset>
    <fieldset id='steps'>
        <legend>Steps to get service (Optional)</legend>
        <?php
$current_steps = $steps;
$steps = [];
foreach($current_steps as $step) {
    $steps[$step['step_no'] - 1] = $step['step'];
}
$step_count = count($steps) + 1;
for ($i = 1; $i <= $step_count; ++$i): ?>
    <div class="input-field">
        <label for="step-<?=$i?>">Step <?=$i?>.</label>
        <div class="input-wrapper">
            <input type="text"
                    name="steps[]"
                    id="step-<?=$i?>"
                    placeholder="Enter step <?=$i?>"
                    <?=($steps[$i - 1] ?? false) ? 'value="' . $steps[$i - 1] . '"' : ''?>
            >
        </div>
    </div>
<?php endfor;?>
            <div class="submitButtonContainer">
                <div class="submitButton">
                    <button type="button" id="add-more" class="shadow">
                        Add more steps
                    </button>
                </div>
            </div>
    </fieldset>
    <div class="input-field">
        <label for="pin">Pin to front Page</label>
        <div class="input-wrapper" style="display:block;">
            <input type="checkbox" name="pinned" id="pin" style="height:1.2rem;aspect-ratio:1/1;" checked>
        </div>
    </div>
<?php 
    Other::submit('Edit', value:'Save changes') ?>
        </form>
    </div>
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
</div>

<script>
const addMore = document.getElementById('add-more');
const steps_container = document.getElementById('steps');
var steps = document.querySelectorAll('input[name="steps[]"]');
addMore.addEventListener('click', () => {
    const step = document.createElement('div');
    step.classList.add('input-field');
    const label = document.createElement('label');
    label.setAttribute('for', `step-${steps.length + 1}`);
    label.innerText = `Step ${steps.length + 1}.`;
    const inputWrapper = document.createElement('div');
    inputWrapper.classList.add('input-wrapper');
    const input = document.createElement('input');
    input.setAttribute('type', 'text');
    input.setAttribute('name', 'steps[]');
    input.setAttribute('id', `step-${steps.length + 1}`);
    input.setAttribute('placeholder', `Enter step ${steps.length + 1}`);
    inputWrapper.appendChild(input);
    step.appendChild(label);
    step.appendChild(inputWrapper);
    steps_container.insertBefore(step, document.querySelector('.submitButtonContainer'));
    steps = document.querySelectorAll('input[name="steps[]"]');
});
</script>
<style>
#add-more {
    background-color: var(--blue);
    border: none;
    padding: 0.5rem 1rem;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    font-weight: 600;
    font-size: medium;
    transition: 200ms ease-in-out;
    width: max-content;
}
#add-more:hover {
    transform: scale(1.1);
    cursor: pointer;
}
</style>
<script>
    expandSideBar('sub-items-serv');
</script>