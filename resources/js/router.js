import { createWebHistory, createRouter } from "vue-router";
import ListPage from "./components/pages/List.vue";
import LocationPage from "./components/pages/Location.vue";
import EmployersPage from "./components/pages/Employers.vue";
import SalariesPage from "./components/pages/Salaries.vue";

const routes = [
    {
        path: "/",
        component: ListPage,
        name: "list",
    },
    {
        path: "/location",
        component: LocationPage,
        name: "location",
    },
    {
        path: "/employers",
        component: EmployersPage,
        name: "employers",
    },
    {
        path: "/salaries",
        component: SalariesPage,
        name: "salaries",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
