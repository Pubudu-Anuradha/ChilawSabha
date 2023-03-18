<div class="head-area">
    <h1>New Book Request</h1>
    <hr>
</div>
<form class="fullForm" method="post">
  <!-- redesigning with components done/ to do backend -->

    <?php Text::email('Enter Your Email','email','email',placeholder:'Enter Email');?>
    <?php Text::text('Book Title','title','title',placeholder:'Enter Book Title',maxlength:100);?>
    <?php Text::text('Book Author','author','author',placeholder:'Enter Book Author',maxlength:100);?>
    <?php Text::text('ISBN No','isbn','isbn',placeholder:'Enter ISBN No',maxlength:50);?>
    <?php Text::textarea('Reason for requesting', 'reason', 'reason',placeholder:'Enter Description', required:true); ?>
    <?php Other::submit('Add','add',value:'Add');?>

</form>
