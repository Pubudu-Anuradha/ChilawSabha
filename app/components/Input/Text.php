<?php

class Text
{
    public static function text(
        $title,$name, $id , $class = null,$required=true,$value=NULL,$placeholder=NULL,$type=NULL, 
        $maxlength=NULL, $minlength=NULL, $pattern=NULL, $readonly=NULL, $spellcheck=NULL, $autocomplete=false, $disabled=NULL, $msg=NULL
    ) { 
    ?>
    <div class="input-field">
        <label for="<?=$id?>">
            <?=$title?>
        </label>
        <div class="input-wrapper">
    <?php
        if($msg){
    ?>
            <span class="err-msg">
                <?= $msg ?>
            </span>
        <?php
        }
        ?>
            <input type="<?=$type ? $type : 'text'?>"
                name="<?= $name ?>"
                id="<?= $id ?>"
                <?= $class ? "class=\"$class\"" : '' ?>
                <?= $value ? "value=\"$value\"" : '' ?>
                <?= $placeholder ? "placeholder=\"$placeholder\"" : '' ?>
                <?= $maxlength ? "maxlength=\"$maxlength\"" : '' ?>
                <?= $minlength ? "minlength=\"$minlength\"" : '' ?>
                <?= $pattern ? "pattern=\"$pattern\"" : '' ?>
                <?= $readonly ? "readonly=\"$readonly\"" : '' ?>
                <?= $spellcheck ? "spellcheck=\"$spellcheck\"" : '' ?>
                <?= $autocomplete ? "autocomplete=\"$autocomplete\"" : '' ?>
                <?= $required ? "required" : '' ?>
                <?= $disabled ? "disabled" : '' ?>
            >
        </div>
    </div>
    <?php
    }

    public static function password(
        $title,$name, $id , $class = null,$required=True,$placeholder=NULL,$pattern=NULL, $autocomplete=false , $disabled=false, $msg=NULL,$value=NULL
    ) { 
        Text::text($title,$name,$id,$class,$required,$value,$placeholder,'password',15,8,$pattern,NULL,NULL,$autocomplete,$disabled, $msg);
    }

    public static function email(
        $title,$name, $id, $class = null,$required = NULL, $value= null,$placeholder=NULL,$pattern=NULL,$readonly=NULL,$disabled=false,$msg=NULL
    ) { 
        Text::text($title,$name,$id,$class,$required,$value, $placeholder,'email',100,5,$pattern, $readonly,NULL,NULL, $disabled,$msg);
    }

    public static function textarea(
        $title, $name, $id, $placeholder, $class = null, $value = null, $rows = 10, $cols = 80, $required = null, $spellcheck = false
    ) {?>
    <div class="input-field">
        <label for="<?=$id?>">
            <?=$title?>
        </label>
        <div class="input-wrapper">
            <textarea
                name="<?=$name?>"
                <?=$id ? "id= \"$id\"" : ''?>
                <?=$class ? "class= \"$class\"" : ''?>
                <?=$placeholder ? "placeholder= \"$placeholder\"" : ''?>
                <?="rows= \"$rows\""?>
                <?="cols= \"$cols\""?>
                <?=$required ? "required" : ''?>
                <?=$spellcheck ? "spellcheck=\"$spellcheck\"" : ''?>
            ><?=$value ? $value : ''?></textarea>
        </div>
    </div>
    <?php
    }
}