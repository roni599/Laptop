<template>
    <div class="container">
        <div class="card mt-4 mb-2">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Brands</span>
            </div>
        </div>
        <button class="btn shadow-sm btn-primary mb-2" @click="openCreateBrandModal()">Add Brand</button>

        <div class="card mb-4 tt">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table fw-bold text-muted">
                    <i class="fas fa-table me-1"></i>
                    Roles
                </div>
            </div>
            <div class="card-body">
                <table class="table text-muted">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Brand Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Image</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="brand in brands" :key="brand.id">
                            <th scope="row">{{ brand.id }}</th>
                            <td>{{ brand.brand_name }}</td>
                            <td>{{ brand.status }}</td>
                            <td>
                                <img :src="`/backend/images/brands/${brand.brand_image}`" alt="User Image" width="50"
                                    height="50" />
                            </td>
                            <td>
                                <div class="buttonGroup py-2">
                                    <button type="button" class="btn btn-sm btn-success" @click="openEditModal(brand)">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger mx-2" @click="deleteBrand(brand.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="createBrandModal" tabindex="-1" aria-labelledby="createBrandModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-4">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="createBrandModal">
                            Add Role
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
                                            <p class="text-muted font-bold">Add Role</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="brand_create" enctype="multipart/form-data">
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCategoryName" type="text"
                                                            placeholder="Enter your name" v-model="form.brand_name" />
                                                        <small class="text-danger" v-if="errors.brand_name">{{
                                                            errors.brand_name[0]
                                                            }}</small>
                                                        <label for="inputName">Brand Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-10">
                                                    <div class="form-floating mb-2 mb-md-0">
                                                        <input class="form-control p-3 px-4" id="inputFile" type="file"
                                                            @change="onFileSelect" />
                                                        <small class="text-danger" v-if="errors.image">{{
                                                            errors.image[0] }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <img :src="form.image" width="55" height="55" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-0">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary w-100 mb-2" :disabled="loading">
                                                        <span v-if="loading"
                                                            class="spinner-border spinner-border-sm me-2" role="status"
                                                            aria-hidden="true"></span>
                                                        <span v-if="!loading">Login</span>
                                                        <span v-if="loading">Logging in...</span>
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

        <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="editBrandModal">
                            Edit Brand
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
                                            <p class="text-muted font-bold">Edit Brand</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="brand_update" enctype="multipart/form-data">
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCategoryName" type="text"
                                                            placeholder="Enter your name"
                                                            v-model="editForm.brand_name" />
                                                        <small class="text-danger" v-if="errors.brand_name">{{
                                                            errors.brand_name[0]
                                                            }}</small>
                                                        <label for="inputName">Brand Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCategoryName" type="text"
                                                            placeholder="Enter your name" v-model="editForm.status" />
                                                        <small class="text-danger" v-if="errors.status">{{
                                                            errors.status[0]
                                                            }}</small>
                                                        <label for="inputName">Status</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-10">
                                                    <div class="form-floating mb-2 mb-md-0">
                                                        <input class="form-control p-3 px-4" id="inputFile" type="file"
                                                            @change="onUpdateFileSelect" />
                                                        <small class="text-danger" v-if="errors.image">{{
                                                            errors.image[0] }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <img v-if="editForm.image !== null" :src="getupdateimageSrc()"
                                                            alt="" width="55" height="55" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-0">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary w-100 mb-2" :disabled="loading">
                                                        <span v-if="updating"
                                                            class="spinner-border spinner-border-sm me-2" role="status"
                                                            aria-hidden="true"></span>
                                                        <span v-if="!updating">Login</span>
                                                        <span v-if="updating">Logging in...</span>
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
import axios from 'axios';
import { inject } from 'vue';

export default {
    name: "Brand-vue",
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            brands: [],
            userName,
            profile_img,
            form: {
                brand_name: null,
                image: '/backend/assets/img/pic.jpeg',
            },
            editForm: {
                id: null,
                brand_name: null,
                image: null,
                status: null
            },
            loading: false,
            updating: false,
            errors: {}
        }
    },
    methods: {
        onFileSelect(event) {
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
                    this.form.image = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        },
        async brand_create() {
            this.loading = true
            await axios.post('/api/brands/store', this.form)
                .then((res) => {
                    this.form = {
                        brand_name: null,
                        image: '/backend/assets/img/pic.jpeg',
                    };
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("createBrandModal")
                    );
                    myModal.hide();
                    this.fetch_brands();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.loading = false
                })
        },
        async fetch_brands() {
            await axios.get('/api/brands')
                .then((res) => {
                    this.brands = res.data;
                })
                .catch((error) => {

                })
        },
        openEditModal(brand) {
            this.editForm = { ...brand }
            this.editForm.image = brand.brand_image
            let myModal = new bootstrap.Modal(
                document.getElementById("editBrandModal"),
                {}
            );
            myModal.show();
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
                    this.editForm.image = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        },
        getupdateimageSrc() {
            if (this.editForm.image) {
                if (this.editForm.image.startsWith("data")) {
                    return this.editForm.image;
                } else {
                    return `/backend/images/brands/${this.editForm.image}`;
                }
            }
            return "";
        },
        openCreateBrandModal() {
            let myModal = new bootstrap.Modal(
                document.getElementById("createBrandModal"),
                {}
            );
            myModal.show();
        },
        async brand_update() {
            this.updating = true;
            axios.put('/api/brands/update', this.editForm)
                .then((res) => {
                    this.editForm = {
                        id: null,
                        brand_name: null,
                        image: null,
                        status: null
                    }
                    this.fetch_brands();
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("editBrandModal")
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
                .finally(() => {
                    this.updating = false
                })
        },
        async deleteBrand(id) {
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
                        .delete("/api/brands/delete/" + id)
                        .then((res) => {
                            this.fetch_brands()
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
                })
                .catch((error) => {
                    console.log(error);
                });
        },

    },
    created() {
        this.fetch_brands();
        this.fetchUsers();
    }
}
</script>

<style></style>