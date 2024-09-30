<script lang="ts">
import axios from 'axios';
import TaskList from "./TaskList.vue";
import { Task } from '../types/Task.ts';
import { Project } from '../types/Project.ts';
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
        this.getProjectList();
    },
    methods: {
        handleAddProject(projectName: string) {
            const projectData = {
                name: projectName
            };
            axios.post('project', projectData)
                .then(() => {
                    this.getProjectList(projectName);
                })
                .catch(error => {
                    alert("Error: " + error);
                });
        },
        handleAddTask(taskname: string) {
            if (this.selectedProjectId == 0) {
                alert("You must select a project to add task to first.");
                return;
            }
            const taskData = {
                name: taskname,
                project_id: this.selectedProjectId
            };
            axios.post(`task`, taskData)
                .then(() => {
                    this.getTaskList();
                })
                .catch(error => {
                    alert('Failed To Add Task with error ' + error);
                });
        },
        deleteProjectById() {
            axios.delete(`project/${this.selectedProjectId}`)
                .then(() => {
                    this.ProjectList = this.ProjectList.filter(task => task.id !== this.selectedProjectId);
                    this.TaskList = [];
                })
                .catch(() => {
                    alert('Failed To delete Project!');
                });
        },
        deleteTaskById(taskId) {
            axios.delete(`task/${taskId}`)
                .then(() => {
                    this.TaskList = this.TaskList.filter(task => task.id !== taskId);
                })
                .catch(() => {
                    alert('Failed To delete Task!');
                });
        },
        orderTaskList(tasks) {
            axios.post(`task/order`, { tasks: tasks })
                .then(() => {
                    this.getTaskList();
                })
                .catch(() => {
                    alert('Failed To Order Task!');
                });
        },
        async getProjectList(projectName = -1) {
            axios.get('project').then((res) => {
                if (res.status == 204) {
                    return;
                }
                this.ProjectList = res.data.projects as Project[];
                if (projectName != -1) {
                    this.selectedProjectId = this.ProjectList.find(project => project.name === projectName).id;
                    this.getTaskList();
                }
                if (typeof this.ProjectList === "undefined") {
                    alert("There is something wrong with configuration.\nApplication can not fetch data from JSON endpoint.");
                }
            }).catch((err) => {
                alert(err);
            });
        },
        getTaskList() {
            axios.get(`task/${this.selectedProjectId}`).then((res) => {
                this.TaskList = res.data.tasks as Task[];
            }).catch((err) => {
                alert(err);
            });
        },
        handleProjectSelect() {
            this.getTaskList();
        },
    }
};
</script>

<template>
    <div class="space-y-4">
        <div class="flex flex-col space-y-2">
            <label for="project-select" class="text-base">Projects:</label>
            <select id="project-select" name="projects" @change="handleProjectSelect" v-model="selectedProjectId" v-if="ProjectList.length"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option v-for="project in ProjectList" :key="project.id" :value="project.id" :title="project.name">{{ project.name }}</option>
            </select>
            <img @click="deleteProjectById()" :src="`/drag-and-drop-list/svg/garbage.svg`" alt="Garbage Icon" class="h-6 cursor-pointer">
        </div>

        <div class="flex flex-col space-y-2">
            <AddString @add="handleAddProject" :for="`Project`" />
        </div>

        <div class="flex flex-col space-y-2">
            <label for="task-list" class="text-base">Tasks:</label>
            <TaskList :TaskList="TaskList"
                      @addTask="handleAddTask"
                      @deleteTaskById="deleteTaskById"
                      @orderTaskList="orderTaskList" />
        </div>
    </div>
</template>
