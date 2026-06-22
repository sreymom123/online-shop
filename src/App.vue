<template>
  <div>
    <!-- Navbar -->
    <nav class="navbar">
      <div class="nav-brand">🛒 Online Shop</div>
      <div class="nav-links">
        <router-link to="/">Home</router-link>
        <router-link to="/products">Products</router-link>
        <router-link to="/cart">Cart</router-link>
        <router-link to="/wishlist">Wishlist</router-link>

        <template v-if="isLoggedIn">
          <router-link to="/orders">Orders</router-link>
          <router-link to="/profile">Profile</router-link>
          <button @click="logout">Logout</button>
        </template>

        <template v-else>
          <router-link to="/login">Login</router-link>
          <router-link to="/register">Register</router-link>
        </template>
      </div>
    </nav>

    <!-- Pages -->
    <div class="container">
      <router-view />
    </div>
  </div>
</template>

<script>
import api from './services/api'

export default {
  data() {
    return {
      isLoggedIn: !!localStorage.getItem('token')
    }
  },
  methods: {
    async logout() {
      await api.post('/logout')
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      this.isLoggedIn = false
      this.$router.push('/login')
    }
  }
}
</script>

<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, sans-serif; background: #f5f5f5; }

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background: #2c3e50;
  color: white;
}
.nav-brand { font-size: 1.5rem; font-weight: bold; }
.nav-links a, .nav-links button {
  color: white;
  text-decoration: none;
  margin-left: 1rem;
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1rem;
}
.nav-links a:hover { text-decoration: underline; }
.container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
</style>