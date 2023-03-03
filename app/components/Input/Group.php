<?php 
class Group {
  public static function select(
    $title,$name,$options,$id=NULL,$class=NULL,$selected=NULL,$required=true
    // Options must be an associative array
    // ['value'=>'displayName']
  ){
    $id = $id ? $id : $name;?>
  <div class="input-field">
    <label for="<?= $id ?>"><?= $title ?></label>
    <select name="<?= $name ?> "
            <?=$id ? "id= \"$id\" " : ''?>
            <?=$class ?"class= \"$class\" " : ''?>
            <?= $required? 'required ' : ''?>
    >
    <?php foreach($options as $value=>$name): ?>
      <option value="<?=$value?>" <?= $selected && $selected==$value ? 'selected ':'' ?>>
          <?=$name?>
      </option>
    <?php endforeach; ?>
    </select>
  </div>
  <?php
  }

  private static function render_group(
    $title,$name,$values,$id_prefix,$checked=NULL,$required=true,$type=NULL
    // values is a associative array
    // ['value'=>'displayName']
    // Radio expects one checked element as string
  ){
    if(is_null($type)) throw new Exception("Invalid Group rendering call", 1);
  ?>
  <div class="input-field">
    <label for="<?=$name?>"><?=$title?></label>
    <div class="option-set">
      <?php $i = 1;
      foreach($values as $value=>$label): ?>
        <input type="<?= $type ?> "
              value="<?= $value ?> "
              name="<?= $name ?> "
              id="<?= "$id_prefix\_$i" ?> "
              <?= $required? 'required ' : ''?>
              <?= $checked && ( 
                (is_array($checked) && in_array($value,$checked) ) || (is_string($checked) &&  $checked == $value)
                ) ? 'checked ' : ''?>
        >
        <label for="<?= "$id_prefix\_$i" ?>">
          <?= $label ?>
        </label>
      <?php $i += 1;
      endforeach; ?>
    </div>    
  </div>
  <?php 
  }
  
  public static function radios(
    $title,$name,$values,$id_prefix,$checked=NULL,$required=true
  ){
    if(is_array($checked)) throw new Exception("Radio cannot select more than one option", 1);
    
    Group::render_group($title,$name,$values,$id_prefix,$checked,$required,'radio');
  }
  
  public static function checkboxes(
    $title,$name,$values,$id_prefix,$checked=NULL,$required=true
  ){
    Group::render_group($title,$name,$values,$id_prefix,$checked,$required,'checkbox');
  }
}