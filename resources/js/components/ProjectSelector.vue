<script lang="ts">
import axios from 'axios';
import TaskList from "./TaskList.vue";
import {Task }from '../types/Task.ts'
import {Project} from '../types/Project.ts'
import AddString from "./AddString.vue";

export default {
    components: {
        AddString,
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
            handleAddProject(projectName: string) {
                const projectData = {
                    name: projectName
                };
                axios.post('project', projectData)
                    .catch(error => {
                        alert("Error: " + error)
                    });
                this.getProjectList();
            },
            handleAddTask(taskname: string) {
                const taskData = {
                    name: taskname,
                    project_id: this.selectedProjectId
                };
                axios.post(`task`, taskData)
                    .catch(error => {
                        alert('Failed To Add Task with error ' + error)
                    });
                this.getTasktList()
            },
            deleteProjectById(){
                axios.delete( `project/${this.selectedProjectId}`)
                    .then(() => {
                        this.ProjectList = this.ProjectList.filter(task => task.id !== this.selectedProjectId);
                    })
                    .catch(() => {
                        alert('Failed To delete Task!')
                    })
            },
            deleteTaskById(taskid){
                axios.delete( `task/${taskid}`)
                    .then(() => {
                        this.TaskList = this.TaskList.filter(task => task.id !== taskid);
                    })
                    .catch(() => {
                        alert('Failed To delete Task!')
                    })
            },
            orderTaskList(tasks){
                axios.post( `task/order`,{ tasks: tasks })
                    .catch(() => {
                        alert('Failed To Order Task!')
                    })
            },
            async getProjectList(){
                axios.get('project').then((res) =>
                {
                    this.ProjectList = res.data.projects as Project[]
                }).catch((err)=>{
                    alert(err)
                })

            },
            async getTasktList(){
                axios.get( `task/${this.selectedProjectId}`).then((res) =>
                {
                    this.TaskList = res.data.tasks as Task[]
                }).catch((err)=>{
                    alert(err)
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
        <div class="flex">
        <label for="project-select" class="mr-2 ">Projects:</label>
        <select id="project-select" name="projects" @change="handleProjectSelect" v-model="selectedProjectId" v-if="ProjectList.length"
                class="bg-gray-50 border-1 border-gray-300 text-gray-900 text-xs
                   rounded-lg focus:ring-blue-500 focus:border-blue-500
                   block p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                   dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option  v-for="project in ProjectList as Project[]"
                 :key="project.id"
                 :id="project.id"
                 :value="project.id"
                 :title="project.name">{{ project.name }}</option>
    </select>
            <img @click="deleteProjectById()" :src="`/svg/garbage.svg`" alt="Garbage Icon" class="max-h-5 pl-2 pt-1">
        </div>
        </div>
    <div class="flex w-full">
        <AddString @add="handleAddProject" :for="`Project`"/>
    </div>
    <div class="flex mt-2 mr-2 space-x-2 w-full">
        <label for="task-list" class="mr-2">Tasks:</label>
        <TaskList :TaskList="TaskList as Task[]"
                  @addTask="handleAddTask"
                  @deleteTaskById="deleteTaskById"
                  @orderTaskList="orderTaskList"></TaskList>
    </div>
</template>
