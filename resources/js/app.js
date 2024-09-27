import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';
import Home from './pages/HomePage.vue';
import Project from './pages/ProjectPage.vue';
import About from './pages/AboutPage.vue';

const routes = [
  { path: '/drag-and-drop-list/', component: Home },
  { path: '/drag-and-drop-list/about', component: About },
  { path: '/drag-and-drop-list/project-tasks', component: Project },
];
const router = createRouter({
  history: createWebHistory(),
  routes,
});
const application = createApp(App);
application.use(router);
application.mount('#app');
