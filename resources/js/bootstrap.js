window._ = require('lodash')
window.Popper = require('popper.js').default
window.moment = require('moment')


try {
    window.$ = window.jQuery = require('jquery')

    require('bootstrap')
} catch (e) {}


window.axios = require('axios')

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

axios.interceptors.response.use(null, (error) => {
    if (error.response.status === 403) {
        router.push({ name: '403' })
    }

    return Promise.reject(error)
})
