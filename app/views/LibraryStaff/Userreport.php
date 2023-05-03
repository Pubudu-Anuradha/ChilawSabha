<?php
    $userStat = $data['userStat']['result'] ?? null;
    $table = $data['fine_details'] ?? false;
    $transactions = $data['transaction']['result'] ?? false;
    $transaction_num = 0;
    if ($transactions):
        foreach ($transactions as $transaction):
            if ($transaction['recieved_date'] == null && $transaction['recieved_by'] == null):
                $transactions[$transaction_num]['state'] = 'Not Recieved';
                $transactions[$transaction_num]['recieved_date'] = 'Yet To Recieve';
                $transactions[$transaction_num]['recieved_by'] = 'Yet To Recieve';
            elseif ($transaction['damage'] == 1):
                $transactions[$transaction_num]['state'] = 'Damaged';
            elseif ($transaction['lost'] == 1):
                $transactions[$transaction_num]['state'] = 'Lost';
            else:
                $transactions[$transaction_num]['state'] = 'Recieved';
            endif;
            $transaction_num = $transaction_num + 1;
        endforeach;
    endif;

?>

<div class="content">
    <div class="page">
        <div class="find-user">
            <form action="<?=URLROOT . '/LibraryStaff/userreport' ?>" method="post" id="Form">
                <div class="usr-search">
                    <div class="search-bar">
                        <input type="search" name="search" placeholder=" Search User" id="search" value="<?= $_POST['search'] ?? ((isset($userStat[0]['membership_id']) && isset($userStat[0]['name'])) ? $userStat[0]['membership_id'] ." ". $userStat[0]['name'] : '') ?>" onkeyup="searchUser()" onfocus="selectText(event)">
                        <button name='search-btn' id='searchBtn'>
                            <img src="<?= URLROOT . '/public/assets/search.png' ?>" alt="search btn">
                        </button>
                    </div>

                    <div id ="usr-search-list" class="usr-search-list"></div>
                </div>
            </form>

<script>
    var user = document.getElementById('search');

   function searchUser(){
        var searchDiv = document.getElementById('usr-search-list');
        var userVal = {
        'value':user.value,
        'searchID':'userSearch'
        }

        fetch("<?=URLROOT . '/LibraryStaff/userreport'?>",{
            method:"POST",
            headers: {
                "Content-type":"application/json"
            },
            body: JSON.stringify(userVal)
        })
        .then(response => response.json())
        .then(response => {
            if(response.length > 0){
                searchDiv.innerHTML = '';
                var i = 0;
                response[0].forEach(result => {
                    const searchResultDiv = document.createElement('div');
                    searchResultDiv.classList.add('search-result');
                    searchResultDiv.innerHTML = response[0][i]['membership_id'] + " " + response[0][i]['name'];

                    searchResultDiv.addEventListener('click', () => {
                        user.value = searchResultDiv.innerText;
                        searchDiv.innerHTML = '';
                    });
                    window.addEventListener('click', () => {
                        searchDiv.innerHTML = '';
                    });
                    searchDiv.append(searchResultDiv);
                    i++;
                });
            }
        })
        .catch(err => {
            searchDiv.innerHTML = '';
        });
    }
