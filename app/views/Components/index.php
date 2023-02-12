<?php
Text::text('Enter your name','name','name-id','name-in','Please Enter your name here','Saman Kumara');
Text::email('Enter your Email','email');
Text::password('Enter your password','password');
Text::textarea('Enter your message','message','message-id','message-in','Please Enter your message here','Saman Kumara is okay');

Group::select('selection','Select your word',[
    'a'=>'Apple',
    'b'=>'Ball',
    'c'=>'Cat',
    'd'=>'Dog',
    'e'=>'Elephant',
],selected:'d');