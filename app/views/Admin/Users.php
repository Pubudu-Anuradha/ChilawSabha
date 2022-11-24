<?php require_once 'Header.php'; ?>
<div class="title-row">
    <div class="page-title">
        USER MANAGEMENT
    </div>
    <div class="title-search shadow">
        <input type="text" name="search" id="search" class="field">
        <button class="btn">
            <img src="<?= URLROOT . '/public/assets/search.png' ?>" alt="search btn">
        </button>
    </div>
    <div class="title-row-btns">
        <button class="title-row-btn shadow" onclick="location.href='<?= URLROOT . '/Admin/AddUser' ?>'">
            Add New User
        </button>
        <button class="title-row-btn shadow" onclick="alert('Not Implemented yet')">
            Disabled Users
        </button>
    </div>
</div>
<table>
    <tr class="table-head-row">
        <th class="table-heading"> ID </th>
        <th class="table-heading"> Name </th>
        <th class="table-heading"> NIC </th>
        <th class="table-heading"> Tel no </th>
        <th class="table-heading"> Address </th>
        <th class="table-heading"> Email</th>
        <th class="table-heading"> Employee Type </th>
        <th class="table-heading"> Actions </th>
    </tr>
    <?php if (isset($data['users'])) {
        while ($user = $data['users']->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $user['staff_id']     . '</td>';
            echo '<td>' . $user['first_name']   . ' ' . $user['last_name']    . '</td>';
            echo '<td>' . $user['NIC']          . '</td>';
            echo '<td>' . $user['tel_no']       . '</td>';
            echo '<td>' . $user['address']      . '</td>';
            echo '<td>' . $user['email']        . '</td>';
            $role = 'Invalid';
            switch ($user['role']) {
                case 'Admin':
                    $role = 'Administrator';
                    break;
                case 'Complaint':
                    $role = 'Complaint Handler';
                    break;
                case 'LibraryStaff':
                    $role = 'Library Staff';
                    break;
                case 'Storage':
                    $role = 'Storage Manager';
                    break;
            }
            echo '<td>' . $role . '</td>';
            echo '<td class="actions">  <button class="act-btn edit" onclick="alert(\'Not Implemented yet\')">Edit</button><button class="act-btn disable" onclick="alert(\'Not Implemented yet\')">Disable</button> </td></tr>';
        }
    } ?>
</table>
<?php require_once 'Footer.php'; ?>