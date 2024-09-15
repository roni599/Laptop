import axios from "axios";
class Users_fetch{
    fetchUsers() {
        const token = localStorage.getItem('token');
        return axios.get("/api/auth/me", {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });
      }
}
export default Users_fetch=new Users_fetch();