<div class="content">
    <!-- <pre><?php var_dump($data)?></pre> -->
    <h1>Announcements</h1>
    <hr>
    <?php // TODO: remake all announcements view
    $types_assoc = [];
    foreach($data['types'] ?? [] as $type) {
        if($type['ann_type'] !== 'All')
            $types_assoc[$type['ann_type_id']] = $type['ann_type'];
    }
    Pagination::top('/Posts/Announcements',select_filters:[
        'category' =>[
            'Announcement type' , array_merge(['0' => 'All'] , $types_assoc)
        ],
        'pinned' => [
            'Pinned?' ,[
                2 => 'All',
                0 => 'not pinned',
                1 => 'pinned'
            ]
        ]
    ]);
    ?>
    <style>
        .sabha-img{
            background: url("<?=URLROOT . '/public/assets/logo.jpg'?>");
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
        }
    </style>
    <?php
    $announcements = $data['ann']['result'] ?? [];
    $formatter = new IntlDateFormatter(
        'en_US',
        IntlDateFormatter::LONG,
        IntlDateFormatter::SHORT,
    ); ?>
        <div class="posts no-border">
    <?php if(empty($announcements)): ?>
        <h2>
            No Announcements found
        </h2>
    <?php endif;
        foreach($announcements as $ann): ?>
            <div class="post-single">
                <div class="details shadow">
                    <div class="row">
                        <a class="title"
                        href="<?= URLROOT . '/Posts/Announcement/' . ($ann['post_id'] ?? '0')?>"
                        ><h3>
                            <?php if($ann['pinned']==1):?>
                                <span class="pinned"></span>
                            <?php endif; ?>
                            <?= $ann['title'] ?? 'Not Found' ?>
                        </h3>
                        <a class="category"
                        href="<?= URLROOT . '/Posts/Announcements?category=' . ($ann['t_id'] ?? '0')?>"
                        > <?= $ann['ann_type'] ?? 'Not Found' ?>
                    </a>
                    </div>
                    <div class="summary">
                        <?= $ann['short_description'] ?? 'Not Found' ?>
                    </div>
                    <div class="content-truncated">
                        <?php
                            $content = $ann['content'];
                            if(strlen($content) > 200) {
                                $content = substr($content,0,200);
                            }
                            $content .= '... <a href="'.
                                URLROOT . '/Posts/Announcement/' .
                                ($ann['post_id'] ?? '0') .'">';
                            $content .= 'read more';
                            $content .= '</a>';
                            echo "&emsp;$content";
                        ?>
                    </div>
                    <div class="row">
                        <div class="author">
                            <?= $ann['posted_by'] ?? 'Not found' ?>
                        </div>
                        <div class="views">
                            <?= $ann['views'] ?>
                        </div>
                        <div class="date">
                            <?= $formatter->format(IntlCalendar::fromDateTime($ann['posted_time'] ?? '2022-01-01',null)) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        </div>
    <?php Pagination::bottom('filter-form',$data['ann']['page'],$data['ann']['count']); ?>
</div>