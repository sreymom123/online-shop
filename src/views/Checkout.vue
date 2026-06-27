<template>
  <div class="checkout-page">
    <div class="checkout-card">

      <!-- Header -->
      <div class="card-header">
        <h2>Order Summary</h2>
      </div>

      <div class="card-body">
        <div v-if="message" class="success">{{ message }}</div>

        <!-- Items -->
        <div v-for="item in items" :key="item.id" class="order-item">
          <div class="item-left">
            <div class="item-thumb">
              <img
                :src="item.product.image
                  ? 'http://localhost:8000/storage/' + item.product.image
                  : 'https://placehold.co/52x52'"
              />
            </div>
            <div class="item-info">
              <span class="item-name">{{ item.product.name }}</span>
              <span class="item-sub">{{ item.product.category?.name }} x{{ item.quantity }}</span>
            </div>
          </div>
          <span class="item-price">${{ (item.product.price * item.quantity).toFixed(2) }}</span>
        </div>

        <!-- Subtotal -->
        <div class="subtotal-row">
          <span class="subtotal-label">Subtotal</span>
          <span class="subtotal-value">${{ total }}</span>
        </div>

        <div class="divider"></div>

        <!-- Delivery Address -->
        <div class="form-group">
          <label>DELIVERY ADDRESS</label>
          <div class="address-wrap">
            <textarea
              v-model="address"
              placeholder="Enter your street address..."
              rows="1"
            ></textarea>
            <span class="address-icon">📍</span>
          </div>
        </div>

        <div class="divider"></div>

        <!-- Total -->
        <div class="total-row">
          <span class="total-label">Total</span>
          <span class="total-value">${{ total }}</span>
        </div>

        <!-- Button -->
        <button @click="placeOrder" :disabled="loading" class="btn-order">
          {{ loading ? 'Processing...' : 'Place Order →' }}
        </button>

        <!-- Fine print -->
        <p class="fine-print">
          By placing your order, you agree to Organic Harvest's
          <a href="#">Terms of Service</a> and <a href="#">Sustainability Commitment</a>.
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../services/api'

export default {
  data() {
    return {
      items: [],
      address: '',
      message: '',
      loading: false
    }
  },
  computed: {
    total() {
      return this.items
        .reduce((sum, i) => sum + i.product.price * i.quantity, 0)
        .toFixed(2)
    }
  },
  async mounted() {
    const res = await api.get('/cart')
    this.items = res.data
  },
  methods: {
    async placeOrder() {
      this.loading = true
      try {
        await api.post('/checkout', { address: this.address })
        this.message = 'Order បានដាក់ជោគជ័យ!'
        this.items = []
        setTimeout(() => this.$router.push('/orders'), 2000)
      } catch {
        this.message = 'មានបញ្ហា!'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
* { box-sizing: border-box; }

.checkout-page {
  min-height: 100vh;
  background: #f0f0e8;
  display: flex;
  align-items: flex-start;
  justify-content: center;
  padding: 2.5rem 1rem;
  font-family: 'Segoe UI', system-ui, sans-serif;
}

.checkout-card {
  width: 100%;
  max-width: 360px;
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0,0,0,0.09);
}

/* Header */
.card-header {
  background: #1e3d1e;
  padding: 1.25rem 1.5rem;
}

.card-header h2 {
  color: white;
  font-size: 1.3rem;
  font-weight: 700;
  margin: 0;
}

/* Body */
.card-body {
  padding: 1.25rem 1.5rem;
}

/* Success */
.success {
  background: #e8f5e9;
  color: #2d7a2d;
  border: 1px solid #c8e6c9;
  border-radius: 8px;
  padding: 0.65rem 1rem;
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 1rem;
}

/* Order items */
.order-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem 0;
  border-bottom: 1px solid #f0f0e8;
}

.item-left {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.item-thumb {
  width: 52px;
  height: 52px;
  border-radius: 8px;
  overflow: hidden;
  background: #f0f0e8;
  flex-shrink: 0;
}

.item-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.item-info {
  display: flex;
  flex-direction: column;
  gap: 0.15rem;
}

.item-name {
  font-size: 0.9rem;
  font-weight: 600;
  color: #1a2e1a;
}

.item-sub {
  font-size: 0.75rem;
  color: #8a9a7a;
}

.item-price {
  font-size: 0.95rem;
  font-weight: 700;
  color: #1a2e1a;
}

/* Subtotal */
.subtotal-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.85rem 0 0.5rem 0;
}

.subtotal-label {
  font-size: 0.82rem;
  color: #8a9a7a;
}

.subtotal-value {
  font-size: 0.82rem;
  color: #1a2e1a;
  font-weight: 600;
}

/* Divider */
.divider {
  border: none;
  border-top: 1px solid #f0f0e8;
  margin: 0.5rem 0;
}

/* Address */
.form-group {
  padding: 0.75rem 0;
}

label {
  display: block;
  font-size: 0.68rem;
  font-weight: 700;
  color: #c8a84b;
  letter-spacing: 0.08em;
  text-transform: uppercase;
  margin-bottom: 0.5rem;
}

.address-wrap {
  position: relative;
}

textarea {
  width: 100%;
  padding: 0.65rem 2rem 0.65rem 0.85rem;
  border: 1.5px solid #e0e8d8;
  border-radius: 8px;
  font-size: 0.875rem;
  font-family: inherit;
  color: #1a2e1a;
  background: #fafcf9;
  resize: none;
  outline: none;
  transition: border-color 0.2s;
  line-height: 1.4;
}

textarea:focus {
  border-color: #2d6a0f;
}

textarea::placeholder {
  color: #b0bca8;
}

.address-icon {
  position: absolute;
  right: 0.7rem;
  top: 50%;
  transform: translateY(-50%);
  font-size: 0.95rem;
  pointer-events: none;
}

/* Total */
.total-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.85rem 0;
}

.total-label {
  font-size: 1.4rem;
  font-weight: 800;
  color: #1a2e1a;
}

.total-value {
  font-size: 1.4rem;
  font-weight: 800;
  color: #c8a84b;
}

/* Button */
.btn-order {
  width: 100%;
  padding: 0.85rem;
  background: #1e3d1e;
  color: white;
  border: none;
  border-radius: 30px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  margin-top: 0.25rem;
  transition: background 0.2s;
  font-family: inherit;
  letter-spacing: 0.02em;
}

.btn-order:hover:not(:disabled) {
  background: #2d5a2d;
}

.btn-order:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Fine print */
.fine-print {
  text-align: center;
  font-size: 0.7rem;
  color: #aaa;
  margin-top: 1rem;
  line-height: 1.5;
}

.fine-print a {
  color: #7aaa7a;
  text-decoration: underline;
}
</style>