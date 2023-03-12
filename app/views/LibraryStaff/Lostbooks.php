<div class="content">

    <?php
        $table = $data['Books'];
    ?>
    <div class="page">
        <div class="title">
            <?php $page_title = "LOST BOOKS";
            echo '<h2>' . $page_title . '</h2>';
            ?>  
            <input type="button" onclick="generate('#lostBooks','<?php echo $page_title ?>',5)" value="Export To PDF" class="btn bg-lightblue white"/>
        </div>
    </div>

    <?php Pagination::Top('/LibraryStaff/lostbooks', select_filters:[
        'category_name' => [
            'Choose by Category', [
                'All' => "All",
                'Science' => 'Science',
                'Geography' => 'Geography',
            ],
        ],
    ]);?>

    <?php Table::Table(['accession_no' => 'Accession No', 'title' => 'Title', 'author' => 'Author', 'publisher' => "Publisher", 'category_name' => 'Book Category','lost_description' => 'Description'],
        $table['result'], 'lostBooks',
        actions:[
            'Found' => [[URLROOT . '/LibraryStaff/Lostbooks/%s', 'accession_no'], 'btn found bg-green white',['#']],
        ],empty:$table['nodata']
    );?>

    <?php Pagination::bottom('filter-form', $data['Books']['page'], $data['Books']['count']);?>

    </div>
</div>