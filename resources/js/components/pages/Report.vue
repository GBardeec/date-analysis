<template>
    <div class="container mx-auto px-6 py-8">
        <div class="flex justify-between">
            <h1 class="text-3xl font-bold text-blue-600">Аналитический отчет</h1>

            <button
                @click="downloadReport" id="buttonDownload"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
            >
                Скачать отчет
            </button>
        </div>
        <div class=" mb-6">
            <h4 class=" font-bold text-blue-600">по специализации "{{name }}"</h4>
        </div>
        <!-- География вакансий -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">География вакансий</h3>
            <div class="p-6 pt-0">
                <div v-if="areas">
                    <p class="mb-4 text-gray-700">
                        <span class="font-semibold">Города-лидеры:</span>
                        {{ getTopCities(areas, 3).join(', ') }} демонстрируют наибольшую активность по количеству вакансий.
                        {{ getCityAnalysis(areas) }}
                    </p>
                    <p class="mb-4 text-gray-700">
                        Анализ распределения вакансий по регионам позволяет сделать вывод о концентрации профессиональной активности
                        в определенных городах. Это свидетельствует о высокой конкуренции среди работодателей в этих локациях, что,
                        в свою очередь, создает возможности для соискателей и стимулирует рост заработных плат.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div v-for="(count, city) in getTopCitiesObject(areas, 5)" :key="city"
                             class="border-l-4 border-blue-500 pl-4 py-2">
                            <p class="font-medium text-gray-800">{{ city }}</p>
                            <p class="text-gray-600">{{ count }} вакансий</p>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-8 text-gray-400">Загрузка данных...</div>
            </div>
        </div>

        <!-- Зарплатная аналитика -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">Зарплатная аналитика</h3>
            <div class="p-6 pt-0">
                <div v-if="salaryByArea">
                    <p class="mb-4 text-gray-700">
                        <span class="font-semibold">Диапазон зарплат:</span>
                        Диапазон зарплат варьируется от {{ getMinSalary(salaryByArea) }} до {{ getMaxSalary(salaryByArea) }} руб.
                        {{ getSalaryTrends(salaryByArea) }}
                    </p>
                    <p class="mb-4 text-gray-700">
                        Такие различия в уровнях оплаты труда могут быть связаны с различиями в уровне жизни, спросе на определённые
                        компетенции и стадией развития ИТ-рынка в каждом из регионов. Особенно высокие зарплаты наблюдаются в городах,
                        где развита инфраструктура ИТ-компаний.
                    </p>
                    <div class="mt-4 space-y-3">
                        <div v-for="(salary, city) in getTopSalaries(salaryByArea, 3)" :key="city"
                             class="flex justify-between items-center">
                            <span class="text-gray-700">{{ city }}</span>
                            <span class="font-medium text-green-600">{{ salary }} руб.</span>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-8 text-gray-400">Загрузка данных...</div>
            </div>
        </div>

        <!-- Требуемые навыки -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">Требуемые навыки</h3>
            <div class="p-6 pt-0">
                <div v-if="keySkills">
                    <p class="mb-4 text-gray-700">
                        <span class="font-semibold">Топ-навыки:</span>
                        {{ getTopSkills(keySkills, 3).join(', ') }} являются наиболее востребованными.
                        {{ getSkillsAnalysis(keySkills) }}
                    </p>
                    <p class="mb-4 text-gray-700">
                        Преобладание этих навыков в вакансиях указывает на устойчивый спрос на специалистов, обладающих определенной
                        экспертизой. Это отражает тренды в развитии цифровой экономики и трансформации традиционных
                        бизнес-процессов с помощью новых технологий.
                    </p>
                    <div class="mt-4">
                        <div v-for="(count, skill) in getTopSkillsObject(keySkills, 5)" :key="skill" class="mb-2">
                            <div class="flex justify-between mb-1">
                                <span class="text-gray-700">{{ skill }}</span>
                                <span class="font-medium">{{ count }} раз</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" :style="{ width: (count / maxSkillCount) * 100 + '%' }"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else class="text-center py-8 text-gray-400">Загрузка данных...</div>
            </div>
        </div>

        <!-- Навыки по уровням зарплат -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8" v-if="skillsBySalary">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">Навыки по уровням зарплат</h3>
            <div class="p-6 pt-0">
                <p class="mb-4 text-gray-600">Топ-3 навыка в разных зарплатных диапазонах:</p>

                <div class="space-y-4">
                    <div v-for="(data, range) in skillsBySalary" :key="range" class="border border-gray-400 rounded-lg overflow-hidden" style="margin-top: 10px;">
                        <div
                            class="w-full flex justify-between items-center p-4 text-left bg-gray-100 transition-colors"
                        >
                            <div>
                                <h4 class="text-lg font-semibold text-blue-500">{{ range }}</h4>
                                <p class="text-sm text-gray-500">Всего вакансий: {{ data.vacancy_count }}</p>
                            </div>
                        </div>

                        <div class="px-4 pb-4">
                            <div class="flex flex-wrap gap-2 mt-4">
                                <span v-if="data.top_skills" v-for="(item, index) in data.top_skills.slice(0, 3)"
                                      :key="item.skill"
                                      class="px-3 py-1 rounded-full text-sm"
                                      :class="{
                                          'bg-blue-100 text-blue-800': index === 0,
                                          'bg-green-100 text-green-800': index === 1,
                                          'bg-purple-100 text-purple-800': index === 2
                                      }">
                                    {{ item.skill }} ({{ item.count }})
                                </span>
                                <span v-if="!data.top_skills.length" class="text-sm text-gray-400">
                                    Данные отсутствуют
                                </span>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2" style="margin-top: 10px">
                        Выборка по данному диапазону демонстрирует, что наличие указанных навыков напрямую влияет на уровень предлагаемой зарплаты.
                        Это может служить ориентиром как для соискателей, так и для работодателей.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8" v-if="skillsByArea">
            <h3 class="text-xl font-semibold text-gray-700 p-6 pb-4">Навыки по городам</h3>
            <div class="p-6 pt-0">
                <p class="mb-4 text-gray-600">
                    Представленные данные иллюстрируют различия в требованиях к кандидатам в зависимости от региона.
                    Это важно учитывать как при подборе персонала, так и при формировании образовательных программ и курсов
                    повышения квалификации.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="(skills, city) in Object.entries(skillsByArea).slice(0, 5).reduce((obj, [key, val]) => ({ ...obj, [key]: val }), {})"
                         :key="city"
                         class="border border-gray-400 rounded-lg overflow-hidden">
                        <div class="w-full flex justify-between items-center p-4 text-left bg-gray-100 transition-colors">
                            <h4 class="text-lg font-semibold text-blue-500">{{ city }}</h4>
                        </div>
                        <div class="px-4 pb-4">
                            <div class="flex flex-wrap gap-2 mt-4">
                                <span v-for="(skillObj, index) in skills"
                                      :key="skillObj.skill"
                                      class="px-3 py-1 rounded-full text-sm"
                                      :class="{
                                          'bg-blue-100 text-blue-800': index === 0,
                                          'bg-green-100 text-green-800': index === 1,
                                          'bg-purple-100 text-purple-800': index === 2
                                      }">
                                    {{ skillObj.skill }} ({{ skillObj.count }})
                                </span>
                                <span v-if="!skills.length" class="text-sm text-gray-400">
                                    Данные отсутствуют
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-xl font-semibold text-blue-600 mb-3">Выводы и рекомендации</h3>
            <ul class="list-disc pl-5 text-gray-700 space-y-2">
