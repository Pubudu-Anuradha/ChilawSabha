<?php
$errors = $data['errors'] ?? false;
$old = $data['old'] ?? false;
?>
<div class="content">
    <h1>Add Complaints</h1>
    <hr>
    <div class="formContainer">
        <?php if ($data['Add'] ?? false) {
            if (!$data['Add']['success']) {
                echo "Failed to add Complaint " . $data['Add']['errmsg'];
            } else {
                echo "Added Successfully";
            }
        } ?>

        <form class="fullForm" method="post" enctype="multipart/form-data">
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
            <?php Text::email('Email Address', 'email', 'email', placeholder: 'Insert Email'); ?>
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
            <?php Time::date('Date', 'date', 'date', type: 'date', max: Date("Y-m-d"), value: $old['date'] ?? date('Y-m-d')); ?>
            <?php $categories = [];
            foreach ($data['complaint_categories'] as $category) {
                $categories[$category['category_id']] = $category['complaint_category'];
            }
            Group::select(
                'Complaint Category',
                'category',
                $categories,
                'category',
                selected: $old['complaint_categories'] ?? null
            ); ?>
            <?php Text::textarea('Complaint Description', 'description', 'description', placeholder: 'Enter Description', required: true); ?>
            <?php if ($data['Add']['image_errors'] ?? false) :
                foreach ($data['Add']['image_errors'] as [$_, $photo]) :
                    $message = "There was an error while uploading $photo. Please try again.";
                    Errors::generic($message);
                endforeach;
            endif; ?>
            <?php Files::images('Complaint Images', 'photos', 'photos', required: false); ?>
            <?php Other::submit('Add', 'add', value: 'Add'); ?>
        </form>
    </div>
</div>
<script src="<?= URLROOT . '/public/js/upload_previews.js' ?>"></script>