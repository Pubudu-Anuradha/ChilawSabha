<form action="<?=URLROOT . '/Home/files'?>" method="post" enctype="multipart/form-data">
    <input type="file" name="testfiles[]" id="file-up" multiple>
    <input type="submit" name="Upload" value="Upload">
</form>
<?php var_dump($data);?>