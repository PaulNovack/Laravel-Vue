<script lang="ts">
import { defineComponent, ref, watch } from 'vue';
import { Task } from '../types/Task';
import AddString from './AddString.vue';
import draggable from 'vuedraggable';

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

        return {
            localTaskList,
            deleteTaskById,
            handleAddTask,
            handleDragEnd
        };
    }
});
</script>

<template>
    <div id="task-list" class="w-full">
        <draggable
            v-model="localTaskList"
            group="tasks"
            item-key="id"
            class="space-y-1"
            @end="handleDragEnd">
            <template #item="{ element }">
                <div class="flex justify-between items-center rounded-lg border-2 md:w-1 sm:w-1 lg:w-1/2 border-gray-500 p-0.5">
                    {{ element.name }}
                    <img @click="deleteTaskById(element.id)" :src="`/svg/garbage.svg`" alt="Garbage Icon" class="max-h-4">
                </div>
            </template>
        </draggable>
        <AddString @add="handleAddTask" :for="`Task`" class="pb-1"/>
        Drag Tasks to Re-Order.
    </div>
</template>


