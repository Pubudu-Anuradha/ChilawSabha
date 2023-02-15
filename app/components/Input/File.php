<?php 
class Files{
  private static function input(
    $title,$name, $id = null, $required=true,$accept = NULL,$multiple = true
  ){ 
    $id = $id ? $id : $name;?>
  <div class="inputfield file-upload">
    <label for="<?= $id ?>">
      <?= $title ?>
    </label>
    <input type="file" 
           name="<?= $name . $multiple?'[]':'' ?>"
           id="<?= $id ?>"
           <?= $accept?"accept=\"$accept\"":''?>
           <?= $required?'required':''?>
           <?= $multiple?'multiple':''?>
    >
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