import { store } from "@/services/auth.js";
import router from "@/router";

export default async function auth({ next }) {
    const user = await store.getUser()
    console.log("🚀 ~ file: auth.js:6 ~ auth ~ user:", user)
    
    if (user) {
        return next();
    }
    else {
        router.push({ name: "Login" });
    }

}