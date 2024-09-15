<template>
  <div class="container">
    <div class="card mt-4">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          User-Create</span>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card rounded-lg mt-3">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="icon_text d-flex gap-2 mt-3">
              <p> <i class="fa-solid fa-chart-line"></i></p>
              <p class="text-black font-bold">User Create</p>
            </div>
            <div class="code">
              <router-link class="btn btn-sm btn-success" to="/all_user">All User</router-link>
            </div>
          </div>
          <div class="card-body">
            <form @submit.prevent="user_create" enctype="multipart/form-data">
              <div class="row mb-3">
                <div class="col-md-6">
                  <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="inputName" type="text" placeholder="Enter your name"
                      v-model="form.name" />
                    <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                    <label for="inputName">Full Name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com"
                      v-model="form.email" />
                    <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                    <label for="inputEmail">Email address</label>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-md-6">
                  <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="inputAddress" type="text" placeholder="Address"
                      v-model="form.phone" />
                    <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                    <label for="inputAddress">Phone</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3 mb-md-0">
                    <select class="form-select text-muted h7" v-model="form.role_id"
                      aria-label="Default select example">
                      <option :value="role.id" selected v-for="role in roles" :key="role.id">{{ role.role_name }}
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
                    <input class="form-control" id="inputSalary" type="text" placeholder="Salary"
                      v-model="form.password" />
                    <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                    <label for="inputSalary">Password</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password"
                      v-model="form.password_confirmation" />
                    <label for="inputPasswordConfirm">Confirm Password</label>
                  </div>
                </div>

              </div>

              <div class="row mb-3">
                <div class="col-md-11">
                  <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control p-3 px-4" id="inputFile" type="file" @change="onFileSelect" />
                    <small class="text-danger" v-if="errors.image">{{ errors.image[0] }}</small>
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
                  <!-- <button class="btn btn-primary btn-block">Submit</button> -->
                  <button class="btn btn-primary w-100 mb-2" :disabled="loading">
                    <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
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
</template>

<script>
import axios from 'axios';
import { inject } from 'vue';
export default {
  name: "Create_user",
  // mounted() {
  //   if (!User.loggedIn()) {
  //     this.$router.push({ name: "LoginForm" });
  //   }
  // },
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      form: {
        name: null,
        email: null,
        phone: null,
        password: null,
        role_id: null,
        password_confirmation: null,
        image: '/backend/assets/img/pic.jpeg'
      },
      userName,
      profile_img,
      errors: {},
      roles: [],
      loading: false
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

    async user_create() {
      this.loading = true
      await axios.post("/api/auth/signup", this.form)
        .then((res) => {
          this.form = {
            name: null,
            email: null,
            phone: null,
            password: null,
            role_id: null,
            password_confirmation: null,
            image: '/backend/assets/img/pic.jpeg'
          };
          Toast.fire({
            icon: "success",
            title: res.data.message
          });
          this.$router.push({ name: 'All_user' })
        })
        .catch((error) => {
          this.errors = error.response.data.errors
        })
        .finally(() => {
          this.loading = false
        })
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
  },
  created() {
    this.all_roles();
    this.fetchUsers();
  }
}
</script>

<style scoped></style>
