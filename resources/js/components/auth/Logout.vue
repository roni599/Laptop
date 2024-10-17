<!-- <template></template>

<script>
export default {
    name: "Logout-From",
    mounted() {
        User.logout();
        this.$router.push({ name: "LoginForm" });
        Toast.fire({
            icon: "success",
            title: "Successfully Log Out!"
        });
    },
    data() {
        return {

        }
    }
}
</script>

<style></style> -->

<template></template>

<script>
import axios from 'axios';

export default {
    name: "LogoutForm",
    data() {
        return {
            user_id: null, // Declare user_id here
            form: {
                user_id: null // Will be set later
            }
        }
    },
    methods: {
        async fetchUsers() {
            const token = localStorage.getItem('token');
            try {
                const res = await axios.get("/api/auth/me", {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                this.user_id = res.data.id;
                this.form.user_id = this.user_id;
            } catch (error) {
            }
        },
        async activityLogout() {
            try {
                await axios.post('/api/activityLog/create', this.form)
                    .then((res) => {
                    })
                    .catch((error) => {
                        console.error('Error creating activity log:', error);
                    });
            } catch (error) {
                console.error('Error in activityLogout:', error);
                throw new Error('Failed to create activity log');
            }
        },
        async logout() {
            try {
                await User.logout(); // Perform the logout action
                this.$router.push({ name: "LoginForm" });
                Toast.fire({
                    icon: "success",
                    title: "Successfully Logged Out!"
                });
            } catch (error) {
                console.error('Error logging out:', error);
            }
        },
        async handleLogoutFlow() {
            try {
                // Step 1: Fetch the user data
                await this.fetchUsers();

                // Step 2: Log the activity after user data is fetched
                await this.activityLogout();

                // Step 3: Perform the actual logout
                await this.logout();
            } catch (error) {
                console.error('Error in logout flow:', error);
            }
        }
    },
    mounted() {
        this.handleLogoutFlow(); // Initiate the entire logout flow
    },
}
</script>

<style></style>
