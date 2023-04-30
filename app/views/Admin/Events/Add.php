<div class="content">
    <h1>
        Add new Event
    </h1>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Events'?>" class="btn view bg-blue">Go to Events</a>
    </div>
    <hr>
    <div class="formContainer">
        <form id="add-form" class="fullForm" method="post" enctype="multipart/form-data">
    <?php
    $alias = [
        ['title', 'Title', 'Enter the title of the event'],
        ['short_description', 'Short Description', 'Enter a short description of the event'],
        ['content', 'Content', 'Enter the content of the event post'],
        ['start_time', 'Start Time', 'Enter the starting time of the event'],
        ['end_time', 'End Time', 'Enter the ending time of the event'],
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
    Text::text($alias[0][1], $alias[0][0], $alias[0][0], $alias[0][2], spellcheck:true,
        value:$old[$alias[0][0]] ?? null);
    Text::text($alias[1][1], $alias[1][0], $alias[1][0], $alias[1][2], spellcheck:true,
        value:$old[$alias[1][0]] ?? null);
    Text::textarea($alias[2][1], $alias[2][0], $alias[2][0], $alias[2][2], spellcheck:true,
        value:$old[$alias[2][0]] ?? null);
    Time::date($alias[3][1], $alias[3][0], $alias[3][0], $alias[3][2],type:'datetime-local', required:false,
        value:$old[$alias[3][0]] ?? null);
    Time::date($alias[4][1], $alias[4][0], $alias[4][0], $alias[4][2],type:'datetime-local', required:false,
        value:$old[$alias[4][0]] ?? null); ?>
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
        </form>
    </div>
</div>

<script>
    const start_time = document.getElementById('start_time');
    const end_time = document.getElementById('end_time');
    const form = document.querySelector('form');
    const set_constraints = (e) => {
        if(end_time.value){
            start_time.required = true;
            start_time.max = end_time.value;
        } else {
            start_time.required = false;
        }
        if(form.reportValidity()) {
            if(start_time.value) {
                end_time.min = start_time.value
            }
            form.reportValidity()
        }
    };
    end_time.addEventListener('change' , set_constraints);
    start_time.addEventListener('change' , set_constraints);
    <?php if(isset($_POST['Add'])):?> set_constraints(); <?php endif;?>
</script>

<script src="<?= URLROOT . '/public/js/upload_previews.js' ?>"></script>