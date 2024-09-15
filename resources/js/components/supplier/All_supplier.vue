<template>
    <div class="container">
        <div class="card mt-4 mb-3">
            <div class="card-header border-bottom-0 p-3">
                <router-link class="text-decoration-none" to="/home">Dashboard</router-link><span class="text-muted"> /
                    All Employee</span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table">
                    <i class="fas fa-table me-1"></i>
                    Employee Table
                </div>
                <div class="addNew">
                    <router-link to="/supplier_create" class="btn btn-sm btn-success">Add New</router-link>
                </div>
            </div>
            <div class="card-body">
                <input type="text" id="searchInput" v-model="searchSupplier" placeholder="Search for ID.." />
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Shop Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="supplier in filteredSuppliers" :key="supplier.id">
                            <th scope="row">{{ supplier.id }}</th>
                            <td>{{ supplier.name }}</td>
                            <td>{{ supplier.email }}</td>
                            <td>{{ supplier.phone }}</td>
                            <td>{{ supplier.address }}</td>
                            <td>{{ supplier.shopname }}</td>
                            <td>
                                <img :src="`/backend/images/supplier/${supplier.image}`" width="55" height="55" />
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

        <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEmployeeModalLabel">
                            Edit Supplier
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
                                            <p class="text-black font-bold">Edit Supplier</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="updateSupplier" enctype="multipart/form-data">
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
                                                        <input class="form-control" id="inputNid" type="text"
                                                            placeholder="Phone" v-model="form.phone" />
                                                        <small class="text-danger" v-if="errors.phone">{{
                                                            errors.phone[0]
                                                        }}</small>
                                                        <label for="inputNid">Phone</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputShopName" type="text"
                                                            placeholder="Phone" v-model="form.shopname" />
                                                        <small class="text-danger" v-if="errors.shopname">{{
                                                            errors.shopname[0]
                                                        }}</small>
                                                        <label for="inputNid">Phone</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
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
                                                        <img v-if="form.image !== null" :src="getimageSrc()" alt=""
                                                            width="55" height="55" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block">
                                                        Submit
                                                    </button>
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

export default {
    name: "AllSuppliers",

    data() {
        return {
            suppliers: [],
            searchSupplier: "",
            form: {
                id: null,
                name: null,
                email: null,
                address: null,
                phone: null,
                shopname: null,
                image: null,
            },
            errors: {},
        };
    },

    computed: {
        filteredSuppliers() {
            return this.suppliers.filter((supplier) => {
                return (
                    supplier.id.toString().includes(this.searchSupplier) ||
                    supplier.phone.toString().includes(this.searchSupplier)
                );
            });
        },
    },

    methods: {
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

        fetchSuppliers() {
            axios
                .get("/api/suppliers")
                .then((response) => {
                    this.suppliers = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        openEditModal(supplier) {
            this.form = { ...supplier };
            let myModal = new bootstrap.Modal(
                document.getElementById("editSupplierModal"),
                {}
            );
            myModal.show();
        },

        getimageSrc() {
            if (this.form.image) {
                if (this.form.image.startsWith("data")) {
                    return this.form.image;
                } else {
                    return `/backend/images/supplier/${this.form.image}`;
                }
            }
            return "";
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
                            this.suppliers = this.suppliers.filter((spl) => {
                                return spl.id != id;
                            });
                        })
                        .catch((error) => {
                            this.$router.push({ name: "All_supplier" });
                        });
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                }
            });
        },

        async updateSupplier() {
            await axios
                .put("/api/suppliers/update", this.form)
                .then((res) => {
                    this.fetchSuppliers();
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
                });
        },
    },

    mounted() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "LoginForm" });
        } else {
            this.fetchSuppliers();
        }
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
    width: 60%;
    height: 75vh;
    margin: auto;
}
</style>