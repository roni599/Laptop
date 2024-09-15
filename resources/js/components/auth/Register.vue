<template>
  <div id="layoutAuthentication mt-5">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-7">
              <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                  <h3 class="text-center font-weight-light my-4">
                    Create Account
                  </h3>
                </div>
                <div class="card-body">
                  <form @submit.prevent="signup">
                    <div class="row mb-3">
                      <div class="col-md-12">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="inputFirstName" type="text"
                            placeholder="Enter your first name" v-model="form.name" />
                          <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                          <label for="inputFirstName">Full Name</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com"
                        v-model="form.email" />
                      <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                      <label for="inputEmail">Email address</label>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="inputPassword" type="password" placeholder="Create a password"
                            v-model="form.password" />
                          <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                          <label for="inputPassword">Password</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                          <input class="form-control" id="inputPasswordConfirm" type="password"
                            placeholder="Confirm password" v-model="form.password_confirmation" />
                          <label for="inputPasswordConfirm">Confirm Password</label>
                        </div>
                      </div>
                    </div>
                    <div class="mt-4 mb-0">
                      <div class="d-grid">
                        <button class="btn btn-primary btn-block">
                          Create Account
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center py-3">
                  <div class="small">
                    <!-- <a href="login.html">Have an account? Go to login</a> -->
                    <router-link to="/">Have an account? Go to login</router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "Register-Form",
  mounted() {
    if (User.loggedIn()) {
      this.$router.push({ name: "Home" });
    }
  },
  data() {
    return {
      form: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      },
      errors: {}
    };
  },
  methods: {
    async signup() {
      await axios.post("/api/auth/signup", this.form)
        .then((res) => {
          User.responseAfterLogin(res);
          Toast.fire({
            icon: "success",
            title: "Signed in successfully"
          });
          this.$router.push({ name: 'Home' })
        })
        .catch((error) => {
          this.errors = error.response.data.errors
        })
    }
  }
};
</script>

<style></style>