</script>

            <div class="usr-stat-content">
                <div class="stat-form">
                        <div class="stat-title">
                            <h2>USER STATISTICS</h2>
                        </div>
                    <div class="status-content">
                        <div>
                            <h4>User Name : </h4><?=$userStat[0]['name'] ?? 'No User'?>
                        </div>
                        <div>
                            <h4>Membership ID : </h4><?=$userStat[0]['membership_id'] ?? '-'?>
                        </div>                        
                        <div>
                            <h4>Email : </h4><?=$userStat[0]['email'] ?? '-'?>
                        </div>
                        <div>
                            <h4>Contact Number : </h4><?=$userStat[0]['contact_no'] ?? '-'?>
                        </div>
                        <div>
                            <h4>Address : </h4><?=$userStat[0]['address'] ?? '-'?>
                        </div>      
                        <div>
                            <h4>Damaged Books : </h4><?=$userStat[0]['no_of_books_damaged'] ?? '-'?>
                        </div>   
                        <div>
                            <h4>Lost Books : </h4><?=$userStat[0]['no_of_books_lost'] ?? '-'?>
                        </div>   
                        <div>
                            <h4>Paid Fines : </h4><?=$data['UserFine']['result'][0]['fine_amount'] ?? 'Rs. 0.00'?>
                        </div>                                                                                                                                             
                    </div>
                </div>

                <div class="stat-form">
                        <div class="stat-title">
                            <h2>User Damaged Books</h2>
                        </div>
                        <div class="status-content stat">
                                <?php 
                                    $damaged_books = $data['Damage']['result'] ?? false;
                                    if($damaged_books !== false && count($damaged_books) !== 0):
                                        $i=0;
                                        foreach($damaged_books as $field => $value): ?>
                                            <div class="record b<?= ($i++%2==1) ? '-alt':'' ?>">
                                                <?= $value['title'] ?> by <?= $value['author'] ?>
                                            </div>
                                        <?php endforeach;else:?>
                                        <span class="empty" >No Books Damaged</span>
                                    <?php endif;   
                                ?>                                                                                                                                  
                        </div>
                </div>                

                <div class="stat-form">
                        <div class="stat-title">
                            <h2>User Lost Books</h2>
                        </div>
                        <div class="status-content stat">
                                <?php 
                                    $lost_books = $data['Lost']['result'] ?? false;
                                    if($lost_books !== false && count($lost_books) !== 0):
                                        $i=0;
                                        foreach($lost_books as $field => $value): ?>
                                            <div class="record b<?= ($i++%2==1) ? '-alt':'' ?>">
                                                <?= $value['title'] ?> by <?= $value['author'] ?>
                                            </div>
                                        <?php endforeach;else:?>
                                        <span class="empty">No Books Lost</span>
                                    <?php endif;   
                                ?>                                                                                                                                   
                        </div>
                </div>                
            </div>
        </div>

        <div class="user-borrow-fine-stats">

            <div class="tabs">
                <button class="tab-btn" id="transactions" onclick="openTab(event,'book-transactions')">Book Transactions</button>
                <button class="tab-btn" id ="finepayments" onclick="openTab(event,'fine-payments')">Fine Payments</button>
            </div>

            <div class="tab-content" id="book-transactions">

            <?php if($data['transaction'] ?? false):?>
                <?php Pagination::Top('/LibraryStaff/userreport', select_filters:[
                    'type' =>[
                        'Borrowed/Recieved', [
                            'all' => 'All',
                            'recieve' => 'Recieved'
                        ]
                    ],
                    'timeframe'=>[
                        'Filter By Date',[
                            'all'=>'All',
                            'today'=> 'Today',
                            'yesterday'=>'Yesterday',
                            'last_7_days'=>'Last 7 Days',
                            'last_30_days'=>'Last 30 Days',
                            'this_month'=>'This Month',
                            'last_month'=>'Last Month',
                            'this_year'=>'This Year',
                            'last_year'=>'Last Year',
                            'custom'=>'Custom Range'
                        ]
                    ]
                ]);?>

                    <?php Table::Table(['accession_no'=>'Accession No','title'=>'Title','author'=>'Author','lent_date'=>'Borrowed Date',
                    'lent_by'=>'Lent By','due_date'=>'Due Date','state'=>'Status','recieved_date'=>'Recieved Date','recieved_by'=>'Recieved By'],
                        $transactions,'userTransaction',
                        actions:[],empty:$data['transaction']['nodata']
                    );?>

                <!-- custom modal for time range -->
                <div id="modal-timeframe" class="modal">
                    <div class="modal-content">
                        <div class="close-section"><span class="close" onclick="closeModal()">&times;</span></div>
                            <?php Time::date('Date From', 'fromDate', 'fromDateTable', max:Date("Y-m-d"));?>
                            <?php Time::date('Date To', 'toDate', 'toDateTable', max:Date("Y-m-d"));?>
                        <div class="popup-btn">
                            <input type="button"class="btn bg-green white" value="Confirm" onclick="arrangeCustomTable()">
                            <button type="button" class="btn bg-red white" onclick="closeModal()">Close</button>
                        </div>
                    </div>
                </div>

                <?php Pagination::bottom('filter-form',$data['transaction']['page'],$data['transaction']['count']); 
            
                else:
                    echo "<span>Please Search A Library User</span>";
            endif;?>

            </div>

            <div class="tab-content" id="fine-payments">

            <?php if($data['fine_details'] ?? false):?>
                <?php Pagination::Top('/LibraryStaff/userreport',form_id:'fine-form' ,select_filters:[
                    'timeframefine'=>[
                        'Filter By Date',[
                            'all'=>'All',
                            'today'=> 'Today',
                            'yesterday'=>'Yesterday',
                            'last_7_days'=>'Last 7 Days',
                            'last_30_days'=>'Last 30 Days',
                            'this_month'=>'This Month',
                            'last_month'=>'Last Month',
                            'this_year'=>'This Year',
                            'last_year'=>'Last Year',
                            'custom'=>'Custom Range'
                        ]
                    ]
                ]);?>

                <?php Table::Table(['fine_amount' => 'Fine Amount', 'recieved_date' => 'Recieved Date', 'recieved_by' => "Recieved By"],
                    $table['result'], 'fineTable',
                    actions:[],empty:$table['nodata']
                );?>

                <!-- custom modal for time range -->
                <div id="modal" class="modal">
                    <div class="modal-content">
                        <div class="close-section"><span class="close" onclick="closeModal()">&times;</span></div>
                            <?php Time::date('Date From', 'fromDate', 'fromDate', max:Date("Y-m-d"));?>
                            <?php Time::date('Date To', 'toDate', 'toDate', max:Date("Y-m-d"));?>
                        <div class="popup-btn">
                            <input type="button"class="btn bg-green white" value="Confirm" onclick="arrangeCustom()">
                            <button type="button" class="btn bg-red white" onclick="closeModal()">Close</button>
                        </div>
                    </div>
                </div>

                <?php Pagination::bottom('fine-form',$data['fine_details']['page'],$data['fine_details']['count']);

                else:
                    echo "<span>Please Search A Library User</span>";
            endif;?>

            </div>

        </div>
    </div>
