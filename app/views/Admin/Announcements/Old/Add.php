<div class="content">
    <h1>
        Add New Annoucement
    </h1>
    <hr>
    <div class="formContainer">
        <?php if($data['Add'])
                if(!$data['Add']['success'])
                    echo "Failed to add Announcement ".$data['Add']['errmsg'];
                else
                    echo "Added Successfully";
        ?>
        <form class="fullForm" method="post">
            <div class="inputfield">
                <label for="title">Title</label>
                <div class="inputDiv">
                    <input type="text" id="title" name="title" placeholder="Enter Announcement Title" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="category">Category</label>
                <div class="inputDiv">
                    <select id="category" name="category">
                        <?php $categories = ['Financial','Government','Tender'];
                        foreach($categories as $category): ?>
                            <option value="<?=$category?>"><?=$category?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="inputfield">
                <label for="shortdesc">Short description</label>
                <div class="inputDiv">
                    <input type="text" name="shortdesc" id="shortdesc" placeholder="A short desription about the announcement" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="author">Author</label>
                <div class="inputDiv">
                    <input type="text" name="author" id="author" placeholder="Enter the author of the Announcement" required>
                </div>
            </div>

            <div class="inputfield">
                <label for="content">Announcement Contents</label>
                <div class="inputDiv">
                <textarea id="content" name="content" rows="10" cols="30"></textarea>
                </div>
            </div>

            <div class="submitButtonContainer">
                <div class="submitButton">
                    <input type="submit" id="Add" value="Add Announcement" name="Add">
                </div>
            </div>
        </form>
    </div>
</div>