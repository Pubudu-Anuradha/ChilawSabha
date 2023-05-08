<div class="content">
    <h1>
        Add New Project
    </h1>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Projects'?>" class="btn view bg-blue">Go to Projects</a>
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
    $old = $_POST;
    $errors = $data['errors'] ?? [];
    Errors::validation_errors($errors, $alias);
    if(isset($errors['end_before_start'])) {
        Errors::generic($errors['end_before_start']);
    }
    if(isset($errors['end_no_start'])) {
        Errors::generic($errors['end_no_start']);
    }
    if(isset($errors['ongoing_no_start'])) {
        Errors::generic($errors['ongoing_no_start']);
    }
    if(isset($errors['completed_no_date'])) {
        Errors::generic($errors['completed_no_date']);
    }
    if(isset($errors['no_budget'])) {
        Errors::generic($errors['no_budget']);
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
            <input type="checkbox" name="pinned" id="pin" style="height:1.2rem;aspect-ratio:1/1;" checked>
        </div>
    </div><?php
    if ($errors['attach'] ?? false):
        foreach ($errors['attach'] as $attach):
            $message = "There was an error while uploading $attach. Please try again.";
            Errors::generic($message);
        endforeach;
    endif;
    Files::any('Attach Files', 'attach', 'attach', multiple:true,required:false);
    if($errors['photos'] ?? false):
        foreach ($errors['photos'] as $photo):
            $message = "There was an error while uploading $photo. Please try again.";
            Errors::generic($message);
        endforeach;
    endif;
    Files::images('Upload Photos', 'photos', 'photos',  multiple:true,required:false);
    Other::submit('Add','Add',value:'Add Project');
    ?>
    </div>
</div>

<script src="<?= URLROOT . '/public/js/upload_previews.js' ?>"></script>
<script>
    expandSideBar('sub-items-proj');
</script>