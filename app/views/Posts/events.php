<div class="content">
    <h1>
        Events
    </h1>
<?php if($_SESSION['role']??false === 'Admin'):?>
    <div class="btn-column">
        <a href="<?=URLROOT . '/Admin/Events/Add'?>" class="btn add bg-green">Add An Event</a>
        <a href="<?=URLROOT . '/Admin/Events'?>" class="btn view bg-blue">Manage Events</a>
    </div>
<?php endif;
Pagination::top('/Posts/Events', select_filters:[
    'pinned' => [
        'Pinned?', [
            2 => 'All',
            0 => 'not pinned',
            1 => 'pinned',
        ],
    ],
    'time' => [
        'Event Time', [
            0 => 'All',
            1 => 'Past',
            2 => 'Future'
        ]
    ]
]);
$events = $data['events'][0]['result'] ?? [];
$formatter = new IntlDateFormatter(
    'en_US',
    IntlDateFormatter::LONG,
    IntlDateFormatter::SHORT,
);?>
        <div class="posts no-border">
    <?php if (empty($events)): ?>
        <h2>
            No events found
        </h2>
    <?php endif;
foreach ($events as $event): ?>
            <div class="post-single">
                <div class="details shadow">
                    <div class="row">
                        <a class="title"
                        href="<?=URLROOT . '/Posts/Event/' . ($event['post_id'] ?? '0')?>"
                        ><h3>
                            <?php if ($event['pinned'] == 1): ?>
                                <span class="pinned"></span>
                            <?php endif;?>
                            <?=$event['title'] ?? 'Not Found'?>
                        </h3>
                    </a>
                    </div>
                    <div class="summary">
                        <?=$event['short_description'] ?? 'Not Found'?>
                    </div>
                    <div class="row">
                        <?php
                        $start_time = $event['start_time'] ? $formatter->format(
                            IntlCalendar::fromDateTime($event['start_time'], null),
                        ) : 'TBA';
                        $end_time = $event['end_time'] ? $formatter->format(
                            IntlCalendar::fromDateTime($event['end_time'], null),
                        ) : 'TBA';
                        ?>
                        <div class="date">
                            Starting Time : <?= $start_time ?>
                        </div>
                        <?php if($end_time != 'TBA'): ?>
                        <div class="date">
                            End Time : <?= $end_time ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="content-truncated">
                        <?php
$content = $event['content'];
if (strlen($content) > 200) {
    $content = substr($content, 0, 200);
}
$content .= ' ...<a href="' .
    URLROOT . '/Posts/Event/' .
    ($event['post_id'] ?? '0') . '">';
$content .= 'read more';
$content .= '</a>';
echo "&emsp;$content";
?>                  </div>
                    <div class="row">
                        <div class="author">
                            <?=$event['posted_by'] ?? 'Not found'?>
                        </div>
                        <div class="views">
                            <?=$event['views']?>
                        </div>
                        <div class="date">
                            <?=$formatter->format(IntlCalendar::fromDateTime($event['posted_time'] ?? '2022-01-01', null))?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach?>
        </div>
    <?php Pagination::bottom('filter-form', $data['events'][0]['page'], $data['events'][0]['count']);?>
</div>
</div>