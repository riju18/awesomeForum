
require('./bootstrap');

window.Vue = require('vue');
window.moment = require('moment');
window.Swal = require('sweetalert2');

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('userinfo', require('./components/UserInfo').default);
Vue.component('answer', require('./components/Answer').default);
Vue.component('favoritequestion', require('./components/FavoriteQuestion').default);
Vue.component('acceptanswer', require('./components/AcceptAnswer').default);
Vue.component('answervote', require('./components/AnswerVote').default);
Vue.component('questionvote', require('./components/QuestionVote').default);

const app = new Vue({
    el: '#app',
});
