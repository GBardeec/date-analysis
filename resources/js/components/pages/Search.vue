<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-2">Выберите ИТ-профессию</h1>
        <div class="mx-auto text-center">
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto" style="margin-top: 35px">
                Рады приветствовать вас на странице Атласа ИТ-профессий. Тут вы можете увидеть, насколько востребованы различные профессиональные навыки, как они влияют на заработную плату, как они распределены по городам. Надеемся, что сервис поможет абитуриентам не ошибиться в выборе профессии, работодателям — эффективно планировать прием сотрудников, учебным заведениям — актуализировать свои учебные планы.
            </p>
        </div>
        <div class="bg-white rounded-lg p-6 max-w-md mx-auto">
            <div class="flex flex-col">
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">
                        Специализация
                    </label>
                    <select
                        id="role"
                        v-model="selectedRole"
                        @change="processingNewVacancies"
                        class="w-full max-w-lg px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        :disabled="isLoading"
                    >
                        <option v-for="role in professionalRoles" :key="role.id" :value="role.id">
                            {{ role.name }}
                        </option>
                    </select>
                </div>
            </div>

            <div v-if="isLoading" class="mt-4 text-center">
                <svg class="animate-spin inline-block h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="ml-2 text-gray-600">Загрузка...</span>
            </div>
        </div>

        <!-- Уведомление об успешном сохранении -->
        <transition name="fade">
            <div v-if="showSuccess" class="fixed bottom-4 right-4">
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Специализация успешно сохранена!</span>
                </div>
            </div>
        </transition>
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
            showSuccess: false,
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
    mounted() {
        this.getActiveSpecialization()
    },
    methods: {
        getActiveSpecialization() {
            axios.get('/api/specialization/active')
                .then(res => {
                    if (res.data) {
                        this.selectedRole = res.data.specialization_id
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        processingNewVacancies() {
            this.errors = {};
            this.isLoading = true;
            this.showSuccess = false;

            const selectedRoleName = this.professionalRoles.find(
                role => role.id === this.selectedRole
            )?.name || 'Неизвестная роль';

            localStorage.setItem('lastSelectedRole', selectedRoleName);

            axios.post('/api/specialization/save', {specialization_id: this.selectedRole})
                .then(res => {
                    this.showSuccess = true;
                    setTimeout(() => this.showSuccess = false, 3000);
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

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>
