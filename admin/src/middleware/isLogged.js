import { store } from "@/services/auth.js";
import router from "@/router";

export default function isLogged({ next }) {
    const userCookie = store.getCookie('laravel_session')
    if (userCookie) {
        return next();
    }
    
    router.push({name: "Login"});
}