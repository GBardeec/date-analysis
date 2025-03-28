<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Ключевые навыки</h1>
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Вертикальная столбчатая диаграмма</h3>
            <canvas ref="skillsChart" class="mt-6"></canvas>
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
            <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(value, name) in keySkills" :key="name">
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
import axios from 'axios'
import {BarController, BarElement, CategoryScale, Chart, Legend, LinearScale, Tooltip} from 'chart.js'

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Tooltip, Legend)

export default {
    name: "KeySkill",
    data() {
        return {
            keySkills: [],
            skillsChart: null,
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
                    this.renderChart()
                })
                .catch(error => {
                    console.error('Ошибка при загрузке ключевых навыков:', error)
                })
        },
        renderChart() {
            if (this.skillsChart) {
                this.skillsChart.destroy()
            }

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
                            beginAtZero: true
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            })
        },
    },
}
</script>

<style>
canvas {
    max-height: 400px
}
</style>
