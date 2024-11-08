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
        type: Object,
        required: true,
      },
    },
    setup(props) {
      const columnChart = ref(null);
      let chartInstance = null;
  
      const createChart = () => {
        const ctx = columnChart.value.getContext('2d');
        if (chartInstance) {
          chartInstance.destroy();
        }
        chartInstance = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: props.labels,
            datasets: [
              {
                label: 'Monthly Sales Without Profit',
                data: props.data,
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
        columnChart,
      };
    },
  };
  </script>
  
  <style scoped>
  canvas {
    min-width: 600px;
  }
  </style>