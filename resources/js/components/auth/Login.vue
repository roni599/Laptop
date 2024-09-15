<template>
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content mx-auto">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow border-0 rounded-lg mt-5">
                <div class="text-center mt-5">
                  <img src="/public/backend/assets/img/logo-dark (1).svg" alt="images" class="img-fluid mb-2">
                  <h4 class="f-w-500 mb-2">Login with your email</h4>
                </div>
                <div class="card-body">
                  <form @submit.prevent="login">
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com"
                        v-model="form.email" />
                      <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                      <label for="inputEmail">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputPassword" type="password" placeholder="Password"
                        v-model="form.password" />
                      <label for="inputPassword">Password</label>
                      <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                    </div>
                    <div class="form-check mb-3">
                      <input class="form-check-input" id="inputRememberPassword" type="checkbox" />
                      <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                      <button class="btn btn-primary w-100 mb-2" :disabled="loading" @click="login">
                        <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
                          aria-hidden="true"></span>
                        <span v-if="!loading">Login</span>
                        <span v-if="loading">Logging in...</span>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<!-- <script>
import axios from "axios";
export default {
  name: "Login-From",
  mounted() {
    if (User.loggedIn()) {
      this.$router.push({ name: "Home" });
    }
  },
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      errors: {},
      loading: false
    };
  },
  methods: {
    async login() {
      this.loading = true
      await axios.post("/api/auth/login", this.form)
        .then((res) => {
          User.responseAfterLogin(res);
          Toast.fire({
            icon: "success",
            title: "Signed in successfully"
          });
          this.$router.push({ name: "Home" });
        })
        .catch((error) => {
          this.errors = error.response.data.errors
          Toast.fire({
            icon: "warning",
            title: "Invalid emial or password"
          })
        })
        .finally(() => {
          this.loading = false
        })
    },
  },
};
</script> -->
<script>
import axios from "axios";
export default {
  name: "Login-From",
  mounted() {
    if (User.loggedIn()) {
      this.$router.push({ name: "Home" });
    }
  },
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      errors: {},
      loading: false
    };
  },
  methods: {
    async login() {
      this.loading = true;
      try {
        const res = await axios.post("/api/auth/login", this.form);
        User.responseAfterLogin(res);
        Toast.fire({
          icon: "success",
          title: "Signed in successfully"
        });
        this.$router.push({ name: "Home" });
      } catch (error) {
        if (error.response && error.response.data.errors) {
          // Handle specific errors (e.g., invalid email or password)
          this.errors = error.response.data.errors;
          Toast.fire({
            icon: "warning",
            title: "Invalid email or password"
          });
        } else {
          // Handle other errors (e.g., network issues)
          Toast.fire({
            icon: "error",
            title: "An error occurred. Please try again later."
          });
        }
      } finally {
        // Ensure loading is false even after a failed attempt
        this.loading = false;
      }
    },
  },
};
</script>

<style></style>