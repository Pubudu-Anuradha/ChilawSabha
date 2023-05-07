<?php

class Modal
{
    public static function Modal($content=null,$textarea=false,$title=null,$name=null,$id=null, $class = null, $placeholder=null, $value = null, $rows=null, $cols=null,
    $required = null, $spellcheck = false, $confirmBtn=null, $textTitle=null, $textId=null)
    {?>

    <div id="<?=$id?>" class="modal">

        <div class="modal-content">

            <div class="close-section"><span class="close" onclick="closeModal()">&times;</span></div>

            <?php if($content):?>
            <div class="model-text"><p><?=$content?></p></div>
            <?php endif; ?>


            <!-- if text area is there,always there will be a confirm btn -->
            <?php if($textarea):?>
                    <?php Other::number($textTitle, $textId, $textId, min:0,readonly:true);?>
                    <?php Text::textarea($title,$name,$id, $class, $placeholder, $value, $rows, $cols, $spellcheck) ;?>
                    <div class="popup-btn">
                        <input type="submit" name="confirm" class="btn bg-green white" value="Confirm">
                        <button type="button" class="btn bg-red white" onclick="closeModal()">Close</button>
                    </div>
            <?php endif;?>


            <!-- for instances where no text area but confirm should be there -->
            <?php if($confirmBtn):?>
                <div class="popup-btn">
                    <input type="submit" name="confirm" class="btn bg-green white" value="Confirm">
                    <button type="button" class="btn bg-red white" onclick="closeModal()">Close</button>
                </div>
            <?php endif;?>

            <!-- to make sure button in popup-btn class -->
            <?php if(!$textarea && !$confirmBtn):?>
                <div class="popup-btn">
                    <button type="button" class="btn bg-red white" onclick="closeModal()">Close</button>
                </div>
            <?php endif; ?>

        </div>

    </div>

    <?php
    }
}