<?php

class Text
{
    public static function text(
        $title,$name, $id , $class = null,$required=true,$value=NULL,$placeholder,$type=NULL, 
        $maxlength=NULL, $minlength=NULL, $pattern=NULL, $readonly=NULL, $spellcheck=NULL, $autocomplete=NULL, $disabled=NULL
    ) { ?>
    <div class="input-field">
        <label for="<?= $id ?>">
            <?= $title ?>    
        </label>
        <div class="input-wrapper">
            <input type="<?= $type ? $type : 'text'?>" 
                name="<?=$name?>"
                id="<?=$id?>"
                <?=$class ? "class=\"$class\" " : ''?>
                <?=$value ? "value=\"$value\" " : ''?>
                <?="placeholder=\"$placeholder\" "?>
                <?=$maxlength ? "maxlength=\"$maxlength\" " : ''?>
                <?=$minlength ? "minlength=\"$minlength\" " : ''?>
                <?=$pattern ? "pattern=\"$pattern\" " : ''?>
                <?=$readonly ? "readonly=\"$readonly\" " : ''?>
                <?=$spellcheck ? "spellcheck=\"$spellcheck\" " : ''?>
                <?=$autocomplete ? "autocomplete=\"$autocomplete\" " : ''?>
                <?=$required ? "required " : ''?>
                <?=$disabled ? "disabled " : ''?>
            />
            <span></span>
        </div>
    </div>
    <?php
    }

    public static function password(
        $title,$name, $id , $class = null,$placeholder,$pattern=NULL, $autocomplete=NULL
    ) { 
        Text::text($title,$name,$id,$class,true,NULL,$placeholder,'password',15,8,$pattern,NULL,NULL,$autocomplete,NULL);
    }

    public static function email(
        $title,$name, $id, $class = null,$placeholder,$pattern=NULL,$readonly=NULL
    ) { 
        Text::text($title,$name,$id,$class,true,NULL, $placeholder,'email',100,5,$pattern, $readonly,NULL,NULL,NULL);
    }
    
    public static function textarea(
        $title,$name, $id, $class = null,$placeholder,$value=NULL,$rows,$cols,$required=NULL,$spellcheck=false
    ) { ?>
    <div class="input-field">
        <label for="<?= $name ?>">
            <?= $title ?>    
        </label>
        <div class="input-wrapper">
            <textarea 
                name="<?=$name?>"
                <?=$id ? "id= \"$id\" " : ''?>
                <?=$class ? "class= \"$class\" " : ''?>
                <?=$placeholder ? "placeholder= \"$placeholder\" " : ''?>
                <?= "rows= \"$rows\" "?>
                <?= "cols= \"$cols\" "?>
                <?=$required ? "required " : ''?>
                <?=$spellcheck ? "spellcheck= \"$spellcheck\" " : ''?>
            ><?=$value ?$value: ''?>
            </textarea>
        </div>
    </div>
    <?php
    }
}