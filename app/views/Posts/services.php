<div class="content">
    <h1>Services</h1>
    <hr>
<?php
if(($_SESSION['role'] ?? false)== 'Admin'): ?>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Services/Add'?>" class="btn add bg-green">Add A service</a>
        <a href="<?=URLROOT . '/Admin/Services'?>" class="btn view bg-blue">Manage Services</a>
    </div>
<?php endif;
Pagination::top('/Posts/Services', select_filters:[
    'category' => [
        'Service service_category', array_merge(['0' => 'All'], $data['categories'] ?? []),
    ],
    'pinned' => [
        'Pinned?', [
            2 => 'All',
            0 => 'not pinned',
            1 => 'pinned',
        ],
    ],
    'sort' => [
        'Posted time' , [
            'DESC' => 'Newest to Oldest',
            'ASC' => 'Oldest to Newest'
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
$services = $data['services'][0]['result'] ?? [];
$formatter = new IntlDateFormatter(
    'en_US',
    IntlDateFormatter::LONG,
    IntlDateFormatter::SHORT,
);?>
        <div class="posts no-border">
    <?php if (empty($services)): ?>
        <h2>
            No Services found
        </h2>
    <?php endif;
foreach ($services as $service): ?>
            <div class="post-single">
                <div class="details shadow">
                    <div class="row">
                        <a class="title"
                        href="<?=URLROOT . '/Posts/Service/' . ($service['post_id'] ?? '0')?>"
                        ><h3>
                            <?php if ($service['pinned'] == 1): ?>
                                <span class="pinned"></span>
                            <?php endif;?>
                            <?=$service['title'] ?? 'Not Found'?>
                        </h3>
                        <a class="service_category <?= $service['service_category'] ?? 'err' ?>"
                        href="<?=URLROOT . '/Posts/Services?service_category=' . ($service['category_id'] ?? '0')?>"
                        > <?=$service['service_category'] ?? 'Not Found'?>
                    </a>
                    </div>
                    <div class="summary">
                        <?=$service['short_description'] ?? 'Not Found'?>
                    </div>
                    <div class="content-truncated-service">
                        <?php
                        if(isset($data['services'][1][$service['post_id']])): 
                            $images = $data['services'][1][$service['post_id']];
                            $images = array_map(function($img){
                                return URLROOT . '/public/upload/' . $img['name'];
                            }, $images);
                        ?>
                        <?php endif; ?>
                        <div class="content-trunc">
<?php
$content = $service['content'];
if (strlen($content) > 200) {
    $content = substr($content, 0, 200);
}
$content .= '... <a href="' .
    URLROOT . '/Posts/Service/' .
    ($service['post_id'] ?? '0') . '">';
$content .= 'read more';
$content .= '</a>';
echo "&emsp;$content"; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="author">
                            <?=$service['posted_by'] ?? 'Not found'?>
                        </div>
                        <div class="views">
                            <?=$service['views']?>
                        </div>
                        <div class="date">
                            <?=$formatter->format(IntlCalendar::fromDateTime($service['posted_time'] ?? '2022-01-01', null))?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach?>
        </div>
    <?php Pagination::bottom('filter-form', $data['services'][0]['page'], $data['services'][0]['count']);?>
</div>