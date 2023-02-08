<div class="content">
    <div class="chart">
        <canvas id="myChart1"></canvas>
        <canvas id="myChart2"></canvas>
        <canvas id="myChart3"></canvas>
    </div>  
</div>

<script>
    // Test valuus
    var xValues = ["Italy", "France", "Spain","England"];
    var yValues = [80, 49, 44,60];
    var barColors = ["#6D79E7", "#C7B6EC", "#E5DAFB","lightblue"];
    // Horizontal Bar chart
    new Chart("myChart1", {
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
              display: true,
              text: "Horizontal Bar Chart Test",
              position: "bottom"
            }
          }
        }
    });
    // Pie chart
    new Chart("myChart2", {
        type: "pie",
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
              position: 'right',
              labels: {
                boxWidth: 15
              }
            },
            title: {
              display: true,
              text: "Pie Chart Test",
              position: "bottom"
            }
          }
        }
    });
    // Vertical Bar chart
    new Chart("myChart3", {
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
          // For bar charts
          scales: {
            x: {
              border: {
                display: false,
              },
              grid: {
                display: false
              }
            },
            y: {
              display: false
            }
          },
          // for horizontol or vertical bar
          indexAxis: 'x',
          plugins:{
            legend: {
              display: false,
              position: 'right',
              labels: {
                boxWidth: 15
              }
            },
            title: {
              display: true,
              text: "Vertical Bar Chart Test",
              position: "bottom"
            }
          }
        }
    });

</script>