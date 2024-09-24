import { createRouter, createWebHistory } from 'vue-router'
import Homepage from '../pages/Home.vue'
import LoginForm from '../pages/LoginForm.vue'
import RegisterForm from '../pages/RegisterForm.vue'
import CreateThread from '../page-components/user/CreateThread.vue'
import ViewThreads from '../page-components/user/ViewThreads.vue'
import ViewThread from '../page-components/user/ViewThread.vue';


const DEFAULT_TITLE = 'Anonimy';

const router = createRouter({
    mode: 'history',
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            meta: { title: DEFAULT_TITLE },
            component: Homepage
        },
        {
            path: '/login',
            name: 'login',
            meta: { title: DEFAULT_TITLE + ' | Login' },
            component: LoginForm
        },
        {
            path: '/register',
            name: 'register',
            meta: { title: DEFAULT_TITLE + ' | Register' },
            component: RegisterForm
        },
        {
            path: '/threads/create',
            name: 'Create a thread',
            meta: { title: DEFAULT_TITLE + ' | Create a thread' },
            component: CreateThread
        },
        {
            path: '/threads/view',
            name: 'View threads',
            meta: { title: DEFAULT_TITLE + ' | View threads' },
            component: ViewThreads
        },
        {
            path: '/thread/:slug',
            name: 'View thread',
            meta: { title: DEFAULT_TITLE + ' | View thread' },
            component: ViewThread
        }
    ]
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title

    next()
});

export default router