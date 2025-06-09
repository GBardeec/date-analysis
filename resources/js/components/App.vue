<template>
    <div class="flex flex-col min-h-screen">
        <index-header></index-header>
        <main class="flex-grow">
            <router-view></router-view>
        </main>
        <index-bottom></index-bottom>
    </div>
</template>

<script>
import IndexHeader from "./header/Index.vue";
import IndexBottom from "./bottom/Index.vue";

export default {
    name: "App",
    components: {IndexBottom, IndexHeader},
}
</script>

<style scoped>
</style>
