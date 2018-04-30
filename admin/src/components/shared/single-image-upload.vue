<template>
  <div class="single-image-upload">
    <div class="single-image-upload__image" :style="image"></div>
    <div class="single-image-upload__uploader-container">
      <uploader :upload-url="uploadUrl"

        :extensions="['jpg', 'jpeg', 'png', 'gif']"
        autoupload
        @fileSent="onFileSent"
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'SingleImageUpload',
  props: ['value', 'uploadUrl'],
  data () {
    return {
      image_: ''
    }
  },
  computed: {
    image () {
      const tmp = this.image_ || this.value
      return tmp ? {backgroundImage: 'url(' + tmp + ')'} : null
    }
  },
  methods: {
    onFileSent (file) {
      const _this = this
      this.$emit('fileSent', file.response)
      this.$emit('input', '') // erase the original url
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = function () {
        _this.image_ = reader.result
      }
    }
  }
}
</script>

<style lang="scss">
@import "~scss/_settings.scss";
.single-image-upload {
  max-width: 400px;
  display: flex;
  justify-content: space-between;
}
.single-image-upload__image {
  width: 100px; height: 100px;
  border: 1px solid #DBDBDB;
  border-radius: 3px;
  background-position: center center;
  background-repeat: no-repeat;
  background-size: contain;
  margin-right: $gap;
  flex: 0 0 100px;
}
.single-image-upload__uploader-container {
  flex: 0 0 280px;
  overflow: hidden;
}
</style>
