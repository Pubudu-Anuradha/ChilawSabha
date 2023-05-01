<div class="content">
    <h1>
        Add new Service
    </h1>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Services'?>" class="btn view bg-blue">Go to Services</a>
    </div>
    <hr>
    <div class="formContainer">
        <form id="add-form" class="fullForm" method="post" enctype="multipart/form-data">
    <?php
    $alias = [
        ['title', 'Title', 'Enter the title of the service'],
        ['short_description', 'Short Description', 'Enter a short description of the service'],
        ['content', 'Description of the service', 'Enter the description of the service post'],
    ];
    $old = $_POST;
    $errors = $data['errors'] ?? [];
    Errors::validation_errors($errors, $alias);
    Text::text($alias[0][1], $alias[0][0], $alias[0][0], $alias[0][2], spellcheck:true,
        value:$old[$alias[0][0]] ?? null);
    Text::text($alias[1][1], $alias[1][0], $alias[1][0], $alias[1][2], spellcheck:true,
        value:$old[$alias[1][0]] ?? null);
    Text::textarea($alias[2][1], $alias[2][0], $alias[2][0], $alias[2][2], spellcheck:true,
        value:$old[$alias[2][0]] ?? null); ?>
    <fieldset id='steps'>
        <legend>Steps to get service</legend>
        <?php
            $steps = $_POST['step'] ?? [];
            $steps = array_filter($steps, function($step) {
                return !empty($step);
            });
            $step_count = count($steps) + 1;
            for($i=1;$i<=$step_count;++$i): ?>
            <div class="input-field">
                <label for="step-<?= $i ?>">Step <?= $i ?>.</label>
                <div class="input-wrapper">
                    <input type="text"
                           name="step[]"
                           id="step-<?= $i ?>"
                           placeholder="Enter step <?= $i ?>"
                           <?= ($steps[$i-1] ?? false) ? 'value="'.$steps[$i-1].'"' : '' ?>
                    >
                </div>
            </div>
            <?php endfor; ?>
            <div class="submitButtonContainer">
                <div class="submitButton">
                    <button type="button" id="add-more" class="shadow">
                        Add more steps
                    </button>
                </div>
            </div>
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
    </fieldset>
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
    Other::submit('Add','Add',value:'Add Service');
?>
        </form>
    </div>
</div>

<script>
    const addMore = document.getElementById('add-more');
    const steps_container = document.getElementById('steps');
    var steps = document.querySelectorAll('input[name="step[]"]');
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
        input.setAttribute('name', 'step[]');
        input.setAttribute('id', `step-${steps.length + 1}`);
        input.setAttribute('placeholder', `Enter step ${steps.length + 1}`);
        inputWrapper.appendChild(input);
        step.appendChild(label);
        step.appendChild(inputWrapper);
        steps_container.insertBefore(step, document.querySelector('.submitButtonContainer'));
        steps = document.querySelectorAll('input[name="step[]"]');
    });
</script>