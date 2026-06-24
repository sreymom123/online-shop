<template>
  <div class="profile-box">
    <h2>Profile</h2>

    <div v-if="message" class="success">{{ message }}</div>
    <div v-if="error" class="error">{{ error }}</div>

    <div class="form-group">
      <label>Name</label>
      <input v-model="form.name" type="text" />
    </div>

    <div class="form-group">
      <label>Email</label>
      <input v-model="form.email" type="email" />
    </div>

    <button @click="update" :disabled="loading">
      {{ loading ? 'Saving...' : 'Update Profile' }}
    </button>

    <hr style="margin: 2rem 0" />

    <h3>Change Password</h3>

    <div class="form-group">
      <label>Current Password</label>
      <input v-model="passwordForm.current_password" type="password" />
    </div>

    <div class="form-group">
      <label>New Password</label>
      <input v-model="passwordForm.password" type="password" />
    </div>

    <div class="form-group">
      <label>Confirm New Password</label>
      <input v-model="passwordForm.password_confirmation" type="password" />
    </div>

    <button @click="changePassword" :disabled="loading">
      Change Password
    </button>
  </div>
</template>

<script>
import api from '../services/api'

export default {
  data() {
    return {
      form: { name: '', email: '' },
      passwordForm: {
        current_password: '',
        password: '',
        password_confirmation: ''
      },
      message: '',
      error: '',
      loading: false
    }
  },
  async mounted() {
    const res = await api.get('/profile')
    this.form.name = res.data.name
    this.form.email = res.data.email
  },
  methods: {
    async update() {
      this.loading = true
      try {
        await api.put('/profile', this.form)
        this.message = 'Profile updated!'
      } catch {
        this.error = 'have problem!'
      } finally {
        this.loading = false
      }
    },
    async changePassword() {
      this.loading = true
      try {
        await api.put('/profile/password', this.passwordForm)
        this.message = 'Password changed!'
        this.passwordForm = { current_password: '', password: '', password_confirmation: '' }
      } catch {
        this.error = 'Password not correct!'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.profile-box {
  max-width: 500px;
  margin: 2rem auto;
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
h2, h3 { margin-bottom: 1.5rem; }
.form-group { margin-bottom: 1rem; }
label { display: block; margin-bottom: 0.3rem; font-weight: bold; }
input {
  width: 100%;
  padding: 0.7rem;
  border: 1px solid #ddd;
  border-radius: 5px;
}
button {
  width: 100%;
  padding: 0.8rem;
  background: #2c3e50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top: 1rem;
}
.success { color: green; margin-bottom: 1rem; }
.error { color: red; margin-bottom: 1rem; }
</style>