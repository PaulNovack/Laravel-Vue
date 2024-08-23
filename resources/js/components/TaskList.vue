<script lang="ts">

import { defineComponent } from 'vue';
import  {Task} from '../types/Task'
export default defineComponent({

    props: {
        TaskList: {
            type: Array as () => Array<Task>,
            required: true,
            default: () => []
        }
    },
});


</script>
<style scoped>
.list-enter-active,
.list-leave-active {
    transition: all 1s ease;
}

.list-enter,
.list-leave-to /* .list-leave-active in versions <2.1.8 */ {
    opacity: 0;
    transform: translateX(-10px);
}
</style>
<template>

    <ul id="task-list" name="task-list" class="w-full">
        <li class="transition-transform duration-500 ease-in-out transform
        rounded-lg border-2 w-1/2 border-gray-500 p-0.5 mt-0.5 " v-for="task in TaskList<Task>" :key="task.id">{{task.name}}</li>
    </ul>


</template>
