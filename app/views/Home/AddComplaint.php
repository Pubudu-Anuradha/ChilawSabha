<div class="form">
    <div class="side-menu">
        <h1></h1>
    </div>
    <div class="complaint-form">
        <h2>
            Complaint Form <hr class="hr1">
        </h2>
        <div class="formContainer">
            <!-- redesigned with components. To do back-end integration -->
            <form id="complaint" name="complaint form" class="fullForm" method="post">

              <?php Text::text('Complainer Name','complainerName','complainerName',placeholder:'Enter Name',maxlength:255);?>
              <?php Text::email('Enter Your Email','email','email',placeholder:'Enter Email');?>
              <?php Text::text('Enter Your Phone Number','contactno','contactno',placeholder:'+94XXXXXXXXX or 0XXXXXXXXX', type:'tel',maxlength:12,pattern:"(\+94\d{9})|0\d{9}");?>
              <?php Text::text('Address', 'address', 'address',placeholder:'Enter Address', maxlength:255); ?>
              <!-- for now simply hardcoded types (to do - get categories from DB) -->
              <?php $complaintCategory = ['Garbage disposal','Land issues','Unauthorized construction','Street lamp','Roads require repair','Damaged public infrastructure','Other'] ?>
              <?php Group::select('Complaint Category', 'complaintCateory', $complaintCategory); ?>
              <?php Text::textarea('Briefly Describe Your Incident', 'message', 'message',placeholder:'Enter Description'); ?>
              <?php Files::images('Photos', 'photos', 'photos', required:false); ?>
              <?php Files::any('Attachments', 'attachments', 'attachments', required:false);?>
              <?php Other::submit('Add','add',value:'Add');?>

            </form>
        </div>
    </div>
</div>
