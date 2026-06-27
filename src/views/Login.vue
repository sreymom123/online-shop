<template>
  <div class="auth-page">
    <div class="auth-box">

      <!-- Lock icon -->
      <div class="lock-icon">🔒</div>

      <h2>Login</h2>
      <p class="subtitle">Enter your credentials to access your account</p>

      <div v-if="error" class="error">{{ error }}</div>

      <div class="form-group">
        <label>✉ Email Address</label>
        <input v-model="form.email" type="email" placeholder="Email" />
      </div>

      <div class="form-group">
        <label>⇒ Password</label>
        <input v-model="form.password" type="password" placeholder="Password" />
      </div>

      <button @click="login" :disabled="loading">
        {{ loading ? 'Loading...' : 'Login →' }}
      </button>

      <div class="divider"></div>

      <p>Don't have an account? <router-link to="/register">Register</router-link></p>
    </div>
  </div>
</template>

<script>
import api from '../services/api'

export default {
  // ✅ If user already logged in, redirect to Home immediately
  mounted() {
    const token = localStorage.getItem('token')
    if (token) {
      this.$router.push('/')
    }
  },

  data() {
    return {
      form: { email: '', password: '' },
      error: '',
      loading: false
    }
  },

  methods: {
    async login() {
      this.loading = true
      this.error = ''
      try {
        const res = await api.post('/login', this.form)
        localStorage.setItem('token', res.data.token)
        localStorage.setItem('user', JSON.stringify(res.data.user))

        // ✅ FIX 1: Changed '/dashboard' → '/' because /dashboard doesn't exist in router
        // ✅ FIX 2: Removed window.location.reload() — it was cancelling the navigation
        this.$router.push('/')

      } catch (err) {
        this.error = 'Email ឬ Password មិនត្រឹមត្រូវ!'
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
  max-width: 400px;
  background: white;
  border-radius: 20px;
  padding: 2.5rem 2rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  text-align: center;
}

.lock-icon {
  width: 56px;
  height: 56px;
  background: #e8f0e0;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.4rem;
  margin: 0 auto 1.25rem auto;
}

h2 {
  font-size: 2rem;
  font-weight: 800;
  color: #1a3a1a;
  margin: 0 0 0.5rem 0;
}

.subtitle {
  font-size: 0.82rem;
  color: #8a9a7a;
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
  text-align: left;
}

.form-group {
  margin-bottom: 1rem;
  text-align: left;
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
  margin-top: 0.5rem;
  transition: background 0.2s;
  font-family: inherit;
  letter-spacing: 0.02em;
}

button:hover:not(:disabled) {
  background: #2d5a2d;
}

button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.divider {
  border: none;
  border-top: 1px solid #eee;
  margin: 1.5rem 0 1rem 0;
}

p {
  font-size: 0.85rem;
  color: #8a9a7a;
  margin: 0;
}

p a {
  color: #1a3a1a;
  font-weight: 800;
  text-decoration: none;
}

p a:hover {
  text-decoration: underline;
}
</style>
