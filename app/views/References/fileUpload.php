<form action="<?=URLROOT . '/References/fileUpload'?>" method="post" enctype="multipart/form-data">
    <input type="file" name="testfiles[]" id="file-up" multiple>
    <input type="submit" name="Upload" value="Upload">
</form>
<?php
if(isset($data['uploads']) && $data['uploads']): 
      foreach ($data['uploads'] as $file):?>
        <a href="<?=URLROOT . '/Files/download/'.basename($file['path'])?>"><?=$file['orig']?></a>
<?php endforeach;
endif;?>