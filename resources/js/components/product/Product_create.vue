<template>
    <div class="container">
        <div class="card mt-4 mb-2">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Products-Create</span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-lg mt-2">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="icon_text d-flex gap-2 mt-3">
                            <p><i class="fa-solid fa-chart-line"></i></p>
                            <p class="text-black font-bold">Product Create</p>
                        </div>
                        <div class="code">
                            <router-link class="btn btn-sm btn-success" to="/all_product">All Product</router-link>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="product_create" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputProductName" type="text"
                                            placeholder="Enter product name" v-model="form.product_model" />
                                        <small class="text-danger" v-if="errors.product_model">{{
                                            errors.product_model[0]
                                            }}</small>
                                        <label for="inputProductName">Product Model</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <textarea class="form-control" id="inputProductCode" type="text"
                                            placeholder="Product Code" v-model="form.specification"></textarea>
                                        <small class="text-danger" v-if="errors.specification">{{
                                            errors.specification[0]
                                            }}</small>
                                        <label for="inputEmail">Specification</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputRoot" type="text" placeholder="Root"
                                            v-model="form.quantity" />
                                        <small class="text-danger" v-if="errors.quantity">{{
                                            errors.quantity[0]
                                        }}</small>
                                        <label for="inputRoot">Quentity</label>
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" aria-label="Default select example"
                                            v-model="form.cat_id">
                                            <option v-for="category in categories" :key="category.id"
                                                :value="category.id">
                                                {{ category.cat_name }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-if="errors.cat_id">{{
                                            errors.cat_id[0]
                                            }}</small>
                                        <label for="Buying Price">Category</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" aria-label="Default select example"
                                            v-model="form.brand_id">
                                            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                                {{ brand.brand_name }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-if="errors.brand_id">{{
                                            errors.brand_id[0]
                                            }}</small>
                                        <label for="inputSellingPrice">Brand</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputBuyingDate" type="text"
                                            placeholder="Buying Date" v-model="form.touch_status" />
                                        <small class="text-danger" v-if="errors.touch_status">{{
                                            errors.touch_status[0]
                                            }}</small>
                                        <label for="inputBuyingDate">Touch Status</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <select class="form-select" readonly aria-label="Default select example"
                                            v-model="form.user_id">
                                            <option :value="users.id">
                                                {{ users.user_name }}
                                            </option>
                                        </select>
                                        <small class="text-danger" v-if="errors.user_id">{{ errors.user_id[0] }}</small>
                                        <label class="h6 text-black mb-0" for="inputSupplier">User</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { inject } from 'vue';
export default {
    name: "Product_create",
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            form: {
                product_model: null,
                specification: null,
                // quantity: null,
                touch_status: null,
                // discount: null,
                user_id: null,
                cat_id: null,
                brand_id: null,
            },
            userName,
            profile_img,
            categories: [],
            brands: [],
            users: [],
            suppliers: [],
            errors: {},
        };
    },
    methods: {
        async fetch_categories() {
            await axios.get("/api/categories")
                .then((res) => {
                    this.categories = res.data;
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async fetch_brands() {
            await axios.get("/api/brands")
                .then((res) => {
                    this.brands = res.data;
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async product_create() {
            await axios.post('/api/products/store', this.form)
                .then((res) => {
                    Toast.fire({
                        icon: "success",
                        title: res.data.message
                    });
                    this.$router.push({ name: 'All_product' })
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        },
        async fetchData() {
            const token = localStorage.getItem('token');
            await axios.get("/api/auth/me", {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then((res) => {
                    this.users = res.data;
                    this.userName = res.data.user_name;
                    this.profile_img = res.data.profile_img
                })
                .catch((error) => {
                    console.log(error.response ? error.response.data : error.message);
                });
        }
    },
    created() {
        this.fetch_categories();
        this.fetch_brands();
        this.fetchData()
    },

};
</script>

<style></style>
