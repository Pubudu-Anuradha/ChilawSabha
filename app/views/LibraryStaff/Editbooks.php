<div class="content">
    <div class="page">
        <?php
            $books = $data['books']['result'][0] ?? null;
            $errors = $data['errors'] ?? false;
        ?>

        <h2 class="topic">Edit Books</h2>
        <?php if(!is_null($books)): ?>
            <div class="formContainer">
                <?php if (isset($data['edit'])):
                    if (!$data['edit']['book']['success']):
                        echo "Failed to Edit book " . $data['edit']['book']['errmsg'];
                    else:
                        echo "Saved changes";
                    endif;
                endif;
                ?>
                <form  class="fullForm" method="post">
                    <?php Errors::validation_errors($errors, [
                        'title' => "Title",
                        'author' => 'Author',
                        'publisher' => 'Publisher',
                        'place_of_publication' => "Place of Publication",
                        'date_of_publication' => 'Date of Publication',
                        'isbn' => 'ISBN No',
                        'price' => "Price",
                        'pages' => 'No of Pages',
                        'recieved_date' => 'Recieved Date',
                        'recieved_method' => 'Recieved Method',
                    ]);?>

                    <?php Text::text('Title','title','title',placeholder:'Insert Book Title',maxlength:255,value:$books['title'] ?? null);?>
                    <?php Text::text('Author','author','author',placeholder:'Insert Book Author',maxlength:255,value:$books['author'] ?? null);?>
                    <?php Text::text('Publisher','publisher','publisher',placeholder:'Insert Book Publisher',maxlength:255,value:$books['publisher'] ?? null);?>
                    <?php Text::text('Place of Publication','place_of_publication','place_of_publication',placeholder:'Insert Place of Publication',maxlength:255,value:$books['place_of_publication'] ?? null);?>
                    <?php Time::date('Date of Publication','date_of_publication','date_of_publication',max:Date("Y-m-d"),value:$books['date_of_publication'] ?? null);?>
                    <?php Text::text('ISBN No','isbn','isbn',placeholder:'Insert ISBN No',maxlength:50,value:$books['isbn'] ?? null);?>
                    <?php Other::number('Price','price','price',placeholder:'Insert Book Price',step:0.01,min:"0",value:$books['price'] ?? null);?>
                    <?php Other::number('No of Pages','pages','pages',placeholder:'Insert No of Pages', min:1,value:$books['pages'] ?? null);?>
                    <?php Time::date('Recieved Date','recieved_date','recieved_date',max:Date("Y-m-d"),value:$books['recieved_date'] ?? null);?>
                    <?php Text::text('Recieved Method','recieved_method','recieved_method',placeholder:'Insert Recieved Method',maxlength:255,value:$books['recieved_method'] ?? null);?>
                    <div class="input-field">
                        <label for="mark_damaged">Mark Damaged</label>
                        <div class="input-wrapper">
                            <input type="checkbox" name="mark_damaged" id="mark_damaged" onclick="disablefields()" style="height:1.2rem;aspect-ratio:1/1;">
                        </div>
                    </div>
                    <?php Other::submit('Edit','edit',value:'Save Changes');?>

                </form>
            </div>
        <?php else:?>
            INVALID BOOK ACCESSION NO
        <?php endif;?>
    </div>
</div>

<script>

    //disable field when checkbox clicked
    function disablefields(){
        var checkbox = document.getElementById('mark_damaged');
        var fields = document.getElementsByTagName('input');
        for(var i=0 ; i<fields.length;i++){
            if (fields[i].type == "text" || fields[i].type == "number" || fields[i].type == "date" ) {
                if (checkbox.checked == true) {
                    fields[i].disabled = true;
                } else {
                    fields[i].disabled = false;
                }
            }
        }
    }

</script>
