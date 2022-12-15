<?php require_once 'Header.php'; ?>

<div class="title-row">
    <div class="page-title">
        ADD NEW USER
    </div>
    <button class="title-row-btn shadow" onclick="location.href='<?= URLROOT . '/Admin/Users' ?>'">
        Back to User Managment
    </button>
</div>
<?php
if (isset($data['invalid'])) {
    echo "<div class=\"warn\">" . $data['invalid'] . "</div>";
}
if (isset($data['failed'])) {
    echo "<div class=\"warn\">" . $data['failed'] . "</div>";
}
if (isset($data['added'])) {
    echo "<div class=\"success\">" . $data['added'] . "</div>";
}
?>
<form action="<?= URLROOT . "/Admin/AddUser" ?>" method="post">
    <div class="field">
        <label for="role">
            Employee Type
        </label>
        <select name="role" id="role" required>
            <option value="Complaint">Complaint Handler</option>
            <option value="LibraryStaff">Library Staff</option>
            <option value="Storage">Storage Manager</option>
        </select>
    </div>
    <div class="field">
        <label for="NIC">
            NIC
        </label>
        <input type="text" name="NIC" id="NIC" required>
    </div>
    <div class="field">
        <label for="first_name">
            First Name
        </label>
        <input type="text" name="first_name" id="first_name" required>
    </div>
    <div class="field">
        <label for="last_name">
            Last Name
        </label>
        <input type="text" name="last_name" id="last_name">
    </div>
    <div class="field">
        <label for="email">
            Email
        </label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="field">
        <label for="password">
            Password(Demo Only)
        </label>
        <input type="password" name="password" id="password" required>
    </div>
    <div class="field">
        <label for="tel_no">
            Contact No
        </label>
        <input type="tel" name="tel_no" id="tel_no" maxlength="12" required>
    </div>
    <div class="field">
        <label for="address">
            Address
        </label>
        <input type="text" name="address" id="address" required>
    </div>
    <div class="field">
        <input class="submit shadow" type="submit" value="Add User" name="Submit">
    </div>
</form>
<?php require_once 'Footer.php'; ?>