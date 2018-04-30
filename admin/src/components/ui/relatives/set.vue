<template>
  <div class="relative-set">
      <!-- <div class="connector connector-vertical top-connector"></div> -->
      <svg :class="['connector']" :style="{width: connectorWidth + 4, height: connectorHeight}" xmlns="http://www.w3.org/2000/svg"
      >
      <line :x1="0" :x2="connectorWidth" y1="50%" y2="50%" />
      <template v-for="n in totalParents" >
        <line :key="n" :x1="parentPosition(n)" :x2="parentPosition(n)" y1="0" y2="50%" />
      </template>

      <template v-for="n in totalChildren" >
         <line :key="n+100" :x1="childPosition(n)" :x2="childPosition(n)" y1="50%" y2="100%" />
      </template>

      <!-- <path :d="connectorPath" /> -->
      </svg>
      <div class="relative-set container">
        <relative v-for="(relative, ndx) in relatives" :key="ndx"></relative>
        <relative-empty @addRelative="addRelative"></relative-empty>
      </div>
  </div>
</template>

<script>
const connectorSize = 4
const relativeSize = 100
const relativeGap = 20
const fullRelativeSize = relativeSize + relativeGap

export default {
  name: 'RelativeSet',
  props: {
    relativeType: {default: 'child'}
  },
  data () {
    return {
      relatives: []
    }
  },
  methods: {
    linePosition (ndx, relativesCount) {
      let offset = (this.maxRelatives - relativesCount) * fullRelativeSize / 2
      offset += this.leftOffset
      offset += (fullRelativeSize * (ndx - 1))
      return offset
    },
    parentPosition (ndx) {
      return this.linePosition(ndx, this.totalParents)
    },
    childPosition (ndx) {
      return this.linePosition(ndx, this.totalChildren)
    },
    addRelative () {
      this.relatives.push({})
    }
  },
  computed: {
    totalParents () {
      return 1
    },
    totalChildren () {
      return this.relatives.length + 1
    },
    maxRelatives () {
      return Math.max(this.totalParents, this.totalChildren)
    },
    connectorWidth () {
      return ((this.maxRelatives - 1) * fullRelativeSize) + connectorSize
    },
    leftOffset () {
      return connectorSize / 2
    },
    rightOffset () {
      return this.connectorWidth - (connectorSize / 2)
    },
    connectorHeight () {
      return relativeSize / 2
    },
    connectorViewBox () {
      return '0 0 ' + (this.connectorWidth + connectorSize) + ' ' + relativeSize
    },
    connectorPath () {
      const path = []
      path.push('M 0 100')
      path.push('L 100')
      // const totalParents = 1

      // for(var i = 0; i < totalParents; i++) {
      //   offset = -(relativeSize+ (relativeGap/2)) * i
      //   path.push('M ' + 5o/total0 50')
      //   path.push('L 100')
      // }
      // path.push('V ' + connectorSize)
      // path.push('H 0')
      // path.push('Z')

      return path.join(' ')
    },
    horizontalConnectorSize () {
      const relativeSize = 100
      const connectorSize = 3
      return (this.relatives.length * relativeSize) + connectorSize + 'px'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.relative-set {
  position: relative;

  .top-connector {
      position: relative;
      left: 50%; top: 0;
      transform: translate(-50%, 0)
  }
  .container {
    display: flex;
    justify-content: center;
  }

}
</style>
