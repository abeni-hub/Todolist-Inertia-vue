<script setup>
import { useForm, router } from '@inertiajs/vue3';

defineProps({
    todos: Array,
});

const form = useForm({
    task: '',
});

function addTodo() {
    form.post('/todos', {
        onSuccess: () => form.reset('task'),
    });
}

function deleteTodo(id) {
    router.delete(`/todos/${id}`);
}

function toggleComplete(id) {
    router.patch(`/todos/${id}`);
}
</script>

<template>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Todo List</h1>
        
        <form @submit.prevent="addTodo" class="mb-4">
            <input v-model="form.task" type="text" placeholder="New task" class="border p-2 mr-2" />
            <button type="submit" class="bg-blue-500 text-white p-2">Add</button>
            <div v-if="form.errors.task" class="text-red-500 mt-1">{{ form.errors.task }}</div>
        </form>
        
        <ul>
            <li v-for="todo in todos" :key="todo.id" class="mb-2 flex items-center">
                <span :class="{ 'line-through text-gray-500': todo.completed }">{{ todo.task }}</span>
                <button @click="toggleComplete(todo.id)" class="ml-4 text-green-600">Toggle</button>
                <button @click="deleteTodo(todo.id)" class="ml-2 text-red-600">Delete</button>
            </li>
        </ul>
    </div>
</template>