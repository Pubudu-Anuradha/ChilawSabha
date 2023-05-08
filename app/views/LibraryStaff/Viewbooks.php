<div class="content">
<?php

$id = $data['acc'];
$books = $data['books'];
$edit_history = $data['edit_history'] ?? false;
$state_history = $data['state_history'] ?? false;
$lost_error = $data['lost_error'] ?? false;
$delist_error = $data['delist_error'] ?? false;
$found_error = $data['found_error'] ?? false;
$damage_error = $data['damage_error'] ?? false;
$recondition_error = $data['recondition_error'] ?? false;
$post = $books;
$fields = [
    'title' => "Title",
    'author' => 'Author',
    'publisher' => 'Publisher',
    'price' => 'Price',
    'pages' => 'No of Pages',
];

if($books!==false):
?>
<div class="card-container">

<div class="card">
    <h1>Book Details</h1>
    <hr>
    <div class="book-details">
        <div class="detail">
            <span class="accno"> Accession No </span>
            <span> <?= $books['accession_no'] ?? 'NO ACCESSION NUMBER ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="book-title"> Title </span>
            <span> <?= $books['title'] ?? 'NO TITLE ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="author"> Author </span>
            <span> <?= $books['author'] ?? 'NO AUTHOR ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="isbn"> ISBN </span>
            <span> <?= $books['isbn'] ?? 'NO ISBN ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="category"> Category </span>
            <span> <?= $books['category_name'] ?? 'NO CATEGORY ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="sub-category"> Sub Category </span>
            <span> <?= $books['sub_category_name'] ?? 'NO SUB CATEGORY ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="pages"> Pages </span>
            <span> <?= $books['pages'] ?? 'NO PAGES ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="price"> Price </span>
            <span> <?= $books['price'] ?? 'NO PRICE ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="placeofpub"> Place of Publication </span>
            <span> <?= $books['place_of_publication'] ?? 'NO PLACE OF PUBLICATION ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="dateofpub"> Date of Publication </span>
            <span> <?= $books['date_of_publication'] ?? 'NO DATE OF PUBLICATION ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="recmethod"> Recieved Method </span>
            <span> <?= $books['recieved_method'] ?? 'NO RECIEVED METHOD ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="recdate"> Recieved Date </span>
            <span> <?= $books['recieved_date'] ?? 'NO RECIEVED DATE ERROR' ?> </span>
        </div>
        <div class="detail">
            <span class="state"> Current State </span>
            <span class="state-name"> <?= $books['status'] ?? 'UNKNOWN STATE ERROR' ?> </span>
        </div>

        <form class="fullForm" method="post">
        <div class="options">
            <?php if($books['status'] ?? false):
                    if($books['status'] != 'De-Listed'):?>
                <a href="<?=URLROOT . '/LibraryStaff/Editbooks/' . ($id ?? '') ?>" class="btn edit bg-yellow">
                Edit
                </a>
            <?php endif;endif; ?>
                <?php switch($books['status'] ?? false) {
                case 'Available': ?>
                        <button onclick="openModal(<?=$id?>,'lost_description')" class="btn lost bg-red white">
                            Lost
                        </button>
                        <button onclick="openModal(<?=$id?>,'damage_description')" class="btn damage bg-lightblue white">
                            Damaged
                        </button>
                        <button onclick="openModal(<?=$id?>,'delist_description')" class="btn delist bg-orange white">
                            Delist
                        </button>
                        <?php Modal::Modal(textarea:true, title:"Add Description", name:'lost_description', id:'lost_description', rows:10, cols:50, required:true, textTitle:'Book Accession No', textId:'lost_accession_no');?>
                        <?php Modal::Modal(textarea:true, title:"Add Description", name:'delist_description', id:'delist_description', rows:10, cols:50, required:true, textTitle:'Book Accession No', textId:'delist_accession_no');?>
                        <?php Modal::Modal(textarea:true, title:"Add Description", name:'damage_description', id:'damage_description', rows:10, cols:50, required:true, textTitle:'Book Accession No', textId:'damage_accession_no');?>
                    <?php
                        break;
                case 'Lost': ?>
                        <button onclick="openModal(<?=$id?>,'found_description')" class="btn found bg-green white">
                            Found
                        </button>
                        <?php Modal::Modal(textarea:true, title:"Add Description", name:'found_description', id:'found_description', rows:10, cols:50, required:true, textTitle:'Book Accession No', textId:'found_accession_no');?>
                    <?php
                        break;
                case 'Damaged': ?>
                        <button onclick="openModal(<?=$id?>,'recondition_description')" class="btn recondition bg-green white">
                            Repaired
                        </button>
                        <?php Modal::Modal(textarea:true, title:"Add Description", name:'recondition_description', id:'recondition_description', rows:10, cols:50, required:true, textTitle:'Book Accession No', textId:'recondition_accession_no');?>   
                    <?php
                        break;
                default: ?>
                    <?php
                        break;
                } ?>

        </div>

        <?php if ($lost_error) {
            $message = "There was an error while Marking as Lost";
            Errors::generic($message);
        }
        if ($delist_error) {
            $message = "There was an error while Marking as Delisted";
            Errors::generic($message);
        }
        if ($found_error) {
            $message = "There was an error while Marking as Found";
            Errors::generic($message);
        }
        if ($damage_error) {
            $message = "There was an error while Marking as Damaged";
            Errors::generic($message);
        }
        if ($recondition_error) {
            $message = "There was an error while Marking as Reconditioned";
            Errors::generic($message);
        }
        ?>

        </form>
    </div>
