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
                    <a href="/" class="text-gray-600 hover:text-blue-500 transition">Home</a>
                    <a href="/project-tasks" class="text-gray-600 hover:text-blue-500 transition">Projects</a>
                    <a href="/about" class="text-gray-600 hover:text-blue-500 transition">About</a>
                </div>
            </div>
        </div>
    </nav>
    <RouterView />
</template>

