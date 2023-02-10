<div class="content">
    <?php if($data['announcement'] ):
            if($data['announcement']['error'] || $data['announcement']['nodata']):?>
                <h1>
                    <?=$data['announcement']['nodata']?'Announcement Not found':
                    $data['announcement']['errmsg']?>
                </h1>
            <?php else: 
            $ann = $data['announcement']['result'][0];?>

                <h1><?=$ann['title']?></h1>
                <hr>
                <a class="btn bg-yellow edit"href="<?=URLROOT . '/Admin/Announcements/Edit/'.$ann['id']?>">Edit</a>
                <h3>Category : <?=$ann['category']?> </h3>
                           
                <h3>Short description</h3>
                    <?=$ann['shortdesc']?>
                <h3>Author</h3>
                    <?=$ann['author']?>
                <h2>Announcement Contents</h2>
                    <?=$ann['description']?>
        <?php endif; ?>
        <?php else: ?>
        <h1>
            NO ANNOUNCEMENT ID
        </h1>
        <?php endif; ?>
</div>