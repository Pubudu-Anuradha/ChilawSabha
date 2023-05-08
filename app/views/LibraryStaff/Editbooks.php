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
                    if (!$data['edit']['success']):
                        if(!$data['edit']['errmsg']):
                            echo "Already Updated The Book ";
                        else:
                            echo "Failed to Edit book " . $data['edit']['errmsg'];
                        endif;else:
                        echo "Saved changes";
                    endif;
                endif;
                ?>
                <form  class="fullForm" method="post">
                    <?php Errors::validation_errors($errors, [
                        'title' => "Title",
                        'author' => 'Author',
                        'publisher' => 'Publisher',
                        'price' => "Price",
                        'pages' => 'No of Pages',
                    ]);?>

                    <?php Text::text('Title','title','title',placeholder:'Insert Book Title',maxlength:255,value:$books['title'] ?? null);?>
                    <?php Text::text('Author','author','author',placeholder:'Insert Book Author',maxlength:255,value:$books['author'] ?? null);?>
                    <?php Text::text('Publisher','publisher','publisher',placeholder:'Insert Book Publisher',maxlength:255,value:$books['publisher'] ?? null);?>
                    <?php Other::number('Price','price','price',placeholder:'Insert Book Price',step:0.01,min:"0",value:$books['price'] ?? null);?>
                    <?php Other::number('No of Pages','pages','pages',placeholder:'Insert No of Pages', min:1,value:$books['pages'] ?? null);?>
                    <?php Other::submit('Edit','edit',value:'Save Changes');?>

                </form>
                <?php
                    $edit_history = $data['edit_history'] ?? false;
                    $post = $books;
                    $fields = [
                        'title' => "Title",
                        'author' => 'Author',
                        'publisher' => 'Publisher',
                        'price' => 'Price',
                        'pages' => 'No of Pages',
                    ];
                    if($edit_history !== false && count($edit_history) !== 0): ?>
                        <div class="edit-history card">
                            <h2>Book Edit History</h2>
                            <hr>
                    <?php
                        $i = 0;
                        foreach($edit_history as $edit):
                            foreach($fields as $field => $name):
                                if($edit[$field] !== null && $edit[$field] !== $post[$field]): ?>
                                <div class="record b<?= ($i++%2==1) ? '-alt':'' ?>">
                                    on <span class="time"> <?= $edit['time'] ?> </span> :
                                    <?= $edit['changed_by'] ?> changed the field <b><?= $name ?></b> from
                                    "<?= $edit[$field] ?>" to "<?=$post[$field]?>".
                                </div>
                                    <?php $post[$field] = $edit[$field];
                                endif;
                            endforeach;
                        endforeach;
                    endif;
                ?>
                        </div>
            </div>
        <?php else:?>
            ERROR RETRIEVING BOOK INFORMATION
        <?php endif;?>
    </div>
</div>

<script>

    expandSideBar("sub-items-serv", "see-more-bk");

</script>
