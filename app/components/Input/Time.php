<?php

class Time
{
    public static function date(
        $title,$name, $id , $class = null,$type=NULL, $max=NULL, $min=NULL, $required=true
    ) { ?>
    <div class="input-field">
        <label for="<?= $id ?>">
            <?= $title ?>    
        </label>
        <div class="input-wrapper">
            <input type="<?= $type ? $type : 'time'?>" 
                name="<?=$name?>"
                id="<?=$id?>"
                <?=$class ? "class=\"$class\" " : ''?>
                <?=$max ? "max=\"$max\" " : ''?>
                <?=$min ? "min=\"$min\" " : ''?>
                <?=$required ? "required " : ''?>
            />
        </div>
    </div>
    <?php
    }

    public static function time(
        $title,$name, $id , $class = null, $max=NULL, $min=NULL, $required=true
    ) {
        Time::date($title,$name,$id,$class,'time',$max,$min,$required);
    }

    public static function datetime(
        $title,$name, $id , $class = null, $max=NULL, $min=NULL, $required=true
    ) {
        Time::date($title,$name,$id,$class,'datetime-local',$max,$min,$required);
    }
}