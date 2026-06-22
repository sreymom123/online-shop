<template>
  <div>
    <h2>Products</h2>

    <!-- Search -->
    <div class="search-box">
      <input v-model="search" placeholder="ស្វែងរក Product..." @input="fetchProducts" />
    </div>

    <!-- Products Grid -->
    <div class="products-grid">
      <div v-for="product in products" :key="product.id" class="product-card">
        <img :src="product.image
          ? 'http://localhost:8000/storage/' + product.image
          : 'https://placehold.co/200x200'" />
        <h3>{{ product.name }}</h3>
        <p class="category">{{ product.category?.name }}</p>
        <p class="price">${{ product.price }}</p>
        <router-link :to="'/products/' + product.id" class="btn">View</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../services/api'

export default {
  data() {
    return {
      products: [],
      search: ''
    }
  },
  async mounted() {
    this.fetchProducts()
  },
  methods: {
    async fetchProducts() {
      const url = this.search
        ? `/products/search?q=${this.search}`
        : '/products'
      const res = await api.get(url)
      this.products = res.data.data || res.data
    }
  }
}
</script>

<style scoped>
h2 { margin-bottom: 1.5rem; }
.search-box { margin-bottom: 1.5rem; }
.search-box input {
  width: 100%;
  padding: 0.8rem;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 1rem;
}
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 1.5rem;
}
.product-card {
  background: white;
  border-radius: 10px;
  padding: 1rem;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  text-align: center;
}
.product-card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 5px;
}
.product-card h3 { margin: 0.5rem 0; font-size: 1rem; }
.category { color: #666; font-size: 0.85rem; }
.price { color: #e74c3c; font-weight: bold; margin: 0.5rem 0; }
.btn {
  display: inline-block;
  padding: 0.5rem 1rem;
  background: #2c3e50;
  color: white;
  border-radius: 5px;
  text-decoration: none;
  font-size: 0.9rem;
}
</style>