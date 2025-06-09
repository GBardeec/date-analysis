<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Диаграмма зарплат</h1>

        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4 flex justify-between">
                <div>Распределение зарплат</div>
                <div v-if="salaries && salaries[selectedOption]">
                    Средняя: {{ salaries[selectedOption]['average'] }} руб.
                </div>
            </h3>
            <div class="flex mb-4">
<!--                <select v-model="selectedOption" @change="updateChart" class="border rounded px-3 py-2 mr-4">-->
<!--                    <option value="from">Зарплата от</option>-->
<!--                    <option value="to">Зарплата до</option>-->
<!--                    <option value="average">Средняя зарплата</option>-->
<!--                </select>-->
            </div>
            <canvas ref="salaryChart" class="w-full" style="max-height: 500px; height: 400px;"></canvas>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">
                Распределение зарплат
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Наименование
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Значение
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Доля (%)
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <template v-if="salaries && salaries[selectedOption]">
                        <tr v-for="(value, name) in salaries[selectedOption]['data']" :key="name">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ value }} шт.
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ calculatePercentage(value, salaries[selectedOption]['data']) }}%
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">
                Соотношение навыков по зарплатам
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Зарплатная категория
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Топ навыков
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <template v-if="skillsBySalary">
                        <template v-for="(data, category) in skillsBySalary" :key="category">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 align-top" :rowspan="Math.max(1, data?.top_skills?.length || 1)">
                                    {{ category }}
                                </td>
                                <template v-if="data?.top_skills?.length > 0">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ data.top_skills[0]?.skill || 'Неизвестный навык' }} ({{ data.top_skills[0]?.count || 0 }})
                                    </td>
                                </template>
                                <template v-else>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Нет данных
                                    </td>
                                </template>
                            </tr>
                            <template v-if="data?.top_skills?.length > 1">
                                <tr v-for="(skill, index) in data.top_skills.slice(1)" :key="index">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ skill?.skill || 'Неизвестный навык' }} ({{ skill?.count || 0 }})
                                    </td>
                                </tr>
                            </template>
                        </template>
                    </template>
                    <tr v-else>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
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
import axios from "axios";
import { Chart } from "chart.js";

export default {
    name: "SalariesPage",
    data() {
        return {
            salaries: null,
            skillsBySalary: null,
            salaryChart: null,
            selectedOption: "to",
        }
    },
    mounted() {
        this.getSalaries()
        this.getSkillsBySalaries()
    },
    methods: {
        getSalaries() {
            axios.get('/api/vacancies/salaries/statistic')
                .then(res => {
                    this.salaries = res.data
                    this.updateChart()
                })
                .catch(error => {
                    console.error('Ошибка при загрузке зарплат:', error)
                    this.salaries = {}
                })
        },
        calculatePercentage(value, data) {
            const total = Object.values(data).reduce((sum, count) => sum + count, 0);
            return total > 0 ? ((value / total) * 100).toFixed(2) : 0;
        },
        getSkillsBySalaries() {
            axios.get('/api/vacancies/salaries/linked-skills')
                .then(res => {
                    this.skillsBySalary = res.data
                })
                .catch(error => {
                    console.error('Ошибка при загрузке навыков:', error)
                    this.skillsBySalary = {}
                })
        },
        updateChart() {
            if (this.salaries && this.salaries[this.selectedOption]) {
                this.renderChart()
            }
        },
        renderChart() {
            if (this.salaryChart) {
                this.salaryChart.destroy()
            }

            const ctx = this.$refs.salaryChart.getContext('2d')
            const processedData = {
                labels: Object.keys(this.salaries[this.selectedOption]['data']),
                values: Object.values(this.salaries[this.selectedOption]['data'])
            }

            this.salaryChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: processedData.labels,
                    datasets: [{
                        label: 'Количество вакансий',
                        data: processedData.values,
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
                                text: 'Диапазоны зарплат'
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y} вакансий`
                                }
                            }
                        }
                    }
                }
            })
        },
    },
}
</script>

<style scoped>
/* Единые стили для всех таблиц */
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
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>
