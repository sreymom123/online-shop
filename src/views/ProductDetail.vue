<template>
  <div v-if="product" class="product-detail">
    <div class="product-top">
      <img :src="product.image
        ? 'http://localhost:8000/storage/' + product.image
        : 'https://placehold.co/300x300'" />

      <div class="product-info">
        <h2>{{ product.name }}</h2>
        <p class="category">Category: {{ product.category?.name }}</p>
        <p class="price">${{ product.price }}</p>
        <p>Stock: {{ product.stock }}</p>
        <p>{{ product.description }}</p>

        <div class="actions">
          <button @click="addToCart" class="btn-primary">🛒 Add to Cart</button>
          <button @click="addToWishlist" class="btn-secondary">❤️ Wishlist</button>
        </div>

        <div v-if="message" class="success">{{ message }}</div>
      </div>
    </div>

    <!-- Reviews -->
    <div class="reviews">
      <h3>Reviews ({{ product.reviews?.length || 0 }})</h3>

      <div v-for="review in product.reviews" :key="review.id" class="review-item">
        <strong>{{ review.user?.name }}</strong>
        <span class="stars">{{ '⭐'.repeat(review.rating) }}</span>
        <p>{{ review.comment }}</p>
      </div>

      <!-- Write Review -->
      <div v-if="isLoggedIn" class="write-review">
        <h4>Write a Review</h4>
        <select v-model="reviewForm.rating">
          <option value="1">⭐ 1</option>
          <option value="2">⭐⭐ 2</option>
          <option value="3">⭐⭐⭐ 3</option>
          <option value="4">⭐⭐⭐⭐ 4</option>
          <option value="5">⭐⭐⭐⭐⭐ 5</option>
        </select>
        <textarea v-model="reviewForm.comment" placeholder="Write your review..."></textarea>
        <button @click="submitReview" class="btn-primary">Submit Review</button>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../services/api'

export default {
  data() {
    return {
      product: null,
      message: '',
      isLoggedIn: !!localStorage.getItem('token'),
      reviewForm: { rating: 5, comment: '' }
    }
  },
  async mounted() {
    const res = await api.get(`/products/${this.$route.params.id}`)
    this.product = res.data
  },
  methods: {
    async addToCart() {
      try {
        await api.post('/cart', { product_id: this.product.id, quantity: 1 })
        this.message = 'Add to Cart!'
      } catch {
        this.message = 'Please Login first!'
      }
    },
    async addToWishlist() {
      try {
        await api.post('/wishlist', { product_id: this.product.id })
        this.message = 'Add to Wishlist!'
      } catch {
        this.message = 'Please Login first!'
      }
    },
    async submitReview() {
      try {
        await api.post(`/products/${this.product.id}/reviews`, this.reviewForm)
        this.message = 'Review success!'
        const res = await api.get(`/products/${this.product.id}`)
        this.product = res.data
      } catch {
        this.message = 'have problem!'
      }
    }
  }
}
</script>

<style scoped>
.product-top {
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: 2rem;
  background: white;
  padding: 2rem;
  border-radius: 10px;
  margin-bottom: 2rem;
}
.product-top img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  border-radius: 10px;
}
.category { color: #666; margin: 0.5rem 0; }
.price { color: #e74c3c; font-size: 1.5rem; font-weight: bold; margin: 1rem 0; }
.actions { display: flex; gap: 1rem; margin-top: 1rem; }
.btn-primary, .btn-secondary {
  padding: 0.8rem 1.5rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
}
.btn-primary { background: #2c3e50; color: white; }
.btn-secondary { background: #e74c3c; color: white; }
.reviews {
  background: white;
  padding: 2rem;
  border-radius: 10px;
}
.review-item {
  border-bottom: 1px solid #eee;
  padding: 1rem 0;
}
.stars { margin-left: 0.5rem; }
.write-review { margin-top: 2rem; }
.write-review select, .write-review textarea {
  width: 100%;
  padding: 0.7rem;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin: 0.5rem 0;
}
.write-review textarea { height: 100px; }
.success { color: green; margin-top: 1rem; }
</style>