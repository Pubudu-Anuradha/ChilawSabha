<div class="content">
    <div class="page">
      <div class="analytics-topic topic">
        <h2><?php $page_title = 'ANALYTICS'; echo $page_title;?></h2>
        <button class='btn bg-lightblue' onclick="genReport('chart-area')">Export To PDF</button>
      </div>
        <div class="chart-area" id="chart-area">
            <div class="pie-chart bg-fd-blue">
                <div class="pie-chart-options">
                  <h2>Most Borrowed Categories</h2>
                    <select name="range" id="rangePie" onchange="handleChart('pie')">
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
                <div id="pie-chart-div"> </div>
                <canvas id="most-borrowed-pie"></canvas>
                <!-- custom modal for time range -->
                <div id="modal-pie" class="modal">
                    <div class="modal-content">
                        <div class="close-section"><span class="close" onclick="closeModal()">&times;</span></div>
                            <?php Time::date('Date From', 'fromDate', 'fromDate', max:Date("Y-m-d"));?>
                            <?php Time::date('Date To', 'toDate', 'toDate', max:Date("Y-m-d"));?>
                        <div class="popup-btn">
                            <input type="button"class="btn bg-green white" value="Confirm" onclick="arrangeCustom('pie')">
                            <button type="button" class="btn bg-red white" onclick="closeModal()">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bar-chart-area">
                <div class="bar-chart  bg-fd-blue">
                    <div class="pie-chart-options">
                      <h2>Most Favourite Categories</h2>
                        <select name="range" id="rangeFbar" onchange="handleChart('fbar')">
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
                    <div id="bar-chart-div-f"> </div>
                    <canvas id="most-favourite-bar"></canvas>
                        <!-- custom modal for time range -->
                    <div id="modal-fbar" class="modal">
                        <div class="modal-content">
                            <div class="close-section"><span class="close" onclick="closeModal()">&times;</span></div>
                                <?php Time::date('Date From', 'fromDate', 'fromDateFbar', max:Date("Y-m-d"));?>
                                <?php Time::date('Date To', 'toDate', 'toDateFbar', max:Date("Y-m-d"));?>
                            <div class="popup-btn">
                                <input type="button"class="btn bg-green white" value="Confirm" onclick="arrangeCustom('fbar')">
                                <button type="button" class="btn bg-red white" onclick="closeModal()">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bar-chart  bg-fd-blue">
                      <div class="pie-chart-options">
                      <h2>Most Plan To Read Categories</h2>
                        <select name="range" id="rangeSbar" onchange="handleChart('sbar')">
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
                    <div id="bar-chart-div-s"> </div>
                    <canvas id="most-plan-to-read-bar"></canvas>
                        <!-- custom modal for time range -->
                    <div id="modal-sbar" class="modal">
                        <div class="modal-content">
                            <div class="close-section"><span class="close" onclick="closeModal()">&times;</span></div>
                                <?php Time::date('Date From', 'fromDate', 'fromDateSbar', max:Date("Y-m-d"));?>
                                <?php Time::date('Date To', 'toDate', 'toDateSbar', max:Date("Y-m-d"));?>
                            <div class="popup-btn">
                                <input type="button"class="btn bg-green white" value="Confirm" onclick="arrangeCustom('sbar')">
                                <button type="button" class="btn bg-red white" onclick="closeModal()">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    expandSideBar("sub-items-analytics","see-more-an");

    var barColors = ["#6D79E7", "#C7B6EC", "#E5DAFB","#16169c"];
    var rangePie = document.getElementById('rangePie');
    var rangeFbar = document.getElementById('rangeFbar');
    var rangeSbar = document.getElementById('rangeSbar');
    var chartDiv = document.getElementById('pie-chart-div');
    var barChartFView = document.getElementById('bar-chart-div-f');
    var barChartSView = document.getElementById('bar-chart-div-s');
    var chartCanvas = document.getElementById('most-borrowed-pie');
    var barFchartCanvas = document.getElementById('most-favourite-bar');
    var barSchartCanvas = document.getElementById('most-plan-to-read-bar');
    var chartview,favchartview,plrchartview,openedModal;
    var fromDate = document.getElementById('fromDate');
    var toDate = document.getElementById('toDate');
    var fromDateFbar = document.getElementById('fromDateFbar');
    var toDateFbar = document.getElementById('toDateFbar');
    var fromDateSbar = document.getElementById('fromDateSbar');
    var toDateSbar = document.getElementById('toDateSbar');

    function genReport(id){
      var img;
      html2canvas(document.getElementById(id)).then(
        function (canvas){
          img=canvas.toDataURL("image/png");
          var doc =new jsPDF('landscape', 'mm', 'a4');
          var pageWidth = doc.internal.pageSize.getWidth();
          var imageWidth = 300;
          var title = '<?php echo($page_title)?>';
          var barchartShadow = document.querySelector('.bar-chart');
          barchartShadow.style.boxShadow = '';
          var titleFontSize = 16;
          doc.setFontSize(titleFontSize);
          var titleWidth = doc.getTextWidth(title);
          var titleX = (pageWidth - titleWidth) / 2;
          doc.text(titleX, 20, title);
          doc.addImage(img,'PNG', 15, 30, imageWidth, 0);
          doc.save('<?=$page_title?>'.concat('.pdf'));
      });    
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

    function arrangeCustom(type){
      if(type == 'pie'){
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
          changeChart(type,[fromDateVal,toDateVal]);
          closeModal();
        }
      }
      else if(type == 'fbar'){
        var fromDateFbarVal = fromDateFbar.value;
        var toDateFbarVal = toDateFbar.value;
        if (fromDateFbarVal && toDateFbarVal && fromDateFbarVal > toDateFbarVal) {
            toDateFbar.setCustomValidity('Please selecet a valid Date Range');
        } else {
            toDateFbar.setCustomValidity('');
        }
        toDateFbar.reportValidity();
        fromDateFbar.reportValidity();

        if(toDateFbar.validity.valid && fromDateFbar.validity.valid){
          changeChart(type,[fromDateFbarVal,toDateFbarVal]);
          closeModal();
        }
      }
      else {
        var fromDateSbarVal = fromDateSbar.value;
        var toDateSbarVal = toDateSbar.value;
        if (fromDateSbarVal && toDateSbarVal && fromDateSbarVal > toDateSbarVal) {
            toDateSbar.setCustomValidity('Please selecet a valid Date Range');
        } else {
            toDateSbar.setCustomValidity('');
        }
        toDateSbar.reportValidity();
        fromDateSbar.reportValidity();

        if(toDateSbar.validity.valid && fromDateSbar.validity.valid){
          changeChart(type,[fromDateSbarVal,toDateSbarVal]);
          closeModal();
        }
      }
    }


    function handleChart(type){
      if(type == 'pie'){
        var selectElement = rangePie;
        var selectedOption = selectElement.options[selectElement.selectedIndex].value;
        if (selectedOption === "custom") {
          openModal('modal-pie');
        }
        else {
          changeChart('pie');
        }
      }
      else if(type == 'fbar'){
        var selectElement = rangeFbar;
        var selectedOption = selectElement.options[selectElement.selectedIndex].value;
        if (selectedOption === "custom") {
          openModal('modal-fbar');
        }
        else {
          changeChart('fbar');
        }
      }
      else{
        var selectElement = rangeSbar;
        var selectedOption = selectElement.options[selectElement.selectedIndex].value;
        if (selectedOption === "custom") {
          openModal('modal-sbar');
        }
        else {
          changeChart('sbar');
        }
      }

    }

    document.addEventListener('DOMContentLoaded', function (){

      fetch("<?=URLROOT . '/LibraryStaff/analytics'?>",{
                method:"POST",
                headers: {
                    "Content-type":"application/json"
                } ,
                body: JSON.stringify({
                  'range':'all',
                  'type':'load'
                })
            })
            .then(response => response.json())
            .then(response => {

                if(response[0]['borrow']['result'].length > 0){
                  const categoryNames = response[0]['borrow']['result'].map(item => item.category_name);
                  const borrowCounts = response[0]['borrow']['result'].map(item => item.borrow_count);
                  chartview = doughnutChart(borrowCounts, categoryNames, 'most-borrowed-pie');
                }
                else{
                  chartDiv.innerHTML = "No Data Found";
                  chartCanvas.style.display = "none";
                  chartDiv.classList.add("chartDiv");
                }
                
                if(response[0]['fav']['result'].length > 0){
                    const favcategoryNames = response[0]['fav']['result'].map(item => item.category_name);
                    const favborrowCounts = response[0]['fav']['result'].map(item => item.fav_count);
                    favchartview = hBarChart(favborrowCounts, favcategoryNames, 'most-favourite-bar');
                }
                else{
                  barChartFView.innerHTML = "No Data Found";
                  barFchartCanvas.style.display = "none";
                  barChartFView.classList.add("chartDiv");
                }
                  
                if(response[0]['plr']['result'].length > 0){
                    const plrcategoryNames = response[0]['plr']['result'].map(item => item.category_name);
                    const plrborrowCounts = response[0]['plr']['result'].map(item => item.plr_count);
                    plrchartview = hBarChart(plrborrowCounts, plrcategoryNames, 'most-plan-to-read-bar');
                }
                else{
                  barChartSView.innerHTML = "No Data Found";
                  barSchartCanvas.style.display = "none";
                  barChartSView.classList.add("chartDiv");
                }                
                
        })
        .catch(err => {
            chartDiv.innerHTML = "No Data Found";
            barChartFView.innerHTML = "No Data Found";
            barChartSView.innerHTML = "No Data Found";
            chartCanvas.style.display = "none";
            barFchartCanvas.style.display = "none";
            barSchartCanvas.style.display = "none";
            chartDiv.classList.add("chartDiv");
            barChartFView.classList.add("chartDiv");
            barChartSView.classList.add("chartDiv");
        });
    });

    function doughnutChart(yval,xval,id){
      // Setup Block
      const data = {
          labels: xval,
          datasets: [
            {
              label: "Dataset",
              backgroundColor: barColors,
              data: yval,
              borderWidth: 2
            }
          ]
      };

      // Config Block
      const config = {
        type: "doughnut",
        data,
        options: {
          plugins:{
            legend: {
              display: true,
              position: 'right',
              labels: {
                boxWidth: 25,
                padding: 25
              }
            },
            title: {
              display: false,
              text: "Pie Chart Test",
              position: "bottom"
            }
          }
        }
      };

      // Render Block
      const chart = new Chart(
        document.getElementById(id),
        config
      );

      return chart;
    }

    function hBarChart(yval,xval,id){
      // Setup Block
      const data = {
        labels: xval,
        datasets: [
          {
            label: "Dataset",
            backgroundColor: barColors,
            data: yval,
            borderWidth: 2,
            borderRadius:25,
            borderSkipped: false,
          }
        ]
      };

      // Config Block
      const config = {
        type: "bar",
        data,
        options: {
          scales: {
            x: {
              display: false,
            },
            y: {
              border: {
                display: false,
              },
              grid: {
                display: false
              }
            }
          },
          // for horizontol or vertical bar
          indexAxis: 'y',
          plugins:{
            legend: {
              display: false,
              position: 'right',
              labels: {
                boxWidth: 15
              }
            },
            title: {
              display: false,
              text: "Horizontal Bar Chart Test",
              position: "bottom"
            }
          }
        }
      };

      // Render Block
      const chart = new Chart(
        document.getElementById(id),
        config
      );

      return chart;
    }

    function changeChart(type,arr=null){

      var bodyVal;
      if(arr){
        bodyVal = {              
          "fromDate":arr[0],
          "toDate":arr[1],
          'type': type
        };
      }
      else{
        if(type == 'pie'){
          bodyVal = {
            "range": rangePie.value,
            'type': type
          };          
        }
        else if(type == 'fbar'){
          bodyVal = {
            "range": rangeFbar.value,
            'type': type
          };          
        }
        else{
          bodyVal = {
            "range": rangeSbar.value,
            'type': type
          };           
        }
      }

      fetch("<?=URLROOT . '/LibraryStaff/analytics'?>",{
          method:"POST",
          headers: {
              "Content-type":"application/json"
          },
          body: JSON.stringify(bodyVal)
      })
      .then(response => response.json())
      .then(response => {

        if(type == 'pie'){
            if(response[0]['borrow']['result'].length > 0){
              const categoryNames = response[0]['borrow']['result'].map(item => item.category_name);
              const borrowCounts = response[0]['borrow']['result'].map(item => item.borrow_count);

              chartDiv.innerHTML = "";
              chartCanvas.style.display = "block";

              if(chartview){
                chartview.destroy();
              }

              chartview = doughnutChart(borrowCounts, categoryNames, 'most-borrowed-pie');
            }
            else{
              chartDiv.innerHTML = "No Data Found";
              chartCanvas.style.display = "none";
              chartDiv.classList.add("chartDiv");
            }
        }
        else if(type == 'fbar'){
            if(response[0]['fav']['result'].length > 0){
                const favcategoryNames = response[0]['fav']['result'].map(item => item.category_name);
                const favborrowCounts = response[0]['fav']['result'].map(item => item.fav_count);

                barChartFView.innerHTML = "";
                barFchartCanvas.style.display = "block";

                if(favchartview){
                  favchartview.destroy();
                }

                favchartview = hBarChart(favborrowCounts, favcategoryNames, 'most-favourite-bar');
            }
            else{
              barChartFView.innerHTML = "No Data Found";
              barFchartCanvas.style.display = "none";
              barChartFView.classList.add("chartDiv");
            }
        }
        else if (type == 'sbar'){
            if(response[0]['plr']['result'].length > 0){
                    const plrcategoryNames = response[0]['plr']['result'].map(item => item.category_name);
                    const plrborrowCounts = response[0]['plr']['result'].map(item => item.plr_count);

                    barChartSView.innerHTML = "";
                    barSchartCanvas.style.display = "block";

                    if(plrchartview){
                      plrchartview.destroy();
                    }

                    plrchartview = hBarChart(plrborrowCounts, plrcategoryNames, 'most-plan-to-read-bar');
            }
            else{
              barChartSView.innerHTML = "No Data Found";
              barSchartCanvas.style.display = "none";
              barChartSView.classList.add("chartDiv");
            }    
        }

      })
      .catch(err => {
        if(type == 'pie'){
          chartDiv.innerHTML = "No Data Found";
          chartCanvas.style.display = "none";
          chartDiv.classList.add("chartDiv");
        }
        else if(type=='fbar'){
          barChartFView.innerHTML = "No Data Found";
          barFchartCanvas.style.display = "none";
          barChartFView.classList.add("chartDiv");
        }
        else{
          barChartSView.innerHTML = "No Data Found";
          barSchartCanvas.style.display = "none";
          barChartSView.classList.add("chartDiv");
        }

      });
    }
</script>
