<template>
  <div class="container">
    <!-- <div class="card mt-4">
      <div class="card-header border-bottom-0 p-3">
        <router-link class="text-decoration-none" to="/home">Dashboard</router-link><span class="text-muted"> /
          Employee-Create</span>
      </div>
    </div> -->
    <div class="card mt-4">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          Employee-Create</span>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card rounded-lg mt-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="icon_text d-flex gap-2 mt-3">
              <p> <i class="fa-solid fa-chart-line"></i></p>
              <p class="text-black font-bold">Employee Insert</p>
            </div>
            <div class="code">
              <router-link class="btn btn-sm btn-success" to="/all_employee">All Employee</router-link>
            </div>
          </div>
          <div class="card-body">
            <form @submit.prevent="employee_create" enctype="multipart/form-data">
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
                      v-model="form.address" />
                    <small class="text-danger" v-if="errors.address">{{ errors.address[0] }}</small>
                    <label for="inputAddress">Address</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="inputSalary" type="text" placeholder="Salary"
                      v-model="form.salary" />
                    <small class="text-danger" v-if="errors.salary">{{ errors.salary[0] }}</small>
                    <label for="inputSalary">Salary</label>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="inputJoinDate" type="date" placeholder="Joining Date"
                      v-model="form.join_date" />
                    <small class="text-danger" v-if="errors.join_date">{{ errors.join_date[0] }}</small>
                    <label for="inputJoinDate">Joining Date</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="inputNid" type="text" placeholder="NID" v-model="form.nid" />
                    <small class="text-danger" v-if="errors.nid">{{ errors.nid[0] }}</small>
                    <label for="inputNid">NID</label>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <div class="form-floating mb-3 mb-md-0">
                    <input class="form-control" id="inputNid" type="text" placeholder="Phone" v-model="form.phone" />
                    <small class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</small>
                    <label for="inputNid">Phone</label>
                  </div>
                </div>
                <div class="col-md-5">
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
                  <button class="btn btn-primary btn-block">Submit</button>
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

export default {
  name: "Employee_create",
  mounted() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "LoginForm" });
    }
  },
  data() {
    return {
      form: {
        name: null,
        email: null,
        address: null,
        phone: null,
        salary: null,
        join_date: null,
        nid: null,
        image: '/backend/assets/img/pic.jpeg'
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
          console.log(this.form.image)
        }
        reader.readAsDataURL(file);
      }
    },

    async employee_create() {
      await axios.post('/api/employees/store', this.form)
        .then((res) => {
          this.form = ''
          Toast.fire({
            icon: "success",
            title: res.data.message
          });
          this.$router.push({ name: 'All_employee' })
        })
        .catch((error) => {
          this.errors = error.response.data.errors
        })
    }
  }
}
</script>

<style scoped></style>
