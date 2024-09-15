<template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          Expense Category</span>
      </div>
    </div>
    <button class="btn shadow-sm btn-primary mb-2" @click="openCreateExpenseCategoryModal()">Expense Category
      Create</button>
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
              <th scope="col">Expense Category Name</th>
              <th scope="col">Assign By</th>
              <th scope="col">Status</th>
              <th scope="col">Image</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="expensecategory in expensecategories" :key="expensecategory.id">
              <th scope="row">{{ expensecategory.id }}</th>
              <td>{{ expensecategory.category_name }}</td>
              <td>{{ expensecategory.user.user_name }}</td>
              <td>
                <span v-if="expensecategory.status == 0">Active</span>
                <span v-else>Inactive</span>
              </td>
              <td>
                <img :src="`/backend/images/expensecategory/${expensecategory.images}`" alt="User Image" width="50"
                  height="50" />
              </td>
              <td>
                <div class="buttonGroup py-2">
                  <button type="button" class="btn btn-sm btn-success" @click="openEditModal(expensecategory)">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger mx-2" @click="deleteBrand(expensecategory.id)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="createExpenseCategoryModal" tabindex="-1" aria-labelledby="createExpenseCategoryLabel"
      aria-hidden="true">
      <div class="modal-dialog full-width-modal mt-4">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-muted" id="createExpenseCategoryModal">
              Expense Category Create
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
                      <p class="text-muted font-bold">Expense Category Create</p>
                    </div>
                  </div>
                  <div class="card-body">
                    <form @submit.prevent="category_create" enctype="multipart/form-data">
                      <div class="row mb-1">
                        <div class="col-md-12 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="text" v-model="form.ecname" />
                            <small class="text-danger" v-if="errors.ecname">{{
                              errors.ecname[0]
                            }}</small>
                            <label for="inputName">Expense Category Name</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-12">
                          <div class="form-floating mb-2">
                            <select class="form-select" readonly aria-label="Default select example"
                              v-model="form.user_id">
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
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-11">
                          <div class="form-floating mb-2 mb-md-0">
                            <input class="form-control p-3 px-4" id="inputFile" type="file" @change="onFileSelect" />
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
                            <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
                              aria-hidden="true"></span>
                            <span v-if="!loading">Submiy</span>
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

    <div class="modal fade" id="editExpenseCategoryModal" tabindex="-1" aria-labelledby="editExpenseCategoryModalLabel"
      aria-hidden="true">
      <div class="modal-dialog full-width-modal mt-5">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-muted" id="editExpenseCategoryModal">
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
                    <form @submit.prevent="expensecategory_update" enctype="multipart/form-data">
                      <div class="row mb-1">
                        <div class="col-md-12 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="text" v-model="editForm.ecname" />
                            <small class="text-danger" v-if="errors.ecname">{{
                              errors.ecname[0]
                            }}</small>
                            <label for="inputName">Expense Category Name</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-12">
                          <div class="form-floating mb-2">
                            <select class="form-select" readonly aria-label="Default select example"
                              v-model="editForm.user_id">
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
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-12 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" aria-label="Default select example" v-model="editForm.status">
                              <option :value="0">Active</option>
                              <option :value="1">Inactive</option>
                            </select>
                            <small class="text-danger" v-if="errors.edit_status">{{
                              errors.edit_status[0]
                            }}</small>
                            <label for="inputName">Status</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-11">
                          <div class="form-floating mb-2 mb-md-0">
                            <input class="form-control p-3 px-4" id="inputFile" type="file"
                              @change="onUpdateFileSelect" />
                            <small class="text-danger" v-if="errors.image">{{
                              errors.image[0] }}</small>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-floating mb-3 mb-md-0">
                            <img v-if="editForm.image !== null" :src="getupdateimageSrc()" alt="" width="55"
                              height="55" />
                          </div>
                        </div>
                      </div>
                      <div class="mt-3 mb-0">
                        <div class="d-grid">
                          <button class="btn btn-primary w-100 mb-2" :disabled="loading">
                            <span v-if="updating" class="spinner-border spinner-border-sm me-2" role="status"
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
  name: "Expance_category",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      form: {
        ecname: null,
        user_id: null,
        image: '/backend/assets/img/pic.jpeg',
      },
      editForm: {
        id: null,
        user_id: null,
        ecname: null,
        image: null,
        status: null
      },
      userName,
      profile_img,
      expensecategories: [],
      users: [],
      errors: {},
      loading: false,
      updating: false,
    }
  },
  methods: {
    async category_create() {
      this.loading = true
      await axios.post("/api/expensecategory/store", this.form)
        .then((res) => {
          this.form = {
            ecname: null,
            user_id: null,
            image: '/backend/assets/img/pic.jpeg',
          };
          let myModal = bootstrap.Modal.getInstance(
            document.getElementById("createExpenseCategoryModal")
          );
          myModal.hide();
          this.fetch_expensecategories();
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
    openCreateExpenseCategoryModal() {
      let myModal = new bootstrap.Modal(
        document.getElementById("createExpenseCategoryModal"),
        {}
      );
      myModal.show();
    },
    openEditModal(expensecategory) {
      this.editForm = { ...expensecategory }
      this.editForm.image = expensecategory.images
      this.editForm.ecname = expensecategory.category_name
      let myModal = new bootstrap.Modal(
        document.getElementById("editExpenseCategoryModal"),
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
          return `/backend/images/expensecategory/${this.editForm.image}`;
        }
      }
      return "";
    },
    async expensecategory_update() {
      this.updating = true;
      axios.put('/api/expensecategory/upate', this.editForm)
        .then((res) => {
          this.editForm = {
            id: null,
            user_id: null,
            ecname: null,
            image: null,
            status: null
          }
          this.fetch_expensecategories();
          let myModal = bootstrap.Modal.getInstance(
            document.getElementById("editExpenseCategoryModal")
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
            .delete("/api/expensecategory/delete/" + id)
            .then((res) => {
              this.fetch_expensecategories()
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
          this.users = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async fetch_expensecategories() {
      axios.get('/api/expensecategory')
        .then((res) => {
          this.expensecategories = res.data;
        })
        .catch((error) => {
          console.log(error)
        })
    }
  },
  created() {
    this.fetchUsers();
    this.fetch_expensecategories();
  }
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
  height: 74vh;
  margin: auto;
}
</style>