<?php // TODO: Add functionality
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
            echo "<pre>";
            var_dump($data);
            var_dump($_FILES);
            echo "</pre>";
            $errors = $data['errors'] ?? [];
            Errors::validation_errors($errors,$alias);

            Text::text($alias[0][1],$alias[0][0],$alias[0][0],$alias[0][2],spellcheck:true,
                       required:false,
                       value:$old[$alias[0][0]] ?? null);
            Text::text($alias[1][1],$alias[1][0],$alias[1][0],$alias[1][2],spellcheck:true,
                       value:$old[$alias[1][0]] ?? null);
            Text::textarea($alias[2][1],$alias[2][0],$alias[2][0],$alias[2][2],spellcheck:true,
                       value:$old[$alias[2][0]] ?? null);
            Time::date($alias[3][1],$alias[3][0],$alias[3][0],min:date('Y-m-d'),
                       value:$old[$alias[3][0]] ?? date('Y-m-d'));
            // TODO: Add contacts
            if($errors['attach'] ?? false):
                foreach($errors['attach'] as $attach):
                    $message = "There was an error while uploading $attach. Please try again.";
                    Errors::generic($message);
                endforeach;
            endif;
            Files::any('Attachments','attachments','attachments',required:false);
            if($errors['photos'] ?? false):
                foreach($errors['photos'] as $photo):
                    $message = "There was an error while uploading $photo. Please try again.";
                    Errors::generic($message);
                endforeach;
            endif;
            Files::images('Associated images','photos','photos',required:false);
            Other::submit('Add',value:'Add new Announcement')
            ?>
        </form>
        <script src="<?= URLROOT . '/public/js/upload_previews.js' ?>"></script>
    </div>
</div>