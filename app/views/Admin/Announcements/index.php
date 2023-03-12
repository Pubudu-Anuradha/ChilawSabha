<?php // TODO: Make table with announcement titles and options 
require_once 'common.php';
?> 

<div class="content">
    <h1>
        Manage Announcements
    </h1>
    <hr>
    <pre><?php var_dump($data); ?></pre>
    <?php
    Table::Table(['title' => 'Announcement Title','posted_time' => 'Time posted','ann_type'=>'Type'],$data['announcements']['result'] ?? [],actions:[
        'View' => [[URLROOT . '/Admin/Announcements/View/%s','post_id'],'bg-blue view'],
        'Edit' => [['#'],'bg-yellow edit'],
    ],empty_msg:'No announcements available')
    ?>
    <script>
        const data = <?=json_encode($data);?>;
        console.log(data);
    </script>
</div>