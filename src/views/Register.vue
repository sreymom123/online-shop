<template>
  <div class="auth-page">
    <div class="auth-box">
      <h2>Register</h2>

      <div v-if="error" class="error">{{ error }}</div>

      <div class="form-group">
        <label>Name</label>
        <input v-model="form.name" type="text" placeholder="Your full name" />
      </div>

      <div class="form-group">
        <label>Email</label>
        <input v-model="form.email" type="email" placeholder="Email address" />
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Password</label>
          <input v-model="form.password" type="password" placeholder="Create a password" />
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input v-model="form.password_confirmation" type="password" placeholder="Repeat your password" />
        </div>
      </div>

      <button @click="register" :disabled="loading">
        {{ loading ? 'Loading...' : 'Register →' }}
      </button>

      <p>Already have an account? <router-link to="/login">Login</router-link></p>
    </div>
  </div>
</template>

<script>
import api from '../services/api'

export default {
  // ✅ If already logged in, redirect to Home immediately
  mounted() {
    const token = localStorage.getItem('token')
    if (token) {
      this.$router.push('/')
    }
  },

  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      error: '',
      loading: false
    }
  },
  methods: {
    async register() {
      this.loading = true
      this.error = ''
      try {
        const res = await api.post('/register', this.form)
        localStorage.setItem('token', res.data.token)
        localStorage.setItem('user', JSON.stringify(res.data.user))

        // ✅ FIX: Removed window.location.reload() — it was cancelling
        // the navigation and keeping the user on the register page
        this.$router.push('/')

      } catch (err) {
        this.error = 'Have a problem, please check the data again!'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
* { box-sizing: border-box; }

.auth-page {
  min-height: 100vh;
  background: #f0f0e8;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
  font-family: 'Segoe UI', system-ui, sans-serif;
}

.auth-box {
  width: 100%;
  max-width: 420px;
  background: white;
  border-radius: 20px;
  padding: 2.5rem 2rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

h2 {
  text-align: center;
  font-size: 2rem;
  font-weight: 800;
  color: #1a3a1a;
  margin: 0 0 1.75rem 0;
}

.error {
  background: #fdf0f0;
  color: #c0392b;
  border: 1px solid #f5c6c6;
  border-radius: 8px;
  padding: 0.65rem 1rem;
  font-size: 0.875rem;
  margin-bottom: 1.25rem;
}

.form-group {
  margin-bottom: 1rem;
  flex: 1;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0.75rem;
}

label {
  display: block;
  font-size: 0.78rem;
  font-weight: 600;
  color: #3a5a3a;
  margin-bottom: 0.4rem;
  letter-spacing: 0.01em;
}

input {
  width: 100%;
  padding: 0.7rem 0.9rem;
  border: 1.5px solid #e0e8d8;
  border-radius: 10px;
  font-size: 0.875rem;
  color: #1a2e1a;
  background: #fafcf9;
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
  color: #b0bca8;
  font-size: 0.82rem;
}

button {
  width: 100%;
  padding: 0.85rem;
  background: #1e3d1e;
  color: white;
  border: none;
  border-radius: 30px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  margin-top: 1.25rem;
  transition: background 0.2s;
  font-family: inherit;
  letter-spacing: 0.02em;
}

button:hover:not(:disabled) { background: #2d5a2d; }

button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

p {
  margin-top: 1.25rem;
  text-align: center;
  font-size: 0.85rem;
  color: #8a9a7a;
}

p a {
  color: #c8a84b;
  font-weight: 700;
  text-decoration: none;
}

p a:hover { text-decoration: underline; }
</style>
