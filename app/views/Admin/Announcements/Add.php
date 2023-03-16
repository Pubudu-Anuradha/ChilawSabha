<?php
require_once "common.php";
$old = $data['old'] ?? false;
?>
<div class="content">
    <h1>
        Add New Announcement
    </h1>
    <hr>
    <div class="formContainer">
        <form class="fullForm" method="post" enctype="multipart/form-data">
            <?php
$errors = $data['errors'] ?? [];
Errors::validation_errors($errors, $alias);

Text::text($alias[0][1], $alias[0][0], $alias[0][0], $alias[0][2], spellcheck:true,
    required:false,
    value:$old[$alias[0][0]] ?? null);
$types_assoc = [];
foreach ($data['types'] ?? [] as $type) {
    if ($type['ann_type'] !== 'All') {
        $types_assoc[$type['ann_type_id']] = $type['ann_type'];
    }

}
Group::select('Announcement Category', 'ann_type_id', $types_assoc, required:false);
Text::text($alias[1][1], $alias[1][0], $alias[1][0], $alias[1][2], spellcheck:true,
    value:$old[$alias[1][0]] ?? null);
Text::textarea($alias[2][1], $alias[2][0], $alias[2][0], $alias[2][2], spellcheck:true,
    value:$old[$alias[2][0]] ?? null);
if ($errors['attach'] ?? false):
    foreach ($errors['attach'] as $attach):
        $message = "There was an error while uploading $attach. Please try again.";
        Errors::generic($message);
    endforeach;
endif;?>
            <div class="input-field">
                <label for="pin">Pin to front Page</label>
                <div class="input-wrapper" style="display:block;">
                    <input type="checkbox" name="pinned" id="pin" style="height:1.2rem;aspect-ratio:1/1;" checked>
                </div>
            </div>
            <?php Files::any('Attachments', 'attachments', 'attachments', required:false);
if ($errors['photos'] ?? false):
    foreach ($errors['photos'] as $photo):
        $message = "There was an error while uploading $photo. Please try again.";
        Errors::generic($message);
    endforeach;
endif;
Files::images('Pictures', 'photos', 'photos', required:false);
Other::submit('Add', value:'Add new Announcement')
?>
        </form>
        <script src="<?=URLROOT . '/public/js/upload_previews.js'?>"></script>
    </div>
</div>