<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Вакансии</h1>
        <div>
            <div class="grid grid-cols-1 md:grid-cols-5 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white shadow-md rounded-lg p-4 md:col-span-3">
                    <h3 class="text-lg font-semibold text-gray-700">Активная специализация</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ this.name}}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4 md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-700">Количество вакансий</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ this.vacancyStatistic['total_count'] }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700">Уникальные названия</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ this.vacancyStatistic['unique_names'] }}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700">Премиум-вакансии</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ this.vacancyStatistic['premium_count']  }}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700">Требуется ответное письмо</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ this.vacancyStatistic['letter_required_count']   }}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700">Тестовые вакансии</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ this.vacancyStatistic['test_count'] }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "ListPage",
    data() {
        return {
            vacancyStatistic: [],
            name: '',
        };
    },
    mounted() {
        this.getVacancies();
        this.getSpecName()
    },
    methods: {
        getVacancies() {
            axios.get('/api/vacancies/statistic')
                .then(res => {
                    this.vacancyStatistic = res.data;
                })
                .catch(error => {
                    console.error('Ошибка при загрузке вакансий:', error);
                });
        },
        getSpecName() {
            axios.get('/api/specialization/active')
                .then(res => {
                    this.name = res.data.name;
                })
                .catch(error => {
                    console.error('Ошибка при загрузки активной вакансии:', error);
                })
        },
    },
}
</script>
