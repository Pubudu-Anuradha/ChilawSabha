<div class="content">
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

    var eventValues = ["E01", "E02", "E03","E04"];
    var servValues = ["S01", "S02", "S03","S04"];
    var projValues = ["P01", "P02", "P03","P04"];
    var annValues = ["A01", "A02", "A03","A04"];
    var yValues = [80, 49, 44,60];
    var barColors = ["#6D79E7", "#C7B6EC", "#E5DAFB","lightblue"];

        new Chart("most-viewed-events", {
        type: "bar",
        data: {
          labels: eventValues,
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
              display: false,
              text: "Vertical Bar Chart Test",
              position: "bottom"
            }
          }
        }
    });

    new Chart("most-viewed-services", {
        type: "bar",
        data: {
          labels: servValues,
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
              display: false,
              text: "Vertical Bar Chart Test",
              position: "bottom"
            }
          }
        }
    });

    new Chart("most-viewed-projects", {
        type: "bar",
        data: {
          labels: projValues,
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
              display: false,
              text: "Vertical Bar Chart Test",
              position: "bottom"
            }
          }
        }
    });

    new Chart("most-viewed-announcements", {
        type: "bar",
        data: {
          labels: annValues,
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
              display: false,
              text: "Vertical Bar Chart Test",
              position: "bottom"
            }
          }
        }
    });

</script>