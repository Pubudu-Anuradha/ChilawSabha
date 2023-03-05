<?php
class Errors {
  private function generic($message,$id=null,$class=null){ ?>
    <div class="error<?=!is_null($class)?" $class":''?>"
        <?=!is_null($id)?"id=\"$id\"":''?>>
      <?= $message ?>
    </div>
  <?php }
  public function validation_errors($errors){
    // TODO: Check each validation error and respond
  }
}