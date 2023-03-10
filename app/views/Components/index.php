<?php
Text::text('Enter your name','name','name-id','name-in',true,'Saman Kumara', 'Please Enter your name here');

Text::email('Enter your Email','email','email-id', 'email-in', 'Enter your email here', "([-!#-'*+/-9=?A-Z^-~]+(\.[-!#-'*+/-9=?A-Z^-~]+)*|\"([]!#-[^-~ \t]|(\\[\t -~]))+\")@([0-9A-Za-z]([0-9A-Za-z-]{0,61}[0-9A-Za-z])?(\.[0-9A-Za-z]([0-9A-Za-z-]{0,61}[0-9A-Za-z])?)*|\[((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3}|IPv6:((((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){6}|::((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){5}|[0-9A-Fa-f]{0,4}::((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){4}|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):)?(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){3}|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){0,2}(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){2}|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){0,3}(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){0,4}(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::)((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3})|(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(\.(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])){3})|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){0,5}(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3})|(((0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}):){0,6}(0|[1-9A-Fa-f][0-9A-Fa-f]{0,3}))?::)|(?!IPv6:)[0-9A-Za-z-]*[0-9A-Za-z]:[!-Z^-~]+)])");

Text::password('Enter your password','password','password-id','password-in','Please Enter your password here',"(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})", 'current-password');

Text::textarea('Enter your message','message','message-id','message-in','Please Enter your message here','Saman Kumara is okay', 10, 30, true);

Time::date('Enter your date','date','maxdate-id','maxdate-in','date', date("Y-m-d"), NULL, true);

Time::date('Enter your date','date','mindate-id','mindate-in','date', NULL, date("Y-m-d"), true);

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
</style>