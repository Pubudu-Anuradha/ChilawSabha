<?php

class Text
{
    public static function text(
        $title, $name, $id, $placeholder, $class = null, $required = true, $value = null, $type = null,
        $maxlength = null, $minlength = null, $pattern = null, $readonly = null, $spellcheck = null, $autocomplete = null, $disabled = null
    ) {?>
    <div class="input-field">
        <label for="<?=$id?>">
            <?=$title?>
        </label>
        <div class="input-wrapper">
            <input type="<?=$type ? $type : 'text'?>"
                name="<?=$name?>"
                id="<?=$id?>"
                <?=$class ? "class=\"$class\"" : ''?>
                <?=$value ? "value=\"$value\"" : ''?>
                <?="placeholder=\"$placeholder\""?>
                <?=$maxlength ? "maxlength=\"$maxlength\"" : ''?>
                <?=$minlength ? "minlength=\"$minlength\"" : ''?>
                <?=$pattern ? "pattern=\"$pattern\"" : ''?>
                <?=$readonly ? "readonly=\"$readonly\"" : ''?>
                <?=$spellcheck ? "spellcheck=\"$spellcheck\"" : ''?>
                <?=$autocomplete ? "autocomplete=\"$autocomplete\"" : ''?>
                <?=$required ? "required" : ''?>
                <?=$disabled ? "disabled" : ''?>
            />
            <span></span>
        </div>
    </div>
    <?php
    }

    public static function password(
        $title, $name, $id, $placeholder,$value = null, $class = null, $pattern = null, $autocomplete = null
    ) {
        Text::text($title, $name, $id, $placeholder, $class, true, $value, 'password', 255, 5, $pattern, null, null, $autocomplete, null);
    }

    public static function email(
        $title, $name, $id, $placeholder,$value = null, $class = null, $readonly = null
    ) {
        Text::text($title, $name, $id, $placeholder, $class, true, $value, 'email', 255, 5, $readonly, null, null, null);
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