import { store } from "@/services/auth.js";
import router from "@/router";

export default function isLogged({ next }) {
    console.log("🚀 ~ file: isLogged.js:7 ~ isLogged ~ store.user:", store.user)
    if (store.user) {
        return next();
    }
    
    router.push({name: "Login"});
}