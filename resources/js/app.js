import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './app.vue';
import Home from './pages/HomePage.vue';
import Project from './pages/ProjectPage.vue';
import About from './pages/AboutPage.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/about', component: About },
  { path: '/project', component: Project },
];
const router = createRouter({
  history: createWebHistory(),
  routes,
});
createApp(App).use(router).mount('#app');
