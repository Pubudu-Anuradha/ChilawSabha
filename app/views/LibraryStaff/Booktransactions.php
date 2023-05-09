<div class="content">

    <?php
        $table = $data['Books'];
        $transactions = $table['result'];
        $transaction_num = 0;
        if(isset($table['result'])):
            foreach ($transactions as $transaction):
                if($transaction['recieved_date'] == null && $transaction['recieved_by'] == null):
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

    <div class="page">
        <div class="title">
            <?php $page_title = "BOOK TRANSACTIONS";
            echo '<h2>' . $page_title . '</h2>';
            ?>
            <input type="button" onclick="generate('#bookTransactions','<?php echo $page_title ?>',10)" value="Export To PDF" class="btn bg-lightblue white"/>
        </div>
    </div>

        <?php Pagination::Top('/LibraryStaff/booktransactions', select_filters:[
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

        <?php Table::Table(['accession_no'=>'Accession No','title'=>'Title','author'=>'Author','borrowed_by'=>'Borrowed By','lent_date'=>'Borrowed Date',
        'lent_by'=>'Lent By','due_date'=>'Due Date','state'=>'Status','recieved_date'=>'Recieved Date','recieved_by'=>'Recieved By'],
            $transactions,'bookTransactions',
            actions:[],empty:$table['nodata']

        );?>
            <!-- custom modal for time range -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <div class="close-section"><span class="close" onclick="closeModal()">&times;</span></div>
                    <?php Time::date('Date From', 'fromDate', 'fromDate', max:Date("Y-m-d"),value:(isset($_GET['fromDate'])) ? $_GET['fromDate'] : '');?>
                    <?php Time::date('Date To', 'toDate', 'toDate', max:Date("Y-m-d"),value:(isset($_GET['toDate'])) ? $_GET['toDate'] : '');?>
                    <div class="popup-btn">
                        <input type="button"class="btn bg-green white" value="Confirm" onclick="arrangeCustom()">
                        <button type="button" class="btn bg-red white" onclick="closeModal()">Close</button>
                    </div>
            </div>
        </div>

        <?php Pagination::bottom('filter-form',$data['Books']['page'],$data['Books']['count']);?>

</div>

<script>

    expandSideBar("sub-items-analytics", "see-more-an");

    var timeframe = document.getElementById('timeframe');
    var fromDate = document.getElementById('fromDate');
    var toDate = document.getElementById('toDate');
    var table = document.getElementById('bookTransactions');
    var openedModal;

    if(table != null && table.rows[1] != null && table.rows[1].cells.length != 1){
      for(var i=1; i < table.rows.length; i++){
          table.rows[i].cells[7].style.textAlign = 'center';
          table.rows[i].cells[7].style.cursor = 'pointer';

          if (table.rows[i].cells[7].innerHTML. trim() == 'Recieved') {
              table.rows[i].cells[7].innerHTML = 'Recieved';
              table.rows[i].cells[7].title = 'Recieved';
          }
          if (table.rows[i].cells[7].innerHTML. trim() == 'Lost') {
              table.rows[i].cells[7].innerHTML = 'Lost';
              table.rows[i].cells[7].title = 'Lost';
          }
          if (table.rows[i].cells[7].innerHTML. trim() == 'Damaged') {
              table.rows[i].cells[7].innerHTML = 'Damged';
              table.rows[i].cells[7].title = 'Damaged';
          }
          if (table.rows[i].cells[7].innerHTML. trim() == 'Not Recieved') {
              table.rows[i].cells[7].innerHTML = 'Not Recieved';
              table.rows[i].cells[7].title = 'Not Recieved';
          }
      }
    }


    //removed default behaviour
    timeframe.removeAttribute('onchange');

    timeframe.addEventListener('change',function(e){
        var selectedOption = timeframe.options[timeframe.selectedIndex].value;
        if (selectedOption === "custom") {
            openModal('modal');
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
        filter_form_send();
        // customRange.value = fromDateVal+' To '+toDateVal;
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

        var firstColumnCells = document.querySelectorAll('td:nth-child(8), th:nth-child(8)');
        firstColumnCells.forEach(function(cell) {
            cell.style.display = 'none';
        });


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
    
        firstColumnCells.forEach(function(cell) {
            cell.style.display = 'table-cell';
        });
    }
</script>
