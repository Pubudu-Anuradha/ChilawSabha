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
                    }
                ?>
                <div class="input-field">
                    <label for="sub_category_code">Book Category</label>
                    <select name="sub_category_code" id="sub_category_code" required>
                        <?php  foreach($categories as $value=>$name): ?>
                            <optgroup label="<?=$name?>">
                                <?php foreach($data['subcategories'] as $subcategory):
                                    if($subcategory['category_id'] == $value): ?>
                                        <option value="<?=$subcategory['sub_category_id']?>" >
                                            <?=$subcategory['sub_category_name']?>
                                        </option>
                                <?php endif; endforeach;?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                </div>

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

<script>
    //to compare dates from front end
    var form = document.getElementsByTagName('form')[0];

    form.addEventListener('submit', function(event){
        var pubdate = document.getElementById('date_of_publication').value;
        var recdate = document.getElementById('recieved_date').value;

        if(pubdate>recdate){
            event.preventDefault();
            var recdateErr = document.getElementById('recieved_date');
            //to show the error as default js form errors in browser
            recdateErr.setCustomValidity('Recieved date must be after or on published date.'); 
            recdateErr.reportValidity();
        }
    });
</script>