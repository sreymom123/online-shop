<template>
  <div v-if="product" class="detail-page">
    <div class="product-top">

      <!-- Left: Image -->
      <div class="image-col">
        <div class="main-image-wrap">
          <span class="badge-organic">ORGANIC</span>
          <img :src="product.image
            ? 'http://localhost:8000/storage/' + product.image
            : 'https://placehold.co/300x300'" />
        </div>
        
      </div>

      <!-- Right: Info -->
      <div class="product-info">
        <span class="category-label">{{ product.category?.name }}</span>
        <h2>{{ product.name }}</h2>
        <p class="price">${{ product.price }}</p>
        <p class="description">{{ product.description }}</p>

        <div class="meta-badges">
          <span class="meta-badge">🛒 {{ product.stock }} IN STOCK</span>
          <span class="meta-badge green">🌿 100% ORGANIC</span>
        </div>

        <div class="actions">
          <button @click="addToCart" class="btn-primary">Add to Cart 🛒</button>
        </div>

        <div v-if="message" class="success">{{ message }}</div>
      </div>
    </div>

    <!-- Reviews -->
    <div class="reviews">
      <div class="reviews-header">
        <div>
          <h3>Reviews ({{ product.reviews?.length || 0 }})</h3>
          <p class="reviews-sub">No reviews yet. Be the first to share your thoughts!</p>
        </div>
        <button v-if="isLoggedIn" @click="showReviewForm = !showReviewForm" class="btn-write-review">
          Write a Review
        </button>
      </div>

      <div v-for="review in product.reviews" :key="review.id" class="review-item">
        <strong>{{ review.user?.name }}</strong>
        <span class="stars">{{ '⭐'.repeat(review.rating) }}</span>
        <p>{{ review.comment }}</p>
      </div>

      <!-- Write Review -->
      <div v-if="isLoggedIn && showReviewForm" class="write-review">
        <div class="review-form-card">
          <div class="form-group">
            <label>Overall Rating</label>
            <select v-model="reviewForm.rating">
              <option value="1">⭐ 1</option>
              <option value="2">⭐⭐ 2</option>
              <option value="3">⭐⭐⭐ 3</option>
              <option value="4">⭐⭐⭐⭐ 4</option>
              <option value="5">⭐⭐⭐⭐⭐ 5</option>
            </select>
          </div>

          <div class="form-group">
            <label>Your Thoughts</label>
            <textarea v-model="reviewForm.comment" placeholder="Write your review..."></textarea>
          </div>

          <div class="review-actions">
            <button @click="submitReview" class="btn-primary">Submit Review</button>
            <button @click="showReviewForm = false" class="btn-cancel">Cancel</button>
          </div>
        </div>
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
      reviewForm: { rating: 5, comment: '' },
      showReviewForm: false
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
* { box-sizing: border-box; }

.detail-page {
  min-height: 100vh;
  background: #f0f0e8;
  padding: 2rem 1.5rem;
  font-family: 'Segoe UI', system-ui, sans-serif;
}

/* Top section */
.product-top {
  display: grid;
  grid-template-columns: 320px 1fr;
  gap: 2.5rem;
  background: white;
  padding: 1.5rem;
  border-radius: 14px;
  margin-bottom: 1.5rem;
  box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}

