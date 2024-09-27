<script lang="ts">
export default {

}
</script>

<template>
    <!-- Main Menu -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-start items-center py-4">
                <!-- Menu Links -->
                <div class="flex space-x-6">
                    <a href="/" class="text-xl text-gray-600 hover:text-blue-500 transition">PaulNovack.net Home</a>
                    <a href="/drag-and-drop-list/" class="text-xl text-gray-600 hover:text-blue-500 transition">Home</a>
                    <a href="/drag-and-drop-list/project-tasks" class="text-xl text-gray-600 hover:text-blue-500 transition">Projects</a>
                    <a href="/drag-and-drop-list/about" class="text-xl text-gray-600 hover:text-blue-500 transition">About</a>
                </div>
            </div>
        </div>
    </nav>
    <RouterView />
</template>
