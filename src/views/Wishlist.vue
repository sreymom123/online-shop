<template>
  <div class="wishlist-page">

    <!-- Header -->
    <div class="page-header">
      <h2><span class="heart-icon">♥</span> Wishlist</h2>
      <p class="subtitle">A collection of your favorite sustainable harvests and artisanal goods. Ready to bring the farm to your table?</p>
    </div>

    <div v-if="items.length === 0" class="empty">
      No Wishlist ! <router-link to="/products">Shop Now</router-link>
    </div>

    <div class="products-grid">
      <div v-for="item in items" :key="item.id" class="product-card">

        <!-- Image + badges -->
        <div class="card-image-wrap">
          <img :src="item.product.image
            ? 'http://localhost:8000/storage/' + item.product.image
            : 'https://placehold.co/200x200'" />
          <span class="badge-organic">Organic</span>
          <div class="badge-heart">♥</div>
        </div>

        <!-- Info -->
        <div class="card-body">
          <span class="product-category">{{ item.product.category?.name || 'PRODUCT' }}</span>
          <h3>{{ item.product.name }}</h3>
          <p class="price">${{ item.product.price }}</p>
          <button @click="remove(item.id)" class="btn-remove">⊟ REMOVE</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import api from '../services/api'

export default {
  data() {
    return { items: [] }
  },
  async mounted() {
    const res = await api.get('/wishlist')
    this.items = res.data
  },
  methods: {
    async remove(id) {
      await api.delete(`/wishlist/${id}`)
      this.items = this.items.filter(i => i.id !== id)
    }
  }
}
</script>

<style scoped>

* { box-sizing: border-box; }
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&...');

.wishlist-page {
  min-height: 100vh;
  background: #f0f0e8;
  padding: 2rem 2rem;
  font-family: 'Segoe UI', system-ui, sans-serif;
}

/* Header */
.page-header {
  margin-bottom: 2rem;
}

.page-header h2 {
  font-size: 2.2rem;
  font-weight: 800;
  color: #1a2e1a;
  margin: 0 0 0.5rem 0;
  display: flex;
  align-items: center;
  gap: 0.4rem;
  font-family: 'Playfair Display', serif;
}

.heart-icon {
  color: #c0392b;
  font-size: 1.8rem;
}

.subtitle {
  font-size: 0.88rem;
  color: #6a7a5a;
  margin: 0;
  max-width: 480px;
  line-height: 1.6;
}

/* Empty */
.empty {
  text-align: center;
  padding: 3rem;
  background: white;
  border-radius: 12px;
  color: #777;
}

.empty a {
  color: #2d6a0f;
  font-weight: 600;
  text-decoration: none;
}

/* Grid */
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 220px));
  gap: 1.5rem;
}

/* Card */
.product-card {
  background: white;
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

/* Image area */
.card-image-wrap {
  position: relative;
  width: 100%;
  height: 200px;
}

.card-image-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.badge-organic {
  position: absolute;
  top: 10px;
  left: 10px;
  background: #2d6a0f;
  color: white;
  font-size: 0.68rem;
  font-weight: 700;
  padding: 0.2rem 0.6rem;
  border-radius: 20px;
  letter-spacing: 0.03em;
}

.badge-heart {
  position: absolute;
  top: 8px;
  right: 8px;
  width: 30px;
  height: 30px;
  background: #c0392b;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.85rem;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

/* Card body */
.card-body {
  padding: 0.9rem 1rem 1rem;
}

.product-category {
  font-size: 0.65rem;
  font-weight: 700;
  color: #8a9a7a;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  display: block;
  margin-bottom: 0.25rem;
}

.card-body h3 {
  font-size: 0.95rem;
  font-weight: 700;
  color: #1a2e1a;
  margin: 0 0 0.4rem 0;
  line-height: 1.3;
}

.price {
  color: #c0392b;
  font-weight: 700;
  font-size: 1rem;
  margin: 0 0 0.75rem 0;
}

.btn-remove {
  width: 100%;
  padding: 0.55rem;
  background: transparent;
  color: #c0392b;
  border: 1.5px solid #c0392b;
  border-radius: 8px;
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.05em;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
  font-family: inherit;
}

.btn-remove:hover {
  background: #c0392b;
  color: white;
}
</style>