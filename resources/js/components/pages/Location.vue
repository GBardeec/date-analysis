<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Расположение</h1>
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Вертикальная столбчатая диаграмма</h3>
            <canvas ref="skillsChart" class="mt-6"></canvas>
        </div>

        <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
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
                <tr v-for="(value, name) in areas" :key="name">
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
    </div>
</template>

<script>
import axios from "axios"
import {Chart} from "chart.js"

export default {
    name: "LocationPage",
    data() {
        return {
            areas: [],
        }
    },
    mounted() {
        this.getAreas()
    },
    methods: {
        getAreas() {
            axios.get('/api/vacancies/areas/statistic')
                .then(res => {
                    this.areas = res.data
                    this.renderChart()
                })
                .catch(error => {
                    console.error('Ошибка при загрузке вакансий:', error)
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
                        label: 'Количество расположений',
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
