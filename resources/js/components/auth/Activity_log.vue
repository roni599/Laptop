<template>
    <div class="container">
        <div class="card mt-4 mb-4">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Activity-log</span>
            </div>
        </div>
        <div class="card mb-4 tt">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table fw-bold text-muted">
                    <i class="fas fa-table me-1"></i>
                    Activity Logs Table
                </div>
            </div>
            <div class="table_size">
                <div class="card-body">
                    <div class="table_size">
                        <table class="table text-muted table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Activity Log Type</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(activity, index) in paginatedActivityLogs" :key="activity.id">
                                    <td>{{ startEntry + index }}</td>
                                    <td>{{ activity.type }}</td>
                                    <td>{{ activity.user.user_name }}</td>
                                    <td>
                                        <span class="badge bg-success" v-if="activity.status === '1'">Active</span>
                                        <span class="badge bg-danger" v-else>Inactive</span>
                                    </td>
                                    <td>
                                        <div>{{ formatDate(activity.created_at).date }}</div>
                                        <div>{{ formatDate(activity.created_at).time }}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="page d-flex justify-around align-items-center w-100">
                        <div class="text-muted mb-2 w-50">
                            Showing {{ startEntry }} to {{ endEntry }} of {{ filteredTotalEntries }} entries
                        </div>
                        <div class="pagination_link mt-2 w-50 d-flex justify-content-end">
                            <nav>
                                <ul class="pagination justify-content-center">
                                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(currentPage - 1)">
                                            <i class="fas fa-angle-left"></i>
                                        </a>
                                    </li>
                                    <li class="page-item" v-for="page in totalFilteredPages" :key="page"
                                        :class="{ active: currentPage === page }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(page)">{{ page }}</a>
                                    </li>
                                    <li class="page-item" :class="{ disabled: currentPage === totalFilteredPages }">
                                        <a class="page-link" href="#" @click.prevent="goToPage(currentPage + 1)">
                                            <i class="fas fa-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
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
    name: "Activity_log",
    data() {
        const userName = inject('userName');
        const profile_img = inject('profile_img');
        return {
            activitylogs: [],
            userName,
            profile_img,
            currentPage: 1,
            perPage: 10,
            id: null,
        }
    },
    computed: {
        paginatedActivityLogs() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.activitylogs.slice(start, start + this.perPage);
        },
        filteredTotalEntries() {
            return this.activitylogs.length;
        },
        totalFilteredPages() {
            return Math.ceil(this.filteredTotalEntries / this.perPage);
        },
        startEntry() {
            return (this.currentPage - 1) * this.perPage + 1;
        },
        endEntry() {
            const end = this.currentPage * this.perPage;
            return end > this.filteredTotalEntries ? this.filteredTotalEntries : end;
        },
    },
    methods: {
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
                    this.id = res.data.id;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const dateOptions = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                timeZone: 'Asia/Dhaka',
            };
            const timeOptions = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                timeZone: 'Asia/Dhaka',
                hour12: true,
            };
            const formattedDate = date.toLocaleDateString('en-GB', dateOptions);
            const formattedTime = date.toLocaleTimeString('en-GB', timeOptions);
            return {
                date: formattedDate,
                time: formattedTime,
            };
        },
        async activityLog() {
            if (this.id) {
                await axios.get(`/api/activityLog/${this.id}`)
                    .then((res) => {
                        this.activitylogs = res.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                console.error('User ID is not available.');
            }
        },
        goToPage(page) {
            if (page > 0 && page <= this.totalFilteredPages) {
                this.currentPage = page;
            }
        },
    },
    created() {
        this.fetchUsers().then(() => {
            this.activityLog();
        });
    }
}
</script>

<style scoped>
.table_size {
    width: 100%;
    overflow: auto;
}
</style>