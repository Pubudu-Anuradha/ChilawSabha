<div class="content">
<div class="complaint-dashboard">
    <h2 class="analytics-topic">Dashboard</h2>
    <div class="upper-content complaint-upper">
        <div class="complaint-count">
            <div class="new-complaint-count">
                <h1> New Complaints </h1>
                <span>08</span>
            </div>
            <div class="resolved-complaint-count">
                <h1> My Resolved Complaints </h1>
                <span>15</span> 
            </div>
            <div class="working-complaint-count">
                <h1> My Working Complaints </h1>
                <span>05</span> 
            </div>
        </div>
        <div class="pie-outer-content">
          <h3>Most Complaint Categories</h3>
          <div class="most-complaint-category">
            <canvas id="most-complaint-categories"></canvas>
          </div>
        </div>

    </div>
    <div class="lower-content complaint-lower">
        <h3>Complaints In Each Month</h3>
        <canvas id="complaint-in-month"></canvas>
    </div>
</div>
</div>

<script>

    var catValues = ["Land Issues", "Vehicle Issues", "Service Issues","Online System Issues", "Staff Issues"];
    var monValues = ["Jan", "Feb", "Mar","Apr","May", "Jun", "Jul","Aug","Sep", "Oct", "Nov"];
    var complaintcount = [23,44,76,12,45,45,17,85,36,77,18]
    var yValues = [80, 49, 44,60, 65];
    var barColors = ["#6D79E7", "#C7B6EC", "#E5DAFB","lightblue","#6D79E7", "#C7B6EC", "#E5DAFB","lightblue","#6D79E7", "#C7B6EC", "#E5DAFB"];

    new Chart("most-complaint-categories", {
            type: "pie",
            data: {
            labels: catValues,
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
              // responsive: true,
              maintainAspectRatio: false,
            plugins:{
                legend: {
                display: true,
                position: 'right',
                labels: {
                    boxWidth: 20
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

    new Chart("complaint-in-month", {
        type: "bar",
        data: {
          labels: monValues,
          datasets: [
            {
              label: "Dataset",
              backgroundColor: barColors,
              data: complaintcount,
              borderWidth: 2,
              borderRadius:25,
              borderSkipped: false,
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
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
              display: false,
              text: "Vertical Bar Chart Test",
              position: "bottom"
            }
          }
        }
    });

</script>