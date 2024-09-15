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
                    <!-- <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img
                            src="/public/backend/images/users/135_ekRoni.png" class="images" alt="">
                        </a> -->
                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw text-white"></i></a>
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
                                    <router-link class="nav-link" to="/user_create">User Create</router-link>
                                    <router-link class="nav-link" to="/all_user">User List</router-link>
                                    <router-link class="nav-link" to="/role">Role</router-link>
                                </nav>
                            </div>

                            <router-link to="/brand" class="nav-link collapsed">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tags mt-1"></i>
                                </div>
                                Brands
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </router-link>

                            <router-link to="/category" class="nav-link collapsed">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-th-large mt-1"></i>
                                </div>
                                Category
                                <div class="sb-sidenav-collapse-arrow">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                            </router-link>

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
                                </nav>
                            </div>
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
export default {
    name:"Nav-vue",
    data(){
        return{}
    }
}
</script>

<style></style>