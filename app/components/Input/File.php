<?php 
class Files{
  private static function input(
    $title,$name, $id = null, $required=true,$accept = NULL,$multiple = true
  ){ 
    $id = $id ? $id : $name; ?>
  <div class="input-field file-upload">
    <label for="<?= $id ?>">
      <?= $title ?>
    </label>
    <div class="input-wrapper">
    <div class="file_upload">
      <input type="file" 
            name="<?= $name . ($multiple ? '[]':'') ?>"
            id="<?= $id ?>"
            <?= $accept?"accept= \"$accept\"":'' ?>
            <?= $required?'required':'' ?>
            <?= $multiple?'multiple':'' ?>
      >
      <div class="previews"></div>
    </div>
    </div>
  </div>
  <?php }

  public static function any(
    $title,$name, $id = null, $required=true,$multiple = true
  ){ 
    Files::input($title,$name,$id,$required,NULL,$multiple);
  }

  public static function images(
    $title,$name, $id = null, $required=true,$multiple = true
  ){
    Files::input($title,$name,$id,$required,'image/*',$multiple);
  }
}