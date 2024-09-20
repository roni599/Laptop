<template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link>
        <span class="text-muted h5"> / Serials List</span>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between">
        <div class="employee_table">
          <i class="fas fa-table me-1"></i>
          Stocks List Table
        </div>
        <!-- <div class="addNew">
          <router-link to="/stocks_create" class="btn btn-sm btn-success">Add New</router-link>
        </div> -->
      </div>
      <div class="card-body">
        <input type="text" id="searchInput" v-model="searchSerial" placeholder="Search for ID.." />
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Serial Number</th>
              <th scope="col">Barcode Number</th>
              <th scope="col">Stock ID</th>
              <th scope="col">Assing By</th>
              <th scope="col">Color</th>
              <th scope="col">Status</th>
              <th scope="col">Return Status</th>
              <th scope="col">Image</th>
              <!-- <th scope="col">barcode</th> -->
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="serial in filteredSerials" :key="serial.id">
              <td>{{ serial.id }}</td>
              <td>{{ serial.serial_no }}</td>
              <td>{{ serial.barcode_no }}</td>
              <td>{{ serial.stock_id }}</td>
              <td>{{ serial.user.user_name }}</td>
              <td>{{ serial.color }}</td>
              <td>
                <span v-if="serial.status === 0">Processing</span>
                <span v-else>Ready for sale</span>
              </td>
              <td>
                <span v-if="serial.return_status === 0">At The Shop</span>
                <span v-else>Return</span>
              </td>
              <td>
                <img v-if="serial.image" :src="`/backend/images/serial/${serial.image}`" alt="User Image" width="55"
                  height="55" />
                <span v-else>User not <br> provide image</span>
              </td>
              <!-- <td class="text-center">
                <img v-if="Serial.barcode" :src="`data:image/png;base64,${Serial.barcode}`" alt="Barcode" width="100"
                  height="20" />
                <div>
                  {{ Serial.serial.serial_no }}
                </div>
              </td> -->
              <td>
                <div class="buttonGroup py-2 d-flex justify-between">
                  <button type="button" class="btn btn-sm btn-success" @click="openEditModal(serial)">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger mx-2" @click="deleteSerial(serial.id)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierLabel" aria-hidden="true">
      <div class="modal-dialog full-width-modal mt-3">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-muted" id="editSupplierModal">
              Edit Serial
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
                      <p class="text-muted font-bold">Edit Serial</p>
                    </div>
                  </div>
                  <div class="card-body">
                    <form @submit.prevent="serial_edit" enctype="multipart/form-data">
                      <div class="row mb-3">
                        <div class="col-md-6" hidden>
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputAddress" type="text" placeholder="Address"
                              v-model="form.user_id" />
                            <small class="text-danger" v-if="errors.user_id">{{
                              errors.user_id[0]
                            }}</small>
                            <label for="inputAddress">Users Name</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputName" type="text" placeholder="Enter your name"
                              v-model="form.serial_no" />
                            <small class="text-danger" v-if="errors.serial_no">{{
                              errors.serial_no[0]
                            }}</small>
                            <label for="inputName">Serial Number</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputEmail" type="text" placeholder="name@example.com"
                              v-model="form.barcode_no" />
                            <small class="text-danger" v-if="errors.barcode_no">{{
                              errors.barcode_no[0]
                            }}</small>
                            <label for="inputEmail">Barcode Number</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" aria-label="Default select example" v-model="form.status">
                              <option :value="0">Processing</option>
                              <option :value="1">Ready for sale</option>
                            </select>
                            <small class="text-danger" v-if="errors.status">{{
                              errors.status[0]
                            }}</small>
                            <label for="inputAddress">Status</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <select class="form-select" aria-label="Default select example"
                              v-model="form.return_status">
                              <option :value="0">At the shop</option>
                              <option :value="1">Return</option>
                            </select>
                            <small class="text-danger" v-if="errors.return_status">{{
                              errors.return_status[0]
                            }}</small>
                            <label for="inputPhone">Return Status</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputEmail" type="text" placeholder="name@example.com"
                              v-model="form.color" />
                            <small class="text-danger" v-if="errors.color">{{
                              errors.color[0]
                            }}</small>
                            <label for="inputEmail">Color</label>
                          </div>
                        </div>

                        <div class="col-md-5">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control p-3 px-4" id="inputFile" type="file"
                              @change="onUpdateFileSelect" />
                            <small class="text-danger" v-if="errors.image">{{
                              errors.image[0]
                            }}</small>
                          </div>
                        </div>
                        <div class="col-md-1">
                          <div class="form-floating mb-3 mb-md-0">
                            <img v-if="form.image !== null" :src="getupdateimageSrc()" alt="" width="55" height="55" />
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
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { inject } from 'vue';
export default {
  name: 'All_serials',
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      Serials: [],
      userName,
      profile_img,
      users: [],
      form: {
        id: null,
        serial_no: null,
        barcode_no: null,
        color: null,
        status: null,
        return_status: null,
        image: null,
        user_id: null
      },
      barcodeImage: '',
      errors: {},
      searchSerial:''
    }
  },
  methods: {
    async feth_Serials() {
      await axios.get("/api/serials")
        .then((res) => {
          console.log(res)
          this.Serials = res.data
        })
        .catch((error) => {
          console.log(error)
        })
    },
    async serial_edit() {
      await axios.put("/api/serials/upate", this.form)
        .then((res) => {
          let myModal = bootstrap.Modal.getInstance(
            document.getElementById("editSupplierModal")
          );
          this.feth_Serials();
          myModal.hide();
          Toast.fire({
            icon: "success",
            title: res.data.message,
          });
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        })
    },
    async deleteSerial(id) {
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
            .delete("/api/serials/delete/" + id)
            .then((res) => {
              this.feth_Serials()
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
    openEditModal(serial) {
      this.form = { ...serial }
      this.form.user_id = this.users.id
      let myModal = new bootstrap.Modal(
        document.getElementById("editSupplierModal"),
        {}
      );
      myModal.show();
    },
    getupdateimageSrc() {
      if (this.form.image) {
        if (this.form.image.startsWith("data")) {
          return this.form.image;
        } else {
          return `/backend/images/serial/${this.form.image}`;
        }
      }
      return "";
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
          this.form.image = event.target.result;
        }
        reader.readAsDataURL(file);
      }
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
    this.feth_Serials();
    this.fetchUsers();
  },
  computed: {
    filteredSerials() {
      return this.Serials.filter((serial) => {
        return (
          serial.id.toString().includes(this.searchSerial) || serial.barcode_no.toLowerCase().includes(this.searchSerial.toLowerCase()) || serial.serial_no.toLowerCase().includes(this.searchSerial.toLowerCase())
        );
      });
    },
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
  height: 70vh;
  margin: auto;
}
</style>