<template>
    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-blue-600">
                Атлас ИТ-профессий
            </div>

            <ul class="flex space-x-6">
                <li>
                    <router-link
                        to="/"
                        class="px-3 py-2 rounded-md transition duration-300"
                        :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/', 'text-gray-700 hover:text-blue-500': $route.path !== '/'}"
                    >
                        Общая статистика
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
                <li>
                    <router-link
                        to="/report"
                        class="px-3 py-2 rounded-md transition duration-300"
                        :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/report', 'text-gray-700 hover:text-blue-500': $route.path !== '/report'}"
                    >
                        Отчет
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

