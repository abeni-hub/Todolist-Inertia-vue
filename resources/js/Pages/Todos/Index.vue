<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    todos: Array,
});

const form = useForm({
    task: '',
});

const editForm = useForm({
    task: '',
});

const editingId = ref(null);

function addTodo() {
    form.post('/todos', {
        onSuccess: () => form.reset('task'),
    });
}

function deleteTodo(id) {
    router.delete(`/todos/${id}`);
}

function toggleComplete(id) {
    router.patch(`/todos/${id}/toggle`);
}

function startEdit(todo) {
    editingId.value = todo.id;
    editForm.task = todo.task;
}

function saveEdit(id) {
    editForm.patch(`/todos/${id}`, {
        onSuccess: () => {
            editingId.value = null;
            editForm.reset();
        },
    });
}

function cancelEdit() {
    editingId.value = null;
    editForm.reset();
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
                <template v-if="editingId !== todo.id">
                    <span :class="{ 'line-through text-gray-500': todo.completed }">{{ todo.task }}</span>
                    <button @click="toggleComplete(todo.id)" class="ml-4 text-green-600">Toggle</button>
                    <button @click="startEdit(todo)" class="ml-2 text-blue-600">Edit</button>
                    <button @click="deleteTodo(todo.id)" class="ml-2 text-red-600">Delete</button>
                </template>
                <template v-else>
                    <input v-model="editForm.task" type="text" class="border p-2 mr-2 flex-grow" />
                    <button @click="saveEdit(todo.id)" class="bg-green-500 text-white p-2 mr-2">Save</button>
                    <button @click="cancelEdit" class="bg-gray-500 text-white p-2">Cancel</button>
                    <div v-if="editForm.errors.task" class="text-red-500 mt-1">{{ editForm.errors.task }}</div>
                </template>
            </li>
        </ul>
    </div>
</template>