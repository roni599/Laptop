<template>
    <div class="container">
        <div class="card mt-4 mb-2">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Supplier</span>
            </div>
        </div>
        <button class="btn shadow-sm btn-primary mb-2" @click="openCreateSupplierModal()">Add Supplier</button>
        <div class="card mb-4 tt">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table fw-bold text-muted">
                    <i class="fas fa-table me-1"></i>
                    Category
                </div>
            </div>
            <div class="card-body">
                <table class="table text-muted">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Supplier Name</th>
                            <th scope="col">Eamil</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Shop Name</th>
                            <!-- <th scope="col">Product Name</th> -->
                            <th scope="col">Assign By</th>
                            <th scope="col">Image</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="supplier in suppliers" :key="supplier.id">
                            <td>{{ supplier.id }}</td>
                            <td>{{ supplier.name }}</td>
                            <td>{{ supplier.email }}</td>
                            <td>{{ supplier.phone }}</td>
                            <td>{{ supplier.address }}</td>
                            <td>{{ supplier.shopname }}</td>
                            <!-- <td>{{ supplier.product.product_model }}</td> -->
                            <td>{{ supplier.user.user_name }}</td>
                            <td>
                                <img :src="`/backend/images/supplier/${supplier.image}`" alt="User Image" width="50"
                                    height="50" />
                            </td>
                            <td>
                                <div class="buttonGroup py-2">
                                    <button type="button" class="btn btn-sm btn-success"
                                        @click="openEditModal(supplier)">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger mx-2" @click="deleteSupplier(supplier.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="createSupplierModal" tabindex="-1" aria-labelledby="createSupplierLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-3">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSupplierModal">
                            Create Supplier
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card rounded-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="icon_text d-flex gap-2 mt-3">
                                            <p><i class="fa-solid fa-chart-line"></i></p>
                                            <p class="text-black font-bold">Create Supplier</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="supplier_create" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputName" type="text"
                                                            placeholder="Enter your name" v-model="form.name" />
                                                        <small class="text-danger" v-if="errors.name">{{
                                                            errors.name[0]
                                                        }}</small>
                                                        <label for="inputName">Full Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputEmail" type="email"
                                                            placeholder="name@example.com" v-model="form.email" />
                                                        <small class="text-danger" v-if="errors.email">{{
                                                            errors.email[0]
                                                        }}</small>
                                                        <label for="inputEmail">Email address</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputAddress" type="text"
                                                            placeholder="Address" v-model="form.address" />
                                                        <small class="text-danger" v-if="errors.address">{{
                                                            errors.address[0]
                                                        }}</small>
                                                        <label for="inputAddress">Address</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPhone" type="text"
                                                            placeholder="Phone" v-model="form.phone" />
                                                        <small class="text-danger" v-if="errors.phone">{{
                                                            errors.phone[0]
                                                        }}</small>
                                                        <label for="inputPhone">Phone</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" readonly
                                                            aria-label="Default select example" v-model="form.user_id">
                                                            <option :value="users.id">
                                                                {{ users.user_name }}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.user_id">{{
                                                            errors.user_id[0]
                                                        }}</small>
                                                        <label for="inputAddress">Users Name</label>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" aria-label="Default select example"
                                                            v-model="form.product_id">
                                                            <option v-for="product in products" :key="product.id"
                                                                :value="product.id">{{ product.product_model }}</option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.product_id">{{
                                                            errors.product_id[0]
                                                            }}</small>
                                                        <label for="inputPhone">Product Model</label>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputShopName" type="text"
                                                            placeholder="Shop Name" v-model="form.shopname" />
                                                        <small class="text-danger" v-if="errors.shopname">{{
                                                            errors.shopname[0]
                                                        }}</small>
                                                        <label for="inputNid">Shop Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <!-- <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputShopName" type="text"
                                                            placeholder="Shop Name" v-model="form.shopname" />
                                                        <small class="text-danger" v-if="errors.shopname">{{
                                                            errors.shopname[0]
                                                            }}</small>
                                                        <label for="inputNid">Shop Name</label>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-11">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control p-3 px-4" id="inputFile" type="file"
                                                            @change="onFileSelect" />
                                                        <small class="text-danger" v-if="errors.image">{{
                                                            errors.image[0]
                                                        }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <img :src="form.image" width="55" height="55" />
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


        <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-3">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="editSupplierModal">
                            Edit Supplier
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mb-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card rounded-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="icon_text d-flex gap-2 mt-3">
                                            <p><i class="fa-solid fa-chart-line"></i></p>
                                            <p class="text-muted font-bold">Edit Supplier</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="supplier_edit" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputName" type="text"
                                                            placeholder="Enter your name"
                                                            v-model="editForm.edit_name" />
                                                        <small class="text-danger" v-if="errors.edit_name">{{
                                                            errors.edit_name[0]
                                                        }}</small>
                                                        <label for="inputName">Full Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputEmail" type="email"
                                                            placeholder="name@example.com"
                                                            v-model="editForm.edit_email" />
                                                        <small class="text-danger" v-if="errors.edit_email">{{
                                                            errors.edit_email[0]
                                                        }}</small>
                                                        <label for="inputEmail">Email address</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputAddress" type="text"
                                                            placeholder="Address" v-model="editForm.edit_address" />
                                                        <small class="text-danger" v-if="errors.edit_address">{{
                                                            errors.edit_address[0]
                                                        }}</small>
                                                        <label for="inputAddress">Address</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPhone" type="text"
                                                            placeholder="Phone" v-model="editForm.edit_phone" />
                                                        <small class="text-danger" v-if="errors.edit_phone">{{
                                                            errors.edit_phone[0]
                                                        }}</small>
                                                        <label for="inputPhone">Phone</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" readonly
                                                            aria-label="Default select example"
                                                            v-model="editForm.edit_user_id">
                                                            <option :value="users.id">
                                                                {{ users.user_name }}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.edit_user_id">{{
                                                            errors.edit_user_id[0]
                                                        }}</small>
                                                        <label for="inputAddress">Users Name</label>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" aria-label="Default select example"
                                                            v-model="editForm.edit_product_id">
                                                            <option v-for="product in products" :key="product.id"
                                                                :value="product.id">{{ product.product_model }}</option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.product_id">{{
                                                            errors.product_id[0]
                                                            }}</small>
                                                        <label for="inputPhone">Product Model</label>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputShopName" type="text"
                                                            placeholder="Shop Name" v-model="editForm.edit_shopname" />
                                                        <small class="text-danger" v-if="errors.edit_shopname">{{
                                                            errors.edit_shopname[0]
                                                        }}</small>
                                                        <label for="inputNid">Shop Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control p-3 px-4" id="inputFile" type="file"
                                                            @change="onUpdateFileSelect" />
                                                        <small class="text-danger" v-if="errors.edit_image">{{
                                                            errors.edit_image[0]
                                                        }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <img v-if="editForm.edit_image !== null"
                                                            :src="getupdateimageSrc()" alt="" width="55" height="55" />
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
import axios from "axios";
import { inject } from 'vue';
export default {
    name: "Supplier-vue",
    // mounted() {
    //     if (!User.loggedIn()) {
    //         this.$router.push({ name: "LoginForm" });
    //     }
    // },
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            userName,
            profile_img,
            products: [],
            users: [],
            suppliers: [],
            form: {
                name: null,
                email: null,
                address: null,
                phone: null,
                shopname: null,
                product_id: null,
                user_id: null,
                image: "/backend/assets/img/pic.jpeg",
            },
            editForm: {
                edit_id: null,
                edit_name: null,
                edit_email: null,
                edit_address: null,
                edit_phone: null,
                edit_shopname: null,
                edit_product_id: null,
                edit_user_id: null,
                edit_image: null
            },
            errors: {},
        };
    },
    methods: {
        openCreateSupplierModal() {
            let myModal = new bootstrap.Modal(
                document.getElementById("createSupplierModal"),
                {}
            );
            myModal.show();
        },
        async fetch_product() {
            await axios.get("/api/products")
                .then((res) => {
                    this.products = res.data;
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        onFileSelect(event) {
            let file = event.target.files[0];
            if (file.size > 1048576) {
                Toast.fire({
                    icon: "warning",
                    title: "image must be less then 1 mb!",
                });
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.image = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        async supplier_create() {
            await axios.post("/api/suppliers/store", this.form)
                .then((res) => {
                    this.form = {
                        name: null,
                        email: null,
                        address: null,
                        phone: null,
                        shopname: null,
                        product_id: null,
                        user_id: null,
                        image: '/backend/assets/img/pic.jpeg',
                    };
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("createSupplierModal")
                    );
                    myModal.hide();
                    this.fetch_suppliers();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
        async fetchUsers() {
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
                    console.log(error);
                });
        },
        async fetch_suppliers() {
            axios.get("/api/suppliers")
                .then((res) => {
                    this.suppliers = res.data;
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        async supplier_edit() {
            axios.put('/api/suppliers/update', this.editForm)
                .then((res) => {
                    this.editForm = {
                        edit_id: null,
                        edit_name: null,
                        edit_email: null,
                        edit_phone: null,
                        edit_address: null,
                        edit_shopname: null,
                        edit_product_id: null,
                        edit_user_id: null,
                        edit_image: null,
                    }
                    this.fetch_suppliers();
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("editSupplierModal")
                    );
                    myModal.hide();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
        },
        openEditModal(supplier) {
            this.editForm.edit_id = supplier.id;
            this.editForm.edit_name = supplier.name;
            this.editForm.edit_email = supplier.email;
            this.editForm.edit_address = supplier.address;
            this.editForm.edit_phone = supplier.phone;
            this.editForm.edit_product_id = supplier.product_id;
            this.editForm.edit_user_id = supplier.user_id;
            this.editForm.edit_shopname = supplier.shopname;
            this.editForm.edit_image = supplier.image;
            let myModal = new bootstrap.Modal(
                document.getElementById("editSupplierModal"),
                {}
            );
            myModal.show();
        },
        getupdateimageSrc() {
            if (this.editForm.edit_image) {
                if (this.editForm.edit_image.startsWith("data")) {
                    return this.editForm.edit_image;
                } else {
                    return `/backend/images/supplier/${this.editForm.edit_image}`;
                }
            }
            return "";
        },
        onUpdateFileSelect(event) {
            let file = event.target.files[0]
            if (file.size > 1048576) {
                Toast.fire({
                    icon: "warning",
                    title: "image must be less then 1 mb!"
                });
            }
            else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.editForm.edit_image = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        },
        async deleteSupplier(id) {
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
                        .delete("/api/suppliers/delete/" + id)
                        .then((res) => {
                            this.fetch_suppliers()
                        })
                        .catch((error) => {
                        });
                    Swal.fire({
                        title: "Deleted!",
                        text: "Category has been deleted.",
                        icon: "success",
                    });
                }
            });
        },
    },
    created() {
        this.fetch_product();
        this.fetchUsers();
        this.fetch_suppliers();
    }
};
</script>

<style scoped>
.full-width-modal {
    max-width: 100%;
    max-height: 100vh;
}

.full-width-modal .modal-content {
    width: 60%;
    height: 79vh;
    margin: auto;
}
</style>