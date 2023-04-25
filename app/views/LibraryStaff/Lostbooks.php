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
            <?php $page_title = "LOST BOOKS";
            echo '<h2>' . $page_title . '</h2>';
            ?>
            <input type="button" onclick="generate('#lostBooks','<?php echo $page_title ?>',5)" value="Export To PDF" class="btn bg-lightblue white"/>
        </div>
    </div>

    <?php Pagination::Top('/LibraryStaff/lostbooks', select_filters:[
        'category_name' => [
            'Choose by Category', $category_arr,
        ],
    ]);?>

    <?php Table::Table(['accession_no' => 'Accession No', 'title' => 'Title', 'author' => 'Author', 'publisher' => "Publisher", 'category_name' => 'Book Category','lost_description' => 'Description'],
        $table['result'], 'lostBooks',
        actions:[
            'Found' => [['#'], 'btn found bg-green white',["openModal(%s,'found_description')",'accession_no']],
        ],empty:$table['nodata']
    );?>

    <?php Modal::Modal(textarea:true, title:"Add Description", name:'found_description', id:'found_description', rows:10, cols:50, required:true, textTitle:'Book Accession No', textId:'found_accession_no');?>


    <?php Pagination::bottom('filter-form', $data['Books']['page'], $data['Books']['count']);?>

    </div>
</div>

<script>
        var openedModal;
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

        function closeModal(){
            openedModal.style.display = "none";
        }
        function openModal(id,modal){
            event.preventDefault();
            openedModal = document.getElementById(modal);
            openedModal.querySelector('input[type="number"]').value = id;
            openedModal.style.display = "block";

            window.onclick = function(event) {
                if (event.target == openedModal) {
                    openedModal.style.display = "none";
                }
            }
        }
</script>
