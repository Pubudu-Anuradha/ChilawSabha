<?php require_once 'Header.php';?>

    <div style="display:flex">
        
        <?php require_once 'Dashboard.php'; ?>

        <div class="addNewItemType">
            <div style="display:flex">
                <div class="sub">
                    <h1 class="viewTitle" style="margin-right: 400px;">Add New Item Type</h1>

                    <?php require_once 'Logout.php'; ?>
                </div>
            </div>

            <hr class="horizontal" /><br/>

            <div class="insertForm">
                <form action="<?= URLROOT . "/Storage/AddNewItemType" ?>" method="post">
                    <label for="item_id">Item ID</label><input type="text" name="item_id" required /><br />
                    <label for="item_name">Item Type Name</label><input type="text" name="item_name" required /><br />
                    <label for="item_category">Item Category</label><select name="item_category" id="categorySelect">
                        <option value="Inventory">Inventory</option>
                        <option value="Construction">Construction</option>
                        <option value="Stationary">Stationary</option>
                        <option value="Plumbing">Plumbing</option>
                        <option value="Medical">Medical</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Vehical Parts">Vehical Parts</option>
                    </select><br/>
                    <label for="min_stock">Min Stock</label><input type="number" name="min_stock" required /><br />
                    <label for="max_stock">Max Stock</label><input type="number" name="max_stock" required /><br />
                        
                    <input type="submit" value="Submit" name="Submit" id="addNewItemType" />
                    <?php 
                    success($data,'typeadded');
                    warn($data, 'typenotadded');
                    warn($data, 'invalidinput');
                    ?>
                </form>
            </div>
        </div>

    </div>

<?php require_once 'Footer.php';?>
