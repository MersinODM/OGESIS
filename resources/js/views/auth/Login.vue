<template>
  <div class="login-box mt-4">
    <!--    <div class="login-logo">-->
    <!--      &lt;!&ndash;        <div class="row">&ndash;&gt;-->
    <!--      &lt;!&ndash;          <div class="text-center">&ndash;&gt;-->
    <!--      &lt;!&ndash;            <img src="images/Logo.PNG" class="img-circle" alt="...">&ndash;&gt;-->
    <!--      &lt;!&ndash;          </div>&ndash;&gt;-->
    <!--      &lt;!&ndash;        </div>&ndash;&gt;-->
    <!--      <a :href="sanitizeUrl"><b>{{ settings.city }}</b>ÖDM</a>-->
    <!--    </div>-->
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a
          href="/"
          class="h1"
        ><b>OGE</b>SIS</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">
          Kullanmaya başlamak için lütfen oturum açınız.
        </p>

        <form
          method="post"
          @submit.prevent
        >
          <div class="input-group mb-3">
            <input
              v-model="email"
              name="email"
              class="form-control"
              autocomplete="username"
              placeholder="Kullancı Adı/E-Posta giriniz"
            >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="mdi mdi-email form-control-feedback" />
              </div>
            </div>
            <span
              class="error invalid-feedback"
            >{{ }}</span>
          </div>
          <div class="input-group mb-3">
            <input
              v-model="password"
              name="password"
              type="password"
              class="form-control"
              autocomplete="current-password"
              placeholder="Şifrenizi giriniz"
            >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="mdi mdi-lock form-control-feedback" />
              </div>
            </div>
            <span

              class="error invalid-feedback"
            >{{ }}</span>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <button
                type="submit"
                class="btn btn-primary btn-block mb-3"
                @click="loginToSys"
              >
                Oturum Aç
              </button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <router-link
          :to="{ name: 'underConstruction' }"
          class="mb-2"
        >
          Şifremi unuttum
          <span class="mdi mdi-passport-biometric" />
        </router-link>
      </div>
    </div>
    <licence-info />
  </div>
</template>

<script>

import LicenceInfo from '../../components/LicenceInfo'
import SkinHelper from '../../utils/SkinHelper'
import { ref } from 'vue'
import { useStore } from 'vuex'
import { useAuthActionTypes } from '../../utils/constants'
// import router from "../../router";

export default {
  name: 'Login',
  components: { LicenceInfo },
  setup (props) {
    const store = useStore()
    const { AUTH, LOGIN } = useAuthActionTypes()
    SkinHelper.CloseModalSkin()
    SkinHelper.LoginSkin()
    const email = ref()
    const password = ref()
    const loginToSys = async () => {
      await store.dispatch(LOGIN.withPrefix(AUTH), { email: email.value, password: password.value })
    }

    // const getCsrfToken = async () => {
    //   await AuthService.getCsrfToken()
    // }

    // getCsrfToken()
    return {
      loginToSys,
      email,
      password
    }
  }
}
</script>

<style lang="scss">

</style>
