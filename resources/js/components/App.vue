<template>
    <div class="flex flex-col min-h-screen">
        <index-header></index-header>
        <main class="flex-grow">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import IndexHeader from "./header/Index.vue";

export default {
    name: "App",
    components: {IndexHeader},
}
</script>

<style scoped>
</style>
