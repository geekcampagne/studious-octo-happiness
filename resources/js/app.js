import './bootstrap';
import { createApp } from 'vue'
import router from './router';
// Vuetify
import  'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import * as labs from 'vuetify/labs/components'

const vuetify = createVuetify({
    components: {
        ...components,
        ...labs,
      },
      directives
})

const app = createApp().use(vuetify).use(router)

Object.entries(import.meta.globEager('./**/*.vue')).forEach(([path, definition]) => {
    app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default)
})

app.mount('#app')
