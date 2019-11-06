require('./bootstrap');

/**
 * ==============================================
 * RECURSOS DO ROUTER
 */
window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter)



/**
 * ==============================================
 * RECURSOS DO V-FORM
 */
import { Form, HasError, AlertError } from 'vform'
window.Form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


/**
 * ==============================================
 * ROTAS
 */
let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },

]
const router = new VueRouter({
    mode:'history',
    routes  
})


/**
 * ==========================================
 * filtros personalizados vue js
 */

import moment from 'moment';

Vue.filter('upText',function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
})
Vue.filter('myDate',function(created){
   return moment(created).format('Do MMMM YYYY');
})



/**
 * ================================================
 * recurso do progress bar
 */
import VueProgressBar from 'vue-progressbar'

const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '7px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
  }
Vue.use(VueProgressBar, options)



/**
 * =======================================
 * SWEET ALERT
 */
import Swal from 'sweetalert2'
window.swal = Swal
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
})
window.toast = Toast


/**
 * ==========================================
 *  VUE JS EVENTS fire vue js
 */

// fire is when a user is created in user's component
window.Fire = new Vue();


/**
 * PASSPORT COMPONENTS 
 * ===============================================
 */

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);


/**
 * ACL
 * ===============================================
 */
import Gate from './Gate'
Vue.prototype.$gate = new Gate(window.user)


/**
 * ==============================================
 * RENDER
 */
new Vue({
    el:"#app",
    router
})