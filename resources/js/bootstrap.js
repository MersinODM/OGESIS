/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
// import jquery from 'admin-lte/plugins/jquery/jquery.slim.min'
// import 'admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min'
// import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min'
// import 'admin-lte/dist/js/adminlte.min'
import router from './router'
// window.Jquery = window.$ = jquery

$.fn.dataTable.ext.errMode = async (settings) => {
  if (settings && settings.jqXHR && settings.jqXHR.status === 401) {
    await router.push({ name: 'login' })
  }
  if (settings.jqXHR?.status === 419) {
    // location.reload()
  }
}// Datatables için err mode kapatılıyor tüm hataları biz yakalayacağız
$.fn.DataTable.ext.pager.numbers_length = 6 // Sayfalama genişliği

// $(document).ajaxStart(() => {
$.ajaxSetup({
  cache: false,
  xhrFields: {
    withCredentials: true
  },
  headers: {
    'X-CSRF-TOKEN': document.getElementsByName('csrf-token')[0].getAttribute('content'),
    Accept: 'application/json'
  }
})

// })

// eslint-disable-next-line no-extend-native
String.prototype.withPrefix = function (prefix) {
  return prefix + this
}

// eslint-disable-next-line no-extend-native
String.prototype.withSuffix = function (suffix) {
  return this + suffix
}

// eslint-disable-next-line no-extend-native
Array.prototype.insert = function (index, item) {
  this.splice(index, 0, item)
}

