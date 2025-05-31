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
                        :disabled="isLoading"
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
                        :disabled="isLoading"
                    />
                    <p v-if="errors.count" class="text-red-500 text-sm mt-1">
                        {{ errors.count[0] }}
                    </p>
                </div>
            </div>

            <button
                @click="processingNewVacancies"
                class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all relative"
                :disabled="isLoading"
            >
                <span v-if="!isLoading">Получить вакансии</span>
                <span v-else class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Загрузка...
                </span>
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
            isLoading: false,
            professionalRoles: [
                { id: '156', name: 'BI-аналитик, аналитик данных' },
                { id: '160', name: 'DevOps-инженер' },
                { id: '10', name: 'Аналитик' },
                { id: '12', name: 'Арт-директор, креативный директор' },
                { id: '150', name: 'Бизнес-аналитик' },
                { id: '25', name: 'Гейм-дизайнер' },
                { id: '165', name: 'Дата-сайентист' },
                { id: '34', name: 'Дизайнер, художник' },
                { id: '36', name: 'Директор по информационным технологиям (CIO)' },
                { id: '73', name: 'Менеджер продукта' },
                { id: '155', name: 'Методолог' },
                { id: '96', name: 'Программист, разработчик' },
                { id: '164', name: 'Продуктовый аналитик' },
                { id: '104', name: 'Руководитель группы разработки' },
                { id: '157', name: 'Руководитель отдела аналитики' },
                { id: '107', name: 'Руководитель проектов' },
                { id: '112', name: 'Сетевой инженер' },
                { id: '113', name: 'Системный администратор' },
                { id: '148', name: 'Системный аналитик' },
                { id: '114', name: 'Системный инженер' },
                { id: '116', name: 'Специалист по информационной безопасности' },
                { id: '121', name: 'Специалист технической поддержки' },
                { id: '124', name: 'Тестировщик' },
                { id: '125', name: 'Технический директор (CTO)' },
                { id: '126', name: 'Технический писатель' }
            ]
        };
    },
    methods: {
        processingNewVacancies() {
            this.errors = {};
            this.isLoading = true;

            const selectedRoleName = this.professionalRoles.find(
                role => role.id === this.selectedRole
            )?.name || 'Неизвестная роль';

            localStorage.setItem('lastSelectedRole', selectedRoleName);

            axios.post('/api/vacancies/new', {
                professional_role: this.selectedRole,
                count: this.count
            })
                .then(res => {
                    if (res.data) {
                        console.log('Выбранная роль:', localStorage.getItem('lastSelectedRole'));
                    }
                })
                .catch(error => {
                    if (error.response?.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error('Ошибка:', error);
                    }
                })
                .finally(() => {
                    this.isLoading = false;
                });
        }
    }
}
</script>

<style>
.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
