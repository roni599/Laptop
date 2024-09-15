<template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          Roles</span>
      </div>
    </div>
    <button class="btn shadow-sm btn-primary mb-2" @click="openCreateRoleModal()">Add Role</button>
    <div class="card mb-4 tt">
      <div class="card-header d-flex justify-content-between">
        <div class="employee_table fw-bold text-muted">
          <i class="fas fa-table me-1"></i>
          Roles
        </div>
        <!-- <div class="addNew">
          <router-link to="/customer_create" class="btn btn-sm btn-success">Add New</router-link>
        </div> -->
      </div>
      <div class="card-body">
        <!-- <input type="text" class="form-control" id="searchInput" v-model="searchCustomer"
          placeholder="Search for ID.." /> -->
        <table class="table text-muted">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Role Name</th>
              <th scope="col">Permissions</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="role in roles" :key="role.id">
              <td>{{ role.id }}</td>
              <td>{{ role.role_name }}</td>
              <!-- <td>{{ role.permissions }}</td> -->
              <td>
                <span v-if="role.permissions == 1">Read</span>
                <span v-else-if="role.permissions == 2">Write</span>
                <span v-else-if="role.permissions == 3">Read Write Update</span>
                <span v-else-if="role.permissions == 4">Read Write Update Delete</span>
                <span v-else>No Permissions</span>
              </td>
              <td>{{ role.status }}</td>
              <td>
                <div class="buttonGroup py-2">
                  <button type="button" class="btn btn-sm btn-success" @click="openRoleEditModal(role)">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger mx-2" @click="deleteRole(role.id)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog full-width-modal mt-5">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-muted" id="createRoleModal">
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
                    <form @submit.prevent="category_create" enctype="multipart/form-data">
                      <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="text" placeholder="Enter your name"
                              v-model="form.role_name" />
                            <small class="text-danger" v-if="errors.role_name">{{
                              errors.role_name[0]
                            }}</small>
                            <label for="inputName">Role Name</label>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select text-muted h7" v-model="form.privilege"
                              aria-label="Default select example">
                              <option value="1" selected>Read</option>
                              <option value="2">Write</option>
                              <option value="3">Read Write Update</option>
                              <option value="4">Read Write Update Delete</option>
                            </select>
                            <small class="text-danger" v-if="errors.privilege">{{ errors.privilege[0] }}</small>
                            <label for="inputName">Select Privilege</label>
                          </div>
                        </div>
                      </div>
                      <div class="mt-3 mb-0">
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
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
      <div class="modal-dialog full-width-modal mt-5">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-muted" id="editRoleModal">
              Edit Role
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
                      <p class="text-muted font-bold">Edit Role</p>
                    </div>
                  </div>
                  <div class="card-body">
                    <form @submit.prevent="edit_role" enctype="multipart/form-data">
                      <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="text" placeholder="Enter your name"
                              v-model="edit_form.role_name" />
                            <small class="text-danger" v-if="errors.role_name">{{
                              errors.role_name[0]
                            }}</small>
                            <label for="inputName">Role Name</label>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select text-muted h7" v-model="edit_form.privilege"
                              aria-label="Default select example">
                              <option value="1" selected>Read</option>
                              <option value="2">Write</option>
                              <option value="3">Read Write Update</option>
                              <option value="4">Read Write Update Delete</option>
                            </select>
                            <small class="text-danger" v-if="errors.privilege">{{ errors.privilege[0] }}</small>
                            <label for="inputName">Select Privilege</label>
                          </div>
                        </div>
                      </div>
                      <div class="mt-3 mb-0">
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
  name: "Category_create",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      form: {
        role_name: null,
        privilege: null
      },
      edit_form: {
        id: null,
        role_name: null,
        privilege: null
      },
      userName,
      profile_img,
      roles: [],
      errors: {},
    };
  },
  methods: {
    async category_create() {
      await axios
        .post("/api/roles/store", this.form)
        .then((res) => {
          this.form = {
            role_name: null,
            privilege: null,
          };
          let myModal = bootstrap.Modal.getInstance(
            document.getElementById("createRoleModal")
          );
          myModal.hide();
          this.all_roles();
          Toast.fire({
            icon: "success",
            title: res.data.message,
          });
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
    openCreateRoleModal() {
      let myModal = new bootstrap.Modal(
        document.getElementById("createRoleModal"),
        {}
      );
      myModal.show();
    },
    openRoleEditModal(role) {
      this.edit_form.id = role.id,
      this.edit_form.role_name = role.role_name;
      this.edit_form.privilege = role.permissions;
      let myModal = new bootstrap.Modal(
        document.getElementById("editRoleModal"),
        {}
      );
      myModal.show();
    },
    async all_roles() {
      await axios.get('/api/roles')
        .then((res) => {
          this.roles = res.data;
        })
        .catch((error) => {
          console.log(error)
        })
    },
    async edit_role() {
      await axios.put('/api/roles/update', this.edit_form)
        .then((res) => {
          this.all_roles();
          let myModal = bootstrap.Modal.getInstance(
            document.getElementById("editRoleModal")
          );
          myModal.hide();
          Toast.fire({
            icon: "success",
            title: res.data.message,
          });
        })
    },
    async deleteRole(id) {
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
            .delete("/api/roles/delete/" + id)
            .then((res) => {
              this.all_roles()
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
    // if (!User.loggedIn()) {
    //   this.$router.push({ name: "LoginForm" });
    // }
    this.all_roles();
    this.fetchUsers();
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
</style>