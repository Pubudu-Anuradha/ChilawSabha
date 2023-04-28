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

    <?php Pagination::Top('/LibraryStaff/bookrequest', select_filters:[]);?>

    <?php Table::Table(['email' => 'Email', 'title' => 'Title', 'author' => 'Author', 'isbn' => "ISBN", 'reason' => 'Reason','requested_time' => 'Requested On'],
        $table['result'], 'bookRequests',
        actions:[
            'Add Book' => [[URLROOT . '/LibraryStaff/Addbooks/%s','request_id'], 'btn add bg-lightblue white',['#']],
            'Reject' => [['#'], 'btn reject bg-red white',["openModal('%s','reject_request')",'request_id']]
        ],empty:$table['nodata'],empty_msg:'No Book Requests Recieved'
    );?>

    <?php Modal::Modal(content:'Are You Sure to reject Request ID : ', id:'reject_request',confirmBtn:true);?>


    <?php Pagination::bottom('filter-form', $data['BookRequest']['page'], $data['BookRequest']['count']);?>
</div>

<script>

        var openedModal;

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
