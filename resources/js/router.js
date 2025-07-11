import { createWebHistory, createRouter } from "vue-router";
import ListPage from "./components/pages/List.vue";
import MainPage from "./components/pages/Main.vue";
import KeySkillPage from "./components/pages/KeySkill.vue";
import LocationPage from "./components/pages/Location.vue";
import EmployersPage from "./components/pages/Employers.vue";
import SalariesPage from "./components/pages/Salaries.vue";
import Report from "./components/pages/Report.vue";
import Search from "./components/pages/Search.vue";

const routes = [
    {
        path: "/info",
        component: ListPage,
        name: "list",
    },
    {
        path: "/",
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
    {
        path: "/report",
        component: Report,
        name: "report",
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
