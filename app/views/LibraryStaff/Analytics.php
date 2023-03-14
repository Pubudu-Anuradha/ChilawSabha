<div class="content">
    <div class="page">
        <h2 class="topic">ANALYTICS</h2>
        <div class="chart-area">
            <div class="pie-chart bg-fd-blue">
                <div class="pie-chart-options">
                  <h2>Most Borrowed Categories</h2>
                    <select name="range" id="range" onchange="changeChart()">
                      <option value="all">All</option>
                      <option value="this month">This Month</option>
                      <option value="last month">Last Month</option>
                      <option value="this year">This Year</option>
                      <option value="last year">Last Year</option>
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
</div>

<script>

    var xValues = ["Philosophy", "Science", "Literature","Technology","Religion"];
    var yValues = [80, 49, 44, 60, 29];
    var barColors = ["#6D79E7", "#C7B6EC", "#E5DAFB","#16169c"];
    var range = document.getElementById('range');
    var chartDiv = document.getElementById('pie-chart-div');
    var chartCanvas = document.getElementById('most-borrowed-pie');
    var chartview;


    document.addEventListener('DOMContentLoaded', function (){

      // need to add db data for this as well
      hBarChart(yValues, xValues, 'most-favourite-bar');
      hBarChart(yValues, xValues, 'most-plan-to-read-bar');

      fetch("<?=URLROOT . '/LibraryStaff/analytics'?>",{
                method:"POST",
                headers: {
                    "Content-type":"application/json"
                } ,
                body: JSON.stringify('all') 
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

    function changeChart(){

      fetch("<?=URLROOT . '/LibraryStaff/analytics'?>",{
          method:"POST",
          headers: {
              "Content-type":"application/json"
          },
          body: JSON.stringify(range.value)    
      })
      .then(response => response.json())
      .then(response => {
        console.log(response[0]);

          if(response.length > 0){

            const categoryNames = response[0].map(item => item.category_name);
            const borrowCounts = response[0].map(item => item.borrow_count);

            chartDiv.innerHTML = "";
            chartCanvas.style.display = "block";

            if(chartview){
              chartview.destroy();
            }

            chartview = doughnutChart(borrowCounts, categoryNames, 'most-borrowed-pie');

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