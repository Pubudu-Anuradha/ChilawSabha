<?php
$errors = $data['errors'] ?? false;
$old = $data['old'] ?? false;
?>
<div class="content">
    <div class="page">
        <h2 class="topic">Add Books</h2>
        <div class="formContainer">
            <?php if ($data['Add'] ?? false) {
                if (!$data['Add']['success']) {
                    echo "Failed to add book " . $data['Add']['errmsg'];
                } else {
                    echo "Added Successfully";
                }
            }?>

            <form  class="fullForm" method="post">

                <?php Text::text('Title','title','title','Insert Book Title',maxlength:255);?>
                <?php Text::text('Author','author','author','Insert Book Author',maxlength:255);?>
                <?php Text::text('Publisher','publisher','publisher','Insert Book Publisher',maxlength:255);?>
                <?php Text::text('Place of Publication','place_of_publication','place_of_publication','Insert Place of Publication',maxlength:255);?>
                <?php Time::date('Date of Publication','date_of_publication','date_of_publication',max:Date("Y-m-d"));?>
                <?php $categories = [];
                foreach ($data['categories'] as $category) {
                    $categories[$category['category_id']] = $category['category_name'];
                }?>

                <?php Group::select('Book Category','category_code',$categories,selected:$old['role'] ?? null);?>
                <?php Other::number('Accession No', 'accession_no', 'accession_no', placeholder:'Insert Accession No', min:0);?>
                <?php Text::text('ISBN No','isbn','isbn','Insert ISBN No',maxlength:50);?>
                <?php Other::number('Price','price','price',placeholder:'Insert Book Price',step:0.01,min:0);?>
                <?php Other::number('No of Pages','pages','pages',placeholder:'Insert No of Pages', min:1);?>
                <?php Time::date('Recieved Date','recieved_date','recieved_date',max:Date("Y-m-d"));?>
                <?php Text::text('Recieved Method','recieved_method','recieved_method','Insert Recieved Method',maxlength:255);?>
                <?php Other::submit('Add','add',value:'Add');?>

            </form>
        </div>

    </div>
</div>