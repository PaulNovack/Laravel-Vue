<script lang="ts">
import { defineComponent, ref, watch } from 'vue';
import { Task } from '../types/Task';
import AddString from './AddString.vue';
import draggable from 'vuedraggable';
import axios from "axios";

export default defineComponent({
    components: { AddString, draggable },
    emits: ['addTask', 'deleteTaskById', 'orderTaskList'],
    props: {
        TaskList: {
            type: Array as () => Array<Task>,
            required: true,
            default: () => []
        }
    },
    setup(props, { emit }) {
        // Create a local reactive copy of TaskList
        const localTaskList = ref([...props.TaskList]);

        // Watch for changes in the prop TaskList and update the local copy
        watch(() => props.TaskList, (newList) => {
            localTaskList.value = [...newList];
        });

        const deleteTaskById = (taskId: number) => {
            emit('deleteTaskById', taskId);
        };

        const handleAddTask = (name: string) => {
            if (name) {
                emit('addTask', name);
            }
        };

        const handleDragEnd = () => {
            emit('orderTaskList', localTaskList.value);
        };

        const debounce = (func, wait) => {
            let timeout;
            return (...args) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => func(...args), wait);
            };
        };

        const updateTaskText = (key, value, taskList) => {
            const project_id = taskList.find(task => task.id === key)?.project_id;
            const taskData = {
                name: value,
                project_id: project_id
            };
            axios.patch(`task/` + key, taskData)
                .catch(error => {
                    alert('Failed To Update Task with error ' + error);
                });
        };

        const debouncedUpdateTaskText = debounce(updateTaskText, 500); // 1/2 second

        return {
            localTaskList,
            deleteTaskById,
            handleAddTask,
            handleDragEnd,
            debounce,
            updateTaskText,
            debouncedUpdateTaskText
        };
    }
});
</script>

<template>
    <div id="task-list" class="w-full space-y-4">
        <draggable
            v-model="localTaskList"
            group="tasks"
            item-key="id"
            class="space-y-2"
            @end="handleDragEnd">
            <template #item="{ element }">
                <div class="flex justify-between items-center rounded-lg border-2 border-gray-500 p-3">
                    <input @input="debouncedUpdateTaskText(element.id, $event.target.value, localTaskList)"
                           class="w-full p-2 text-base rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           :key="element.id"
                           :value="element.name" />
                    <img @click="deleteTaskById(element.id)"
                         :src="`/drag-and-drop-list/svg/garbage.svg`"
                         alt="Delete Task"
                         class="h-6 w-6 ml-2 cursor-pointer" />
                </div>
            </template>
        </draggable>

        <AddString @add="handleAddTask" :for="`Task`" class="pt-4" />

        <div class="text-center text-sm">Drag Tasks to Re-Order</div>
    </div>
</template>

<style scoped>
/* Add any additional styles here if needed */
</style>
