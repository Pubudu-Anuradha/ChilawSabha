<?php 
class Group {
  public static function select(
    $title,$name,$options,$id=NULL,$class=NULL,$selected=NULL,$required=true
    // Options must be an associative array
  ){?>
        <!-- $title,$name, $id = null, $class = null,$placeholder=NULL,$value=NULL,$required=true,$type=NULL -->
  <div class="inputfield">
    <label for="<?= $name ?>"><?= $title ?></label>
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
}