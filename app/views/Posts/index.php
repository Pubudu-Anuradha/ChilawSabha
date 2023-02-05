<?php
$post = [
        'title' => 'A special Announcement',
        'category' => 'test',
        'shortdesc' => 'This is a very special announcement about something.',
        'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque optio
 consequuntur consequatur voluptates repellendus eos aliquam? Eaque dolor esse
 debitis velit voluptatibus voluptates saepe reiciendis numquam sunt distinctio
 natus dicta est fuga quisquam eveniet, nostrum quos neque dolorum, non
 aliquam. Expedita possimus nam sapiente fuga? Illum voluptates eligendi
 quisquam et assumenda! Esse dicta earum corporis quam illo rem ipsam soluta
 alias omnis tenetur, cum, sequi sunt incidunt, in corrupti nam facere
 accusantium deleniti laboriosam officia eius modi officiis suscipit. Magnam
 laborum debitis molestias dolorum facere. Nostrum, provident! Possimus fuga
 praesentium velit numquam in odit corrupti! Odio rerum voluptate doloribus!
 Cum!',
        'author' => 'Sarindu Thampath',
        'date' => '2023-01-23',
    ];
$posts = [
    $post,$post,
    $post,$post,
    $post,$post,
    $post,$post,
    $post,$post,
]
?>
<div class="cat-title">
    Announcements
</div>
<hr />
<div class="filters">
    <form action="<?=URLROOT . '/Posts'?>" method="get">
        <div class="filter">
            <label for="search">
                Search
            </label>
            <input type="search" name="search" id="search">
        </div>
        <div class="filter">
            <label for="category">
                Filter by Category
            </label>
            <select name="category" id="category">
                <option value="All">
                    All
                </option>
                <option value="test">
                    test
                </option>
            </select>
        </div>
        <div class="filter">
            <label for="sort">
                Sort by date
            </label>
            <select name="sort" id="sort">
                <option value="DESC">
                    Newest to Oldest
                </option>
                <option value="ASC">
                    Oldest to Newest
                </option>
            </select>
        </div>
    </form>
</div>
<div class="posts">
    <?php foreach($posts as $post): ?>
        <div class="post shadow">
            <div class="title">
                <a href="#"><?=$post['title']?></a>
            </div>
            <hr>
            <div class="shortdesc">
                <?=$post['shortdesc']?>
            </div>
            <div class="details">
                <div class="author">
                    <?=$post['author']?>
                </div>
                <div class='date'>
                    <?=implode('/',explode('-',$post['date']))?>
                </div>
                <div class='category'>
                    <a href="#">
                        <?=$post['category']?>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>