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
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4" id="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img v-show="!loading" @load="handleImageLoad" :src="`/backend/images/users/${profile_img}`"
                            class="images" alt="">
                    </a>
                    <!-- <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw text-white"></i></a> -->
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><router-link class="dropdown-item" to="/edit_profile">Settings</router-link></li>
                        <li><router-link class="dropdown-item" to="/activity_log">Activity Log</router-link></li>
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
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/role' }"
                                        to="/role">Role</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/user_create' }"
                                        to="/user_create">User Create</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/all_user' }"
                                        to="/all_user">User List</router-link>
                                </nav>
                            </div>
                            <router-link class="nav-link collapsed" :class="{ 'active': $route.path === '/category' }"
                                to="/category">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-th-large mt-1" style="color: grey !important;"></i>
                                </div>
                                <span :class="{ 'text-primary': $route.path === '/category' }">Category</span>
                            </router-link>


                            <router-link :class="{ 'active': $route.path === '/brand' }" to="/brand"
                                class="nav-link collapsed">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tags mt-1" style="color: grey !important;"></i>
                                </div>
                                Brands
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </router-link>

                            <router-link :class="{ 'active': $route.path === '/supplier' }" to="/supplier"
                                class="nav-link collapsed">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-truck" style="color: grey !important;"></i>
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
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/payment_type' }"
                                        to="/payment_type">Payment Create</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/investment' }"
                                        to="/investment">Investment</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/reserve_table' }"
                                        to="/reserve_table">Reserve Table</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/bills_table' }"
                                        to="/bills_table">Bills Table</router-link>
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
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/product_create' }"
                                        to="/product_create">Products Purchase</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/all_product' }"
                                        to="/all_product">Purchase History</router-link>
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
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/stocks_create' }"
                                        to="/stocks_create">Stocks Create</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/all_stocks' }"
                                        to="/all_stocks">Stocks List</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/all_serials' }"
                                        to="/all_serials">Serials List</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/return_repair' }"
                                        to="/return_repair">Return && Repair</router-link>
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
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/expence_category' }"
                                        to="/expence_category">Expense Category</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/expence_create' }"
                                        to="/expence_create">Expense Create</router-link>
                                    <router-link class="nav-link"
                                        :class="{ 'active text-primary': $route.path === '/all_expense' }"
                                        to="/all_expense">Expense List</router-link>
                                </nav>
                            </div>
                            <router-link class="nav-link collapsed"
                                :class="{ 'active': $route.path === '/bill_generate' }" to="/bill_generate">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-receipt mt-1" style="color: grey !important;"></i>
                                </div>
                                <span :class="{ 'text-primary': $route.path === '/bill_generate' }"> Bill
                                    Generate</span>
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
                            <div class="text-muted">Copyright &copy; Mystrix It 2024</div>
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
import axios from 'axios'; // Make sure to import axios

export default {
    name: "App",
    data() {
        const userName = ref('');
        const profile_img = ref('');
        const user_id = ref(null); // Define user_id here
        provide('userName', userName);
        provide('profile_img', profile_img);

        return {
            userName,
            profile_img,
            user_id, // Return user_id
            loading: true,
            inactivityTimer: null,
            form: {
                user_id: null,
            }
        };
    },
    methods: {
        handleImageLoad() {
            this.loading = false;
        },
        async activityLogout() {
            try {
                await axios.post('/api/activityLog/create', this.form);
            } catch (error) {
                console.error('Error creating activity log:', error);
            }
        },
        async fetchUsers() {
            const token = localStorage.getItem('token');
            try {
                const res = await axios.get("/api/auth/me", {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                this.user_id = res.data.id; // Set the user_id correctly
                this.form.user_id = this.user_id; // Also set form.user_id
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        },
        async logout() {
            await User.logout();
            this.$router.push({ name: "LoginForm" });
            Toast.fire({
                icon: "success",
                title: "Successfully Logged Out!"
            });
        },
        resetInactivityTimer() {
            clearTimeout(this.inactivityTimer);
            this.inactivityTimer = setTimeout(async () => {
                if (User.loggedIn()) {
                    await this.fetchUsers(); // Fetch user details first
                    await this.activityLogout(); // Make sure to wait for it
                    this.logout();
                    window.location.href = '/';
                }
            }, 1800000);
        },
    },
    mounted() {
        window.addEventListener('mousemove', this.resetInactivityTimer);
        window.addEventListener('keypress', this.resetInactivityTimer);
        window.addEventListener('click', this.resetInactivityTimer);
        window.addEventListener('scroll', this.resetInactivityTimer);
        this.resetInactivityTimer();
    },
    beforeUnmount() {
        window.removeEventListener('mousemove', this.resetInactivityTimer);
        window.removeEventListener('keypress', this.resetInactivityTimer);
        window.removeEventListener('click', this.resetInactivityTimer);
        window.removeEventListener('scroll', this.resetInactivityTimer);
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
    #navbar-nav,
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