</div>


<script>

    expandSideBar("sub-items-analytics", "see-more-an");


    var openedModal;
    var timeframe = document.getElementById('timeframe');
    var timeframefine = document.getElementById('timeframefine');
    var fromDateTable = document.getElementById('fromDateTable');
    var toDateTable = document.getElementById('toDateTable');
    var fromDate = document.getElementById('fromDate');
    var toDate = document.getElementById('toDate');
    var table = document.getElementById('userTransaction');
    var fineTable = document.getElementById('fineTable');

    var btn = <?php echo(isset($_SESSION['clicked']) ? json_encode($_SESSION['clicked']) : 'transactions')?>;

    if(btn == 'transactions'){
        document . getElementById("transactions") . click();
    }
    else{
        document . getElementById("finepayments") . click();
    }

    //removed search from fines
    if(table != null && fineTable != null){
        var filter = document.querySelectorAll('.filter')[3];
        filter.parentNode.removeChild(filter);
    }

    function selectText(event){
        event.target.select();
    }

    function openTab(event, tab){
        var i, tabs , tabBtn;
        tabs = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabs.length; i++) {
            tabs[i].style.display = "none";
        }

        tabBtn = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tabBtn.length; i++) {
            tabBtn[i].className = tabBtn[i].className.replace(" active", "");
        }

        document.getElementById(tab).style.display = "block";
        event.currentTarget.className += " active";
    }

    if(table != null && table.rows[1] != null && table.rows[1].cells.length != 1){
      for(var i=1; i < table.rows.length; i++){
          table.rows[i].cells[6].style.textAlign = 'center';
          table.rows[i].cells[6].style.cursor = 'pointer';

          if (table.rows[i].cells[6].innerHTML. trim() == 'Recieved') {
              table.rows[i].cells[6].innerHTML = '🟢';
              table.rows[i].cells[6].title = 'Recieved';
          }
          if (table.rows[i].cells[6].innerHTML. trim() == 'Lost') {
              table.rows[i].cells[6].innerHTML = '🔴';
              table.rows[i].cells[6].title = 'Lost';
          }
          if (table.rows[i].cells[6].innerHTML. trim() == 'Damaged') {
              table.rows[i].cells[6].innerHTML = '🟠';
              table.rows[i].cells[6].title = 'Damaged';
          }
          if (table.rows[i].cells[6].innerHTML. trim() == 'Not Recieved') {
              table.rows[i].cells[6].innerHTML = '⚪️';
              table.rows[i].cells[6].title = 'Not Recieved';
          }
      }
    }

    //removed default behaviour
    if(table != null){
        timeframe.removeAttribute('onchange');

        timeframe.addEventListener('change',function(e){
            var selectedOption = timeframe.options[timeframe.selectedIndex].value;
            if (selectedOption === "custom") {
                openModal('modal-timeframe');
            }
            else {
                filter_form_send();
            }
        });
    }

    //removed default behaviour
    if(fineTable != null){
        timeframefine.removeAttribute('onchange');

        timeframefine.addEventListener('change',function(e){
            var selectedOption = timeframefine.options[timeframefine.selectedIndex].value;
            if (selectedOption === "custom") {
                openModal('modal');
            }
            else {
                fine_form_send();
            }
        });
    }

    function arrangeCustom(){
        var fromDateVal = fromDate.value;
        var toDateVal = toDate.value;
        if (fromDateVal && toDateVal && fromDateVal > toDateVal) {
            toDate.setCustomValidity('Please selecet a valid Date Range');
        } else {
            toDate.setCustomValidity('');
        }
        toDate.reportValidity();
        fromDate.reportValidity();
        
        if(toDate.validity.valid && fromDate.validity.valid){
            fine_form_send();
            closeModal();
        }
    }

    function arrangeCustomTable(){
        var fromDateVal = fromDateTable.value;
        var toDateVal = toDateTable.value;
        if (fromDateVal && toDateVal && fromDateVal > toDateVal) {
            toDateTable.setCustomValidity('Please selecet a valid Date Range');
        } else {
            toDateTable.setCustomValidity('');
        }
        toDateTable.reportValidity();
        fromDateTable.reportValidity();
        
        if(toDateTable.validity.valid && fromDateTable.validity.valid){
            filter_form_send();
            closeModal();
        }
    }

    function closeModal(){
      openedModal.style.display = "none";
    }

    function openModal(modal){
        event.preventDefault();
        openedModal = document.getElementById(modal);
        openedModal.style.display = "block";

        window.onclick = function(event) {
          if (event.target == openedModal) {
              openedModal.style.display = "none";
          }
        }
    }

 

</script>