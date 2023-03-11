<div class="content">
    <div class="page">
            <?php if($data['books'] ):
            if($data['books']['error'] || $data['books']['nodata']):?>
                <h1>
                    <?=$data['books']['nodata']?'Book Not found':
                    $data['books']['errmsg']?>
                </h1>
            <?php else: 
            $books = $data['books']['result'][0];?>

        <h2 class="topic">Edit Books</h2>
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

                <?php Text::text('Title','title','title','Insert Book Title',maxlength:255,value:$books['title']);?>
                <?php Text::text('Author','author','author','Insert Book Author',maxlength:255,value:$books['author']);?>
                <?php Text::text('Publisher','publisher','publisher','Insert Book Publisher',maxlength:255,value:$books['publisher']);?>
                <?php Text::text('Place of Publication','place_of_publication','place_of_publication','Insert Place of Publication',maxlength:255,value:$books['place_of_publication']);?>
                <?php Time::date('Date of Publication','date_of_publication','date_of_publication',max:Date("Y-m-d"),value:$books['date_of_publication']);?>
                <?php Other::number('Accession No','accession_no','accession_no',placeholder:'Insert Accession No',min:0,value:$books['accession_no']);?>
                <?php Text::text('ISBN No','isbn','isbn','Insert ISBN No',maxlength:50,value:$books['isbn']);?>
                <?php Other::number('Price','price','price',placeholder:'Insert Book Price',step:0.01,min:"0",value:$books['price']);?>
                <?php Other::number('No of Pages','pages','pages',placeholder:'Insert No of Pages', min:1,value:$books['pages']);?>
                <?php Time::date('Recieved Date','recieved_date','recieved_date',max:Date("Y-m-d"),value:$books['recieved_date']);?>
                <?php Text::text('Recieved Method','recieved_method','recieved_method','Insert Recieved Method',maxlength:255,value:$books['recieved_method']);?>
                <?php Other::submit('Edit','edit',value:'Save Changes');?>

            </form>
        </div>
            <?php endif; else:?>
                NO ID GIVEN
            <?php endif;?>
    </div>
</div>