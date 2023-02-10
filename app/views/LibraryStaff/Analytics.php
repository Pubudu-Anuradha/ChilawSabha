<div class="content">
    <div class="analytics">
        <h2 class="analytics-topic">ANALYTICS</h2>
        <div class="chart-area">
            <div class="pie-chart">
                <h3>Most Borrowed Categories</h3>
                <canvas id="most-borrowed-pie"></canvas>
            </div>
            <div class="bar-chart-area">
                <div class="bar-chart">
                    <h3>Most Favourite Categories</h3>
                    <canvas id="most-favourite-bar"></canvas>
                </div>
                <div class="bar-chart">
                    <h3>Most Plan To Read Categories</h3>
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

    new Chart("most-borrowed-pie", {
        type: "doughnut",
        data: {
          labels: xValues,
          datasets: [
            {
              label: "Dataset",
              backgroundColor: barColors,
              data: yValues,
              borderWidth: 2
            }
          ]
        },
        options: {
          plugins:{
            legend: {
              display: true,
              position: 'bottom',
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
    });

    new Chart("most-favourite-bar", {
        type: "bar",
        data: {
          labels: xValues,
          datasets: [
            {
              label: "Dataset",
              backgroundColor: barColors,
              data: yValues,
              borderWidth: 2,
              borderRadius:25,
              borderSkipped: false,
            }
          ]
        },
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
    });

    new Chart("most-plan-to-read-bar", {
        type: "bar",
        data: {
          labels: xValues,
          datasets: [
            {
              label: "Dataset",
              backgroundColor: barColors,
              data: yValues,
              borderWidth: 2,
              borderRadius:25,
              borderSkipped: false,
            }
          ]
        },
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
    });

</script>