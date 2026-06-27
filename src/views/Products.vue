<template>
  <div class="products-page">
    <!-- Header -->
    <div class="products-header">
      <h2>Our Products</h2>
      <div class="search-box">
        <span class="search-icon">🔍</span>
        <input v-model="search" placeholder="Search Product..." @input="fetchProducts" />
      </div>
    </div>

    <!-- Category Filter Buttons -->
    <div class="category-filters">
      <button
        class="cat-btn"
        :class="{ active: selectedCategory === null }"
        @click="selectCategory(null)"
      >
        All Categories
      </button>
      <button
        v-for="cat in categories"
        :key="cat.id"
        class="cat-btn"
        :class="{ active: selectedCategory === cat.id }"
        @click="selectCategory(cat.id)"
      >
        {{ cat.name }}
      </button>
    </div>

    <!-- Products Grid -->
    <div class="products-grid">
      <div v-for="product in products" :key="product.id" class="product-card">
        <div class="product-img-wrap">
          <img :src="product.image
            ? 'http://localhost:8000/storage/' + product.image
            : require('@/assets/400x300.svg')" :alt="product.name" />
          <span class="product-badge">{{ getBadge(product) }}</span>
        </div>
        <div class="product-info">
          <p class="category">{{ product.category?.name }}</p>
          <h3>{{ product.name }}</h3>
          <div class="product-footer">
            <span class="price">${{ parseFloat(product.price).toFixed(2) }}</span>
            <router-link :to="'/products/' + product.id" class="btn-view">View →</router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty state -->
    <div v-if="products.length === 0 && !loading" class="empty">
      <p>No products found.</p>
    </div>

    <!-- Loading state -->
    <div v-if="loading" class="empty">
      <p>Loading products...</p>
    </div>
  </div>
</template>

<script>
import api from '../services/api'

export default {
  data() {
    return {
      products: [],
      categories: [],
      selectedCategory: null,
      search: '',
      loading: false,
      badges: ['ORGANIC', 'COLD PRESSED', 'SEASONAL', 'NEW', 'FRESH', 'LOCAL']
    }
  },
  async mounted() {
    await this.fetchCategories()
    await this.fetchProducts()
  },
  methods: {
    async fetchCategories() {
      const res = await api.get('/categories')
      this.categories = res.data
    },
    async fetchProducts() {
      this.loading = true
      try {
        if (this.search) {
          const res = await api.get(`/products/search?q=${this.search}`)
          this.products = res.data.data || res.data
        } else if (this.selectedCategory) {
          const res = await api.get(`/products?category_id=${this.selectedCategory}`)
          this.products = res.data.data || res.data
        } else {
          const res = await api.get('/products')
          this.products = res.data.data || res.data
        }
      } catch (e) {
        console.error(e)
      } finally {
        this.loading = false
      }
    },
    selectCategory(categoryId) {
      this.selectedCategory = categoryId
      this.search = ''
      this.fetchProducts()
    },
    getBadge(product) {
      return this.badges[product.id % this.badges.length]
    }
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap');

.products-page {
  padding: 2.5rem 4rem;
  background: #f0f7e8;
  min-height: 100vh;
  font-family: 'Inter', sans-serif;
}

/* ── HEADER ── */
.products-header {
  margin-bottom: 1.5rem;
}
.products-header h2 {
  font-family: 'Playfair Display', serif;
  font-size: 2.2rem;
  font-weight: 700;
  color: #1a2e0d;
  margin-bottom: 1rem;
}
.search-box {
  display: flex;
  align-items: center;
  gap: 0.6rem;
  background: white;
  border: 1.5px solid #d8edc8;
  border-radius: 50px;
  padding: 0.6rem 1.2rem;
  max-width: 380px;
}
.search-icon { font-size: 0.95rem; color: #7aa860; }
.search-box input {
  border: none;
  outline: none;
  font-size: 0.9rem;
  color: #3a4a2a;
  background: transparent;
  width: 100%;
}
.search-box input::placeholder { color: #aac89a; }

/* ── CATEGORY FILTERS ── */
.category-filters {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-wrap: wrap;
  margin-bottom: 1.75rem;
}
.cat-btn {
  padding: 0.45rem 1.1rem;
  border-radius: 99px;
  border: 1.5px solid #c8ddb8;
  background: white;
  color: #3a5a2a;
  font-size: 0.85rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  font-family: 'Inter', sans-serif;
}
.cat-btn:hover {
  border-color: #2d6a0f;
  color: #2d6a0f;
  background: #f0f7e8;
}
.cat-btn.active {
  background: #1e3a0d;
  color: white;
  border-color: #1e3a0d;
}

/* ── GRID ── */
.products-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 1.25rem;
}

/* ── CARD ── */
.product-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(45,106,15,0.07);
  transition: transform 0.2s, box-shadow 0.2s;
}
.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 28px rgba(45,106,15,0.13);
}

/* Image */
.product-img-wrap {
  position: relative;
  height: 220px;
  overflow: hidden;
}
.product-img-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s;
}
.product-card:hover .product-img-wrap img { transform: scale(1.05); }

/* Badge */
.product-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background: rgba(30, 60, 10, 0.75);
  color: white;
  font-size: 0.62rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  padding: 0.25rem 0.65rem;
  border-radius: 20px;
  text-transform: uppercase;
  backdrop-filter: blur(4px);
}

/* Info */
.product-info {
  padding: 1rem 1.1rem 1.1rem;
}
.category {
  font-size: 0.7rem;
  font-weight: 700;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: #7aa860;
  margin-bottom: 0.3rem;
}
.product-info h3 {
  font-size: 1rem;
  font-weight: 600;
  color: #1a2e0d;
  margin-bottom: 0.75rem;
  line-height: 1.3;
}
.product-footer {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.price {
  font-size: 1.1rem;
  font-weight: 700;
  color: #1a2e0d;
}
.btn-view {
  background: #1a2e0d;
  color: white;
  text-decoration: none;
  font-size: 0.82rem;
  font-weight: 600;
  padding: 0.45rem 1rem;
  border-radius: 50px;
  transition: background 0.2s;
}
.btn-view:hover { background: #2d6a0f; }

/* Empty / Loading */
.empty {
  text-align: center;
  padding: 3rem;
  color: #7aa860;
  font-size: 1rem;
}

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
  .products-page { padding: 2rem 2rem; }
  .products-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
  .products-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
  .products-grid { grid-template-columns: 1fr; }
  .products-header h2 { font-size: 1.6rem; }
}
</style>
