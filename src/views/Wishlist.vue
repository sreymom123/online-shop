<template>
  <div>
    <h2>❤️ Wishlist</h2>

    <div v-if="items.length === 0" class="empty">
      Wishlist ទទេ! <router-link to="/products">Shop Now</router-link>
    </div>

    <div class="products-grid">
      <div v-for="item in items" :key="item.id" class="product-card">
        <img :src="item.product.image
          ? 'http://localhost:8000/storage/' + item.product.image
          : 'https://placehold.co/200x200'" />
        <h3>{{ item.product.name }}</h3>
        <p class="price">${{ item.product.price }}</p>
        <button @click="remove(item.id)" class="btn-remove">លប់</button>
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
h2 { margin-bottom: 1.5rem; }
.empty { text-align: center; padding: 3rem; background: white; border-radius: 10px; }
.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 1.5rem;
}
.product-card {
  background: white;
  border-radius: 10px;
  padding: 1rem;
  text-align: center;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.product-card img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 5px;
}
.price { color: #e74c3c; font-weight: bold; margin: 0.5rem 0; }
.btn-remove {
  padding: 0.5rem 1rem;
  background: #e74c3c;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
</style>