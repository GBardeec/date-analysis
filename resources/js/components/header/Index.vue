<template>
    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-blue-600">
                Анализ данных HH
            </div>

            <ul class="flex space-x-6">
                <li>
                    <router-link
                        to="/search"
                        class="px-3 py-2 rounded-md transition duration-300"
                        :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/search', 'text-gray-700 hover:text-blue-500': $route.path !== '/search'}"
                    >
                        Новая вакансия
                    </router-link>
                </li>
                <li>
                    <router-link
                        to="/"
                        class="px-3 py-2 rounded-md transition duration-300"
                        :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/', 'text-gray-700 hover:text-blue-500': $route.path !== '/'}"
                    >
                        Вакансии
                    </router-link>
                </li>
                <li>
                    <router-link
                        to="/key-skill"
                        class="px-3 py-2 rounded-md transition duration-300"
                        :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/key-skill', 'text-gray-700 hover:text-blue-500': $route.path !== '/key-skill'}"
                    >
                        Ключевые навыки
                    </router-link>
                </li>
                <li>
                    <router-link
                        to="/location"
                        class="px-3 py-2 rounded-md transition duration-300"
                        :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/location', 'text-gray-700 hover:text-blue-500': $route.path !== '/location'}"
                    >
                        Локации
                    </router-link>
                </li>
                <li>
                    <router-link
                        to="/salaries"
                        class="px-3 py-2 rounded-md transition duration-300"
                        :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/salaries', 'text-gray-700 hover:text-blue-500': $route.path !== '/salaries'}"
                    >
                        Зарплаты
                    </router-link>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script>
export default {
    name: "IndexHeader",
}
</script>

<style scoped>
.router-link-exact-active {
    /* Дублируем стили для точного совпадения */
    color: #2563eb;
    font-weight: 500;
    background-color: #eff6ff;
}
</style>
