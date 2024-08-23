<script lang="ts">
import axios from 'axios';
import TaskList from "./TaskList.vue";
import {Task }from '../types/Task.ts'
import {Project} from '../types/Project.ts'
const host = import.meta.env.VITE_PUSHER_HOST;
export default {
    components: {
        TaskList
    },
    data() {
        return {
            ProjectList: [] as Project[],
            TaskList: [] as Task[],
            selectedProjectId: 0
        }
    },
    mounted() {
        this.getProjectList()

    },
    methods:
        {
            async getProjectList(){
                axios.get(host + "/projects").then((res) =>
                {
                    console.log(res)
                    this.ProjectList = res.data.projects as Project[]
                }).catch((err)=>{
                    console.log(err)
                })

            },
            async getTasktList(){
                axios.get(host + `/tasks/${this.selectedProjectId}`).then((res) =>
                {
                    console.log(res)
                    this.TaskList = res.data.tasks as Task[]
                }).catch((err)=>{
                    console.log(err)
                })

            },
            handleProjectSelect(){
                this.getTasktList()
            },
        }
}
</script>
<template>
    <div class="flex w-full">
        <label for="project-select" class="mr-2 ">Projects:</label>
        <select id="project-select" name="projects" @change="handleProjectSelect" v-model="selectedProjectId" v-if="ProjectList.length"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500
                focus:border-blue-500 block p-0.5 dark:bg-gray-700 dark:border-gray-600
                dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option  v-for="project in ProjectList as Project[]"
                 :key="project.id"
                 :id="project.id"
                 :value="project.id"
                 :title="project.name">{{ project.name }}</option>
    </select>
    </div>
    <div class="flex mt-2 mr-2 space-x-2 w-full">
        <label for="task-list" class="mr-2">Tasks:</label>
        <TaskList :TaskList="TaskList as Task[]"></TaskList>
    </div>
</template>