</div>
    <?php
    if($edit_history !== false && count($edit_history) !== 0): ?>
        <div class="edit-history card">
            <h2>Book Edit History</h2>
            <hr>
    <?php
        $i = 0;
        foreach($edit_history as $edit):
            foreach($fields as $field => $name):
                if($edit[$field] !== null && $edit[$field] !== $post[$field]): ?>
                <div class="record b<?= ($i++%2==1) ? '-alt':'' ?>">
                    on <span class="time"> <?= $edit['time'] ?> </span> :
                    <?= $edit['changed_by'] ?> changed the field <b><?= $name ?></b> from
                    "<?= $edit[$field] ?>" to "<?=$post[$field]?>".
                </div>
                    <?php $post[$field] = $edit[$field];
                endif;
            endforeach;
        endforeach;
    endif;
    ?>
        </div>
    <?php
    if($state_history !== false && count($state_history) !== 0): ?>
        <div class="state-history card">
            <h2>Book State Change History</h2>
            <hr>
    <?php
        $i = 0;
        foreach($state_history as $state_change): ?>
        <?php if($state_change['l_reason'] ?? false):?>
          <?php if(!is_null($state_change['f_reason'])): ?>
            <div class="record<?= ($i++%2==0) ? ' b':''?>">
              on <span class="time">
                  <?= $state_change['f_time'] ?? 'NO TIMESTAMP ERROR' ?>
              </span> :
                <?= $state_change['f_name'] ?? 'NO RE-ENABLER ERROR' ?>
                 Mark the book as found citing the reason
                 "<b><?= $state_change['f_reason'] ?? 'NO REASON ERROR' ?></b>".
            </div>
          <?php endif; ?>
            <div class="record<?= ($i++%2==0) ? ' b':'' ?>">
              on <span class="time">
                  <?= $state_change['l_time'] ?? 'NO TIMESTAMP ERROR' ?>
              </span> :
                <?= $state_change['l_name'] ?? 'NO DISABLER ERROR' ?>
                 Mark the book as lost citing the reason
                 "<b><?= $state_change['l_reason'] ?? 'NO REASON ERROR' ?></b>".
            </div>
        <?php endif; ?>

        <?php if ($state_change['dm_reason'] ?? false): ?>
          <?php if (!is_null($state_change['rc_reason'])): ?>
            <div class="record<?=($i++ % 2 == 0) ? ' b' : ''?>">
              on <span class="time">
                  <?=$state_change['rc_time'] ?? 'NO TIMESTAMP ERROR'?>
              </span> :
                <?=$state_change['rc_name'] ?? 'NO RE-ENABLER ERROR'?>
                 Mark the book as reconditioned citing the reason
                 "<b><?=$state_change['rc_reason'] ?? 'NO REASON ERROR'?></b>".
            </div>
          <?php endif;?>
            <div class="record<?=($i++ % 2 == 0) ? ' b' : ''?>">
              on <span class="time">
                  <?=$state_change['dm_time'] ?? 'NO TIMESTAMP ERROR'?>
              </span> :
                <?=$state_change['dm_name'] ?? 'NO DISABLER ERROR'?>
                 Mark the book as damaged citing the reason
                 "<b><?=$state_change['dm_reason'] ?? 'NO REASON ERROR'?></b>".
            </div>
        <?php endif;?>

        <?php if ($state_change['de_reason'] ?? false): ?>
            <div class="record<?=($i++ % 2 == 0) ? ' b' : ''?>">
              on <span class="time">
                  <?=$state_change['de_time'] ?? 'NO TIMESTAMP ERROR'?>
              </span> :
                <?=$state_change['de_name'] ?? 'NO DISABLER ERROR'?>
                 Mark the book as de-list citing the reason
                 "<b><?=$state_change['de_reason'] ?? 'NO REASON ERROR'?></b>".
            </div>
        <?php endif;?>
    <?php
        endforeach;
    endif;
    ?>
        </div>
</div>
<?php else: ?>
<h1>
  ERROR RETRIEVING BOOK INFORMATION
</h1>
<?php endif; ?>
</div>

<script>
    expandSideBar("sub-items-serv","see-more-bk");
    var openedModal;

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
