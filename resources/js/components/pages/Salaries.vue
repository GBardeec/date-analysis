<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Диаграмма зарплат</h1>
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4 flex justify-between">
                <div>Распределение зарплат</div>
                <div v-if="this.salaries && this.salaries[this.selectedOption]">
                    Средняя: {{ this.salaries[this.selectedOption]['average'] }} руб.
                </div>
            </h3>
            <div class="flex mb-4">
                <select v-model="selectedOption" @change="updateChart" class="border rounded px-3 py-2 mr-4">
                    <option value="from">Зарплата от</option>
                    <option value="to">Зарплата до</option>
                    <option value="average">Средняя зарплата</option>
                </select>
            </div>
            <canvas ref="salaryChart" class="mt-6"></canvas>
        </div>
    </div>

    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg overflow-hidden mb-5">
        <table class="w-full">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Наименование
                </th>
                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Значение
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" v-if="this.salaries && this.salaries[this.selectedOption]">
            <tr v-for="(value, name) in this.salaries[this.selectedOption]['data']" :key="name">
                <td class="px-4 py-2 text-center">
                    <div class="text-sm text-gray-900">
                        {{ name }}
                    </div>
                </td>
                <td class="px-4 py-2 text-center">
                    <div class="text-sm text-gray-900">
                        {{ value }} шт.
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
import axios from "axios";
import { Chart } from "chart.js";

export default {
    name: "SalariesPage",
    data() {
        return {
            salaries: [],
            salaryChart: null,
            selectedOption: "from",
        }
    },
    mounted() {
        this.getSalaries()
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
                })
        },
        updateChart() {
            this.renderChart()
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
