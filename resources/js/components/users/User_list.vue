<template>
  <div class="container">
    <div class="card mt-4">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          All Users</span>
      </div>
    </div>
    <div class="card mb-4 mt-3 tt">
      <div class="card-header d-flex justify-content-between">
        <div class="employee_table">
          <i class="fas fa-table me-1"></i>
          Users Table
        </div>
        <div class="addNew">
          <router-link to="/user_create" class="btn btn-sm btn-success">Add New</router-link>
        </div>
      </div>
      <div class="card-body">
        <input type="text" id="searchInput" v-model="searchUser" placeholder="Search for ID.." />
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Phone</th>
              <th scope="col">Role Name</th>
              <th scope="col">Status</th>
              <th scope="col">Image</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in filteredUsers" :key="user.id">
              <th scope="row">{{ user.id }}</th>
              <td>{{ user.user_name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.phone }}</td>
              <td>{{ user.role.role_name }}</td>
              <td>{{ user.status }}</td>
              <td>
                <img :src="`/backend/images/users/${user.profile_img}`" alt="User Image" width="55" height="55" />
              </td>
              <td>
                <div class="buttonGroup py-2">
                  <button type="button" class="btn btn-sm btn-success" @click="openEditModal(user)">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger mx-2" @click="deleteUser(user.id)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
      <div class="modal-dialog full-width-modal mt-5">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">
              Edit User
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
                      <p class="text-black font-bold">Edit User</p>
                    </div>
                  </div>
                  <div class="card-body">
                    <form @submit.prevent="updateEmployee" enctype="multipart/form-data">
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputName" type="text" placeholder="Enter your name"
                              v-model="form.name" />
                            <small class="text-danger" v-if="errors.name">{{
                              errors.name[0]
                            }}</small>
                            <label for="inputName">Full Name</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com"
                              v-model="form.email" />
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
                            <input class="form-control" id="inputAddress" type="text" placeholder="Address"
                              v-model="form.phone" />
                            <small class="text-danger" v-if="errors.phone">{{
                              errors.phone[0]
                            }}</small>
                            <label for="inputAddress">Phone</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select text-muted h7" v-model="form.role_id"
                              aria-label="Default select example">
                              <option :value="role.id" selected v-for="role in roles" :key="role.id">{{ role.role_name
                                }}
                              </option>
                            </select>
                            <small class="text-danger" v-if="errors.role_id">{{ errors.role_id[0] }}</small>
                            <label for="inputNid">Role</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputNid" type="text" placeholder="Phone"
                              v-model="form.status" />
                            <small class="text-danger" v-if="errors.status">{{
                              errors.status[0]
                            }}</small>
                            <label for="inputNid">Status</label>
                          </div>
                        </div>
                        <div class="col-md-5">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control p-3 px-4" id="inputFile" type="file" @change="onFileSelect" />
                            <small class="text-danger" v-if="errors.image">{{
                              errors.image[0]
                            }}</small>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-floating mb-3 mb-md-0">
                            <img v-if="form.image !== null" :src="getimageSrc()" alt="" width="55" height="55" />
                          </div>
                        </div>
                      </div>
                      <div class="mt-4 mb-0">
                        <div class="d-grid">
                          <button class="btn btn-primary w-100 mb-2" :disabled="loading">
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
  name: "Userlist-vue",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      loading: false,
      users: [],
      roles: [],
      searchUser: "",
      form: {
        id: null,
        name: null,
        email: null,
        phone: null,
        role_id: null,
        status: null,
        image: null
      },
      userName,
      profile_img,
      errors: {},
    };
  },

  computed: {
    filteredUsers() {
      if (!Array.isArray(this.users)) {
        return [];
      }
      return this.users.filter((user) => {
        return (
          user.user_name.toString().includes(this.searchUser) ||
          user.phone.toString().includes(this.searchUser)
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
          title: "image must be less than 1 MB!",
        });
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.image = event.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    
    async fetch_user() {
      await axios.get('/api/alluser')
        .then((res) => {
          if (Array.isArray(res.data)) {
            this.users = res.data;
          } else {
            this.users = [];
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },

    openEditModal(employee) {
      this.form = { ...employee };
      this.form.name = employee.user_name;
      this.form.image = employee.profile_img;
      let myModal = new bootstrap.Modal(
        document.getElementById("editUserModal"),
        {}
      );
      myModal.show();
    },

    getimageSrc() {
      if (this.form.image) {
        if (this.form.image.startsWith("data")) {
          return this.form.image;
        } else {
          return `/backend/images/users/${this.form.image}`;
        }
      }
      return "";
    },

    async deleteUser(id) {
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
            .delete("/api/user/delete/" + id)
            .then((res) => {
              this.users = this.users.filter((user) => user.id !== id);
            })
            .catch((error) => {
              console.log(error);
              this.$router.push({ name: "All_user" });
            });
          Swal.fire("Deleted!", "User has been deleted.", "success");
        }
      });
    },

    async updateEmployee() {
      this.loading = true;
      await axios.put('/api/user/update', this.form)
        .then((res) => {
          let myModal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
          myModal.hide();
          this.fetch_user();
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

    async fetchUsers() {
      const token = localStorage.getItem('token');
      await axios.get("/api/auth/me", {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
        .then((res) => {
          this.userName = res.data.user_name;
          this.profile_img = res.data.profile_img;
          if (Array.isArray(res.data.users)) {
            this.users = res.data.users;
          } else {
            this.users = [];
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  created() {
    this.fetch_user();
    this.all_roles();
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
  height: 70vh;
  margin: auto;
}
</style>
