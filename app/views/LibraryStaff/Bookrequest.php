<div class="content">

    <?php
        $table = $data['BookRequest'];
    ?>
    <div class="page">
        <div class="title">
            <?php $page_title = "BOOK REQUESTS";
            echo '<h2>' . $page_title . '</h2>';
            ?>
        </div>
    </div>

    <?php Pagination::Top('/LibraryStaff/bookrequest', select_filters:[
            'type'=>[
                'Filter By Type',[
                    'new'=>'New',
                    'added'=> 'Added',
                    'rejected'=>'Rejected',
                ]
            ]
    ]);?>

    <?php Table::Table(['email' => 'Email', 'title' => 'Title', 'author' => 'Author', 'isbn' => "ISBN", 'reason' => 'Reason','time' => 'Requested On'],
        $table['result'], 'bookRequests',
        actions:[
            'Add Book' => [[URLROOT . '/LibraryStaff/Addbooks/%s','request_id'], 'btn add bg-lightblue white',['#']],
            'Reject' => [['#'], 'btn delist bg-red white',["openModal('%s','reject_request')",'request_id']]
        ],empty:$table['nodata'],empty_msg:'No Book Requests Recieved'
    );?>

    <?php Modal::Modal(content:'Are You Sure to reject Request ID : ', id:'reject_request',confirmBtn:true);?>


    <?php Pagination::bottom('filter-form', $data['BookRequest']['page'], $data['BookRequest']['count']);?>
</div>

<script>

        var openedModal;
        var type = document.getElementById('type');
        var table = document.getElementById('bookRequests');

        if(type.value == 'added'){
            table.rows[0].cells[5].innerHTML = 'Added On';
            table.rows[0].deleteCell(4);
            table.rows[0].deleteCell(5);
            for(let i=1;i<table.rows.length;i++){
                if(table.rows[1].cells.length != 1){
                    table.rows[i].deleteCell(4);
                    table.rows[i].deleteCell(5);
                }  
                else{
                    break;
                }     
            }
        }
        else if(type.value == 'rejected'){
            table.rows[0].cells[5].innerHTML = 'Rejected On';
            table.rows[0].deleteCell(4);
            table.rows[0].deleteCell(5);
            for(let i=1;i<table.rows.length;i++){
                if(table.rows[1].cells.length != 1){
                    table.rows[i].deleteCell(4);
                    table.rows[i].deleteCell(5);
                } 
                else{
                    break;
                }  
            }
        }
    
        function closeModal(){
            openedModal.style.display = "none";
        }
        function openModal(id,modal){
            event.preventDefault();
            openedModal = document.getElementById(modal);
            if(id){
              if(openedModal.querySelector('input[type="number"]')){
                  openedModal.querySelector('input[type="number"]').value = id;
              }
              else{
                  openedModal.querySelector('p').innerText = "Are You Sure To Reject The Book Request" ;
              }
            }
            openedModal.style.display = "block";

            rejectConfirmBtn = openedModal.querySelector('input[type="submit"]');
            rejectConfirmBtn.addEventListener('click',function(){
              rejectConfirmBtn.value = id;
            });
            window.onclick = function(event) {
                if (event.target == openedModal) {
                    openedModal.style.display = "none";
                }
            }
        }



</script>
