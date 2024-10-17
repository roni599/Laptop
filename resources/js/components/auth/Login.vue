<template>
  <div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
      <main>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5">
              <div class="card shadow border-0 rounded-lg">
                <div class="text-center mt-4">
                  <img src="/public/backend/assets/img/logo-dark (1).svg" alt="images" class="img-fluid mb-2">
                  <h4 class="f-w-500 mb-2">Login with your email</h4>
                </div>
                <div class="card-body">
                  <form @submit.prevent="login">
                    <!-- Email Input -->
                    <div class="form-floating mb-3">
                      <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com"
                        v-model="form.email" />
                      <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                      <label for="inputEmail">Email address</label>
                    </div>

                    <!-- Password Input with Eye Icon -->
                    <div class="form-floating mb-3 position-relative">
                      <input class="form-control" :type="showPassword ? 'text' : 'password'" id="inputPassword"
                        placeholder="Password" v-model="form.password" />
                      <label for="inputPassword">Password</label>
                      <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>

                      <!-- Eye Icon -->
                      <span class="position-absolute end-0 top-50 translate-middle-y me-3"
                        @click="togglePasswordVisibility" style="cursor: pointer;">
                        <i :class="showPassword ? 'fas fa-eye' : 'fas fa-eye-slash'"></i>
                      </span>
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
      loading: false,
      showPassword: false, // Initially show eye-slash (password hidden)
    };
  },
  methods: {
    togglePasswordVisibility() {
      // Toggle password visibility
      this.showPassword = !this.showPassword;
    },
    async login() {
      this.loading = true;
      try {
        const res = await axios.post("/api/auth/login", this.form);
        console.log(res)
        User.responseAfterLogin(res);
        Toast.fire({
          icon: "success",
          title: "Signed in successfully"
        });
        this.$router.push({ name: "Home" });
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = error.response.data.errors;
          Toast.fire({
            icon: "warning",
            title: "Invalid email or password"
          });
        } else {
          Toast.fire({
            icon: "error",
            title: "An error occurred. Please try again later."
          });
        }
      } finally {
        this.loading = false;
      }
    },
  }
};
</script>

<style scoped>
/* Optional: Style for eye icon */
.position-relative {
  position: relative;
}

.end-0 {
  right: 0;
}

.me-3 {
  margin-right: 1rem;
}

.fas.fa-eye,
.fas.fa-eye-slash {
  color: #6c757d;
  /* Set icon color */
}
</style>
