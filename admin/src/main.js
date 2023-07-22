import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

import { createApp } from 'vue'
import App from '@/App.vue'
import router from "@/router";
import { VueQueryPlugin } from "@tanstack/vue-query";
import VueCookies from 'vue3-cookies'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
  icons: { defaultSet: 'mdi' }

})

createApp(App)
  .use(VueQueryPlugin)
  .use(vuetify)
  .use(router)
  .use(VueCookies, {
    expireTimes: "30d",
    path: "/",
    domain: "",
    secure: false,
    sameSite: "None",
  })
  .mount('#app')
