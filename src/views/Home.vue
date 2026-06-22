<template>
  <div>
    <div class="hero">
      <h1>🛒 Welcome to Online Shop</h1>
      <p>Find the best products at the best prices!</p>
      <router-link to="/products" class="btn">Shop Now</router-link>
    </div>
  </div>
</template>

<style scoped>
.hero {
  text-align: center;
  padding: 4rem 2rem;
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.hero h1 { font-size: 2.5rem; margin-bottom: 1rem; }
.hero p { color: #666; margin-bottom: 2rem; }
.btn {
  background: #2c3e50;
  color: white;
  padding: 0.8rem 2rem;
  border-radius: 5px;
  text-decoration: none;
}
</style>