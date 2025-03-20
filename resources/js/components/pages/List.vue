<template>
    <div class="container mx-auto px-6 py-8">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Общий список</h1>
        <p class="text-gray-700">
            данные
        </p>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "ListPage",
    data() {
        return {

        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            axios.get('/api/check')
                .then(res =>{
                    console.log(res);
                })
        },
    },
}
</script>
