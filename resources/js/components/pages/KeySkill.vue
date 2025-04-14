<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Ключевые навыки</h1>

        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Распределение ключевых навыков</h3>
            <div class="chart-container">
                <canvas ref="skillsChart" class="w-full" style="max-height: 500px; height: 400px;"></canvas>            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">Статистика по навыкам</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Навык
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Количество упоминаний
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Доля (%)
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(count, skill) in keySkills" :key="skill">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ skill }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ count }} шт.
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ calculatePercentage(count) }}%
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import {BarController, BarElement, CategoryScale, Chart, Legend, LinearScale, Tooltip} from 'chart.js'

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Tooltip, Legend)

export default {
    name: "KeySkill",
    data() {
        return {
            keySkills: null,
            skillsChart: null,
            totalSkills: 0
        }
    },
    mounted() {
        this.getKeySkills()
    },
    methods: {
        getKeySkills() {
            axios.get('/api/vacancies/key-skill/statistic')
                .then(res => {
                    this.keySkills = res.data
                    this.totalSkills = Object.values(res.data).reduce((a, b) => a + b, 0)
                    this.renderChart()
                })
                .catch(error => {
                    console.error('Ошибка при загрузке ключевых навыков:', error)
                    this.keySkills = {}
                })
        },
        calculatePercentage(count) {
            if (this.totalSkills === 0) return 0
            return ((count / this.totalSkills) * 100).toFixed(2)
        },
        renderChart() {
            if (this.skillsChart) {
                this.skillsChart.destroy()
            }

            if (!this.keySkills) return

            const ctx = this.$refs.skillsChart.getContext('2d')
            const labels = Object.keys(this.keySkills)
            const data = Object.values(this.keySkills)

            this.skillsChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Количество упоминаний',
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
                                text: 'Количество упоминаний'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Навыки'
                            },
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            })
        }
    }
}
</script>

<style scoped>
canvas {
    max-height: 400px
}

.chart-container {
    position: relative;
    height: 400px;
    width: 100%;
}

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
