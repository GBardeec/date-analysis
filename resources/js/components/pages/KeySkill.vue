<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Ключевые навыки</h1>
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Вертикальная столбчатая диаграмма</h3>
            <canvas ref="skillsChart" class="mt-6"></canvas>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {BarController, BarElement, CategoryScale, Chart, Legend, LinearScale, Tooltip} from 'chart.js';

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Tooltip, Legend);

export default {
    name: "KeySkill",
    data() {
        return {
            vacancies: [],
            keySkillsAnalysis: {},
            showStatistics: false,
            skillsChart: null,
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
                    this.analyzeKeySkills();
                })
                .catch(error => {
                    console.error('Ошибка при загрузке вакансий:', error);
                });
        },
        analyzeKeySkills() {
            const skillsCount = {};

            this.vacancies.forEach(vacancy => {
                if (vacancy.key_skills && Array.isArray(vacancy.key_skills)) {
                    vacancy.key_skills.forEach(skill => {
                        const skillName = skill.name;
                        if (skillsCount[skillName]) {
                            skillsCount[skillName]++;
                        } else {
                            skillsCount[skillName] = 1;
                        }
                    });
                }
            });

            this.keySkillsAnalysis = Object.entries(skillsCount)
                .sort((a, b) => b[1] - a[1])
                .reduce((acc, [key, value]) => {
                    acc[key] = value;
                    return acc;
                }, {});

            this.renderChart();
        },
        renderChart() {
            if (this.skillsChart) {
                this.skillsChart.destroy();
            }

            const ctx = this.$refs.skillsChart.getContext('2d');

            // const top30Skills = Object.entries(this.keySkillsAnalysis)
            //     .sort((a, b) => b[1] - a[1])
            //     .slice(0, 30);

            const top30Skills = Object.entries(this.keySkillsAnalysis)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 30);

            const labels = top30Skills.map(skill => skill[0]);
            const data = top30Skills.map(skill => skill[1]);

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
            });
        },
    },
}
</script>

<style>
canvas {
    max-height: 400px;
}
</style>
