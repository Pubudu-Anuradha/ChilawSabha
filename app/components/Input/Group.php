<?php 
class Group {
  public static function select(
    $title,$name,$options,$id=NULL,$class=NULL,$selected=NULL,$required=true
    // Options must be an associative array
    // ['value'=>'displayName']
  ){
    $id = $id ? $id : $name;?>
  <div class="inputfield">
    <label for="<?= $id ?>"><?= $title ?></label>
    <select name="<?= $name ?>"
            <?=$id ? 'id="' . $id . '"' : ''?>
            <?=$class ?'class="' . $class . '"' : ''?>
            <?= $required? 'required' : ''?>
    >
    <?php foreach($options as $value=>$name): ?>
      <option value="<?=$value?>" <?= $selected && $selected==$value ? 'selected':'' ?>>
          <?=$name?>
      </option>
    <?php endforeach; ?>
    </select>
  </div>
  <?php
  }

  public static function radio(
    $title,$name,$values,$id_prefix,$checked=NULL,$required=true
    // values is a associative array
    // ['value'=>'displayName']
  ){ ?>
  <div class="inputfield">
    <label for="<?=$name?>"><?=$title?></label>
    <div class="option-set">
      <?php $i = 1;
      foreach($values as $value=>$label): ?>
        <input type="radio"
              value="<?= $value ?>"
              name="<?= $name ?>"
              id="<?= "$id_prefix\_$i" ?>"
              <?= $required? 'required' : ''?>
              <?= $checked && $checked == $value ? 'checked' : ''?>
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
}