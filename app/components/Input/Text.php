<?php

class Text
{
    public static function text(
        $title,$name, $id , $class = null,$required=true,$value=NULL,$placeholder,$type=NULL, 
        $maxlength=NULL, $minlength=NULL, $pattern=NULL, $readonly=NULL, $spellcheck=NULL, $autocomplete=NULL
    ) { ?>
    <div class="input-field">
        <label for="<?= $id ?>">
            <?= $title ?>    
        </label>
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
        />
        <span></span>
    </div>
    <?php
    }

    public static function password(
        $title,$name, $id , $class = null,$placeholder,$pattern=NULL, $autocomplete=NULL
    ) { 
        Text::text($title,$name,$id,$class,true,NULL,$placeholder,'password',15,8,$pattern,NULL,NULL,$autocomplete);
    }

    public static function email(
        $title,$name, $id, $class = null,$placeholder,$readonly=NULL
    ) { 
        Text::text($title,$name,$id,$class,true,NULL, $placeholder,'email',100,5,$readonly,NULL,NULL);
    }
    
    public static function textarea(
        $title,$name, $id, $class = null,$placeholder,$value=NULL,$rows=10,$cols=30,$required=NULL
    ) { ?>
    <div class="input-field">
        <label for="<?= $name ?>">
            <?= $title ?>    
        </label>
        <textarea 
            name="<?=$name?>"
            <?=$id ? 'id="' . $id . '"' : ''?>
            <?=$class ?'class="' . $class . '"' : ''?>
            <?=$placeholder ?'placeholder="' . $placeholder . '"' : ''?>
            <?="rows=\"$rows\""?>
            <?="cols=\"$cols\""?>
            <?=$required ?'required' : ''?>
        ><?=$value ?$value: ''?>
    </textarea>
    </div>
    <?php
    }
}