<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Новая вакансия</h1>
        <div class="bg-white rounded-lg p-6 max-w-md mx-auto">
            <div class="flex flex-col">
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">
                        Специализация
                    </label>
                    <select
                        id="role"
                        v-model="selectedRole"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    >
                        <option v-for="role in professionalRoles" :key="role.id" :value="role.id">
                            {{ role.name }}
                        </option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="count" class="block text-gray-700 text-sm font-bold mb-2">
                        Количество вакансий
                    </label>
                    <input
                        type="number"
                        id="count"
                        v-model="count"
                        placeholder="Введите количество"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    />
                    <p v-if="errors.count" class="text-red-500 text-sm mt-1">
                        {{ errors.count[0] }}
                    </p>
                </div>
            </div>

            <button
                @click="processingNewVacancies"
                class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all"
            >
                Получить вакансии
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "SearchPage",
    data() {
        return {
            selectedRole: '96',
            count: 10,
            errors: {},
            professionalRoles: [
                { id: '124', name: 'BI-аналитик, аналитик данных' },
                { id: '165', name: 'DevOps-инженер' },
                { id: '156', name: 'Аналитик' },
                { id: '160', name: 'Арт-директор, креативный директор' },
                { id: '164', name: 'Бизнес-аналитик' },
                { id: '148', name: 'Гейм-дизайнер' },
                { id: '150', name: 'Дата-сайентист' },
                { id: '155', name: 'Дизайнер, художник' },
                { id: '157', name: 'Директор по информационным технологиям (CIO)' },
                { id: '153', name: 'Менеджер продукта' },
                { id: '154', name: 'Методолог' },
                { id: '96', name: 'Программист, разработчик' },
                { id: '164', name: 'Продуктовый аналитик' },
                { id: '149', name: 'Руководитель группы разработки' },
                { id: '152', name: 'Руководитель отдела аналитики' },
                { id: '151', name: 'Руководитель проектов' },
                { id: '158', name: 'Сетевой инженер' },
                { id: '159', name: 'Системный администратор' },
                { id: '161', name: 'Системный аналитик' },
                { id: '162', name: 'Системный инженер' },
                { id: '163', name: 'Специалист по информационной безопасности' },
                { id: '166', name: 'Специалист технической поддержки' },
                { id: '167', name: 'Тестировщик' },
                { id: '168', name: 'Технический директор (CTO)' },
                { id: '169', name: 'Технический писатель' }
            ]
        };
    },
    methods: {
        processingNewVacancies() {
            this.errors = {};

            axios.post('/api/vacancies/new', {
                professional_role: this.selectedRole,
                count: this.count
            })
                .then(res => {
                    if (res.data) {
                        alert(`Успешно получено ${res.data.count} вакансий`);
                    }
                })
                .catch(error => {
                    if (error.response?.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error('Ошибка:', error);
                        alert('Произошла ошибка при получении вакансий');
                    }
                });
        }
    }
}
</script>
