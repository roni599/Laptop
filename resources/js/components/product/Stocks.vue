<template>
    <div class="container">
        <div class="card mt-4 mb-3">
            <div class="card-header border-bottom-0 p-3">
                <router-link class="text-decoration-none" to="/home">Dashboard</router-link><span class="text-muted"> /
                    Product Stocks</span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table">
                    <i class="fas fa-table me-1"></i>
                    Product Stocks Table
                </div>
            </div>
            <div class="card-body">
                <input type="text" id="searchInput" v-model="searchProducts" placeholder="Search for ID.." />
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Code</th>
                            <th scope="col">Status</th>
                            <th scope="col">Quentity</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in filteredProducts" :key="product.id">
                            <th scope="row">{{ product.id }}</th>
                            <td>{{ product.product_name }}</td>
                            <td>{{ product.product_code }}</td>
                            <td v-if="product.product_quantity>=1"><span class="text-success">Available</span></td>
                            <td v-else><span class="text-danger">Not Available</span></td>
                            <td>{{ product.product_quantity }}</td>
                            <td>
                                <img :src="`/backend/images/product/${product.image}`" alt="Employee Image" width="55"
                                    height="55" />
                            </td>
                            <td>
                                <div class="buttonGroup py-2">
                                    <button type="button" class="btn btn-sm btn-success"
                                        @click="openEditModal(product)">
                                        <i class="fa-solid fa-pen-to-square"></i>
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
            <div class="modal-dialog full-width-modal mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">
                            Edit Stocks
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="card rounded-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="icon_text d-flex gap-2 mt-3">
                                            <p><i class="fa-solid fa-chart-line"></i></p>
                                            <p class="text-black font-bold">Edit Stocks</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="updateProduct" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control text-muted" id="inputProductName"
                                                            type="text" placeholder="Enter product name"
                                                            v-model="form.product_name" readonly />
                                                        <small class="text-danger" v-if="errors.product_name">{{
                                                            errors.product_name[0]
                                                            }}</small>
                                                        <label for="inputProductName">Product Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputProductQuentity"
                                                            type="text" placeholder="Product Quentity"
                                                            v-model="form.product_quantity" />
                                                        <small class="text-danger" v-if="errors.product_quantity">{{
                                                            errors.product_quantity[0]
                                                        }}</small>
                                                        <label for="inputProductQuentity">Product Quentity</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
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

export default {
    name: "AllProduct",
    data() {
        return {
            products: [],
            searchProducts: "",
            form: {
                id: null,
                product_name: null,
                product_quantity: null,
            },
            errors: {},
        };
    },
    created() {
        this.fetchProducts()
        axios.get("/api/categories").then((res) => {
            this.categories = res.data;
        });
        axios.get("/api/suppliers").then((res) => {
            this.suppliers = res.data;
        });
    },
    computed: {
        filteredProducts() {
            return this.products.filter((product) => {
                return (
                    product.id.toString().includes(this.searchProducts) || product.product_name.toString().includes(this.searchProducts)
                );
            });
        },
    },
    methods: {
        async fetchProducts() {
            await axios.get('/api/products')
                .then((res) => {
                    this.products = res.data;
                }).
                catch((error) => {

                });
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
            await axios.put("/api/products/stocks/update", this.form)
                .then((res) => {
                    this.fetchProducts();
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("editProductModal")
                    );
                    myModal.hide();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
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
    height: 65vh;
    margin: auto;
}
</style>
