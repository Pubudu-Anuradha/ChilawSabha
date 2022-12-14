<?php require_once 'Header.php';?>

    <div style="display:flex">
        <div class="dashboard">
            <a href="<?= URLROOT . "/Storage/index" ?>" class="option">Dashboard</a>
            <a href="<?= URLROOT . "/Storage/ViewItems" ?>" class="option">View Items</a>
            <a href="<?= URLROOT . "/Storage/AddNewItemType" ?>" class="option">Add New Type of Item</a>
            <a href="#" class="option">Issue Items</a>
            <a href="#" class="option">Recieve Items</a>
            <a href="#" class="option">Damaged Items</a>
            <a href="#" class="option">Nearly Out of Stock Items</a>
            <a href="#" class="option">Issue And Recieve History</a>
        </div>

        <div class="viewItems">
            <div style="display:flex">
                <div class="sub">
                    <h1 class="viewTitle">View Items</h1>

                    <select name="categorySort" id="categorySort">
                        <option value="">Choose Category</option>
                        <option value="Inventory">Inventory</option>
                        <option value="Construction">Construction</option>
                        <option value="Stationary">Stationary</option>
                        <option value="Plumbing">Plumbing</option>
                        <option value="Medical">Medical</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Vehical Parts">Vehical Parts</option>
                    </select>

                    <input type="search" id="search" name="viewSearch" placeholder="Search">
                    <button class="searchButton">
                        <img src="<?= URLROOT . '/public/assets/search.png' ?>" alt="Search Logo" class="searchLogo" />
                    </button>

                    <img src="<?= URLROOT . '/public/assets/Login.png' ?>" alt="Profile Avatar" class="profileAvatar" />
                            
                    <select class="logoutForm" name="logoutForm" id="logoutForm" onchange="if(this.value=='Logout')location.href='<?= URLROOT . '/Login/Logout' ?>'">
                        <option value="name" style="display:none"><?= $_SESSION['name'] ?></option>
                        <option value="Logout">Logout</option>
                    </select>
                </div>
            </div>

            <hr class="horizontal" /><br/>

            <div class="itemList">
                <table class="itemTable">
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Item Category</th>
                        <th>Min Stock</th>
                        <th>Max Stock</th>
                        <th>Current Quantity</th>
                        <th class="action">Action</th>
                    </tr>

                    <?php
                        if (isset($data['items'])) {
                            while ($item = $data['items']->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $item['item_id'] . '</td>';
                                echo '<td>' . $item['item_name'] . '</td>';
                                echo '<td>' . $item['item_category'] . '</td>';
                                echo '<td class="numberView">' . $item['min_stock'] . '</td>';
                                echo '<td class="numberView">' . $item['max_stock'] . '</td>';
                                echo '<td class="numberView">' . $item['current_quantity'] . '</td>';
                                echo '<td class="buttonSet"><input type="submit" class="issueButton" name=issueButton value="Issue"/>
                                    <input type="submit" class="recieveButton" name=recieveButton value="Recieve"/>
                                    <input type="submit" class="editButton" name=editButton value="Edit item details"/></td>';
                                echo '</tr>';
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>

<?php require_once 'Footer.php';?>
