<template>
    <header class="bg-white shadow-md">
        <nav class="container mx-auto px-6 py-4 md:hidden">
            <div class="flex justify-between items-center">
                <div class=" text-2xl font-bold text-blue-600">
                    Атлас ИТ-профессий
                </div>

                <!-- Кнопка меню для мобильных -->
                <button
                    @click="isMenuOpen = !isMenuOpen"
                    class="md:hidden p-2 rounded-md text-gray-700 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            :d="isMenuOpen ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"
                        />
                    </svg>
                </button>
            </div>

            <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
            >
                <ul
                    v-show="isMenuOpen || !isMobile"
                    class="mt-4 md:mt-0 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-6"
                >
                    <li>
                        <router-link
                            to="/search"
                            class="block px-3 py-2 rounded-md transition duration-300"
                            :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/search', 'text-gray-700 hover:text-blue-500': $route.path !== '/search'}"
                            @click="isMenuOpen = false"
                        >
                            Поиск
                        </router-link>
                    </li>
                    <li>
                        <router-link
                            to="/"
                            class="block px-3 py-2 rounded-md transition duration-300"
                            :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/', 'text-gray-700 hover:text-blue-500': $route.path !== '/'}"
                            @click="isMenuOpen = false"
                        >
                            Статистика
                        </router-link>
                    </li>
                    <li>
                        <router-link
                            to="/key-skill"
                            class="block px-3 py-2 rounded-md transition duration-300"
                            :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/key-skill', 'text-gray-700 hover:text-blue-500': $route.path !== '/key-skill'}"
                            @click="isMenuOpen = false"
                        >
                            Навыки
                        </router-link>
                    </li>
                    <li>
                        <router-link
                            to="/location"
                            class="block px-3 py-2 rounded-md transition duration-300"
                            :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/location', 'text-gray-700 hover:text-blue-500': $route.path !== '/location'}"
                            @click="isMenuOpen = false"
                        >
                            Локации
                        </router-link>
                    </li>
                    <li>
                        <router-link
                            to="/salaries"
                            class="block px-3 py-2 rounded-md transition duration-300"
                            :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/salaries', 'text-gray-700 hover:text-blue-500': $route.path !== '/salaries'}"
                            @click="isMenuOpen = false"
                        >
                            Зарплаты
                        </router-link>
                    </li>
                    <li>
                        <router-link
                            to="/report"
                            class="block px-3 py-2 rounded-md transition duration-300"
                            :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/report', 'text-gray-700 hover:text-blue-500': $route.path !== '/report'}"
                            @click="isMenuOpen = false"
                        >
                            Отчет
                        </router-link>
                    </li>
                </ul>
            </transition>
        </nav>
        <nav class="hidden md:block container mx-auto px-6 py-4">

        <div class="flex justify-between items-center">
                <div class=" text-2xl font-bold text-blue-600">
                    Атлас ИТ-профессий
                </div>

                <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                >
                    <ul
                        v-show="isMenuOpen || !isMobile"
                        class="mt-4 md:mt-0 flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-6"
                    >
                        <li>
                            <router-link
                                to="/search"
                                class="block px-3 py-2 rounded-md transition duration-300"
                                :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/search', 'text-gray-700 hover:text-blue-500': $route.path !== '/search'}"
                                @click="isMenuOpen = false"
                            >
                                Поиск
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                to="/"
                                class="block px-3 py-2 rounded-md transition duration-300"
                                :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/', 'text-gray-700 hover:text-blue-500': $route.path !== '/'}"
                                @click="isMenuOpen = false"
                            >
                                Статистика
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                to="/key-skill"
                                class="block px-3 py-2 rounded-md transition duration-300"
                                :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/key-skill', 'text-gray-700 hover:text-blue-500': $route.path !== '/key-skill'}"
                                @click="isMenuOpen = false"
                            >
                                Навыки
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                to="/location"
                                class="block px-3 py-2 rounded-md transition duration-300"
                                :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/location', 'text-gray-700 hover:text-blue-500': $route.path !== '/location'}"
                                @click="isMenuOpen = false"
                            >
                                Локации
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                to="/salaries"
                                class="block px-3 py-2 rounded-md transition duration-300"
                                :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/salaries', 'text-gray-700 hover:text-blue-500': $route.path !== '/salaries'}"
                                @click="isMenuOpen = false"
                            >
                                Зарплаты
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                to="/report"
                                class="block px-3 py-2 rounded-md transition duration-300"
                                :class="{'text-blue-600 font-medium bg-blue-50': $route.path === '/report', 'text-gray-700 hover:text-blue-500': $route.path !== '/report'}"
                                @click="isMenuOpen = false"
                            >
                                Отчет
                            </router-link>
                        </li>
                    </ul>
                </transition>
            </div>
        </nav>
    </header>
</template>

<script>
import { ref, onMounted, onBeforeUnmount } from 'vue';

export default {
    name: "IndexHeader",
    setup() {
        const isMenuOpen = ref(false);
        const isMobile = ref(false);

        const checkScreenSize = () => {
            isMobile.value = window.innerWidth < 768; // md breakpoint in Tailwind
            if (!isMobile.value) {
                isMenuOpen.value = true;
            } else {
                isMenuOpen.value = false;
            }
        };

        onMounted(() => {
            checkScreenSize();
            window.addEventListener('resize', checkScreenSize);
        });

        onBeforeUnmount(() => {
            window.removeEventListener('resize', checkScreenSize);
        });

        return {
            isMenuOpen,
            isMobile
        };
    }
}
</script>
