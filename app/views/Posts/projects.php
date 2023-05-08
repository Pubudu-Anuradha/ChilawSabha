<div class="content">
    <h1>Projects</h1>
    <hr>
<?php
if(($_SESSION['role'] ?? false)== 'Admin'): ?>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Projects/Add'?>" class="btn add bg-green">Add A project</a>
        <a href="<?=URLROOT . '/Admin/Projects'?>" class="btn view bg-blue">Manage Projects</a>
    </div>
<?php endif;
$status_assoc = [];
foreach ($data['status'] ?? [] as $status) {
    $status_assoc[$status['status_id']] = $status['project_status'];
}
Pagination::top('/Posts/Projects', select_filters:[
    'status' => [
        'Project Status', array_merge(['0' => 'All'], $status_assoc),
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
$projects = $data['projects'][0]['result'] ?? [];
$formatter = new IntlDateFormatter(
    'en_US',
    IntlDateFormatter::LONG,
    IntlDateFormatter::SHORT,
);?>
        <div class="posts no-border">
    <?php if (empty($projects)): ?>
        <h2>
            No Projects found
        </h2>
    <?php endif;
foreach ($projects as $proj): ?>
            <div class="post-single">
                <div class="details shadow">
                    <div class="row">
                        <a class="title"
                        href="<?=URLROOT . '/Posts/Project/' . ($proj['post_id'] ?? '0')?>"
                        ><h3>
                            <?php if ($proj['pinned'] == 1): ?>
                                <span class="pinned"></span>
                            <?php endif;?>
                            <?=$proj['title'] ?? 'Not Found'?>
                        </h3>
                        <a class="status <?= $proj['status'] ?? 'err' ?>"
                        href="<?=URLROOT . '/Posts/Projects?status=' . ($proj['status_id'] ?? '0')?>"
                        > <?=$proj['status'] ?? 'Not Found'?>
                    </a>
                    </div>
                    <div class="summary">
                        <?=$proj['short_description'] ?? 'Not Found'?>
                    </div>
                    <div class="row">
                        <?php
                        $date_formatter = new IntlDateFormatter(
                            'en_US',
                            IntlDateFormatter::LONG,
                            IntlDateFormatter::NONE,
                        );
                        $start_date = $proj['start_date'] ? $date_formatter->format(
                            IntlCalendar::fromDateTime($proj['start_date'], null),
                        ) : 'TBA';
                        $expected_end_date = $proj['expected_end_date'] ? $date_formatter->format(
                            IntlCalendar::fromDateTime($proj['expected_end_date'], null),
                        ) : 'TBA';
                        ?>
                        <div class="date">
                            Starting date : <?= $start_date ?>
                        </div>
                        <div class="date">
                            Expected end date : <?= $expected_end_date ?>
                        </div>
                        <?php $budget = $proj['budget'] ? 
                            '<span class="money">' . number_format($proj['budget'],2) . '</span>' : 'TBA' ?>
                        <div class="budget">
                            Budget : <?= $budget ?>
                        </div>
                    </div>
                    <div class="content-truncated-proj">
                        <?php
                        if(isset($data['projects'][1][$proj['post_id']])): 
                            $images = $data['projects'][1][$proj['post_id']];
                            $images = array_map(function($img){
                                return URLROOT . '/public/upload/' . $img['name'];
                            }, $images);
                        ?>
                        <?php endif; ?>
                        <div class="content-trunc">
<?php
$content = $proj['content'];
if (strlen($content) > 200) {
    $content = substr($content, 0, 200);
}
$content .= '... <a href="' .
    URLROOT . '/Posts/Project/' .
    ($proj['post_id'] ?? '0') . '">';
$content .= 'read more';
$content .= '</a>';
echo "&emsp;$content"; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="author">
                            <?=$proj['posted_by'] ?? 'Not found'?>
                        </div>
                        <div class="views">
                            <?=$proj['views']?>
                        </div>
                        <div class="date">
                            <?=$formatter->format(IntlCalendar::fromDateTime($proj['posted_time'] ?? '2022-01-01', null))?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach?>
        </div>
    <?php Pagination::bottom('filter-form', $data['projects'][0]['page'], $data['projects'][0]['count']);?>
</div>