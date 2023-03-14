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
    var complaintcount = [23,44,76,12,45,45,17,85,36,77,18];
    var yValues = [80, 49, 44,60, 65];

    window.onload = pieChart(yValues,catValues,'most-complaint-categories');
    window.onload = vBarChart(complaintcount,monValues,'complaint-in-month');

    function pieChart(yval,xval,id){
      var barColors = ["#6D79E7", "#C7B6EC", "#E5DAFB","lightblue"];
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
           type: "pie",
            data,
            options: {
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
      };

      // Render Block
      const chart = new Chart(
        document.getElementById(id),
        config
      );
    }


    function vBarChart(yval,xval,id){
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
      };

      if (id === 'complaint-in-month') {
        config.options.responsive = true;
        config.options.maintainAspectRatio = false;
      }

      // Render Block
      const chart = new Chart(
        document.getElementById(id),
        config
      );
    }

</script>