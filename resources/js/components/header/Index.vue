<template>
    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <router-link to="/" class="text-2xl font-bold ">
                Анализ данных HH
            </router-link>

            <ul class="flex space-x-6">
                <li>
                    <router-link to="/search" class="text-gray-700 hover: transition duration-300">
                      Новая вакансия
                    </router-link>
                </li>
                <li>
                    <router-link to="/" class="text-gray-700 hover: transition duration-300">
                        Общий список
                    </router-link>
                </li>
                <li>
                    <router-link to="/key-skill" class="text-gray-700 hover: transition duration-300">
                        Ключевые навыки
                    </router-link>
                </li>
<!--                <li>-->
<!--                    <router-link to="/location" class="text-gray-700 hover: transition duration-300">-->
<!--                        Расположение-->
<!--                    </router-link>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <router-link to="/employers" class="text-gray-700 hover: transition duration-300">-->
<!--                        Работодатели-->
<!--                    </router-link>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <router-link to="/salaries" class="text-gray-700 hover: transition duration-300">-->
<!--                        Зарплаты-->
<!--                    </router-link>-->
<!--                </li>-->
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

</style>
