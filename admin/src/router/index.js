import { createRouter, createWebHistory } from "vue-router";
import auth from '@/middleware/auth';
import isNotLogged from '@/middleware/isNotLogged';

import HomeView from "@/views/HomeView.vue";
import LoginView from "@/views/LoginView.vue";
import DocumentationView from "@/views/DocumentationView.vue";
import UpdatePairView from "@/views/UpdatePairView.vue";
import CreatePairView from "@/views/CreatePairView.vue";




const routes = [
  {
    path: '/',
    name: 'Documentation',
    component: DocumentationView
  },
  {
    path: "/admin",
    name: "Home",
    component: HomeView,
    meta: {
      middleware: auth
    }
  },
  {
    path: "/login",
    name: "Login",
    component: LoginView,
  },
  {
    path: "/admin/pair/create",
    name: "New Pair",
    component: CreatePairView,
    meta: {
      middleware: auth
    }
  },
  {
    path: "/admin/pair/update/:id",
    name: "Update pair",
    component: UpdatePairView,
    props: true,
    meta: {
      middleware: auth
    }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});


function nextFactory(context, middleware, index) {
  const subsequentMiddleware = middleware[index];
  if (!subsequentMiddleware) return context.next;

  return (...parameters) => {
    context.next(...parameters);
    const nextMiddleware = nextFactory(context, middleware, index);
    subsequentMiddleware({ ...context, next: nextMiddleware });
  };
}



router.beforeEach((to, from, next) => {
  if (to.meta.middleware) {
    const middleware = Array.isArray(to.meta.middleware)
      ? to.meta.middleware
      : [to.meta.middleware];

    const context = {
      from,
      next,
      router,
      to,
    };
    const nextMiddleware = nextFactory(context, middleware, 1);

    return middleware[0]({ ...context, next: nextMiddleware });
  }

  return next();
});

export default router;
