<template>
    <div class="container">
        <div class="card mt-4 mb-2">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Payment Type</span>
            </div>
        </div>
        <button class="btn shadow-sm btn-primary mb-2" @click="openCreatePaymentModal()">Add Payment-type</button>

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
                            <th scope="col">Payment Type</th>
                            <th scope="col">Assign By</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="paymenttype in paymenttypes" :key="paymenttype.id">
                            <th scope="row">{{ paymenttype.id }}</th>
                            <td>{{ paymenttype.pt_name }}</td>
                            <td>{{ paymenttype.user.user_name }}</td>
                            <td>{{ paymenttype.status }}</td>
                            <td>
                                <div class="buttonGroup py-2">
                                    <button type="button" class="btn btn-sm btn-success"
                                        @click="openEditModal(paymenttype)">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger mx-2"
                                        @click="deletePaymentType(paymenttype.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="createPaymentModal" tabindex="-1" aria-labelledby="createPaymentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-4">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="createPaymentModal">
                            Add Paymet-type
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
                                            <p class="text-muted font-bold">Add Payment-type</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="payme_type_create" enctype="multipart/form-data">
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCategoryName" type="text"
                                                            placeholder="Enter your name" v-model="form.payment_type" />
                                                        <small class="text-danger" v-if="errors.payment_type">{{
                                                            errors.payment_type[0]
                                                        }}</small>
                                                        <label for="inputName">Payment Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" readonly
                                                            aria-label="Default select example" v-model="form.user_id">
                                                            <option :value="users.id">
                                                                {{ users.user_name }}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.user_id">{{
                                                            errors.user_id[0] }}</small>
                                                        <label class="h6 text-black mb-0" for="inputSupplier">User
                                                            Name</label>
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
                                                        <span v-if="loading">Submit...</span>
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

        <div class="modal fade" id="editPaymentTypeModal" tabindex="-1" aria-labelledby="editPaymentTypeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="editPaymentTypeModal">
                            Edit Payment-type
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
                                            <p class="text-muted font-bold">Edit Payment-type</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="paymenttype_update" enctype="multipart/form-data">
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCategoryName" type="text"
                                                            placeholder="Enter your name"
                                                            v-model="editForm.edit_payment_type" />
                                                        <small class="text-danger" v-if="errors.edit_payment_type">{{
                                                            errors.edit_payment_type[0]
                                                        }}</small>
                                                        <label for="inputName">Payment Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-3">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" readonly
                                                            aria-label="Default select example"
                                                            v-model="editForm.edit_user_id">
                                                            <option :value="users.id">
                                                                {{ users.user_name }}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.edit_user_id">{{
                                                            errors.edit_user_id[0] }}</small>
                                                        <label class="h6 text-black mb-0" for="inputSupplier">User
                                                            Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-3">
                                                    <div class="col-md-12">
                                                        <div class="form-floating mb-3 mb-md-0">
                                                            <select class="form-select"
                                                                aria-label="Default select example"
                                                                v-model="editForm.edit_status">
                                                                <option :value="0">Inactive</option>
                                                                <option :value="1">Active</option>
                                                            </select>
                                                            <small class="text-danger" v-if="errors.edit_status">{{
                                                                errors.edit_status[0] }}</small>
                                                            <label for="inputPhone">Payment Type Status</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-0">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary w-100 mb-2" :disabled="loading">
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
    name: "PaymentType-vue",
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            form: {
                payment_type: null,
                user_id: null,
            },
            editForm: {
                id: null,
                edit_payment_type: null,
                edit_user_id: null,
                edit_status: null
            },
            errors: {},
            loading: false,
            updating: false,
            userName,
            profile_img,
            users: [],
            paymenttypes: []
        }
    },
    methods: {
        async payme_type_create() {
            this.loading = true
            await axios.post("/api/payment-types/store", this.form)
                .then((res) => {
                    this.form = {
                        brand_name: null,
                        user_id: null,
                    };
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("createPaymentModal")
                    );
                    myModal.hide();
                    this.fetch_paymenttype();
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
        openCreatePaymentModal() {
            let myModal = new bootstrap.Modal(
                document.getElementById("createPaymentModal"),
                {}
            );
            myModal.show();
        },
        async paymenttype_update() {
            this.updating = true;
            axios.put('/api/payment-types/upate', this.editForm)
                .then((res) => {
                    this.editForm = {
                        id: null,
                        edit_payment_type: null,
                        edit_status: null,
                        edit_user_id: null,
                    }
                    this.fetch_paymenttype();
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("editPaymentTypeModal")
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
        async deletePaymentType(id) {
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
                        .delete("/api/payment-types/delete/" + id)
                        .then((res) => {
                            this.fetch_paymenttype()
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
        openEditModal(paymenttype) {
            this.editForm.id = paymenttype.id;
            this.editForm.edit_payment_type = paymenttype.pt_name;
            this.editForm.edit_user_id = paymenttype.user_id;
            this.editForm.edit_status = paymenttype.status;
            let myModal = new bootstrap.Modal(
                document.getElementById("editPaymentTypeModal"),
                {}
            );
            myModal.show();
        },
        async fetch_paymenttype() {
            await axios.get('/api/payment-types')
                .then((res) => {
                    this.paymenttypes = res.data;
                })
                .catch((res) => {
                    console.log(res)
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
        this.fetchData();
        this.fetch_paymenttype();

    },
}
</script>

<style>
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
    height: 70vh;
    margin: auto;
}
</style>