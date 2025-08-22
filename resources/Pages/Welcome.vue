<script setup>
defineProps({
    message: String,
});
</script>

<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold">{{ message }}</h1>
    </div>
</template>