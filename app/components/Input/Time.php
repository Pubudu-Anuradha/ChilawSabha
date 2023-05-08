<?php

class Time
{
    public static function date(
        $title,$name, $id , $class = null,$type=NULL, $max=NULL, $min=NULL, $required=true,$value=NULL
    ) { ?>
    <div class="input-field">
        <label for="<?= $id ?>">
            <?= $title ?>
        </label>
        <div class="input-wrapper">
            <input type="<?= $type ? $type : 'date'?>"
                name="<?=$name?>"
                id="<?=$id?>"
                <?=$class ? "class=\"$class\" " : ''?>
                <?=$max ? "max=\"$max\" " : ''?>
                <?=$min ? "min=\"$min\" " : ''?>
                <?=$value ? "value=\"$value\" " : ''?>
                <?=$required ? "required " : ''?>
            />
            <span></span>
        </div>
    </div>
    <?php
    }

    public static function time(
        $title,$name, $id , $class = null, $max=NULL, $min=NULL, $required=true,$value=NULL
    ) {
        Time::date($title,$name,$id,$class,'time',$max,$min,$required,$value);
    }

    public static function datetime(
        $title,$name, $id , $class = null, $max=NULL, $min=NULL, $required=true,$value=NULL
    ) {
        Time::date($title,$name,$id,$class,'datetime-local',$max,$min,$required,$value);
    }
}
