<template>
  <div>
    <!-- Navbar -->
    <nav class="navbar">
      <!-- Left: Logo -->
      <div class="nav-logo">
        <span class="logo-icon">🌿</span>
        <div class="logo-text">
          <strong>Online Shop</strong>
          <small>Eat Fresh. Live Well.</small>
        </div>
      </div>

      <!-- Hamburger (mobile) -->
      <button class="hamburger" @click="menuOpen = !menuOpen" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <!-- Center: Links -->
      <div class="nav-links" :class="{ open: menuOpen }">
        <router-link to="/" @click="menuOpen = false">Home</router-link>
        <router-link to="/products" @click="menuOpen = false">Products</router-link>
        <router-link to="/cart" @click="menuOpen = false">🛒 Cart</router-link>
        <router-link to="/wishlist" @click="menuOpen = false">♡ Wishlist</router-link>

        <template v-if="isLoggedIn">
          <router-link to="/orders" @click="menuOpen = false">Orders</router-link>

          <!-- ✅ FIX 2: Show user name from localStorage -->
          <router-link to="/profile" class="user-chip" @click="menuOpen = false">
            👤 {{ userName }}
          </router-link>

          <button @click="logout">Logout</button>
        </template>

        <template v-else>
          <router-link to="/login" @click="menuOpen = false">Login</router-link>
          <router-link to="/register" @click="menuOpen = false">Register</router-link>
        </template>
      </div>
    </nav>

    <!-- Pages -->
    <div class="container">
      <!-- ✅ FIX 1: Watch route changes to re-check login state -->
      <router-view @login="onLogin" />
    </div>
  </div>
</template>

<script>
import api from './services/api'

export default {
  data() {
    return {
      isLoggedIn: !!localStorage.getItem('token'),
      // ✅ FIX 2: Load user name from localStorage
      userName: JSON.parse(localStorage.getItem('user') || '{}')?.name || 'Profile',
      menuOpen: false
    }
  },

  // ✅ FIX 1: Watch the route — every time user navigates,
  // re-check localStorage so navbar updates after login/logout
  watch: {
    $route() {
      this.isLoggedIn = !!localStorage.getItem('token')
      this.userName = JSON.parse(localStorage.getItem('user') || '{}')?.name || 'Profile'
      this.menuOpen = false
    }
  },

  methods: {
    async logout() {
      try {
        await api.post('/logout')
      } catch (e) {
        // even if API fails, still clear local storage
      }
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      this.isLoggedIn = false
      this.userName = 'Profile'
      this.$router.push('/login')
    }
  }
}
</script>

<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: Arial, sans-serif; background: #f8faf5; }

/* ── NAVBAR ── */
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 2.5rem;
  background: #ffffff;
  height: 64px;
  position: sticky;
  top: 0;
  z-index: 100;
  border-bottom: 1px solid #e8f0e0;
  box-shadow: 0 1px 8px rgba(45,106,15,0.06);
}

/* Logo */
.nav-logo {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-shrink: 0;
}
.logo-icon { font-size: 1.6rem; }
.logo-text strong {
  display: block;
  font-size: 1rem;
  font-weight: 700;
  color: #1a2e0d;
  line-height: 1.1;
}
.logo-text small {
  font-size: 0.65rem;
  color: #5a8a2e;
}

/* ── Hamburger ── */
.hamburger {
  display: none;
  flex-direction: column;
  justify-content: center;
  gap: 5px;
  width: 36px;
  height: 36px;
  background: none;
  border: 1px solid #e2e6de;
  border-radius: 8px;
  cursor: pointer;
  padding: 6px;
  flex-shrink: 0;
}
.hamburger span {
  display: block;
  height: 2px;
  background: #2d6a0f;
  border-radius: 2px;
  transition: all 0.2s;
}

/* Nav links */
.nav-links {
  display: flex;
  align-items: center;
  gap: 0.25rem;
}
.nav-links a {
  text-decoration: none;
  color: #3a4a2a;
  font-size: 0.9rem;
  font-weight: 500;
  padding: 0.3rem 0.75rem;
  border-radius: 6px;
  border-bottom: 2px solid transparent;
  transition: color 0.2s, border-color 0.2s;
}
.nav-links a:hover { color: #2d6a0f; }
.nav-links a.router-link-active {
  color: #2d6a0f;
  border-bottom-color: #2d6a0f;
  font-weight: 600;
}

/* ✅ User name chip style */
.user-chip {
  background: #f0f7e8;
  border: 1px solid #c8e0a8;
  border-radius: 20px !important;
  padding: 0.25rem 0.75rem !important;
  font-size: 0.85rem !important;
  color: #2d6a0f !important;
  font-weight: 600 !important;
  border-bottom: 1px solid #c8e0a8 !important;
}
.user-chip:hover { background: #e0f0c8 !important; }

.nav-links button {
  background: none;
  border: 1px solid #d0e8b0;
  color: #2d6a0f;
  font-size: 0.88rem;
  font-weight: 600;
  padding: 0.3rem 0.9rem;
  border-radius: 20px;
  cursor: pointer;
  margin-left: 0.5rem;
  transition: all 0.2s;
}
.nav-links button:hover {
  background: #2d6a0f;
  color: white;
}

/* Full width container */
.container {
  width: 100%;
  margin: 0;
  padding: 0;
}

/* ── MOBILE RESPONSIVE ── */
@media (max-width: 768px) {
  .navbar {
    padding: 0 1.25rem;
    flex-wrap: wrap;
    height: auto;
    min-height: 64px;
  }

  .hamburger {
    display: flex;
  }

  .nav-links {
    display: none;
    width: 100%;
    flex-direction: column;
    align-items: flex-start;
    gap: 0;
    padding: 0.5rem 0 1rem;
    border-top: 1px solid #e8f0e0;
  }

  .nav-links.open {
    display: flex;
  }

  .nav-links a {
    width: 100%;
    padding: 0.65rem 0.5rem;
    border-bottom: 1px solid #f0f5e8;
    border-radius: 0;
    font-size: 0.95rem;
  }

  .nav-links a.router-link-active {
    border-bottom-color: #f0f5e8;
    background: #f5faf0;
    padding-left: 0.75rem;
  }

  .user-chip {
    width: 100%;
    border-radius: 0 !important;
    border-bottom: 1px solid #f0f5e8 !important;
    background: transparent !important;
  }

  .nav-links button {
    margin-left: 0;
    margin-top: 0.5rem;
    width: 100%;
    text-align: left;
    border-radius: 8px;
    padding: 0.6rem 0.75rem;
  }
}
</style>
