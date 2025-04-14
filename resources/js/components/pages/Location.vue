<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Распределение по городам</h1>

        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Количество вакансий по городам</h3>
            <canvas ref="skillsChart" class="w-full" style="max-height: 500px; height: 400px;"></canvas>        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">Статистика по городам</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Город</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Количество вакансий</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(value, name) in areas" :key="name">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ value }} шт.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Таблица с навыками по городам -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">Навыки по городам</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Город</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Топ навыков</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <template v-if="skillsByArea">
                        <template v-for="(skills, city) in skillsByArea" :key="city">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 align-top" :rowspan="Math.max(1, skills?.length || 1)">
                                    {{ city }}
                                </td>
                                <template v-if="skills?.length > 0">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ skills[0].skill }} ({{ skills[0].count }})
                                    </td>
                                </template>
                                <template v-else>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Нет данных
                                    </td>
                                </template>
                            </tr>
                            <template v-if="skills?.length > 1">
                                <tr v-for="(skill, index) in skills.slice(1)" :key="index">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ skill.skill }} ({{ skill.count }})
                                    </td>
                                </tr>
                            </template>
                        </template>
                    </template>
                    <tr v-else>
                        <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                            Загрузка данных...
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Таблица с зарплатами по городам -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">Зарплаты по городам</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Город</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Средняя зарплата</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <template v-if="salaryByArea">
                        <tr v-for="(salary, city) in salaryByArea" :key="city">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ city }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ salary.toLocaleString() }} руб.</td>
                        </tr>
                    </template>
                    <tr v-else>
                        <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">
                            Загрузка данных...
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios"
import {Chart} from "chart.js"

export default {
    name: "LocationPage",
    data() {
        return {
            areas: null,
            skillsByArea: null,
            salaryByArea: null,
            skillsChart: null
        }
    },
    mounted() {
        this.getAreas()
        this.getSkillsByArea()
        this.getSalaryByArea()
    },
    methods: {
        getAreas() {
            axios.get('/api/vacancies/areas/statistic')
                .then(res => {
                    this.areas = res.data
                    this.renderChart()
                })
                .catch(error => {
                    console.error('Ошибка при загрузке городов:', error)
                    this.areas = {}
                })
        },
        getSkillsByArea() {
            axios.get('/api/vacancies/areas/linked-skills')
                .then(res => {
                    this.skillsByArea = res.data
                })
                .catch(error => {
                    console.error('Ошибка при загрузке навыков:', error)
                    this.skillsByArea = {}
                })
        },
        getSalaryByArea() {
            axios.get('/api/vacancies/areas/linked-salaries')
                .then(res => {
                    this.salaryByArea = res.data
                })
                .catch(error => {
                    console.error('Ошибка при загрузке зарплат:', error)
                    this.salaryByArea = {}
                })
        },
        renderChart() {
            if (this.skillsChart) {
                this.skillsChart.destroy()
            }

            const ctx = this.$refs.skillsChart.getContext('2d')

            const labels = Object.keys(this.areas)
            const data = Object.values(this.areas)

            // Убрал первый город (по задаче)
            labels.shift()
            data.shift()

            this.skillsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Количество вакансий',
                        data: data,
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Количество вакансий'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Города'
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.parsed.y} вакансий`
                                }
                            }
                        }
                    }
                }
            })
        }
    }
}
</script>

<style scoped>
table {
    min-width: 100%;
}

th, td {
    padding: 0.75rem 1.5rem;
}

thead th {
    background-color: #f9fafb;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

tbody tr:nth-child(odd) {
    background-color: #ffffff;
}

tbody tr:nth-child(even) {
    background-color: #f9fafb;
}
</style>
