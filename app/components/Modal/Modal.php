<?php

class Modal
{
    // btnlist is an associative array.pass values as key,value pairs
    public static function Modal($content=null,$textarea=false,$title=null,$name=null,$id=null, $class = null, $placeholder=null, $value = null, $rows=null, $cols=null, 
    $required = null, $spellcheck = false, $btnlist=null)
    {?>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="close-section"><span class="close" onclick="closeModal()">&times;</span></div>

            <?php if($content):?>
            <div class="model-text"><p><?=$content?></p></div>
            <?php endif; ?>

            <?php if($textarea){
                Text::textarea($title,$name,$id, $class, $placeholder, $value, $rows, $cols,$required, $spellcheck) ;
            }
            ?>

            <div class="popup-btn">
                <?php if($btnlist):
                    foreach($btnlist as $btn => $func):?>
                        <button class="btn bg-green white" onclick="<?=$func?>"><?=$btn?></button>
                <?php endforeach;endif;?>
                <button class="btn bg-red white" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>

    <?php
    }
}