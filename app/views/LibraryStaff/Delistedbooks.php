<div class="content">

    <?php
        $table = $data['Books'];
        $categories = $data['Category']['result'] ?? [];
        $category_arr = ['All' => "All"];
        foreach ($categories as $category){
            $category_arr[$category['category_id']] = $category['category_name'];
        }
    ?>
    <div class="page">
        <div class="title">
            <?php $page_title = "DE-LISTED BOOKS";
            echo '<h2>' . $page_title . '</h2>';
            ?>
            <input type="button" onclick="generate('#delistedBooks','<?php echo $page_title ?>',5)" value="Export To PDF" class="btn bg-lightblue white"/>
        </div>
    </div>

    <?php Pagination::Top('/LibraryStaff/delistedbooks', select_filters:[
        'category_name' => [
            'Choose by Category', $category_arr,
        ],
    ]);?>

    <?php Table::Table(['accession_no' => 'Accession No', 'title' => 'Title', 'author' => 'Author', 'publisher' => "Publisher", 'category_name' => 'Book Category','delist_description' => 'Description'],
        $table['result'], 'delistedBooks',
        actions:[],empty:$table['nodata']
    );?>

    <?php Pagination::bottom('filter-form', $data['Books']['page'], $data['Books']['count']);?>
</div>

<script>

        expandSideBar("sub-items-serv","see-more-bk");

        function generate(id,title,num_of_cloumns) {

            var doc = new jsPDF('p', 'pt', 'a4');

            var text = title;
            var txtwidth = doc.getTextWidth(text);

            var x = (doc . internal . pageSize . width - txtwidth) / 2;

            doc.text(x, 50, text);
            //to define the number of columns to be converted
            var columns = [];
            for(let i=0; i<num_of_cloumns; i++){
                columns.push(i);
            }

            doc.autoTable({
                html: id,
                startY: 70,
                theme: 'striped',
                columns: columns,
                columnStyles: {
                    halign: 'left'
                },
                styles: {
                    minCellHeight: 30,
                    halign: 'center',
                    valign: 'middle'
                },
                margin: {
                    top: 150,
                    bottom: 60,
                    left: 10,
                    right: 10
                }
            })
            doc.save(title.concat('.pdf'));
        }
</script>