/* Image col */
.image-col {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.main-image-wrap {
  position: relative;
  border-radius: 10px;
  overflow: hidden;
  height: 280px;
}

.main-image-wrap img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.badge-organic {
  position: absolute;
  top: 10px;
  left: 10px;
  background: rgba(30, 61, 30, 0.85);
  color: white;
  font-size: 0.65rem;
  font-weight: 700;
  padding: 0.25rem 0.6rem;
  border-radius: 4px;
  letter-spacing: 0.08em;
  z-index: 1;
}

.image-thumbs {
  display: flex;
  gap: 0.5rem;
}

.thumb {
  width: 52px;
  height: 52px;
  border-radius: 8px;
  overflow: hidden;
  border: 2px solid #e0e0d8;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f5f5ee;
}

.thumb.active {
  border-color: #1e3d1e;
}

.thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.thumb-icon {
  font-size: 1.2rem;
}

/* Product info */
.product-info {
  padding: 0.5rem 0;
}

.category-label {
  font-size: 0.7rem;
  font-weight: 700;
  color: #8a9a7a;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  display: block;
  margin-bottom: 0.4rem;
}

.product-info h2 {
  font-size: 2rem;
  font-weight: 800;
  color: #1a2e1a;
  margin: 0 0 0.5rem 0;
}

.price {
  font-size: 1.6rem;
  font-weight: 800;
  color: #c0392b;
  margin: 0 0 0.75rem 0;
}

.description {
  font-size: 0.875rem;
  color: #6a7a6a;
  line-height: 1.6;
  margin: 0 0 1rem 0;
}

.meta-badges {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.25rem;
}

.meta-badge {
  font-size: 0.72rem;
  font-weight: 600;
  color: #6a7a6a;
  display: flex;
  align-items: center;
  gap: 0.3rem;
}

.meta-badge.green {
  color: #2d6a0f;
}

/* Actions */
.actions {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  flex-wrap: wrap;
}

.qty-control {
  display: flex;
  align-items: center;
  border: 1.5px solid #d0d8c8;
  border-radius: 30px;
  overflow: hidden;
  height: 42px;
}

.qty-btn {
  width: 36px;
  height: 42px;
  background: transparent;
  border: none;
  font-size: 1.1rem;
  cursor: pointer;
  color: #444;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
  transition: background 0.15s;
}

.qty-btn:hover {
  background: #f0f0e8;
}

.qty-value {
  padding: 0 0.75rem;
  font-size: 0.9rem;
  font-weight: 600;
  color: #1a2e1a;
  min-width: 28px;
  text-align: center;
}

.btn-primary {
  padding: 0.65rem 1.5rem;
  background: #1e3d1e;
  color: white;
  border: none;
  border-radius: 30px;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  height: 42px;
  transition: background 0.2s;
  font-family: inherit;
}

.btn-primary:hover {
  background: #2d5a2d;
}

.btn-wishlist {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  border: 1.5px solid #d0d8c8;
  background: white;
  font-size: 1.1rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #c0392b;
  transition: background 0.2s;
}

.btn-wishlist:hover {
  background: #fdf0f0;
}

.success {
  margin-top: 0.75rem;
  font-size: 0.85rem;
  color: #2d7a2d;
  font-weight: 500;
}

/* Reviews */
.reviews {
  background: white;
  border-radius: 14px;
  padding: 1.75rem;
  box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}

.reviews-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 1.25rem;
}

.reviews-header h3 {
  font-size: 1.2rem;
  font-weight: 700;
  color: #1a2e1a;
  margin: 0 0 0.25rem 0;
}

.reviews-sub {
  font-size: 0.8rem;
  color: #9aaa8a;
  margin: 0;
}

.btn-write-review {
  padding: 0.5rem 1rem;
  background: #f0f0e8;
  color: #4a6a4a;
  border: 1px solid #d8e0d0;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  cursor: pointer;
  font-family: inherit;
  transition: background 0.2s;
  white-space: nowrap;
}

.btn-write-review:hover {
  background: #e0e8d8;
}

.review-item {
  border-bottom: 1px solid #eee;
  padding: 1rem 0;
}

.stars { margin-left: 0.5rem; }

/* Write review form */
.write-review {
  margin-top: 1.5rem;
}

.review-form-card {
  background: #fafaf5;
  border: 1px solid #e8e8e0;
  border-radius: 12px;
  padding: 1.25rem;
  max-width: 340px;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  font-size: 0.78rem;
  font-weight: 600;
  color: #4a5a4a;
  margin-bottom: 0.5rem;
}

.review-form-card select {
  width: 100%;
  padding: 0.7rem 0.85rem;
  border: 1.5px solid #2a2a2a;
  border-radius: 8px;
  font-size: 0.9rem;
  font-family: inherit;
  color: #1a2e1a;
  background: white;
  outline: none;
  cursor: pointer;
  appearance: auto;
}

textarea {
  width: 100%;
  padding: 0.7rem 0.85rem;
  border: 1.5px solid #e0e8d8;
  border-radius: 8px;
  font-size: 0.875rem;
  font-family: inherit;
  color: #1a2e1a;
  background: white;
  resize: none;
  height: 100px;
  outline: none;
  transition: border-color 0.2s;
}

textarea:focus {
  border-color: #2d6a0f;
}

textarea::placeholder {
  color: #b0b8a8;
}

.review-actions {
  display: flex;
  gap: 0.75rem;
  align-items: center;
}

.btn-cancel {
  background: transparent;
  border: none;
  color: #7a8a7a;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  padding: 0;
  font-family: inherit;
}

.btn-cancel:hover {
  color: #1a2e1a;
}
</style>