<div class="content">
<!-- <?php
var_dump($data);
?> -->

<h1>
    Manage Announcements
</h1>
<hr>

<script>
    const send = ()=>{
        document.getElementById('filterform').submit();
    }
</script>
<div class="filters">
    <form action="<?=URLROOT . '/Admin/Announcements'?>" method="get" id="filterform">
        <div class="filter">
            <label for="search">
                Search
            </label>
            <input class="search" type="search" name="search" id="search" value="<?= isset($_GET['search']) ? $_GET['search']:''?>">
            <span onclick="send()"></span>
        </div>
        <div class="filter">
            <label for="category">
                Filter by Category
            </label>
            <select onchange="send()" name="category" id="category">
                <?php foreach (['All','Financial','Government','Tender'] as $cat):?>
                    <option value="<?=$cat?>" <?php if(isset($_GET['category']) && $_GET['category']==$cat) {echo 'selected';} ?>>
                        <?=$cat?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="filter">
            <label for="sort">
                Sort by date
            </label>
            <select onchange="send()" name="sort" id="sort">
                <?php foreach(['DESC'=>'Newest to Oldest','ASC'=>'Oldest to Newest'] as $val=>$desc):?>
                    <option value="<?= $val ?>" <?php if(isset($_GET['sort']) && $_GET['sort']==$val) {echo 'selected';} ?>>
                        <?=$desc?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
</div>

<?php 
$table = $data['announcements'];
?>
<div class="content-table">
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>Title</th>
                <th>Short Desctiption</th>
                <th>Author</th>
                <th>Date</th>
                <th>Category</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!$table['nodata'] && !$table['error']):
            foreach($table['result'] as $ann): ?>
            <tr>
                <td><?= $ann['id']?></td>
                <td><?= $ann['title']?></td>
                <td><?= $ann['shortdesc']?></td>
                <td><?= $ann['author']?></td>
                <td><?= $ann['date']?></td>
                <td><?= $ann['category']?></td>
                <td>
                    <div  class="btn-column">
                        <button class="btn bg-green">
                            <span class="view">
                                View
                            </span>
                        </button>
                        <button class="btn bg-yellow">
                            <span class="edit">
                                Edit
                            </span>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; endif;?>
        </tbody>
    </table>
</div>

<div class="page-nav">
    <?php
    $page = $data['announcements']['page'];
    $size = $page[1];
    $max = $data['announcements']['count'];
    $page_count = ceil($max / $size);
    $current = $page[0] / $size;
    ?>
    <div class="page-nos">
        <?php if($current!=0):?>
            <a href="<?= URLROOT . "/Admin/Announcements?page=0&size=$size" ?>" class="page-btn">&lt;&lt;</a>
            <a href="<?= URLROOT . "/Admin/Announcements?page=".($current - 1)."&size=$size" ?>" class="page-btn">&lt;</a>
        <?php endif; ?>
        <select name="page" onchange="send()" id="page">
            <?php
            $i = 0;
            for (; $i * $size < $max; $i++) : ?>
                <option value="<?= $i ?>" <?= $i==$current?'selected' : ''?>><?= $i + 1 ?></option>
            <?php endfor ?>
        </select>
        <?php if($current<$page_count-1):?>
            <a href="<?= URLROOT . "/Admin/Announcements?page=" . ($current + 1) . "&size=$size" ?>" class="page-btn">&gt;</a>
            <a href="<?= URLROOT . "/Admin/Announcements?page=" . ($page_count - 1) . "&size=$size" ?>" class="page-btn">&gt;&gt;</a>
        <?php endif; ?>
    </div>
    <div class="page-size">
        No.of Posts per page : <select name="size" onchange="send()" id="size">
            <?php foreach ([10, 25, 50, 100] as $page_size) : ?>
                <option value="<?= $page_size ?>" <?= $page_size == $size?'selected':''?>><?= $page_size ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
</form>

</div>