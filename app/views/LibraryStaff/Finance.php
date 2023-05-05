<?php
$errors = $data['errors'] ?? false;
$fine = $data['Fine']['result'][0] ?? null;
$table = $data['fine_details'] ?? false;
?>

<div class="content">
    <div class="page">
        <h2 class="topic"><?php $page_title = 'FINANCE'; echo $page_title;?></h2>
        <div class="fine">
            <div class="fine-amount">
                <div class="fine-amount-options">
                    <h2>Total Fines Collected</h2>
                    <select name="range" id="range" onchange="handleFine()">
                      <option value="all">All</option>
                      <option value="today">Today</option>
                      <option value="yesterday">Yesterday</option>
                      <option value="last_7_days">Last 7 Days</option>
                      <option value="last_30_days">Last 30 Days</option>
                      <option value="this month">This Month</option>
                      <option value="last month">Last Month</option>
                      <option value="this year">This Year</option>
                      <option value="last year">Last Year</option>
                      <option value="custom" id="customRange">Custom Range</option>
                    </select>
                </div>
                <div class="fine-value" id="fineValue">
                    Rs. 0.00
                </div>
            </div>
            <div class="fine-form">
                <div class="fine-form-input">
                    <h2>Fine Parameters</h2>
                    <?php if(!is_null($fine)):?>
                    <?php if ($data['Edit'] ?? false) {
                        if (!$data['Edit']['success']) {
                            echo "Failed To Edit Fine Details " . $data['Edit']['errmsg'];
                        } else {
                            echo "Fine Details Edited Successfully";
                        }
                    }?>

                    <form  class="fullForm" method="post">

                        <?php Errors::validation_errors($errors, [
                            'delay_month_fine' => "Fine For First Month",
                            'delay_after_fine' => 'Fine From Second Month',
                        ]);?>

                        <?php Other::number('Fine For First Month (Per Day)','delay_month_fine','delay_month_fine',placeholder:'Insert Amount',step:0.01,min:0,required:false,value:$fine['delay_month_fine'] ?? '');?>
                        <?php Other::number('Fine From Second Month (Per Day)','delay_after_fine','delay_after_fine',placeholder:'Insert Amount',step:0.01,min:0,required:false,value:$fine['delay_after_fine'] ?? '');?>
                        <?php Other::submit('Edit','edit',value:'Save Changes');?>
                    </form>
                    <?php endif;?>
                </div>
            </div>
        </div>
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

        <div class="fine-details">
            <div class="tabs">
                <button class="tab-btn" id="payments" onclick="openTab(event,'fine-payment')">Fine Payments</button>
                <button class="tab-btn" id ="history" onclick="openTab(event,'fine-edit-history')">Fine Edit History</button>
            </div>

            <div class="tab-content" id="fine-payment">

                <?php Pagination::Top('/LibraryStaff/finance', select_filters:[
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

                <?php Table::Table(['name' => 'Member Name', 'fine_amount' => 'Fine Amount', 'recieved_date' => 'Recieved Date', 'recieved_by' => "Recieved By"],
                    $table['result'], 'fineRecieved',
                    actions:[],empty:$table['nodata']
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

                <?php Pagination::bottom('filter-form',$data['fine_details']['page'],$data['fine_details']['count']);?>

            </div>

            <div class="tab-content history" id="fine-edit-history">
                <?php
                    $edit_history = $data['edit_history'] ?? false;
                    $post = $fine;
                    $fields = [
                        'delay_month_fine' => "Fine For First Month",
                        'delay_after_fine' => 'Fine From Second Month'
                    ];
                    if($edit_history !== false && count($edit_history) !== 0): ?>
                        <div class="edit-history card">
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
            </div>
        </div>
    </div>
</div>

<script>
    expandSideBar("sub-items-analytics", "see-more-an");
    var timeframe = document.getElementById('timeframe');
    var fromDate = document.getElementById('fromDate');
    var toDate = document.getElementById('toDate');
    var fromDateTable = document.getElementById('fromDateTable');
    var toDateTable = document.getElementById('toDateTable');
    var fineValue = document.getElementById('fineValue');
    var openedModal;

    document.getElementById("payments").click();

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

    // removed default behaviour
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
            changeFine([fromDateVal, toDateVal]);
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

    function handleFine(){
      var selectElement = document.getElementById("range");
      var selectedOption = selectElement.options[selectElement.selectedIndex].value;
      if (selectedOption === "custom") {
        fineAmountFlag = true;
        openModal('modal');
      }
      else {
        changeFine();
      }
    }

    document.addEventListener('DOMContentLoaded', function (){

      fetch("<?=URLROOT . '/LibraryStaff/finance'?>",{
          method:"POST",
          headers: {
              "Content-type":"application/json"
          },
          body: JSON.stringify({
              "range":'all'
            })
      })
      .then(response => response.json())
      .then(response => {
          if(response[0].length > 0){
            fineValue.innerHTML = 'Rs. ' + response[0][0]['fine_amount'];
          }
          else{
            fineValue.innerHTML = "Rs. 0.00";
          }
      })
      .catch(err => {
          fineValue.innerHTML = "No Fine Data Found";
      });

    });

    function changeFine(arr=null){
      fetch("<?=URLROOT . '/LibraryStaff/finance'?>",{
          method:"POST",
          headers: {
              "Content-type":"application/json"
          },
          body: JSON.stringify(
            arr ? {
              "fromDate":arr[0],
              "toDate":arr[1]
            } : {
              "range":range.value
            })
      })
      .then(response => response.json())
      .then(response => {
          if(response[0].length > 0){
            if(response[0][0]['fine_amount'] != null){
                fineValue.innerHTML = 'Rs. ' + response[0][0]['fine_amount'];
            }
            else{
                fineValue.innerHTML = "Rs. 0.00";
            }
          }
          else{
            fineValue.innerHTML = "Rs. 0.00";
          }
      })
      .catch(err => {
          fineValue.innerHTML = "No Fine Data Found";
      });
    }

</script>
