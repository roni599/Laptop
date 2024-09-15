import { createRouter, createWebHistory } from 'vue-router';

import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';
import Forget from '../components/auth/Forget.vue';
import Home from '../components/Home.vue';
import Logout from '../components/auth/Logout.vue';

import Create_user from '../components/users/Create_user.vue';
import User_list from '../components/users/User_list.vue';
import Role from '../components/users/Role.vue';

import Brand from '../components/brands/Brand.vue';

import Category from '../components/category/Category.vue';

import Product_create from '../components/product/Product_create.vue';
import All_product from '../components/product/All_product.vue';
import All_serials from '../components/stocks/All_serials.vue';

import Stocks_create from '../components/stocks/Stocks_create.vue';
import All_stocks from '../components/stocks/All_stocks.vue';

import Supplier from '../components/supplier/Supplier.vue';

import PaymentType from '../components/paymentType/PaymentType.vue';
import Investment from '../components/paymentType/Investment.vue';
import Reserve_table from '../components/paymentType/Reserve_table.vue';

import All_expense from '../components/expense/All_expense.vue';
import Expence_create from '../components/expense/Expence_create.vue';
import Expence_category from '../components/expense/Expence_category.vue';
import Bill_generate from '../components/bill/Bill_generate.vue';
import Bill_print from '../components/bill/Bill_print.vue';

const routes = [
    { name: 'LoginForm', component: Login, path: '/' },
    { name: 'RegisterForm', component: Register, path: '/register' },
    { name: 'Forget', component: Forget, path: '/forget' },
    { name: 'Home', component: Home, path: '/home' },
    { name: 'Logout', component: Logout, path: '/logout' },

    { name: 'User_create', component: Create_user, path: '/user_create' },
    { name: 'All_user', component: User_list, path: '/all_user' },
    { name: 'Role', component: Role, path: '/role' },

    { name: 'Brand', component: Brand, path: '/brand' },

    { name: 'Category', component: Category, path: '/category' },

    { name: 'Product_create', component: Product_create, path: '/product_create' },
    { name: 'All_product', component: All_product, path: '/all_product' },

    { name: "Stocks_create", component: Stocks_create, path: '/stocks_create' },
    { name: 'All_stocks', component: All_stocks, path: '/all_stocks' },
    { name: 'All_serials', component: All_serials, path: '/all_serials' },

    { name: "Supplier", component: Supplier, path: '/supplier' },

    {name:"Expence_category",component:Expence_category, path:'/expence_category'},
    {name:"Expence_create", component:Expence_create, path:'/expence_create'},
    {name:"All_expense", component:All_expense, path:'/all_expense'},

    {name:"Payment_type", component:PaymentType, path:'/payment_type'},
    {name:"Investment",component:Investment, path:'/investment'},
    {name:"Reserve_table",component:Reserve_table,path:'/reserve_table'},

    {name:"Bill", component:Bill_generate, path:'/bill_generate'},
    {name:"Bill_print",component:Bill_print,path:'/bill_print'},
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;