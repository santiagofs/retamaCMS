<template>
  <div class="relative-container">
    <div :class="['relative', gender, {active: active}]" @click="activate">
        <span :class="['gender', {default: gender === '?'}]">{{gender}}</span>
        <span :class="['text', {default: name === ''}]">
          <span v-if="!active">{{getName}}</span>
          <input type="text" class="name-input" v-if="active" v-model="name" :placeholder="getName" />
        </span>
        <span :class="['age', {default: age === '?'}]">{{age}}</span>
        <span :class="['diagnosis', {default: diagnosis === '?'}]">
          {{diagnosis}}
        </span>

        <a @click="save" v-if="active">save</a>
        {{active}}
    </div>
  </div>
</template>

<script>
export default {
  name: 'Relative',
  props: {
    name: {default: ''},
    age: {default: '?'},
    gender: {default: '?'},
    diagnosis: {default: '?'},
    relation: {default: 'child'}
  },
  data () {
    return {
      active: false,
      form: {
        name: '',
        gender: '',
        age: '',
        diagnosis: ''
      }
    }
  },
  methods: {
    activate () {
      this.active = true
    },
    save (ev) {
      console.log(ev)
      ev.preventDefault()
      ev.stopPropagation()
      this.active = false
    }
  },
  computed: {
    getName () {
      return this.name ? this.name : this.relation + ' name'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
.relative {
  cursor: pointer;
  transition: all .5s ease-in-out;

  .text {
    width: 90%;
    margin: 0 auto;
    &.default {
      font-weight: normal;
      color: #CCC;
    }
  }
  input[type="text"] {
    font-size: 18px;
  }
  .name-input {
    box-sizing: border-box;
    width: 100%;

    text-align: center;
    &:focus {
      outline: none;
    }

  }
  &.active {

    z-index: 100;
    position: absolute;
    width: 160px; height: 160px;
    transform: translate(-40px, -40px)
  }
}
</style>
