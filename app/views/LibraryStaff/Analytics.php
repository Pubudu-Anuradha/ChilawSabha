<div class="content">
    <div class="page">
        <h2 class="topic"><?php $page_title = 'ANALYTICS'; echo $page_title;?></h2>
        <div class="chart-area" id="chart-area">
            <div class="pie-chart bg-fd-blue">
                <div class="pie-chart-options">
                  <h2>Most Borrowed Categories</h2>
                    <select name="range" id="range" onchange="handleChart()">
                      <option value="all">All</option>
                      <option value="this month">This Month</option>
                      <option value="last month">Last Month</option>
                      <option value="this year">This Year</option>
                      <option value="last year">Last Year</option>
                      <option value="custom" id="customRange">Custom Range</option>
                    </select>
                </div>
                <div id="pie-chart-div"> </div>
                <canvas id="most-borrowed-pie"></canvas>
            </div>
            <div class="bar-chart-area">
                <div class="bar-chart  bg-fd-blue">
                    <h2>Most Favourite Categories</h2>
                    <canvas id="most-favourite-bar"></canvas>
                </div>
                <div class="bar-chart  bg-fd-blue">
                    <h2>Most Plan To Read Categories</h2>
                    <canvas id="most-plan-to-read-bar"></canvas>
                </div>
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
</div>

<script>
    expandSideBar("sub-items-analytics","see-more-an");

    var xValues = ["Philosophy", "Science", "Literature","Technology","Religion"];
    var yValues = [80, 49, 44, 60, 29];
    var barColors = ["#6D79E7", "#C7B6EC", "#E5DAFB","#16169c"];
    var range = document.getElementById('range');
    var chartDiv = document.getElementById('pie-chart-div');
    var chartCanvas = document.getElementById('most-borrowed-pie');
    var chartview,openedModal;
    var customRange = document.getElementById('customRange');
    var fromDate = document.getElementById('fromDate');
    var toDate = document.getElementById('toDate');

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
        changeChart([fromDateVal,toDateVal]);
        // customRange.value = fromDateVal+' To '+toDateVal;
        closeModal();
      }
    }


    function handleChart(){
      var selectElement = document.getElementById("range");
      var selectedOption = selectElement.options[selectElement.selectedIndex].value;
      if (selectedOption === "custom") {
        openModal('modal');
      }
      else {
        changeChart();
      }
    }

    document.addEventListener('DOMContentLoaded', function (){

      // need to add db data for this as well
      hBarChart(yValues, xValues, 'most-favourite-bar');
      hBarChart(yValues, xValues, 'most-plan-to-read-bar');

      fetch("<?=URLROOT . '/LibraryStaff/analytics'?>",{
                method:"POST",
                headers: {
                    "Content-type":"application/json"
                } ,
                body: JSON.stringify({
                  'range':'all'})
            })
            .then(response => response.json())
            .then(response => {
                if(response.length > 0){

                  const categoryNames = response[0].map(item => item.category_name);
                  const borrowCounts = response[0].map(item => item.borrow_count);

                  chartview = doughnutChart(borrowCounts, categoryNames, 'most-borrowed-pie');

                }
        })
        .catch(err => {
            chartDiv.innerHTML = "No Data Found";
            chartCanvas.style.display = "none";
            chartDiv.classList.add("chartDiv");
            console.log(err);
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
      var barColors = ["#6D79E7", "#C7B6EC", "#E5DAFB","lightblue"];
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

    function changeChart(arr=null){

      fetch("<?=URLROOT . '/LibraryStaff/analytics'?>",{
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

            const categoryNames = response[0].map(item => item.category_name);
            const borrowCounts = response[0].map(item => item.borrow_count);

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
      })
      .catch(err => {
          chartDiv.innerHTML = "No Data Found";
          chartCanvas.style.display = "none";
          chartDiv.classList.add("chartDiv");
          console.log(err);
      });
    }
</script>
