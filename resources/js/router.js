import { createWebHistory, createRouter } from "vue-router";
import ListPage from "./components/pages/List.vue";
import KeySkillPage from "./components/pages/KeySkill.vue";
import LocationPage from "./components/pages/Location.vue";
import EmployersPage from "./components/pages/Employers.vue";
import SalariesPage from "./components/pages/Salaries.vue";
import Search from "./components/pages/Search.vue";

const routes = [
    {
        path: "/",
        component: ListPage,
        name: "list",
    },
    {
        path: "/search",
        component: Search,
        name: "search",
    },
    {
        path: "/location",
        component: LocationPage,
        name: "location",
    },
    {
        path: "/key-skill",
        component: KeySkillPage,
        name: "keySkill",
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
