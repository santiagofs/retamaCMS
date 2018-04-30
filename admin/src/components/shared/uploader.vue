<template>
  <div class="uploader">
    <ul class="uploader-list" v-if="uploadUrl">
      <li v-for="(file, index) in queue" :key="index" class="uploader-file">
        <div class="uploder-file__top">
          <span v-if="file.uploadStatus" class="uploder-file__upload-status" :class="[file.uploadStatus]">
            <checkIcon v-if="file.uploadStatus === 'success'" />
            <errorIcon v-if="file.uploadStatus === 'error'" />
          </span>
          <span class="uploder-file__name">{{file.name}}</span>
          <span class="uploder-file__remove" v-if="file.status !== 1" @click="removeFile(file)"><trash /></span>
        </div>
        <div class="uploder-file__error" v-if="file.error">{{file.error}}</div>
        <div class="uploder-file__progress-bar" v-if="file.status">
          <div class="uploder-file__progress" :style="{width: file.progress + '%'}"></div>
        </div>
      </li>
    </ul>
    <input type="file" ref="fileupload" @change="onFilesSelected" :multiple="multiple" />
    <div class="uploader-actions">
      <button class="button" @click="selectFile">select</button>
      <button class="button is-info" @click="processQueue" v-if="!autoupload && toUpload.length > 0">Upload</button>
    </div>
  </div>
</template>

<script>
import trash from 'icons/delete'
import checkIcon from 'icons/check'
import errorIcon from 'icons/alert-circle-outline'

export default {
  name: 'uploader',
  components: {trash, checkIcon, errorIcon},
  props: {
    extensions: {type: Array, default: () => ['jpg', 'jpeg', 'png', 'gif']},
    autoupload: Boolean,
    errors: {type: Array, default: () => []},
    maxFileSize: {default: 1024 * 1024 * 1000},
    multiple: Boolean,
    uploadUrl: {default: ''}
  },
  data () {
    return {
      queue: []
    }
  },
  computed: {
    toUpload () {
      return this.queue.filter(e => (!e.error && !e.status))
    }
  },
  methods: {
    selectFile () { this.$refs.fileupload.click() },
    checkValidExtension (file) {
      if (!this.extensions || !this.extensions.length) return true
      const ext = file.name.slice((file.name.lastIndexOf('.') - 1 >>> 0) + 2)
      return this.extensions.indexOf(ext) !== -1
    },
    onFilesSelected () {
      const files = this.$refs.fileupload.files
      if (!files.length) return false;

      for (var ndx = 0; ndx < files.length; ndx++) {
        var file = files.item(ndx);
        if (!this.checkValidExtension(file)) file.error = 'Invalid file type'

        if (file.size > this.maxFileSize) file.error = 'Max size exceeded (' + this.maxFileSize + ')'

        if (this.queue.filter(e => e.name === file.name).length) file.error = 'Already a file with that name'

        file.status = 0
        file.uploadStatus = ''
        file.response = ''

        this.queue.push(file)
      }

      this.$refs.fileupload.value = ''
      if (this.autoupload) this.processQueue()
    },
    updateFile (file, property, value) {
      const fileIndex = this.queue.indexOf(file);
      file[property] = value;
      this.$set(this.queue, fileIndex, file)
    },
    sendFile (file) {
      const xhr = new XMLHttpRequest();
      const fd = new FormData();
      this.updateFile(file, 'status', 1)

      xhr.open('POST', this.uploadUrl, true);

      xhr.upload.addEventListener('progress', e => {
        if (e.lengthComputable) {
          let percentage = Math.round((e.loaded * 100) / e.total);
          this.updateFile(file, 'progress', percentage)
        }
      }, false)

      xhr.upload.addEventListener('load', e => {}, false);

      xhr.addEventListener('readystatechange', e => {
        if (xhr.readyState === 4) {
          if (xhr.status !== 200) {
            this.updateFile(file, 'error', 'Error on server side')
            this.updateFile(file, 'uploadStatus', 'error')
          } else {
            this.updateFile(file, 'uploadStatus', 'success')
            this.updateFile(file, 'response', JSON.parse(xhr.responseText))
          }
          this.updateFile(file, 'status', 2)
          this.$emit('fileSent', file, this.queue)
          this.$emit('input', this.queue)

          if (this.multiple) {
            this.processQueue()
          } else {
            this.queue = []
          }
        }
      })

      fd.append('media_upload', file);
      xhr.send(fd);
    },
    removeFile (file) {
      const fileIndex = this.queue.indexOf(file);
      this.queue.splice(fileIndex, 1)
    },
    processQueue () {
      if (!this.toUpload.length) return false
      this.sendFile(this.toUpload[0])
    }
  }
}

</script>

<style lang="scss" scoped>
@import "~scss/_settings.scss";
.uploader {
  width: 100%;
  input[type="file"] {
    display: none;
  }

  .uploader-file {
    padding: 5px;
    border: 1px solid #DDD;
    border-radius: 4px;
    &:not(:first-child) {
      margin-top: 5px;
    }
  }

  .uploder-file__top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    max-width: 100%;
    overflow: hidden;
    .uploder-file__remove {
      flex: 0 0 20;
      display: flex;
      cursor: pointer;
      .material-design-icon {
        width: 18px; height: 18px;
        fill: $danger;
      }
      justify-content: space-between;
      align-items: center;
    }
    .uploder-file__name {
      flex: 1 0 0;
      overflow: hidden;
    }
    .uploder-file__upload-status {
      width: 24px;
      display: flex;
      .material-design-icon {
        width: 18px; height: 18px;
      }
      &.success {
        fill: $success;
      }
      &.error {
        fill: $danger;
      }
    }
  }
  .uploder-file__error {
    color: $danger;
    font-size: 12px;
  }
  .uploder-file__progress-bar {
    border: 1px solid #DDD;
    border-radius: 4px;
    background: #EEE;
    height: 8px;

    .uploder-file__progress {
      height: 8px;
      width: 0%;
      background: $turquoise;
      border-radius: 4px;
      transition: width 0.5s ease-in-out;
    }

  }
  .uploader-actions {
    text-align: right;
    padding-top: 16px;
  }

}
</style>

