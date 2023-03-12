<?php

class Other{

    //Changes min ,max,value formats like this because if value of any of them is zero turnary relationship will ignore it.
    public static function number(
        $title,$name, $id = null, $class = null,$placeholder=NULL,$value=NULL,$required=true,$step=NULL,$min=NULL,$max=NULL,$readonly=NULL
    ) { ?>
    <div class="input-field">
        <label for="<?= $id ?>">
            <?= $title ?>    
        </label>
        <input type="number" 
            name="<?=$name?>"
            <?=$id ? "id=\"$id\"" : ''?>
            <?=$class ? "class=\"$class\"" : ''?>
            <?=$placeholder ? "placeholder=\"$placeholder\"" : ''?>
            <?= "value=\"" . ($value ?? '') . "\"" ?>
            <?=$step ? "step=\"$step\"" : ''?>
            <?= "min=\"" . ($min ?? '') . "\"" ?>
            <?= "max=\"" . ($max ?? '') . "\"" ?>
            <?=$required ? 'required' : ''?>
            <?=$readonly ? 'readonly' : ''?>
        />
        <span></span>
    </div>
    <?php
    }

    public static function submit(
        $name, $id = null, $class = null,$value=NULL,$disabled=false
    ) { ?>
    <div class="submitButtonContainer">
        <div class="submitButton">
            <input type="submit" 
                name="<?=$name?>"
                <?=$id ? "id=\"$id\"" : ''?>
                <?=$class ? "class=\"$class\"" : ''?>
                <?=$value ? "value=\"$value\"" : ''?>
                <?=$disabled ? 'disabled' : ''?>
            />
        </div>
    </div>
    <?php
    }
}