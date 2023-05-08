<div class="download-page">
    <div class="download-page-content">
        <h2 class="download-topic">Downloads</h2>

<?php
$categories = $data['categories'] ?? [];
$admin = ($_SESSION['role']??'Guest') == 'Admin';
$formatter = new IntlDateFormatter(
    'en_US',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
);
foreach($categories as ['cat_id' => $cat_id,'category' => $category]):
$cat_files = array_filter($data['cat_files'],function($a) use($cat_id){
    return ($a['cat_id']?? false) ==$cat_id;
});
if(!empty($cat_files) || $admin):
?>

        <div>
            <div class="download-accordin"><?= $category ?></div>
            <div class="panel">
<?php if($admin):?>
<form class="fullForm" method="post" enctype="multipart/form-data">
<input type="text" name="cat_id" value="<?= $cat_id ?>" hidden>
<?php
$errors =$data['AddFilesErr']??[];
Errors::validation_errors($errors);
Files::any('Add Files', 'files');
Other::submit('AddFiles', value:'Add Files');
?>
    </form>
<?php endif; ?>
                <ul>
<?php
$i=0;
foreach($cat_files as ['name'=>$name,'orig'=>$orig,'cat_id'=>$_,'added_time'=>$added_time]): ?>
    <li style="display: flex;gap:1rem;align-items:center;" <?= ++$i%2==0 ? 'class="alt shadow"' :'class="norm shadow"' ?>>
    <?php if($admin):?>
    <form method="POST">
        <input type="text" name="cat_id" value="<?= $cat_id ?>" hidden>
        <input type="text" name="file_name" value="<?= $name ?>" hidden>
        <button type="submit" name="DeleteFile" class="btn bg-red">&times;</button>
    </form>
    <?php endif; ?>
    <a id="<?= $name ?>" href="<?= URLROOT . '/Downloads/file/' . $name ?>"
        class="download-link"><?= $orig ?> (<?php
            echo $formatter->format(IntlCalendar::fromDateTime($added_time,null));
        ?>)</a>
    </li>
<?php endforeach;?>
                </ul>
            </div>
        </div>
<?php endif;
endforeach; ?>
    </div>
<?php if($admin): ?>
    <div class="formContainer">
        <form class="fullForm" method="post">
<?php
$errors = $data['AddCatErrors'] ?? [];
Errors::validation_errors($errors);
Text::text('New Category Name','category','category-new');
Other::submit('AddCategory',value:'Add a new Category');
?>
        </form>
    </div>
<?php endif; ?>
</div>

<script>
    var acc = document.getElementsByClassName("download-accordin");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            var panel = this.nextElementSibling
            if (panel.style.display === "block") {
                panel.style.display = "none";
            }
            else {
                panel.style.display = "block";
            }
        });
    }
</script>