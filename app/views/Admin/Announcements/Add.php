<?php // TODO: Add functionality
    require_once "common.php";
?>
<div class="content">
    <h1>
        Add New Announcement
    </h1>
    <hr>
    <div class="formContainer">
        <form class="fullForm" method="post">
            <?php
            Text::text($alias[0][1],$alias[0][0],$alias[0][0],$alias[0][2],spellcheck:true);
            Text::text($alias[1][1],$alias[1][0],$alias[1][0],$alias[1][2],spellcheck:true);
            Text::textarea($alias[2][1],$alias[2][0],$alias[2][0],$alias[2][2],spellcheck:true);
            Time::date($alias[3][1],$alias[3][0],$alias[3][0],min:date('Y-m-d'),
                       value:date('Y-m-d'));
            Files::any('Attachments','attachments',required:false);
            Files::images('Associated images','photos',required:false);
            Other::submit('Add',value:'Add new Announcement')
            ?>
        </form>
        <script src="<?= URLROOT . '/public/js/upload_previews.js' ?>"></script>
    </div>
</div>