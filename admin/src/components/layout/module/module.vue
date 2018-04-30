<style lang="scss" >
@import "~scss/_settings.scss";
.main-module {

  border-radius: 4px;
  height: 100%;


  .main-module_header {
    border-bottom: 1px solid #DDD;
    padding: 0 0 $gap;
    margin: 0 $gap;
    h1 {
      font-size: 1.4rem;
      .main-module_subtitle {
        color: #000;
        margin: 0;
      }
    }
  }
  .main-module_content {
    padding: $gap 0;
    // margin: 0 $gap;
    height: calc(100% - 50px);
    overflow: auto;
  }

}
</style>

<template>
  <section class="main-module">
      <header class="main-module_header ">
        <div class="level">
          <div class="level-left">
            <h1>
              <span class="main-module_title">{{title}}</span> <span v-if="subtitle">-</span> <span class="main-module_subtitle">{{subtitle}}</span>
            </h1>
          </div>
        <div class="actions level-right"><slot name="actions"></slot></div>
        </div>
      </header>
      <div class="main-module_content">
         <slot></slot>
      </div>
  </section>
</template>

<script>

export default {
  name: 'Module',
  props: {
    'title': {default: ''},
    subtitle: {default: ''}
  }
}
</script>

