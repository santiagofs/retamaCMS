<template>
  <div id="signin-wrapper" class="box">
    <div id="signin-form">
      <h1 class="title">Sign In</h1>
      <div class="form">

        <div class="field">
          <label class="label">Username/email</label>
          <div class="control">
            <input type="text" class="input" placeholder="username/email"  v-model="username" />
          </div>
        </div>

        <div class="field">
          <label class="label">Password</label>
          <div class="control">
            <input type="password" class="input" placeholder="password"  v-model="password" />
          </div>
        </div>
        <p class="error-message" v-if="errorMessage">
          {{ errorMessage }}
        </p>
        <div class="field is-grouped is-grouped-right">
          <div class="control">
            <button class="sign-in is-link button" @click="doSignIn()">Sign In</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
// import { mapActions } from 'vuex'
// import { store } from '@/store'

export default {
  name: 'SignIn',
  data () {
    return {
      username: 'santiagofs@gmail.com',
      password: 'a',
      showBP: false
    }
  },
  computed: {
    errorMessage () {
      return this.$store.state.user.loginErrorMessage
    }
  },
  methods: {
    doSignIn: function () {
      this.$store.dispatch('user/doSignIn', {
        username: this.username,
        password: this.password,
        router: this.$router
      })
    }
  }
}
</script>

<style lang="scss">
@import "~scss/_settings.scss";
#signin-wrapper {
  width: 400px;
  padding: $gap;
  margin: 50px auto;
  background: #FAFAFA;
  color: #333;
}

#signin-form {
  .label, .title {
    color: #333;
  }
  .error-message {
    font-size: 14px;
    color: $danger;
  }
  .bp-login-trigger {
    font-size: 14px;
    color: #666;
    text-align: center;
    padding-top: $gap;
    a {
      color: $primary;
    }
  }
}
.bp-login {
  position: fixed;
  left: 0; top: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,.2);
}
</style>

