<template>
    <div class="settings-form">
        <div v-if="!showVerification">
            <div class="form-group">
                <ul>
                    <li> Setting Key: <span v-text="settingKey"></span></li>
                    <li> Setting Value: <span v-text="settingOldValue"></span></li>
                </ul>
            </div>
            <hr>
            <div class="form-group">
                <label>Setting New Value</label>
                <input v-model="settingValue" class="form-control" />
            </div>

            <div v-if="setting.requires_verification" class="form-group">
                <label>Verification Method</label>
                <select v-model="verificationMethod" class="form-control">
                    <option value="sms">SMS</option>
                    <option value="email">Email</option>
                    <option value="telegram">Telegram</option>
                </select>
            </div>

            <button @click="updateSetting" class="btn btn-primary">
                Update Setting
            </button>
        </div>

        <div v-else>
            <div class="form-group">
                <label>Enter Verification Code</label>
                <input v-model="verificationCode" class="form-control" />
            </div>

            <button @click="verifyCode" class="btn btn-primary">
                Verify Code
            </button>

            <button @click="changeMethod" class="btn btn-secondary">
                Change Verification Method
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        setting: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            settingValue: '',
            settingKey: '',
            settingOldValue: '',
            verificationMethod: 'sms',
            verificationCode: '',
            verificationId: null,
            showVerification: false
        }
    },

    mounted() {
        // Вызываем функцию при монтировании компонента
        this.getSettingValue();
    },

    methods: {
        async getSettingValue() {
            try {
                const settingValue = await axios.get(`api/settings/${this.setting.id}/getSettingValue`);

                if (settingValue.data) {
                    this.settingOldValue = settingValue.data.settingValue;
                    this.settingKey = settingValue.data.settingKey;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        },

        async updateSetting() {
            try {
                const response = await axios.post(`api/settings/${this.setting.id}`, {
                    value: this.settingValue,
                    verification_method: this.verificationMethod
                });

                if (response.data.verification_id) {
                    this.verificationId = response.data.verification_id;
                    this.showVerification = true;
                    window.alert(JSON.stringify(response.data.message));
                }
            } catch (error) {
                console.error('Error updating setting:', error);
            }
        },

        async verifyCode() {
            try {
                await axios.post(`api/settings/${this.setting.id}/verify`, {
                    code: this.verificationCode,
                    verification_id: this.verificationId,
                    value: this.settingValue
                });

                this.$emit('setting-updated');
                window.alert('SUCCESS!');
                this.showVerification = false;
            } catch (error) {
                console.error('Error verifying code:', error);
            }
        },

        changeMethod() {
            this.showVerification = false;
        }
    }
}
</script>