<!--                <li>Концентрация вакансий в крупных городах указывает на необходимость развития ИТ-инфраструктуры в регионах.</li>-->
                <li>Высокий спрос на технические и аналитические навыки требует постоянного повышения квалификации специалистов.</li>
                <li>Зарплатные ожидания должны соотноситься не только с опытом, но и с конкретным набором ключевых компетенций.</li>
                <li>Рекрутерам следует учитывать региональные особенности рынка при составлении вакансий.</li>
            </ul>
        </div>
    </div>
<!--    <div id="pages" >-->
<!--        <key-skill-page></key-skill-page>-->
<!--        <location-page></location-page>-->
<!--        <salaries-page></salaries-page>-->
<!--    </div>-->
</template>


<script>
import axios from "axios"
import KeySkillPage from "./KeySkill.vue";
import LocationPage from "./Location.vue";
import SalariesPage from "./Salaries.vue";

export default {
    name: "AnalyticsReport",
    components: {KeySkillPage, LocationPage, SalariesPage},
    data() {
        return {
            areas: null,
            keySkills: null,
            skillsBySalary: null,
            salaries: null,
            salaryByArea: null,
            skillsByArea: null,
            maxSkillCount: 0,
            expandedSalaryRanges: [],
            expandedCities: [],
            showAllSkills: {},
            showAllCitySkills: {},
            name: '',
            countVac: '',
        }
    },
    mounted() {
        this.getVacancies()
        this.getAreas()
        this.getKeySkills()
        this.getSalaries()
        this.getSkillsByArea()
        this.getSalaryByArea()
        this.getSkillsBySalaries()
        this.name = this.getSpecName()
    },
    methods: {
        getSpecName() {
            return localStorage.getItem('lastSelectedRole')
        },
        // Загрузка данных
        getVacancies() {
            axios.get('/api/vacancies')
                .then(res => {
                   this.countVac = res.data.length
                })
                .catch(error => {
                    console.error('Ошибка при загрузке городов:', error);
                    this.areas = {}
                })
        }
        ,getAreas() {
            axios.get('/api/vacancies/areas/statistic')
                .then(res => {
                    this.areas = res.data
                })
                .catch(error => {
                    console.error('Ошибка при загрузке городов:', error);
                    this.areas = {}
                })
        },
        getKeySkills() {
            axios.get('/api/vacancies/key-skill/statistic')
                .then(res => {
                    this.keySkills = res.data
                    this.maxSkillCount = Math.max(...Object.values(res.data))
                })
                .catch(error => {
                    console.error('Ошибка при загрузке ключевых навыков:', error);
                    this.keySkills = {}
                })
        },
        getSalaries() {
            axios.get('/api/vacancies/salaries/statistic')
                .then(res => {
                    this.salaries = res.data
                })
                .catch(error => {
                    console.error('Ошибка при загрузке зарплат:', error);
                    this.salaries = {}
                })
        },
        getSkillsByArea() {
            axios.get('/api/vacancies/areas/linked-skills')
                .then(res => {
                    this.skillsByArea = res.data
                })
                .catch(error => {
                    console.error('Ошибка при загрузке навыков по городам:', error);
                    this.skillsByArea = {}
                })
        },
        getSalaryByArea() {
            axios.get('/api/vacancies/areas/linked-salaries')
                .then(res => {
                    this.salaryByArea = res.data
                })
                .catch(error => {
                    console.error('Ошибка при загрузке зарплат по регионам:', error);
                    this.salaryByArea = {}
                })
        },
        getSkillsBySalaries() {
            axios.get('/api/vacancies/salaries/linked-skills')
                .then(res => {
                    this.skillsBySalary = res.data
                })
                .catch(error => {
                    console.error('Ошибка при загрузке навыков по зарплатам:', error);
                    this.skillsBySalary = {}
                })
        },

        // Анализ данных
        getTopCities(data, count) {
            return Object.entries(data).sort((a, b) => b[1] - a[1]).slice(0, count).map(item => item[0])
        },
        getTopCitiesObject(data, count) {
            return Object.entries(data).sort((a, b) => b[1] - a[1]).slice(0, count).reduce((obj, [key, val]) => ({
                ...obj,
                [key]: val
            }), {})
        },
        getCityAnalysis(data) {
            const cities = Object.keys(data)
            if (cities.includes('Бишкек')) return 'Наблюдается международное присутствие с вакансиями из Бишкека.'
            if (cities.includes('Алматы') && cities.includes('Астана')) return 'Казахстан представлен двумя крупными городами: Алматы и Астана.'
            return 'Города показывают стабильный рост количества вакансий.'
        },
        getTopSkills(data, count) {
            return Object.entries(data).sort((a, b) => b[1] - a[1]).slice(0, count).map(item => item[0])
        },
        getTopSkillsObject(data, count) {
            return Object.entries(data).sort((a, b) => b[1] - a[1]).slice(0, count).reduce((obj, [key, val]) => ({
                ...obj,
                [key]: val
            }), {})
        },
        getSkillsAnalysis(data) {
            const topSkill = Object.entries(data).sort((a, b) => b[1] - a[1])[0]
            return `Навык "${topSkill[0]}" встречается в ${topSkill[1]} из ${this.countVac} вакансий.`
        },
        getMinSalary(data) {
            return Math.min(...Object.values(data)).toLocaleString('ru-RU')
        },
        getMaxSalary(data) {
            return Math.max(...Object.values(data)).toLocaleString('ru-RU')
        },
        getSalaryTrends(data) {
            const avg = Object.values(data).reduce((a, b) => a + b, 0) / Object.values(data).length
            // return `Средняя зарплата по всем городам составляет ${avg.toLocaleString('ru-RU', {maximumFractionDigits: 0})} руб.`
        },
        getTopSalaries(data, count) {
            return Object.entries(data).sort((a, b) => b[1] - a[1]).slice(0, count)
                .reduce((obj, [key, val]) => ({...obj, [key]: val.toLocaleString('ru-RU')}), {})
        },
        downloadReport() {
            // 1. Сохраняем текущее состояние
            const pagesContainer = document.getElementById('pages');
            const hadHiddenClass = pagesContainer.classList.contains('hidden');
            pagesContainer.classList.remove('hidden');

            // 3. Создаем временный div с копией HTML
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = document.documentElement.outerHTML;

            // Удаляем ненужные элементы
            const header = tempDiv.querySelector('header');
            if (header) header.remove();

            const buttonDownload = tempDiv.querySelector('#buttonDownload');
            if (buttonDownload) buttonDownload.remove();

            const modifiedHtml = tempDiv.innerHTML;

            // 4. Создаем и запускаем загрузку
            const element = document.createElement('a');
            const blob = new Blob([modifiedHtml], { type: 'text/html' });
            element.href = URL.createObjectURL(blob);
            element.download = 'analytics_report.html';
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);

            if (hadHiddenClass) {
                setTimeout(() => {
                    pagesContainer.classList.add('hidden');
                }, 100);
            }
        },
    }
}
</script>

<style scoped>
.container {
    max-width: 1200px;
}
</style>


