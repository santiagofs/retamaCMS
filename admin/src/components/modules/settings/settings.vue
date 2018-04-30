<template>
  <admin-module title="Settings" :subtitle="''">

    <div slot="actions">
      <button class="button is-info" @click="save">Save</button>
    </div>

        <div class="form">
          <field label="Logo" name="primary">
            <div class="logo-container">
              <div class="logo" :style="logo"></div>
              <div class="uploader-container">
                <uploader :upload-url="uploadUrl"
                  v-model="logo"
                  :extensions="['jpg', 'jpeg', 'png', 'gif']"
                  :max-file-size="1024 * 1024 * 1000"
                  :autoupload="true"
                  @fileSent="onFileSent"
                />
              </div>
            </div>
          </field>
        </div>

        <div class="colors">
          <field label="Primary color" name="primary" :validation="$v.colors.primary">
            <hex-color v-model="colors.primary" @input="$v.colors.primary.$touch()" />
          </field>

          <field label="Secondary color" name="secondary" :validation="$v.colors.secondary">
            <hex-color v-model="colors.secondary" @input="$v.colors.secondary.$touch()" />
          </field>

          <field label="Highlight color" name="highlight" :validation="$v.colors.highlight">
            <hex-color v-model="colors.highlight" @input="$v.colors.highlight.$touch()" />
          </field>

          <field label="Text color" name="text" :validation="$v.colors.text">
            <hex-color v-model="colors.text" @input="$v.colors.text.$touch()" />
          </field>

          <field label="Background color" name="background" :validation="$v.colors.background">
            <hex-color v-model="colors.background" @input="$v.colors.background.$touch()" />
          </field>

        </div>

  </admin-module>


</template>

<script>

import { mapState } from 'vuex'
import record from '@/components/layout/module/record'
import field from '@/components/layout/module/record/field'
import fieldStatus from '@/components/layout/module/record/field-status'
import * as CRUD from '@/main/crud'
import * as Alerts from '@/main/alerts'
import ColorField from '@/components/shared/color'
import HexColor from '@/components/shared/hex-color'

import { withParams } from 'vuelidate/lib'
import {req} from 'vuelidate/lib/validators/common'
import { required } from 'vuelidate/lib/validators'

const isHex = withParams({ type: 'isHex' }, value => {
  return !req(value) || /^#[0-9A-F]{6}$/i.test(value) || /^#[0-9A-F]{3}$/i.test(value)
})

export default {
  name: 'Edit',
  components: {record, 'field-status': fieldStatus, field, 'hex-color': HexColor, 'color-field': ColorField},
  data () {
    return {
      currentColor: 'primary'
    }
  },
  computed: {
    user () {
      return this.$store.state.user
    },
    ...mapState({
      allOptions: state => state.settings.allPlanOptions // 'settings/allPlanOptions'
    }),
    logo: {
      get () {
        console.log('in settings', this.$store.state.settings.logo)
        return {backgroundImage: 'url(' + this.$store.state.settings.logo + ')'}
      },
      set (value) {
        this.$store.commit('settings/logo', value)
      }
    },
    colors: {
      get () {
        return this.$store.state.settings.customization
      },
      set (value) {
        this.$store.commit('settings/customizations', value)
      }
    },
    uploadUrl () {
      return process.env.API_URL + '/media/upload'
    }
  },
  validations () {
    return {
      colors: {
        primary: {required, isHex},
        secondary: {required, isHex},
        highlight: {required, isHex},
        text: {required, isHex},
        background: {required, isHex}
      }

    }
  },
  methods: {
    save () {
      this.$store.dispatch('settings/saveSettings', this.user.id)
    },
    toggleOption (id, value) {
      this.$store.commit('settings/toggleOption', id)
    },
    doLeave (next) {
      // this.$store.commit('admins/setRecord', null);
      // this.$v.$reset()
      next()
    },
    onFileSent (file) {
      const that = this
      that.$store.commit('settings/tmpLogo', file.response)
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = function () {
        // console.log(reader.result)
        // this.logo = {backgroundImage: reader.result}
        that.$store.commit('settings/logo', reader.result)
      }
    }
  },
  beforeMount () {
    // if (this.$route.params.id === '0') return
    this.$store.dispatch('settings/getSettings', this.user.id)
  },
  beforeRouteLeave (to, from, next) {
    if (!CRUD.anyDirty(this.$v)) return this.doLeave(next)
    Alerts.confirmLeave().then(() => {
      this.doLeave(next)
    })
  }
}
</script>

<style lang="scss">
@import "~scss/_settings.scss";

.tabs {
  border-bottom: 1px solid #dbdbdb;
  &:not(:last-child) {
    margin-bottom: 0;
  }
  ul {
    border-bottom: none;
  }
}
.panel-control {
  padding: $gap;

}
.settings-control {
  padding: 0 $gap;
  align-items: flex-start;
}

.logo {
  width: 100px; height: 100px;
  border: 1px solid #DBDBDB;
  border-radius: 3px;
  background-position: center center;
  background-repeat: no-repeat;
  background-size: contain;
  margin-right: $gap;
  flex: 0 0 100px;
}
.logo-container {
  width: 400px;
  display: flex;
  justify-content: space-between;
  margin-bottom: $gap/2;
}
.uploader-container {
  flex: 0 0 280px;
  overflow: hidden;
}
.form {
  margin: 0 $gap $gap;
  max-width: 400px;
}

.colors {
  display: flex;
  flex-wrap: wrap;
  .field {
    margin: 0 $gap $gap;
  }
}
</style>

