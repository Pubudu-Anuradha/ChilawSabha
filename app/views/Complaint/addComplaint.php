<?php
$errors = $data['errors'] ?? false;
$old = $data['old'] ?? false;
?>
<div class="content">
    <div class="page">
        <h2 class="topic">Add Complaints</h2>
        <div class="formContainer">
            <?php if ($data['Add'] ?? false) {
                if (!$data['Add']['success']) {
                    echo "Failed to add Complaint " . $data['Add']['errmsg'];
                } else {
                    echo "Added Successfully";
                }
            } ?>

            <form class="fullForm" method="post">

                <?php Errors::validation_errors($errors, [
                    "name" => "Name",
                    'email' => 'Email',
                    'contact_no' => 'Contact No',
                    'address' => "Address",
                    'description' => 'Description',
                    'category' => 'Category',
                    'date' => 'Date',

                ]); ?>

                <?php Text::text('Complainer Name', 'name', 'name', placeholder: 'Insert Name', maxlength: 255); ?>
                <?php Text::text('Email Address', 'email', 'email', placeholder: 'Insert Email', maxlength: 255); ?>
                <?php Text::text(
                    'Mobile No',
                    'contact_no',
                    'contact_no',
                    '+94XXXXXXXXX or 0XXXXXXXXX',
                    type: 'tel',
                    maxlength: 12,
                    pattern: "(\+94\d{9})|0\d{9}",
                    value: $old['contact_no'] ?? null
                ); ?>
                <?php Text::text('Address', 'address', 'address', placeholder: 'Enter address', maxlength: 255); ?>
                <?php Time::date('Date', 'date', 'date', max: Date("Y-m-d")); ?>
                <?php $categories = [];
                foreach ($data['complaint_categories'] as $category) {
                    $categories[$category['category_id']] = $category['category_name'];
                }
                Group::select(
                    'Complaint Category',
                    'category',
                    $categories,
                    'category',
                    selected: $old['complaint_categories'] ?? null
                ); ?>
                <?php Text::text('Complaint Description', 'description', 'description', placeholder: 'Enter description', maxlength: 255); ?>
                <?php Other::submit('Add', 'add', value: 'Add'); ?>
            </form>
        </div>
    </div>
</div>