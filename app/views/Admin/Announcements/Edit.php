<?php require_once 'common.php';
$old = $data['ann'][0] ?? [];
$errors = $data['errors'] ?? []; ?>
<div class="content">
    <h1>
        Edit Announcement : <?= $old['title'] ?? 'Not Found' ?>
    </h1>
    <hr>

    <form class="fullForm" method="post" enctype="multipart/form-data">
    <?php 
            var_dump($data);
            Errors::validation_errors($errors,[
                'title' =>'Announcement title',
                'short_description'=> 'Short description',
                'content'=>'Text content of announcement',
                'visible_start_date'=>'Scheduled public visible date'
            ]);
            Text::text($alias[0][1],$alias[0][0],$alias[0][0],$alias[0][2],spellcheck:true,
                       required:false,
                       value:$old[$alias[0][0]] ?? null);
            $types_assoc = [];
            foreach($data['types'] ?? [] as $type) {
                if($type['ann_type'] !== 'All')
                    $types_assoc[$type['ann_type_id']] = $type['ann_type'];
            }
            Group::select('Announcement Category','ann_type_id',$types_assoc,
                        selected:$old['ann_type_id'] ?? null);
            Text::text($alias[1][1],$alias[1][0],$alias[1][0],$alias[1][2],spellcheck:true,
                       value:$old[$alias[1][0]] ?? null);
            Text::textarea($alias[2][1],$alias[2][0],$alias[2][0],$alias[2][2],spellcheck:true,
                       value:$old[$alias[2][0]] ?? null);
            ?>
            <div class="input-field">
                <label for="pin">Pin to front Page</label>
                <div class="input-wrapper" style="display:block;">
                    <input type="checkbox" name="pinned" id="pin" style="height:1.2rem;
                    aspect-ratio:1/1;" <?= (($old['pinned'] ?? 0) == 1)? 'checked' : '' ?>>
                </div>
            </div>
            <div class="input-field">
                <label for="hide">Hidden</label>
                <div class="input-wrapper" style="display:block;">
                    <input type="checkbox" name="hidden" id="hide" style="height:1.2rem;
                    aspect-ratio:1/1;" <?= (($old['hidden'] ?? 0) == 1)? 'checked' : '' ?>>
                </div>
            </div>
            <?php 
            Other::submit('Edit',value:'Save changes')
            ?>
    </form>
</div>