<?php

class Text
{
    public static function text(
        $title,$name, $id = null, $class = null,$placeholder=NULL,$value=NULL,$required=true,$type=NULL
    ) { ?>
    <div class="inputfield">
        <label for="<?= $name ?>">
            <?= $title ?>    
        </label>
        <input type="<?= $type ? $type : 'text'?>" 
            name="<?=$name?>"
            <?=$id ? 'id="' . $id . '"' : ''?>
            <?=$class ?'class="' . $class . '"' : ''?>
            <?=$placeholder ?'placeholder="' . $placeholder . '"' : ''?>
            <?=$value ?'value="' . $value . '"' : ''?>
            <?=$required ?'required' : ''?>
        />
    </div>
    <?php
    }

    public static function password(
        $title,$name, $id = null, $class = null,$required=true,$value=NULL,$placeholder=NULL
    ) { 
        Text::text($title,$name,$id,$class,$placeholder,$value,$required,'password');
    }

    public static function email(
        $title,$name, $id = null, $class = null,$required=true,$value=NULL,$placeholder=NULL
    ) { 
        Text::text($title,$name,$id,$class,$placeholder,$value,$required,'email');
    }
    
    public static function textarea(
        $title,$name, $id = null, $class = null,$placeholder=NULL,$value=NULL,$rows=10,$cols=30,$required=true
    ) { ?>
    <div class="inputfield">
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
        ><?=$value ?$value: ''?></textarea>
    </div>
    <?php
    }
}