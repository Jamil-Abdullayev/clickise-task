import './bootstrap';
import { createApp } from 'vue';
import SettingsForm from './components/SettingsForm.vue';
import SettingsList from "./components/SettingsList.vue";

const app = createApp({});
app.component('settings-form', SettingsForm);
app.component('settings-list', SettingsList);
app.mount('#app');
