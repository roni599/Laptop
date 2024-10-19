<!-- 
<template>
    <div>
      <canvas ref="monthlyprofitChart"></canvas>
    </div>
  </template>
  
  <script>
  import { ref, onMounted, watch } from 'vue';
  import { Chart, registerables } from 'chart.js';
  
  Chart.register(...registerables);
  
  export default {
    name: 'MonthlyprofitChart',
    props: {
      labels: {
        type: Array,
        required: true,
      },
      data: {
        type: Array,
        required: true,
      },
    },
    setup(props) {
      const monthlyprofitChart = ref(null);
      let chartInstance = null; // Store the chart instance
  
      const createChart = () => {
        const ctx = monthlyprofitChart.value.getContext('2d');
        if (chartInstance) {
          chartInstance.destroy(); // Destroy existing chart instance to avoid duplicate charts
        }
        chartInstance = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: props.labels, // Use labels from props
            datasets: [
              {
                label: 'Monthly Profit',
                data: props.data, // Use data from props
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
              },
            ],
          },
          options: {
            scales: {
              y: {
                beginAtZero: true,
              },
            },
          },
        });
      };
  
      // Watch for changes in props to update the chart
      watch(() => [props.labels, props.data], createChart);
  
      onMounted(() => {
        createChart();
      });
  
      return {
        monthlyprofitChart,
      };
    },
  };
  </script>
  
  <style scoped>
  canvas {
    min-width: 600px;
  }
  </style> -->

  <template>
    <div>
      <canvas ref="columnChart"></canvas>
    </div>
  </template>
  
  <script>
  import { ref, onMounted, watch } from 'vue';
  import { Chart, registerables } from 'chart.js';
  
  Chart.register(...registerables);
  
  export default {
    name: 'ColumnChart',
    props: {
      labels: {
        type: Array,
        required: true,
      },
      data: {
        type: Array,
        required: true,
      },
    },
    setup(props) {
      const columnChart = ref(null);
      let chartInstance = null; // Store the chart instance
  
      const createChart = () => {
        const ctx = columnChart.value.getContext('2d');
        if (chartInstance) {
          chartInstance.destroy(); // Destroy existing chart instance to avoid duplicates
        }
        chartInstance = new Chart(ctx, {
          type: 'bar', // Bar chart for column representation
          data: {
            labels: props.labels, // Use labels from props
            datasets: [
              {
                label: 'Monthly Net Profit',
                data: props.data, // Use data from props
                backgroundColor: props.data.map(value => value >= 0 ? 'rgba(75, 192, 192, 0.6)' : 'rgba(255, 99, 132, 0.6)'), // Different colors for positive/negative
                borderColor: props.data.map(value => value >= 0 ? 'rgba(75, 192, 192, 1)' : 'rgba(255, 99, 132, 1)'),
                borderWidth: 1,
                barPercentage: 0.5, // Adjust the width of the bars
              },
            ],
          },
          options: {
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  callback: function(value) {
                    return value < 0 ? value : '+' + value; // Format ticks to show '+' for positive values
                  },
                },
              },
              x: {
                stacked: false,
              },
            },
          },
        });
      };
  
      // Watch for changes in props to update the chart
      watch(() => [props.labels, props.data], createChart);
  
      onMounted(() => {
        createChart();
      });
  
      return {
        columnChart,
      };
    },
  };
  </script>
  
  <style scoped>
  canvas {
    min-width: 600px;
    max-width: 100%;
  }
  </style>
  