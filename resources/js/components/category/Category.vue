<template>
    <div class="container">
        <div class="card mt-4 mb-2">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Category</span>
            </div>
        </div>
        <button class="btn shadow-sm btn-primary mb-2" @click="openCreateCategoryModal()">Add Category</button>
        <div class="card mb-4 tt">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table fw-bold text-muted">
                    <i class="fas fa-table me-1"></i>
                    Category
                </div>
            </div>
            <div class="card-body">
                <div class="table_size">
                    <table class="table text-muted">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Image</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in categories" :key="category.id">
                                <th scope="row">{{ category.id }}</th>
                                <td>{{ category.cat_name }}</td>
                                <td>{{ category.status }}</td>
                                <td>
                                    <img v-if="category.cat_img" :src="`/backend/images/categories/${category.cat_img}`"
                                        alt="User Image" width="50" height="50" />
                                    <span v-else>User not <br> provide image</span>
                                </td>
                                <td>
                                    <div class="buttonGroup py-2 d-flex justify-between">
                                        <button type="button" class="btn btn-sm btn-success"
                                            @click="openEditModal(category)">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger mx-2" @click="deleteCategory(category.id)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-4">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="createCategoryModal">
                            Add Category
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
                                            <p class="text-muted font-bold">Add Category</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="category_create" enctype="multipart/form-data">
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCategoryName" type="text"
                                                            placeholder="Enter your name" v-model="form.cat_name" />
                                                        <small class="text-danger" v-if="errors.cat_name">{{
                                                            errors.cat_name[0]
                                                            }}</small>
                                                        <label for="inputName">Category Name</label>
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
                                                        <span v-if="!loading">Submit</span>
                                                        <span v-if="loading">Submitting...</span>
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

        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="editCategoryModal">
                            Edit Categoy
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
                                            <p class="text-muted font-bold">Edit Category</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="category_update" enctype="multipart/form-data">
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCategoryName" type="text"
                                                            placeholder="Enter your name" v-model="editForm.cat_name" />
                                                        <small class="text-danger" v-if="errors.cat_name">{{
                                                            errors.brand_name[0]
                                                        }}</small>
                                                        <label for="inputName">Category Name</label>
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
                                                    <button class="btn btn-primary w-100 mb-2" :disabled="updating">
                                                        <span v-if="updating"
                                                            class="spinner-border spinner-border-sm me-2" role="status"
                                                            aria-hidden="true"></span>
                                                        <span v-if="!updating">Update</span>
                                                        <span v-if="updating">Updating...</span>
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
    name: "Category-vue",
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            loading: false,
            updating: false,
            userName,
            profile_img,
            categories: [],
            form: {
                cat_name: null,
                image: '/backend/assets/img/pic.jpeg',
            },
            editForm: {
                id: null,
                cat_name: null,
                image: null,
                status: null
            },
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
        openCreateCategoryModal() {
            let myModal = new bootstrap.Modal(
                document.getElementById("createCategoryModal"),
                {}
            );
            myModal.show();
        },
        async category_create() {
            this.loading = true
            const formData = new FormData();
            formData.append('cat_name', this.form.cat_name);

            if (this.form.image && this.form.image !== '/backend/assets/img/pic.jpeg') {
                // Append the image if it's not the default
                formData.append('image', this.form.image);
            }

            await axios.post('/api/categories/store', formData)
                .then((res) => {
                    this.form = {
                        cat_name: null,
                        image: '/backend/assets/img/pic.jpeg',
                    };
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("createCategoryModal")
                    );
                    myModal.hide();
                    this.feth_category();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .finally(() => {
                    this.loading = false;
                })
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
        openEditModal(category) {
            this.editForm = { ...category };
            this.editForm.image = category.cat_img;
            let myModal = new bootstrap.Modal(
                document.getElementById("editCategoryModal"),
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
                    return `/backend/images/categories/${this.editForm.image}`;
                }
            }
            return "";
        },
        async category_update() {
            this.updating = true;
            axios.put('/api/categories/update', this.editForm)
                .then((res) => {
                    this.editForm = {
                        id: null,
                        cat_name: null,
                        image: null,
                        status: null
                    }
                    this.feth_category();
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("editCategoryModal")
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
        async deleteCategory(id) {
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
                        .delete("/api/categories/delete/" + id)
                        .then((res) => {
                            this.categories = this.categories.filter((cat) => {
                                return cat.id != id
                            })
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
        async feth_category() {
            await axios.get("/api/categories")
                .then((res) => {
                    this.categories = res.data;
                })
                .catch((error) => {

                })
        },
    },
    created() {
        this.feth_category();
        this.fetchUsers();
    }
}
</script>

<style scoped>
.table_size {
    width: 100%;
    overflow: auto;
}
</style>