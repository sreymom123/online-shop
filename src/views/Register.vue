<template>
  <div class="auth-box">
    <h2>Register</h2>

    <div v-if="error" class="error">{{ error }}</div>

    <div class="form-group">
      <label>Name</label>
      <input v-model="form.name" type="text" placeholder="Your name" />
    </div>

    <div class="form-group">
      <label>Email</label>
      <input v-model="form.email" type="email" placeholder="Email" />
    </div>

    <div class="form-group">
      <label>Password</label>
      <input v-model="form.password" type="password" placeholder="Password" />
    </div>

    <div class="form-group">
      <label>Confirm Password</label>
      <input v-model="form.password_confirmation"
             type="password" placeholder="Confirm Password" />
    </div>

    <button @click="register" :disabled="loading">
      {{ loading ? 'Loading...' : 'Register' }}
    </button>

    <p>មានគណនីហើយ? <router-link to="/login">Login</router-link></p>
  </div>
</template>

<script>
import api from '../services/api'

export default {
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
        this.$router.push('/')
        window.location.reload()
      } catch (err) {
        this.error = 'មានបញ្ហា សូមពិនិត្យទិន្នន័យម្តងទៀត!'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.auth-box {
  max-width: 400px;
  margin: 2rem auto;
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
h2 { margin-bottom: 1.5rem; }
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
.error { color: red; margin-bottom: 1rem; }
p { margin-top: 1rem; text-align: center; }
</style>