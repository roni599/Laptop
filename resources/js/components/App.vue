<template>
    <div class="main">
        <nav class="sb-topnav navbar navbar-expand navbar-info bg-info"
            v-show="$route.path === '/' || $route.path === '/register' || $route.path === '/forget' ? false : true">
            <router-link class="navbar-brand ps-3" to="/home">
                <img src="/public/backend/assets/img/laptop_paradise2.png" alt="logo image" style="margin-left: -75px"
                    width="300" class="logo-lg">
            </router-link>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
                <i class="fas fa-bars text-white fs-4"></i>
            </button>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <div class="form-group mb-0 d-flex align-items-center">
                        <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
                        <button class="btn btn-light-secondary btn-search"><i
                                class="fas fa-search text-white"></i></button>
                    </div>
                </div>
            </form>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img v-show="!loading" @load="handleImageLoad" :src="`/backend/images/users/${profile_img}`"
                            class="images" alt="">
                    </a>
                    <!-- <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw text-white"></i></a> -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <router-link class="dropdown-item" to="/logout">Logout</router-link>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav"
                v-show="$route.path === '/' || $route.path === '/register' || $route.path === '/forget' ? false : true">
                <nav class="sb-sidenav accordion sb-sidenav-light shadow" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav sb-sidenav-menu-heading">
                            <div class="sb-sidenav-menu-heading">
                                <p>Navigation</p>
                            </div>
                            <router-link class="nav-link rounded-end mb-3 bg-secondary text-white" to="/home">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-home text-white"></i>
                                </div>
                                Dashboard
                            </router-link>
                            <!-- <router-link class="nav-link bg-secondary text-white fw-bold" to="/pos">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt text-white"></i>
                                </div>
                                POS
                            </router-link>
                            <div class="sb-sidenav-menu-heading">Interface</div> -->

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-users mt-1"></i>
                                </div>
                                Users
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link class="nav-link" to="/role">Role</router-link>
                                    <router-link class="nav-link" to="/user_create">User Create</router-link>
                                    <router-link class="nav-link" to="/all_user">User List</router-link>
                                </nav>
                            </div>
                            <router-link to="/category" class="nav-link collapsed">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-th-large mt-1"></i>
                                </div>
                                Category
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </router-link>
                            <router-link to="/brand" class="nav-link collapsed">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tags mt-1"></i>
                                </div>
                                Brands
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </router-link>

                            <router-link to="/supplier" class="nav-link collapsed">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                Suppliers
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </router-link>

                            <!-- <router-link to="/payment_type" class="nav-link collapsed">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                Payment
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </router-link> -->

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapsePayment" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                Payment
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </a>
                            <div class="collapse" id="collapsePayment" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link class="nav-link" to="/payment_type">Payment Create</router-link>
                                    <router-link class="nav-link" to="/investment">Investment</router-link>
                                    <router-link class="nav-link" to="/reserve_table">Reserve Table</router-link>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseproducts" aria-expanded="false"
                                aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-box-open mt-1"></i>
                                </div>
                                Products
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </a>
                            <div class="collapse" id="collapseproducts" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link class="nav-link" to="/product_create">Products Create</router-link>
                                    <router-link class="nav-link" to="/all_product">Products List</router-link>
                                </nav>
                            </div>


                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseExpense" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                Expence
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </a>
                            <div class="collapse" id="collapseExpense" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link class="nav-link" to="/expence_category">Expense Category</router-link>
                                    <router-link class="nav-link" to="/expence_create">Expense Create</router-link>
                                    <router-link class="nav-link" to="/all_expense">Expense List</router-link>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseStocks" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-chart-line mt-1"></i>
                                </div>
                                Stocks
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </a>
                            <div class="collapse" id="collapseStocks" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link class="nav-link" to="/stocks_create">Stocks Create</router-link>
                                    <router-link class="nav-link" to="/all_stocks">Stocks List</router-link>
                                    <router-link class="nav-link" to="/all_serials">Serials List</router-link>
                                </nav>
                            </div>

                            <router-link to="/bill_generate" class="nav-link collapsed">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                Bill Generate
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </router-link>

                            <!-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#collapseExpense" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-chart-line mt-1"></i>
                                </div>
                                Expence Category
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </a>
                            <div class="collapse" id="collapseExpense" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <router-link class="nav-link" to="/expence_create">Expense Create</router-link>
                                    <router-link class="nav-link" to="/all_expense">All Expense</router-link>
                                </nav>
                            </div> -->
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content"
                :class="{ 'pc-container': true, 'custom-style': $route.path !== '/' && $route.path !== '/register' && $route.path !== '/forget' }">
                <main>
                    <div class="container-fluid px-2"
                        :class="{ 'pc-content': true, 'no-padding': $route.path === '/' || $route.path === '/register' || $route.path === '/forget' }">
                        <router-view></router-view>
                    </div>
                </main>
                <footer class="py-3 w-100">
                    <div class="container-fluid"
                        v-show="$route.path === '/' || $route.path === '/register' || $route.path === '/forget' ? false : true">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, provide } from 'vue';
