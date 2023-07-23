import { reactive } from 'vue'
import router from "@/router";
import axiosInstance from "@/services/axios";
import { useCookies } from 'vue3-cookies';

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
                this.user = data
                return data
            }
        } catch (error) {
            this.user = null
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
            if (response?.status === 202) {
                const loggedUser = await this.getUser()
                this.user = loggedUser.data

                router.push("/admin")
            }
        } catch (error) {
            this.errors = { login: error.message }
        }


    },
    async handleLogout() {
        await axiosInstance.post("/logout");
        this.user = null;
        router.push("/")
    },
    async getCookie(key) {
        const { cookies } = useCookies();
        const cookie = cookies.get(key)
        console.log("🚀 ~ file: auth.js:52 ~ getCookie ~ cookie:", cookie)
        return  cookie
    }
});
