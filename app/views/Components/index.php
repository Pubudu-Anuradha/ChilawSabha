<?php
Text::text('Enter your name','name','name-id','name-in','Please Enter your name here','Saman Kumara');
Text::email('Enter your Email','email');
Text::password('Enter your password','password');
Text::textarea('Enter your message','message','message-id','message-in','Please Enter your message here','Saman Kumara is okay');

Group::select('Select your word','selection',[
    'a'=>'Apple',
    'b'=>'Ball',
    'c'=>'Cat',
    'd'=>'Dog',
    'e'=>'Elephant',
],selected:'e');

Group::radios("Radio Options","rad",[
    'a'=>'Apple',
    'b'=>'Ball',
    'c'=>'Cat',
    'd'=>'Dog',
    'e'=>'Elephant',
],"rad",checked:'e',required:true);

Group::checkboxes("Radio Options","rad",[
    'a'=>'Apple',
    'b'=>'Ball',
    'c'=>'Cat',
    'd'=>'Dog',
    'e'=>'Elephant',
],"rad_c",checked:['a','e'],required:true);

Files::any('Upload any file','files');
Files::images('Upload Photos','images');
?>
<script src="<?=URLROOT.'/public/js/upload_previews.js'?>"></script>
<style>
    /* Colors */
    :root{
    --blue: #7387EF;
    --lightblue: #93B4F2;
    --fadedblue: #F0F5FE;
    --red: #FF4040;
    --green: #25A704;
    --yellow: #F3BC2F;
    --orange: #E2631B;
    --grey: #9A9A9A;
    --bgcolor: #ffffff;
    --black: #000000;
    }

    .previews{
        width: calc(100% - 1rem);
        box-sizing: border-box;
        background-color: var(--lightblue);
        border-radius: 10px;
        padding: 0 4rem;
        margin-top: 1rem;
    }
    .previews > div{
        width: 100%;
        box-sizing: border-box;
        max-height: 120px;
        min-height: 120px;
        display: flex;
        padding: 1rem 0;
    }
    .previews > div:not(:last-child){
        border-bottom: 2px solid #000000;
    }
    .previews > div > div{
        align-self: center;
        float: left;
        margin-right: auto;
    }
    .previews > div > img{
        float: right;
        margin-left: auto;
        align-self: center;
    }
    .previews > div > div > button{
        margin-right: 1rem;
        height: 2rem;
        width: 2rem;
        display:inline-flex;
        justify-content: center;
        align-items: center;
        background-color: var(--red);
        color: #000;
        font-size: larger;
        font-weight: 900;
        border: none;
        border-radius: 50%;
        border: 1px solid #000;
    }
</style>