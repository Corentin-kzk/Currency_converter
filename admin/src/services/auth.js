import { reactive } from 'vue'
import router from "@/router";
import axiosInstance from "@/services/axios";

export const store = reactive({
    user: null,
    errors: [],
    status: null,
    async getToken() {
        await axiosInstance.get("/sanctum/csrf-cookie");
    },
    async getUser() {
        await this.getToken();
        try {
            const data = await axiosInstance.get("/api/user");
            if (data) {
                return data
            }
        } catch (error) {
            return null;
        }
    },
    async handleLogin(data) {
        this.errors = [];
        await this.getToken();

        try {
            const response = await axiosInstance.post("/login", {
                email: data.email,
                password: data.password,
            });
            console.log(response);
            if (response?.status === 202) {
                const loggedUser = await this.getUser()
                this.user = loggedUser.data
                
                router.push("/")
            }
        } catch (error) {
            this.errors = { login : error.message}  
        }
        console.log("🚀 ~ file: auth.js:40 ~ handleLogin ~ this.errors :", this.errors )
        console.log("🚀 ~ file: auth.js:35 ~ handleLogin ~ this.user:", this.user)

        
    },
    async handleLogout() {
        await axiosInstance.post("/logout");
        this.user = null;
    },
});
