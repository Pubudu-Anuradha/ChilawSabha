<?php
$eventstat = $data['EventStat'];
// foreach ($eventstat['result'] as $evestat):
//     $views[] = $evestat['views'];
//     $names[] = $evestat['name'];
// endforeach;
// var_dump($names);
?>

<div class="content admin-analytics">
<div class="admin-dashboard">
    <h2 class="analytics-topic">Dashboard</h2>
    <div class="upper-content">
        <div class="main-page-views">
            <h1> 456 </h1>
            <span>Main Page Views</span>
        </div>
        <div class="number-of-posts">
            <div>
                <div class="event-posts">
                    <h3>10</h3>
                    <span>No of Event Posts</span>
                </div>
                <div class="service-posts">
                    <h3>17</h3>
                    <span>No of Service Posts</span>
                </div>
            </div>
            <div>
                <div class="project-posts">
                    <h3>43</h3>
                    <span>No of Project Posts</span>
                </div>
                <div class="announcement-posts">
                    <h3>12</h3>
                    <span>No of Annoucement Posts</span>
                </div>
            </div>
        </div>
        <div class="most-viewed-events">
            <h3>Most Viewed Events</h3>
            <canvas id="most-viewed-events"></canvas>
        </div>
    </div>
    <div class="lower-content">
        <div>
            <h3>Most Viewed Services</h3>
            <canvas id="most-viewed-services"></canvas>
        </div>
        <div>
            <h3>Most Viewed Projects</h3>
            <canvas id="most-viewed-projects"></canvas>
        </div>
        <div>
            <h3>Most Viewed Announcements</h3>
            <canvas id="most-viewed-announcements"></canvas>
        </div>
    </div>
</div>
</div>

<script>
    window.onload = vBarChart(<?php echo json_encode($views); ?>,<?php echo json_encode($names); ?>,'most-viewed-events');
    window.onload = vBarChart(<?php echo json_encode($views); ?>,<?php echo json_encode($names); ?>,'most-viewed-services');
    window.onload = vBarChart(<?php echo json_encode($views); ?>,<?php echo json_encode($names); ?>,'most-viewed-projects');
    window.onload = vBarChart(<?php echo json_encode($views); ?>,<?php echo json_encode($names); ?>,'most-viewed-announcements');

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