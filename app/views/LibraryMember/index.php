<div class="content">
    <?php $userStat = $data['userStat']['result'] ?? ''; ?>

    <div class="head-area">
        <div class="sub-head-area">
            <h1>WELCOME TO CHILAW PUBLIC LIBRARY</h1>
        </div>
        <hr>    
    </div>
    <div class="dashboard-mid-area">
        <div class="fine-container">
            <h2>Fine Amount</h2>
            <div class="fine-sub">
                <img src=<?= URLROOT . '/public/assets/fine.png' ?> alt='Fine Image'>
                <div id="fineCal"></div>
            </div>
        </div>
        <div class="request-container">
            <h2>Request Book</h2>
            <button class="btn request" onclick="window.location='<?= URLROOT . '/LibraryMember/bookRequest' ?>'"><img src=<?= URLROOT . '/public/assets/addcomplaint.png' ?> alt='Book Request Image'></button>
        </div>
        <div class="new-and-suggest">
            <h2>New Books</h2>
            <?php
                //Table::Table(['title' => 'Title', 'author' => 'Author'], $data['newBooks']['result'] ?? [], 'new-books-id', actions:[], empty:!(count($data['newBooks']['result']) > 0), empty_msg:'No new books');
                $empty_new = !(count($data['newBooks']['result']) > 0);
                if(!$empty_new){
                    $rows = $data['newBooks']['result'] ?? [];
                    foreach($rows as $row){
            ?>
                        <ul>
                            <li><?= $row['title'] . ' ( ' . $row['author'] . ' )' ?></li>
                        </ul>
            <?php
                    }
                }
            ?>
        </div>
        <div class="new-and-suggest">
            <h2>Suggested Books</h2>
            <?php
                $empty_new = !(count($data['sugBooks']) > 0);
                if(!$empty_new):
                    $rows = $data['sugBooks'] ?? [];
                    foreach($rows as $row):
            ?>
                        <ul>
                            <li><?= $row['title'] . ' ( ' . $row['author'] . ' )' ?></li>
                        </ul>
            <?php
                    endforeach;
                else:
            ?>
                    <p style="text-align:center; font size: 1.2rem">No suggested books</p>  
            <?php
                endif;
            ?>
        </div>
    </div>
    <div class="dashboard-bottom-area">
        <div class="dashboard-bottom-sub">
            <h2>Borrowed Books Section</h2>
            <button class="extend" onclick="extendDueDate('extendBtn', <?php echo htmlspecialchars(json_encode($userStat)); ?>)">Extend Due Date</button>
            <?php Modal::Modal(content:'Are You Sure?',name:'extendBtn', id:'extendBtn', confirmBtn:true); ?>
            <?php Modal::Modal(content:'Couldn\'t extend due date. Try again later.',name:'errorModal', id:'errorModal'); ?>
        </div>
        <hr>
        <?php 
            Table::Table(['accession_no' => 'Accession No', 'title' => 'Title', 'author' => 'Author', 'publisher' => 'Publisher', 'due_date' => 'Due Date'], $data['books']['result'] ?? [], 'borrow-books-id', actions:[], empty:!(count($data['books']['result']) > 0), empty_msg:'No currently borrowed books');
        ?>
    </div>
</div>

