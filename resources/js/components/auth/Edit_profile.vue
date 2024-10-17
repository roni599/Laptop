<template>
    <div class="container">
        <div class="card mt-4 mb-4">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Edit-Profile</span>
            </div>
        </div>
        <ul class="nav nav-pills mb-3 gap-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active shadow-sm" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true"><i class="fa fa-user me-1"></i>Profile</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link shadow-sm" id="pills-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                    aria-selected="false"><i class="fa fa-lock me-1"></i>
                    Change Password</button>
            </li>
        </ul>
        <div class="tab-content py-1" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="card">
                    <div class="card-header">
                        Profile Details
                    </div>
                    <div class="card-body shadow-sm py-4">
                        <form @submit.prevent="updateUser" enctype="multipart/form-data">
                            <div class="row mb-4">
                                <!-- Image Preview -->
                                <div class="col-md-1">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <img v-if="form.image !== null" :src="getimageSrc()" alt="Profile Image"
                                            width="65" height="65" />
                                    </div>
                                </div>

                                <!-- Button to trigger file input -->
                                <div class="col-md-5">
                                    <div class="form-floating mb-3 mb-md-0 mt-2">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            @click="triggerFileInput">Upload New
                                            Photo</button>
                                        <input type="file" ref="fileInput" style="display: none;"
                                            @change="onFileSelect" />
                                        <small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
                                    </div>
                                    <label class="mt-1 text-secondary" for="image">Allowed JPG, GIF or PNG. Max size of
                                        800K</label>
                                </div>
                            </div>
                            <hr class="mb-4">
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
                                <div class="col-md-12">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputAddress" type="text" placeholder="Address"
                                            v-model="form.phone" />
                                        <small class="text-danger" v-if="errors.phone">{{
                                            errors.phone[0]
                                        }}</small>
                                        <label for="inputAddress">Phone</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary w-100 mb-2" :disabled="loading">
                                        <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span>
                                        <span v-if="!loading">Update</span>
                                        <span v-if="loading">Updating...</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div class="card">
                    <div class="card-header">
                        Change Password
                    </div>
                    <div class="card-body shadow-sm py-5">
                        <!-- <form @submit.prevent="updateUserPassword" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputSalary" type="text" placeholder="Salary"
                                            v-model="form2.password" />
                                        <small class="text-danger" v-if="errors.password">{{ errors.password[0]
                                            }}</small>
                                        <label for="inputSalary">Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputPasswordConfirm" type="password"
                                            placeholder="Confirm password" v-model="form2.password_confirmation" />
                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary w-100 mb-2" :disabled="loading">
                                        <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span>
                                        <span v-if="!loading">Update</span>
                                        <span v-if="loading">Updating...</span>
                                    </button>
                                </div>
                            </div>
                        </form> -->
                        <form @submit.prevent="updateUserPassword" enctype="multipart/form-data">
                            <!-- Password Input -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputPassword" type="password"
                                            placeholder="Password" v-model="form2.password" />
                                        <small class="text-danger" v-if="errors.password">{{ errors.password[0]
                                            }}</small>
                                        <label for="inputPassword">Password</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password Input with Show/Hide Toggle -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3 mb-md-0 position-relative">
                                        <input :type="showConfirmPassword ? 'text' : 'password'" class="form-control"
                                            id="inputPasswordConfirm" placeholder="Confirm password"
                                            v-model="form2.password_confirmation" />
                                        <label for="inputPasswordConfirm">Confirm Password</label>

                                        <!-- Eye Icon for Toggling Password Visibility -->
                                        <span class="position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"
                                            @click="toggleConfirmPassword">
                                            <i :class="showConfirmPassword ? 'fas fa-eye' : 'fas fa-eye-slash'"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-5 mb-0">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary w-100 mb-2" :disabled="loading">
                                        <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
                                            aria-hidden="true"></span>
                                        <span v-if="!loading">Change Password</span>
                                        <span v-if="loading">Cahnging...</span>
                                    </button>
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
import axios from 'axios';
import { inject } from 'vue';
import AppStorage from "../../Helpers/AppStorage";
export default {
    name: "Edit_profile",
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            userName,
            profile_img,
            loading: false,
            form: {
                id: null,
                name: null,
                email: null,
                phone: null,
                image: null
            },
            form2: {
                id: null,
                password: null,
                password_confirmation: null,
            },
            showConfirmPassword: false,
            errors: {},
            roles: [],

        }
    },
    methods: {
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
                    this.form.image = res.data.profile_img
                    this.form.name = res.data.user_name,
                        this.form.id = res.data.id,
                        this.form.phone = res.data.phone
                    this.form.email = res.data.email
                    this.form2.id = res.data.id
                })
                .catch((error) => {
                    console.log(error.response ? error.response.data : error.message);
                });
        },
        triggerFileInput() {
            this.$refs.fileInput.click();  // This will trigger the hidden file input
        },
        onFileSelect(event) {
            let file = event.target.files[0]; // Get the selected file

            if (file.size > 1048576) {  // Check if file size is larger than 1MB
                Toast.fire({
                    icon: "warning",
                    title: "Image must be less than 1 MB!",
                });
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.image = event.target.result;  // Set image data
                };
                reader.readAsDataURL(file);  // Read file as base64 data URL
            }
        },
        getimageSrc() {
            if (this.form.image) {
                // Check if the image is base64 encoded
                if (this.form.image.startsWith("data")) {
                    return this.form.image;
                } else {
                    return `/backend/images/users/${this.form.image}`;  // Return image path from server
                }
            }
            return "";
        },
        async updateUser() {
            this.loading = true;
            await axios.put('/api/roles/userSelfUpdate', this.form)
                .then((res) => {
                    console.log(res);
                    this.fetchData();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        toggleConfirmPassword() {
            this.showConfirmPassword = !this.showConfirmPassword; // Toggle visibility
        },
        async updateUserPassword() {
            this.loading = true;
            await axios.put('/api/roles/userSelfUpdaePassword', this.form2)
                .then((res) => {
                    this.fetchData();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        async all_roles() {
            await axios.get('/api/roles')
                .then((res) => {
                    this.roles = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    created() {
        this.fetchData();
        this.all_roles();
    }
}
</script>

<style></style>