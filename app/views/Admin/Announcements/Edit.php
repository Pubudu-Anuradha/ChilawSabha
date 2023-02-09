<div class="content">
    <?php if($data['announcement'] ):
            if($data['announcement']['error'] || $data['announcement']['nodata']):?>
                <h1>
                    <?=$data['announcement']['nodata']?'Announcement Not found':
                    $data['announcement']['errmsg']?>
                </h1>
            <?php else: 
            // var_dump($data);
            $ann = $data['announcement']['result'][0];?>

    <h1>
        Edit Annoucement
    </h1>
    <hr>
    <div class="formContainer">
        <?php if(isset($data['edit'])):
                if(!$data['edit']['posts']['success'] && !$data['edit']['announce']['success']):
                    echo "Failed to Edit Announcement ".$data['edit']['posts']['errmsg'].'  '.$data['edit']['announce']['errmsg'];
                else:
                    echo "Changes Saved";
                endif;
            endif;
        ?>
        <form class="fullForm" method="post">
            <div class="inputfield">
                <label for="title">Title</label>
                <div class="inputDiv">
                    <input type="text" id="title" name="title" value="<?=$ann['title']?>" placeholder="Enter Announcement Title" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="category">Category</label>
                <div class="inputDiv">
                    <select id="category" name="category">
                        <?php $categories = ['Financial','Government','Tender'];
                        foreach($categories as $category): ?>
                            <option value="<?=$category?>" <?=$ann['category']==$category?'selected':''?> ><?=$category?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="inputfield">
                <label for="shortdesc">Short description</label>
                <div class="inputDiv">
                    <input type="text" name="shortdesc" id="shortdesc" value="<?=$ann['shortdesc']?>" placeholder="A short desription about the announcement" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="author">Author</label>
                <div class="inputDiv">
                    <input type="text" name="author" id="author" value="<?=$ann['author']?>" placeholder="Enter the author of the Announcement" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="content">Announcement Contents</label>
                <div class="inputDiv">
                <textarea id="content" name="content"  rows="10" cols="30"><?=$ann['description']?></textarea>
                </div>
            </div>

            <div class="submitButtonContainer">
                <div class="submitButton">
                    <input type="submit" id="Edit" value="Save changes" name="Edit">
                </div>
            </div>
        </form>
    </div>
        <?php endif; ?>
        <?php else: ?>
        <h1>
            NO ANNOUNCEMENT ID
        </h1>
        <?php endif; ?>
</div>