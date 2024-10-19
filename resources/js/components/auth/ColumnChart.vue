<!-- <template>
    <div>
      <canvas ref="columnChart"></canvas>
    </div>
  </template>
  
  <script>
  import { ref, onMounted } from 'vue';
  import { Chart, registerables } from 'chart.js';
  
  Chart.register(...registerables);
  
  export default {
    name: 'ColumnChart',
    setup() {
      const columnChart = ref(null);
  
      onMounted(() => {
        const ctx = columnChart.value.getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July','August','September','October','November','December'],
            datasets: [
              {
                label: 'Sales',
                data: [65, 59, 80, 81, 56, 55, 40,70,40,30,45,90],
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
   -->

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
        chartInstance.destroy(); // Destroy existing chart instance to avoid duplicate charts
      }
      chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: props.labels, // Use labels from props
          datasets: [
            {
              label: 'Monthly Sales',
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