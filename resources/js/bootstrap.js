/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
// import 'admin-lte/plugins/jquery/jquery.min'
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min'
import 'admin-lte/dist/js/adminlte.min'
import router from './router'

$.fn.dataTable.ext.errMode = async (settings, tn, msg) => {
    if (settings && settings.jqXHR && settings.jqXHR.status === 401) {
        await router.push({name: 'login'})
    }
    if (settings.jqXHR?.status === 419) {
        location.reload()
    }
}// Datatables için err mode kapatılıyor tüm hataları biz yakalayacağız
$.fn.DataTable.ext.pager.numbers_length = 6 // Sayfalama genişliği

$.ajaxSetup({
  xhrFields: {
    withCredentials: true
  },
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
})

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