<script>
    var newModal;

    window.onload = async function(){
        var data = <?php echo ((isset($userStat[0]['due_date']) && !isset($userStat[0]['recieved_date'])) ? json_encode($userStat) : 0);?>;
        var Amount = await calculateFine(data);
        if(Amount>0){
            fineCal.innerText = "Rs."+Amount;
        }else{
            fineCal.innerText = "Rs."+Amount+".00";
        }
    }

    function selectText(event){
        event.target.select();
    }

    async function calculateFine(data){
        var delay_after_fine,delay_month_fine;

        if(data != 0){
            try{
                const response = await fetch("<?=URLROOT . '/LibraryMember/getFine'?>",{
                    method:"POST",
                    headers: {
                        "Content-type":"application/json"
                    }
                });
                const fineData = await response.json();
                if(fineData.length > 0){
                    delay_after_fine = parseFloat(fineData[0]['result'][0]['delay_after_fine']);
                    delay_month_fine = parseFloat(fineData[0]['result'][0]['delay_month_fine']);
                }
            }catch(err) {
                delay_after_fine = 0;
                delay_month_fine = 0;
            };

            const today = new Date();
            const dateString = data[0]['due_date'];
            const dateParts = dateString.split('-');
            const due_date = new Date(dateParts[0], dateParts[1] - 1, dateParts[2], 23, 60, 00);
            const mili_sec_per_day = 1000 * 60 * 60 * 24;
            const timeDiff = today.getTime() - due_date.getTime();
            const diffInDays = Math.ceil(timeDiff / mili_sec_per_day);

            //due date comparison
            if(timeDiff > 0){
                var fineAmount=0;

                //for less than or equal to 1month(30 days)
                if(diffInDays <= 30){
                    fineAmount = diffInDays * delay_month_fine;
                }
                //more than 1 month
                else{
                    fineAmount = (30 * delay_month_fine) + ((diffInDays-30)*delay_after_fine);
                }
            }else{
                fineAmount = 0;
            }
            return fineAmount;
        }else{
            fineAmount = 0;
            return fineAmount;
        }
    }

    function closeModal(){
        newModal.style.display = "none";
    }


    function extendDueDate(modal, data=null){
        event.preventDefault();
        if(data.length != 0){
            newModal = document.getElementById(modal);

            if(data.length>0 && ((data[0]['recieved_date'] != null && data[0]['due_date'] != null) || data[0]['due_date'] == null)){
                modal = 'errorModal';
                newModal = document.getElementById(modal);
                newModal.querySelector('p').innerText = "You don't have currently Borrowed Books";
                newModal.style.display = "block";
            }else{
                var today = new Date();
                const dateString = data[0]['due_date'];
                const dateParts = dateString.split('-');
                const due_date = new Date(dateParts[0], dateParts[1] - 1, dateParts[2], 23, 60, 00);
                const mili_sec_per_day = 1000 * 60 * 60 * 24;
                const timeDiffer = today.getTime() - due_date.getTime();
                const differInDays = Math.ceil(timeDiffer / mili_sec_per_day);
                                
                if(differInDays == 0){
                    var accessions = {
                        'value1':data[0]['accession_no'],
                        'value2':data[1]['accession_no'],
                        'searchID':'extendedCount'
                    }

                    fetch("<?=URLROOT . '/LibraryMember/index'?>",{
                        method:"POST",
                        headers: {
                            "Content-type":"application/json"
                        },
                        body: JSON.stringify(accessions)
                    })
                    .then(response => response.json())
                    .then(response => {
                        if((response[0]['extendCount'].length == 2) && (response[0]['planToReadCount'].length == 2)){
                            extended_count_1 = response[0]['extendCount'][0]['result'][0]['extended_time'];
                            extended_count_2 = response[0]['extendCount'][1]['result'][0]['extended_time'];

                            if(extended_count_1<3 && extended_count_2<3 && (extended_count_1==extended_count_2)){
                                newModal.querySelector('p').innerText = "Proceed to Extend Due Date";
                            }else if (extended_count_1 >= 3 || extended_count_2 >=3){
                                modal = 'errorModal';
                                newModal = document.getElementById(modal);
                                newModal.querySelector('p').innerText = "You Have Exceeded the Extend Count";
                            }
                            newModal.style.display = "block";
                        }
                    })
                    .catch(err => {
                        modal = 'errorModal';
                        newModal = document.getElementById(modal);
                        newModal.querySelector('p').innerText = "Data Retrieving Error";
                        newModal.style.display = "block";
                    });
                }else if(differInDays <= -1){
                    modal = 'errorModal';
                    newModal = document.getElementById(modal);
                    newModal.querySelector('p').innerText = "Please Extend On Due Date";
                    newModal.style.display = "block";
                }else if(timeDiffer > 0){
                    modal = 'errorModal';
                    newModal = document.getElementById(modal);
                    newModal.querySelector('p').innerText = "Due Date Passed";
                    newModal.style.display = "block";
                }

            }
        }else{
            modal = 'errorModal';
            newModal = document.getElementById(modal);
            newModal.style.display = "block";
        }

        window.onclick = function(event) {
            if (event.target == newModal) {
                openedModal.style.display = "none";
            }
        }
    }
</script>