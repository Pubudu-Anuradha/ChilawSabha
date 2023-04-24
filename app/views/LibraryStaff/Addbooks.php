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
                    echo "Failed to add book " . $data['Add']['errmsg'];
                } else {
                    echo "Added Successfully";
                }
            }?>

            <form  class="fullForm" method="post">

                    <?php Errors::validation_errors($errors, [
                        'title' => "Title",
                        'author' => 'Author',
                        'publisher' => 'Publisher',
                        'place_of_publication' => "Place of Publication",
                        'date_of_publication' => 'Date of Publication',
                        'category_code' => 'Category Code',
                        'sub_category_code' => 'Sub Category Code',
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
                <?php $categories = [];
                    foreach ($data['categories'] as $category) {
                        $categories[$category['category_id']] = $category['category_name'];
                    }
                ?>
                <div class="input-field">
                    <label for="sub_category_code">Book Category</label>
                    <select name="category" id="category" required>
                        <?php  foreach($categories as $value=>$name): ?>
                            <option label="<?=$name?>">
                              <?=$name?>
                                <?php foreach($data['subcategories'] as $subcategory):
                                    if($subcategory['category_id'] == $value): ?>
                                        <option value="<?=$subcategory['sub_category_id']?>">
                                            <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' . $subcategory['sub_category_name']?>
                                        </option>
                                <?php endif; endforeach;?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php Other::number('Accession No', 'accession_no', 'accession_no', placeholder:'Insert Accession No', min:0);?>
                <?php Text::text('ISBN No','isbn','isbn',placeholder:'Insert ISBN No',maxlength:50, value:$reqInfo['result'][0]['isbn'] ?? false);?>
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
        if (!recdate . validity . valid) {
            event . preventDefault();
            recdate . reportValidity();
        }
    });
</script>
