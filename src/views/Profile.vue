<template>
  <div class="profile-page">

    <!-- Top Header -->
    <div class="profile-hero">
      <div class="avatar-circle">👤</div>
      <h2 class="welcome-title">Welcome back, {{ form.name }}</h2>
      <p class="welcome-sub">Manage your organic harvest account and preferences</p>
    </div>

    <div class="profile-box">

      <!-- Profile Section -->
      <div class="section-title">
        <span class="section-icon">⊕</span>
        <h3>Profile</h3>
      </div>

      <div v-if="message" class="success">✓ {{ message }}</div>
      <div v-if="error" class="error">✕ {{ error }}</div>

      <div class="form-group">
        <label>Name</label>
        <input v-model="form.name" type="text" />
      </div>

      <div class="form-group">
        <label>Email</label>
        <input v-model="form.email" type="email" />
      </div>

      <button @click="update" :disabled="loading">
        {{ loading ? 'Saving...' : 'Update Profile →' }}
      </button>

      <!-- Password Section -->
      <div class="section-title password-title">
        <span class="section-icon">🔒</span>
        <h3>Change Password</h3>
      </div>

      <div class="form-group">
        <label>Current Password</label>
        <input v-model="passwordForm.current_password" type="password" />
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>New Password</label>
          <input v-model="passwordForm.password" type="password" placeholder="Min. 8 characters" />
        </div>
        <div class="form-group">
          <label>Confirm New Password</label>
          <input v-model="passwordForm.password_confirmation" type="password" />
        </div>
      </div>

      <button @click="changePassword" :disabled="loading" class="btn-password">
        Change Password
      </button>

    </div>
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
* { box-sizing: border-box; }

.profile-page {
  min-height: 100vh;
  background: #f0f0e8;
  padding: 2.5rem 1rem;
  font-family: 'Segoe UI', system-ui, sans-serif;
}

/* Hero */
.profile-hero {
  text-align: center;
  margin-bottom: 1.5rem;
}

.avatar-circle {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  background: #1e3d1e;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  margin: 0 auto 0.75rem auto;
  border: 3px solid #fff;
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.welcome-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1a3a1a;
  margin: 0 0 0.3rem 0;
}

.welcome-sub {
  font-size: 0.8rem;
  color: #7a8a6a;
  margin: 0;
}

/* Card */
.profile-box {
  max-width: 480px;
  margin: 0 auto;
  background: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
}

/* Section titles */
.section-title {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1.25rem;
}

.section-title h3 {
  font-size: 1.3rem;
  font-weight: 700;
  color: #1a3a1a;
  margin: 0;
}

.section-icon {
  font-size: 1.1rem;
  color: #1a3a1a;
}

.password-title {
  margin-top: 2rem;
}

/* Alerts */
.success {
  background: #e8f5e9;
  color: #2d7a2d;
  border: 1px solid #c8e6c9;
  border-radius: 8px;
  padding: 0.65rem 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 1.25rem;
}

.error {
  background: #fdf0f0;
  color: #c0392b;
  border: 1px solid #f5c6c6;
  border-radius: 8px;
  padding: 0.65rem 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 1.25rem;
}

/* Form */
.form-group {
  margin-bottom: 1rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.75rem;
}

label {
  display: block;
  margin-bottom: 0.35rem;
  font-size: 0.78rem;
  font-weight: 600;
  color: #6a8a6a;
  letter-spacing: 0.01em;
}

input {
  width: 100%;
  padding: 0.65rem 0.85rem;
  border: 1.5px solid #e0e8d8;
  border-radius: 8px;
  font-size: 0.9rem;
  color: #1a2e1a;
  background: #f7f8f5;
  outline: none;
  font-family: inherit;
  transition: border-color 0.2s, box-shadow 0.2s;
}

input:focus {
  border-color: #2d6a0f;
  box-shadow: 0 0 0 3px rgba(45,106,15,0.08);
  background: white;
}

input::placeholder {
  color: #b0b8a8;
  font-size: 0.82rem;
}

/* Update button - solid pill */
button {
  padding: 0.7rem 1.5rem;
  background: #1e3d1e;
  color: white;
  border: none;
  border-radius: 30px;
  font-size: 0.88rem;
  font-weight: 600;
  cursor: pointer;
  margin-top: 0.25rem;
  transition: background 0.2s;
  font-family: inherit;
  display: inline-block;
  width: auto;
}

button:hover:not(:disabled) {
  background: #2d5a2d;
}

button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Change Password button - outline pill */
.btn-password {
  background: transparent;
  color: #1a3a1a;
  border: 1.5px solid #1a3a1a;
  margin-top: 1rem;
}

.btn-password:hover:not(:disabled) {
  background: #1e3d1e;
  color: white;
}
</style>