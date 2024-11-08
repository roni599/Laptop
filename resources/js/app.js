// import './bootstrap';
// import { createApp } from 'vue'
// import router from './routes/router';
// import App from './components/App.vue';

// import User from './Helpers/User';
// import Users_fetch from './Helpers/Users_fetch';
// window.User = User;
// window.Users_fetch=Users_fetch;

// import Swal from 'sweetalert2';
// window.Swal = Swal;

// const Toast = Swal.mixin({
//     toast: true,
//     position: "top-end",
//     showConfirmButton: false,
//     timer: 1000,
//     timerProgressBar: true,
//     didOpen: (toast) => {
//         toast.onmouseenter = Swal.stopTimer;
//         toast.onmouseleave = Swal.resumeTimer;
//     }
// });
// window.Toast = Toast;

// createApp(App).use(router).mount("#app")
import './bootstrap';
import { createApp } from 'vue';
import router from './routes/router';
import App from './components/App.vue';

import User from './Helpers/User';
import Users_fetch from './Helpers/Users_fetch';
window.User = User;
window.Users_fetch = Users_fetch;

import Swal from 'sweetalert2';
window.Swal = Swal;

// Setting up SweetAlert2 Toast configuration
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});
window.Toast = Toast;

// Check if an existing Vue app instance is already mounted
if (document.getElementById('app').__vue_app__) {
    document.getElementById('app').__vue_app__.unmount();
}

// Create and mount the Vue app instance
createApp(App).use(router).mount("#app");
