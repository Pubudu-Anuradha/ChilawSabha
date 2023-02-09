<div class="content">
    <h1>
        Manage Events
    </h1>
    <hr>
<div class="filters">
    <form method="get" id="filterform">
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

<div class="content-table">
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>title</th>
                <th>date</th>
                <th>contact</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            <?php for($i=0;$i<=25;++$i): ?>
            <tr>
                <td><?= $i ?></td>
                <td>Event <?= $i ?></td>
                <td>2020-12-13</td>
                <td>0325681285</td>
                <td>
                    <div  class="btn-column">
                        <a class="btn bg-green  view"href="">View</a>
                        <a class="btn bg-red delist"href="">Delete</a>
                    </div>
                </td>
            </tr>
            <?php endfor;?>
        </tbody>
    </table>
</div>

<div class="page-nav">
    <?php
    $page = [0,10];
    $size = $page[1];
    $max = 100;
    $page_count = ceil($max / $size);
    $current = $page[0] / $size;
    ?>
    <div class="page-nos">
        <?php if($current!=0):?>
            <a href="#" class="page-btn">&lt;&lt;</a>
            <a href="#" class="page-btn">&lt;</a>
        <?php endif; ?>
        <select name="page" onchange="send()" id="page">
            <?php
            $i = 0;
            for (; $i * $size < $max; $i++) : ?>
                <option value="<?= $i ?>" <?= $i==$current?'selected' : ''?>><?= $i + 1 ?></option>
            <?php endfor ?>
        </select>
        <?php if($current<$page_count-1):?>
            <a href="#" class="page-btn">&gt;</a>
            <a href="#" class="page-btn">&gt;&gt;</a>
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