export default {
    name: "App",
    data() {
        const userName = ref('');
        const profile_img = ref('');
        provide('userName', userName);
        provide('profile_img', profile_img);
        return {
            userName,
            profile_img,
            loading: true,
            inactivityTimer: null,
        };
    },
    methods: {
        handleImageLoad() {
            this.loading = false;
        },
        resetInactivityTimer() {
            // Clear the existing timer
            clearTimeout(this.inactivityTimer);

            // Set a new timer for 10 minutes (600,000 milliseconds)
            this.inactivityTimer = setTimeout(() => {
                // Check if the user is logged in
                if (User.loggedIn()) {
                    // Trigger logout if the user is inactive for 10 minutes
                    User.logout();
                    window.location.href = '/'; // Redirect to login page after logout
                }
            }, 1800000); // 10 minutes in milliseconds
        },
    },
    mounted() {
        // Set up event listeners for user activity
        window.addEventListener('mousemove', this.resetInactivityTimer);
        window.addEventListener('keypress', this.resetInactivityTimer);
        window.addEventListener('click', this.resetInactivityTimer);
        window.addEventListener('scroll', this.resetInactivityTimer);

        // Start the timer initially
        this.resetInactivityTimer();
    },
    beforeUnmount() {
        // Remove event listeners when the component is destroyed
        window.removeEventListener('mousemove', this.resetInactivityTimer);
        window.removeEventListener('keypress', this.resetInactivityTimer);
        window.removeEventListener('click', this.resetInactivityTimer);
        window.removeEventListener('scroll', this.resetInactivityTimer);

        // Clear the timer when the component is destroyed
        clearTimeout(this.inactivityTimer);
    },

};
</script>

<style>
.input-group {
    position: relative;
}

.input-group .input-group-text {
    position: absolute;
    left: 10px;
    /* Adjust position */
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
}

.input-group .form-control {
    padding-left: 35px;
    /* Adjust padding to make room for the icon */
}

.pc-container {
    position: relative;
}

.pc-container .pc-content {
    padding-left: 35px;
    /* padding-right: 35px; */
    /* padding-top: 35px; */
}

.custom-style {
    padding-left: 227px;
    top: 56px;
    padding-top: 5px;
    min-height: calc(100vh - 130px);
}

.no-padding {
    padding-left: 0px;
    padding-right: 0px;
    padding-top: 0px;
}

@media (max-width: 1200px) {
    .custom-style {
        margin-left: 200px;
        padding-left: 245px;
        top: 50px;
    }
}

@media (max-width: 992px) {
    .custom-style {
        margin-left: 150px;
        top: 40px;
        min-height: calc(100vh - 100px);
    }

    .no-padding {
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 20px;
    }
}

.images {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: 2px solid #708090;
}

@media (max-width: 768px) {
    .custom-style {
        margin-left: 0;
        top: 40px;
        min-height: calc(100vh - 80px);
    }

    .no-padding {
        padding-left: 5px;
        padding-right: 5px;
    }
}

@media (max-width: 576px) {
    .custom-style {
        margin-left: 0;
        top: 40px;
        min-height: calc(100vh - 60px);
    }

    .no-padding {
        padding-left: 0;
        padding-right: 0;
    }
}

@media print {

    #navbar,
    #layoutSidenav_nav,
    #footer {
        display: none;
    }

    #layoutSidenav_content {
        margin: 0;
        padding: 0;
    }

    /* Ensure the content you want to print is visible */
    #print-area {
        display: block;
    }

    .logo-lg {
        display: none;
    }

    footer {
        display: none;
    }
}
</style>
