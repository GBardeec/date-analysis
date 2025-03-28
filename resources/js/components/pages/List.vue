<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Общий список вакансий</h1>
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700">Уникальные названия</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ uniqueNamesCount }}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700">Премиум-вакансии</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ premiumCount }}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700">Требуется ответное письмо</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ responseLetterCount }}</p>
                </div>

                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-700">Тестовые вакансии</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ testVacanciesCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        №
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                        Название
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Премиум
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Требуется ответное письмо
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Тестовая вакансия
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Дата публикации
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        API ссылка
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(vacancy, index) in vacancies" :key="vacancy.id">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ index + 1 }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap w-24">
                        <div class="text-sm font-medium text-gray-900 truncate" :title="vacancy.name">
                            {{ vacancy.name }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ vacancy.premium ? 'Да' : 'Нет' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ vacancy.response_letter_required ? 'Да' : 'Нет' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ vacancy.has_test ? 'Да' : 'Нет' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{ formatDate(vacancy.published_at) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a
                            :href="vacancy.url"
                            class="text-sm text-blue-600 hover:text-blue-800"
                            target="_blank"
                        >
                            Перейти
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "ListPage",
    data() {
        return {
            vacancies: [],
            uniqueNamesCount: 0,
            premiumCount: 0,
            responseLetterCount: 0,
            testVacanciesCount: 0,
        };
    },
    mounted() {
        this.getVacancies();
    },
    methods: {
        getVacancies() {
            axios.get('/api/vacancies/get')
                .then(res => {
                    this.vacancies = res.data;
                    this.calculateStatistics();
                })
                .catch(error => {
                    console.error('Ошибка при загрузке вакансий:', error);
                });
        },
        formatDate(timestamp) {
            const date = new Date(timestamp * 1000);
            return date.toLocaleDateString('ru-RU', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            });
        },
        calculateStatistics() {
            const uniqueNames = new Set(this.vacancies.map(v => v.name));
            this.uniqueNamesCount = uniqueNames.size;

            this.premiumCount = this.vacancies.filter(v => v.premium).length;

            this.responseLetterCount = this.vacancies.filter(v => v.response_letter_required).length;

            this.testVacanciesCount = this.vacancies.filter(v => v.has_test).length;
        },
    },
}
</script>
