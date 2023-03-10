<div class="content">

    <?php
        $table = $data['Books'];
    ?>

    <div class="page">
        <div class="title">
            <?php $page_title = "BOOK CATALOGUE";
            echo '<h2>' . $page_title . '</h2>';
            ?>  
            <input type="button" onclick="generate('#bookCatalog','<?php echo $page_title ?>',5)" value="Export To PDF" class="btn bg-lightblue white"/>
        </div>
    </div>

        <?php Pagination::Top('/LibraryStaff/bookcatalog', select_filters:[
            'category_name' =>[
                'Choose by Category' , [
                    'All' => "All",
                    'Science' => 'Science',
                    'Geography' => 'Geography',
                ]
            ]
        ]);?>

        <?php Table::Table(['accession_no'=>'Accession No','title'=>'Title','author'=>'Author','publisher'=>"Publisher",'category_name'=>'Book Category'],
            $table['result'],'bookCatalog',
            actions:[
                'Edit'=>[[URLROOT.'/LibraryStaff/Editbooks/%s','accession_no'],'btn edit bg-yellow white'],
                'Lost'=>[['#'],'btn lost bg-red white','openModal()'],
                'Delist'=>[[URLROOT.'/LibraryStaff/Delist/%s','accession_no'],'btn delist bg-orange white'],
            ]
    
        );?>
        <?php Modal::Modal(content:'Are You Sure?', textarea:true, title:"Please add a Note", rows:10, cols:50);?>


        <?php Pagination::bottom('filter-form',$data['Books']['page'],$data['Books']['count']);?>


    </div>
</div>

<script>
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

        var modal = document.getElementById("myModal");

        function closeModal(){
            modal.style.display = "none";
        }
        function openModal(){
            modal.style.display = "block";
        }

        window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        }

</script>