<template>
    <div class="settings-table">
        <table class="table">
            <thead>
            <tr>
                <th>Setting Key</th>
                <th>Value</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="setting in settings" :key="setting.id">
                <td>{{ setting.key }}</td>
                <td>{{ setting.value }}</td>
                <td>
                    <button
                        @click="editSetting(setting)"
                        class="btn btn-primary btn-sm"
                    >
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <settings-form
            v-if="selectedSetting"
            :setting="selectedSetting"
            @setting-updated="refreshSettings"
            v-model="showEditForm"
        />
    </div>
</template>

<script>
import SettingsForm from './SettingsForm.vue'

export default {
    components: {
        SettingsForm
    },

    data() {
        return {
            settings: [],
            selectedSetting: null,
            showEditForm: false
        }
    },

    mounted() {
        this.getSettings()
    },

    methods: {
        async getSettings() {
            try {
                const response = await axios.get(`api/settings`)
                this.settings = response.data
            } catch (error) {
                console.error('Error fetching settings:', error)
            }
        },

        editSetting(setting) {
            this.selectedSetting = setting
            this.showEditForm = true
        },

        refreshSettings() {
            this.getSettings()
            this.showEditForm = false
            this.selectedSetting = null
        }
    }
}
</script>

<style scoped>
.settings-table {
    margin: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #f8f9fa;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
