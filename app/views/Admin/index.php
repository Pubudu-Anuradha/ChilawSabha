<div class="content">

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

              border: {
                display: false,
              },
              grid: {
                display: false
              }

          plugins:{
            legend: {
              display: false,
              position: 'right',
              labels: {
                boxWidth: 15
              }
            },
            title: {

              position: "bottom"
            }
          }
        }
    });

          datasets: [
            {
              label: "Dataset",
              backgroundColor: barColors,
              data: yValues,

            }
          ]
        },
        options: {

              position: 'right',
              labels: {
                boxWidth: 15
              }
            },
            title: {

              position: "bottom"
            }
          }
        }
    });

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

              text: "Vertical Bar Chart Test",
              position: "bottom"
            }
          }
        }
    });

</script>