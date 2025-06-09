<template>
    <footer class="bg-white footer-shadow py-5 border-t border-gray-200">
        <div class="container mx-auto px-6">
            <div class="flex flex-row items-center justify-between gap-8" >
                <div class="space-y-3">
                    <div class="text-sm text-gray-600 space-y-2">
                        <p>Студент: <span class="font-medium text-gray-800">Мухаматдинов Ильяс Рустамович</span></p>
                        <p>Преподаватель: <span class="font-medium text-gray-800">Лашкарев Алексей Николаевич</span></p>
                    </div>
                </div>

                <div class="flex flex-col justify-center">
                    <span class="text-sm font-semibold text-gray-800">
                        <a href="https://hh.ru" target="_blank" class="hover:text-indigo-600 transition-colors">
                            hh.ru
                        </a>
                    </span>
                    <span class="text-sm text-gray-600">- ведущая платформа онлайн-рекрутинга в России</span>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "IndexFooter",
};
</script>

<style>
.footer-shadow {
    -webkit-box-shadow: 0px -5px 8px -6px rgba(34, 60, 80, 0.2);
    -moz-box-shadow: 0px -5px 8px -6px rgba(34, 60, 80, 0.2);
    box-shadow: 0px -5px 8px -6px rgba(34, 60, 80, 0.2);
}
</style>
