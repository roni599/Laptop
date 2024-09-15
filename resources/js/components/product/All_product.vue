<template>
    <div class="container">

        <div class="card mt-4 mb-2">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Product-List</span>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table">
                    <i class="fas fa-table me-1"></i>
                    Product Table
                </div>
                <div class="addNew">
                    <router-link to="/product_create" class="btn btn-sm btn-success">Add New</router-link>
                    <button class="btn btn-sm btn-success ms-2" @click="exportToExcel">Export to Excel</button>
                </div>
            </div>
            <div class="card-body">
                <input type="text" id="searchInput" v-model="searchProducts" placeholder="Search for ID.." />
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Model</th>
                            <th scope="col">Specification</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Touch Status</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Stored By</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Brand Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in filteredProducts" :key="product.id">
                            <th scope="row">{{ product.id }}</th>
                            <td>{{ product.product_model }}</td>
                            <td>{{ product.specification }}</td>
                            <td>{{ product.quantity }}</td>
                            <td>{{ product.touch_status }}</td>
                            <td>{{ product.discount }}</td>
                            <td>{{ product.user.user_name }}</td>
                            <td>{{ product.category.cat_name }}</td>
                            <td>{{ product.brand.brand_name }}</td>
                            <td>
                                <div class="buttonGroup py-2">
                                    <button type="button" class="btn btn-sm btn-success"
                                        @click="openEditModal(product)">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger mx-2" @click="deleteProduct(product.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-3">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">
                            Edit Product
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-1">
                            <div class="col-lg-12">
                                <div class="card rounded-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="icon_text d-flex gap-2 mt-3">
                                            <p><i class="fa-solid fa-chart-line"></i></p>
                                            <p class="text-black font-bold">Edit Product</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="updateProduct" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputProductName" type="text"
                                                            placeholder="Enter product name"
                                                            v-model="form.product_model" />
                                                        <small class="text-danger" v-if="errors.product_model">{{
                                                            errors.product_model[0]
                                                            }}</small>
                                                        <label for="inputProductName">Product Model</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <textarea class="form-control" id="inputProductCode" type="text"
                                                            placeholder="Product Code"
                                                            v-model="form.specification"></textarea>
                                                        <small class="text-danger" v-if="errors.specification">{{
                                                            errors.specification[0]
                                                            }}</small>
                                                        <label for="inputEmail">Specification</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputRoot" type="text"
                                                            placeholder="Root" v-model="form.quantity" />
                                                        <small class="text-danger" v-if="errors.quantity">{{
                                                            errors.quantity[0]
                                                            }}</small>
                                                        <label for="inputRoot">Quentity</label>
                                                    </div>
                                                </div>
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
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" aria-label="Default select example"
                                                            v-model="form.brand_id">
                                                            <option v-for="brand in brands" :key="brand.id"
                                                                :value="brand.id">
                                                                {{ brand.brand_name }}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.brand_id">{{
                                                            errors.brand_id[0]
                                                            }}</small>
                                                        <label for="inputSellingPrice">Brand</label>
                                                    </div>
                                                </div>
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
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputBuyingDate" type="text"
                                                            placeholder="Buying Date" v-model="form.discount" />
                                                        <small class="text-danger" v-if="errors.discount">{{
                                                            errors.discount[0]
                                                            }}</small>
                                                        <label class="h6 mb-0" for="inputCategory">Discount</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" readonly
                                                            aria-label="Default select example" v-model="form.user_id">
                                                            <option :value="users.id">
                                                                {{ users.user_name }}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.user_id">{{
                                                            errors.user_id[0] }}</small>
                                                        <label class="h6 text-black mb-0"
                                                            for="inputSupplier">User</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-0 mb-0">
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { inject } from 'vue';
import * as XLSX from "xlsx";
export default {
    name: "AllProduct",
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            userName,
            profile_img,
            products: [],
            searchProducts: "",
            form: {
                id: null,
                product_model: null,
                specification: null,
                quantity: null,
                touch_status: null,
                discount: null,
                user_id: null,
                cat_id: null,
                brand_id: null,
            },
            errors: {},
            categories: [],
            brands: [],
            users: ''
        };
    },
    computed: {
        filteredProducts() {
            return this.products.filter((product) => {
                return (
                    product.id.toString().includes(this.searchProducts) || product.product_model.toLowerCase().includes(this.searchProducts.toLowerCase())
                );
            });
        },
    },
    methods: {

        exportToExcel() {
            // Prepare data for Excel export
            const exportData = this.filteredProducts.map(product => ({
                "Product ID": product.id,
                "Product Model": product.product_model,
                "Specification": product.specification,
                "Quantity": product.quantity,
                "Touch Status": product.touch_status,
                "Discount": product.discount,
                "Stored By": product.user.user_name,
                "Category Name": product.category.cat_name,
                "Brand Name": product.brand.brand_name
            }));

            // Create a new worksheet from the data
            const worksheet = XLSX.utils.json_to_sheet(exportData);

            // Create a new workbook and append the worksheet
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Products");

            // Trigger file download
            XLSX.writeFile(workbook, "Product_Table.xlsx");
        },



        async fetch_products() {
            await axios.get("/api/products")
                .then((res) => {
                    this.products = res.data
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        openEditModal(product) {
            this.form = { ...product };
            let myModal = new bootstrap.Modal(
                document.getElementById("editProductModal"),
                {}
            );
            myModal.show();
        },
        async updateProduct() {
            await axios
                .put("/api/products/update", this.form)
                .then((res) => {
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("editProductModal")
                    );
                    myModal.hide();
                    this.fetch_products();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
        async deleteProduct(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios
                        .delete("/api/products/delete/" + id)
                        .then((res) => {
                            this.products = this.products.filter((product) => {
                                return product.id != id;
                            });
                        })
                        .catch((error) => {
                            this.$router.push({ name: "All_product" });
                        });
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                }
            });
        },
        async fetchData() {
            const token = localStorage.getItem('token');
            await axios.get("/api/auth/me", {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then((res) => {
                    this.userName = res.data.user_name;
                    this.profile_img = res.data.profile_img
                    this.users = res.data;
                })
                .catch((error) => {
                    console.log(error.response ? error.response.data : error.message);
                });
        },
    },
    created() {
        this.fetch_products();
        axios.get("/api/categories").then((res) => {
            this.categories = res.data;
        });
        axios.get("/api/brands").then((res) => {
            this.brands = res.data;
        });
        this.fetchData();
    },
};
</script>

<style scoped>
#searchInput {
    background-image: url("/backend/assets/img/searchicon.png");
    background-position: 10px 12px;
    background-repeat: no-repeat;
    width: 100%;
    font-size: 16px;
    padding: 12px 20px 12px 40px;
    border: 1px solid #ddd;
    margin-bottom: 12px;
}

.full-width-modal {
    max-width: 100%;
    max-height: 100vh;
}

.full-width-modal .modal-content {
    width: 75%;
    height: 80vh;
    margin: auto;
}
</style>
