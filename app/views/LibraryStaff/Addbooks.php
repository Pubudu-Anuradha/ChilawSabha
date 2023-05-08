<?php
$errors = $data['errors'] ?? false;
$old = $data['old'] ?? false;
$reqInfo = $data['reqInfo'] ?? false;
?>
<div class="content">
    <div class="page">
        <h2 class="topic">Add Books</h2>
        <div class="formContainer">
            <?php if ($data['Add'] ?? false) {
                if (!$data['Add']['success']) {
                    echo "Failed To Add Book " . $data['Add']['errmsg'];
                } else {
                    echo "Book Added Successfully";
                }
            }?>

            <form  class="fullForm" method="post">

                    <?php Errors::validation_errors($errors, [
                        'title' => "Title",
                        'author' => 'Author',
                        'publisher' => 'Publisher',
                        'place_of_publication' => "Place of Publication",
                        'date_of_publication' => 'Date of Publication',
                        'category' => 'Book Category',
                        'subcategory' => 'Book Sub Category',
                        'accession_no' => 'Accession No',
                        'isbn' => 'ISBN No',
                        'price' => "Price",
                        'pages' => 'No of Pages',
                        'recieved_date' => 'Recieved Date',
                        'recieved_method' => 'Recieved Method',
                    ]);?>

                <?php Text::text('Title','title','title',placeholder:'Insert Book Title',maxlength:255, value:$reqInfo['result'][0]['title'] ?? false);?>
                <?php Text::text('Author','author','author',placeholder:'Insert Book Author',maxlength:255, value:$reqInfo['result'][0]['author'] ?? false);?>
                <?php Text::text('Publisher','publisher','publisher',placeholder:'Insert Book Publisher',maxlength:255);?>
                <?php Text::text('Place of Publication','place_of_publication','place_of_publication',placeholder:'Insert Place of Publication',maxlength:255);?>
                <?php Time::date('Date of Publication','date_of_publication','date_of_publication',max:Date("Y-m-d"));?>

                <?php $categories = []; $type = [];
                    foreach ($data['categories'] as $category) {
                        foreach($data['subcategories'] as $subcategory){
                            if($subcategory['category_id'] == $category['category_id'] ){
                                $type[$category['category_name']][]  = $subcategory['sub_category_name'];
                            }
                        }
                    }
                ?>

                <div class="input-field">
                    <label for="book_category">Book Category</label>
                    <div class="input-wrapper">
                    <select name="category" id="category" required>
                        <option value="0">Choose a book category</option>
                    </select>           
                    </div>    
                </div>
                <div class="input-field">
                    <label for="book_category"  id="subCategorylabel" style="display:none">Book Sub Category</label>
                    <div class="input-wrapper">
                    <select name="subcategory" id="subcategory" style="display:none">
                    </select>
                    </div>
                </div>

                <?php Other::number('Accession No', 'accession_no', 'accession_no', placeholder:'Insert Accession No', min:0);?>
                <?php Text::text('ISBN No','isbn','isbn',placeholder:'Insert ISBN No',pattern:"(\d{10}|\d{13})",maxlength:50, value:$reqInfo['result'][0]['isbn'] ?? false);?>
                <?php Other::number('Price','price','price',placeholder:'Insert Book Price',step:0.01,min:0);?>
                <?php Other::number('No of Pages','pages','pages',placeholder:'Insert No of Pages', min:1);?>
                <?php Time::date('Recieved Date','recieved_date','recieved_date',max:Date("Y-m-d"));?>
                <?php Text::text('Recieved Method','recieved_method','recieved_method',placeholder:'Insert Recieved Method',maxlength:255);?>
                <?php Other::submit('Add','add',value:'Add Book');?>

            </form>
        </div>

    </div>
</div>

<script>

    expandSideBar("sub-items-serv","see-more-bk");
    //to compare dates from front end
    var form = document.getElementsByTagName('form')[0];
    var pubdate = document.getElementById('date_of_publication');
    var recdate = document.getElementById('recieved_date');

    const select = document.getElementById('category');
    const subSelect = document.getElementById('subcategory');
    const subCategorylabel = document.getElementById('subCategorylabel');

    const bookTypes = <?php echo (isset($type) ? json_encode($type) : false) ?>;

    if(bookTypes){
        for(bookType in bookTypes){
            const option = document.createElement('option');
            option.value = bookType;
            option.textContent = bookType;
            select.appendChild(option);
        }
    

        select.addEventListener('change', function(e){
            const selectedCategory = event.target.value;
            subSelect.innerHTML = "";
            
            if(selectedCategory != 0){
                select.setCustomValidity('');
                const option = document.createElement('option');
                option.value = '0';
                option.textContent = 'Choose a book sub category';
                subSelect.appendChild(option);

                for(const subType of bookTypes[selectedCategory]){
                    const option = document.createElement('option');
                    option.value = subType;
                    option.textContent = subType;
                    subSelect.appendChild(option);
                }
                subSelect.style.display = "block";
                subCategorylabel.style.display = "block";
            }else{
                select.setCustomValidity('Please Select A Book Category');
                subSelect.style.display = "none";
                subCategorylabel.style.display = "none";
            }
        });
    }

    subSelect.addEventListener('change',function(e){
        const subSelectedCategory = event.target.value;
        if(subSelectedCategory != 0){
            subSelect.setCustomValidity('');
        }
        else{
            subSelect.setCustomValidity('Please Select A Book Sub Category');
        }
    });

    recdate.addEventListener('focus',function(){
        this.showPicker();
    });

    pubdate.addEventListener('focus',function(){
        this.showPicker();
    });

    recdate.addEventListener('change', function(event){
        var recdateVal = recdate.value;
        var pubdateVal = pubdate.value;
        if (pubdateVal && recdateVal && pubdateVal > recdateVal) {
            recdate.setCustomValidity('Recieved date must be after or on published date.');
        } else {
            recdate.setCustomValidity('');
        }
    });

    form.addEventListener('submit', function(event){

        if(select.value == 0){
            select.setCustomValidity('Please Select A Book Category');
            select . reportValidity();
        }

        if(subSelect.value == 0){
            subSelect.setCustomValidity('Please Select A Book Sub Category');
            subSelect . reportValidity();
        }

        if (!recdate . validity . valid) {
            event . preventDefault();
            recdate . reportValidity();
        }
        if (!select.validity.valid || !subSelect.validity.valid){
            event.preventDefault();
            if(!subSelect.validity.valid){
                subSelect.reportValidity();
            }
            else if (!select.validity.valid){
                select.reportValidity();
            }
        }
    });


</script>
