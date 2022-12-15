<?php require_once 'Header.php';?>

    <div style="display:flex">
        
        <?php require_once 'Dashboard.php'; ?>

        <div class="viewItems">
            <div style="display:flex">
                <div class="sub">
                    <h1 class="viewTitle">View Items</h1>

                    <?php require_once 'CategorySortAndSearch.php'; ?>

                    <?php require_once 'Logout.php'; ?>
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
                                    <input type="submit" class="editButton" name=editButton value="Edit details"/></td>';
                                echo '</tr>';
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>

<?php require_once 'Footer.php';?>
