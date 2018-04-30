<template>
  <admin-module title="Dashboard" class="dashboard">
    <div class="charts">
      <div class="chart-holder"><canvas id="canvas-1" /></div>
      <div class="chart-holder"><canvas id="canvas-2" /></div>
      <div class="chart-holder"><canvas id="canvas-3" /></div>
      <div class="chart-holder"><canvas id="canvas-4" /></div>
      <div class="chart-holder"><canvas id="canvas-5" /></div>
      <!-- <div class="chart-holder"><canvas id="canvas-6" /></div>
      <div class="chart-holder"><canvas id="canvas-7" /></div> -->
    </div>
  </admin-module>

</template>

<script>
/* eslint no-unused-vars: 0 */ // for chart unused variable
import sampleData from './chart-data'
import Chart from 'chart.js'


export default {
  name: 'Dashboard',
  data () {
    return {
      sampleData
    }
  },
  methods: {
    createChart (chartId, type) {
      const ctx = document.getElementById(chartId);
      const chart = new Chart(ctx, {
        type,
        data: sampleData.data,
        options: sampleData.options
      })
    }
  },
  mounted () {
    this.createChart('canvas-1', 'line')
    this.createChart('canvas-2', 'bar')
    this.createChart('canvas-3', 'pie')
    this.createChart('canvas-4', 'radar')
    this.createChart('canvas-5', 'polarArea')
    // this.createChart('canvas-6', 'bubble')
    // this.createChart('canvas-7', 'scatter')
    // this.createChart('canvas-8', 'radar')
  }
}
</script>

<style lang="scss">
@import "~scss/_settings.scss";
.dashboard {

  .main-module_content {
    margin: 0;
  }
  .charts {
    display: flex;
    flex-wrap: wrap;
    .chart-holder {
      position: relative;
      padding: $gap $gap $gap*3 $gap ;
      width: 50%;
    }
  }
}
</style>
