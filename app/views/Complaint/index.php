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
      <div class="bar-chart-area">
        <canvas id="complaint-in-month"></canvas>
      </div>
    </div>
  </div>
</div>

<script>

  var monValues = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov"];

  document.addEventListener('DOMContentLoaded',function(){

    fetch("<?=URLROOT . '/Complaint/index'?>",{
                    method:"POST",
                    headers: {
                        "Content-type":"application/json"
                    } ,
                    body: JSON.stringify({
                      'type':'load'
                    })
                })
    .then(response => response.json())
    .then(response => {
console.log(response);
      if(response[0]['complaint_categories']['result'].length > 0){
          const categoryNames = response[0]['complaint_categories']['result']['complaint_category'].map(item => item.category_name);
          const compaintCounts = response[0]['complaint_categories']['result']['complaint_count'].map(item => item.complaint_count);
          pieChart(compaintCounts, categoryNames, 'most-complaint-categories');
      }
      else{
        var pieArea = document.querySelector('.most-complaint-category');
        pieArea.innerHTML = "NO DATA FOUND";
        pieArea.style.display = "flex";
        pieArea.style.justifyContent = "center";
        pieArea.style.alignItems = "center";
      }
      if(response[0]['complaint_categories_month']['result'].length > 0){
          const categoryCount = response[0]['complaint_categories_month']['result']['complaint_month_count'].map(item => item.complaint_month_count);
          const compaintMonth = response[0]['complaint_categories_month']['result']['complaint_month'].map(item => item.complaint_month);

          // const MonthNames = compaintMonth.map(monthNum => monValues[monthNum]);
          const categoryCountByMonth = new Array(12).fill(0);

          for (let i = 0; i < compaintMonth.length; i++) {
              categoryCountByMonth[compaintMonth[i]] = categoryCount[i];
          }

          vBarChart(categoryCountByMonth, monValues, 'complaint-in-month');

      }
      else{
        var barArea = document.querySelector('.bar-chart-area');
        barArea.innerHTML = "NO DATA FOUND";
        barArea.style.display = "flex";
        barArea.style.justifyContent = "center";
        barArea.style.alignItems = "center";
        barArea.style.height = "100%";
      }

    })
    .catch(err => {
      console.log(err);
    });

  });



  function pieChart(yval, xval, id) {
    var barColors = ["#6D79E7", "#C7B6EC", "#E5DAFB", "lightblue"];
    // Setup Block
    const data = {
      labels: xval,
      datasets: [{
        label: "Dataset",
        backgroundColor: barColors,
        data: yval,
        borderWidth: 2
      }]
    };

    // Config Block
    const config = {
      type: "pie",
      data,
      options: {
        maintainAspectRatio: false,
        plugins: {
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


  function vBarChart(yval, xval, id) {
    var barColors = ["#6D79E7", "#C7B6EC", "#E5DAFB", "lightblue"];
    // Setup Block
    const data = {
      labels: xval,
      datasets: [{
        label: "Dataset",
        backgroundColor: barColors,
        data: yval,
        borderWidth: 2,
        borderRadius: 25,
        borderSkipped: false,
      }]
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
        plugins: {
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