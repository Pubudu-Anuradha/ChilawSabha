<?php

class Other{

    public static function number(
        $title,$name, $id = null, $class = null,$placeholder=NULL,$value=NULL,$required=true,$step=NULL,$min=NULL,$max=NULL
    ) { ?>
    <div class="inputfield">
        <label for="<?= $name ?>">
            <?= $title ?>    
        </label>
        <input type="number" 
            name="<?=$name?>"
            <?=$id ? 'id="' . $id . '"' : ''?>
            <?=$class ?'class="' . $class . '"' : ''?>
            <?=$placeholder ?'placeholder="' . $placeholder . '"' : ''?>
            <?=$value ?'value="' . $value . '"' : ''?>
            <?=$step ?'step="' . $step . '"' : ''?>
            <?=$min ?'min="' . $min . '"' : ''?>
            <?=$max ?'max="' . $max . '"' : ''?>
            <?=$required ?'required' : ''?>
        />
    </div>
    <?php
    }

    public static function submit(
        $name, $id = null, $class = null,$value=NULL,$disabled=false
    ) { ?>
    <div class="inputfield">
        <input type="submit" 
            name="<?=$name?>"
            <?=$id ? 'id="' . $id . '"' : ''?>
            <?=$class ?'class="' . $class . '"' : ''?>
            <?=$value ?'value="' . $value . '"' : ''?>
            <?=$disabled ?'disabled' : ''?>
        />
    </div>
    <?php
    }
}