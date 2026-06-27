<template>
  <div class="cart-page">
    <h2>Cart</h2>

    <!-- Empty -->
    <div v-if="items.length === 0" class="empty">
      <p>🛒 Your cart is empty!</p>
      <router-link to="/products" class="btn-shop">Shop Now</router-link>
    </div>

    <div v-else class="cart-layout">
      <!-- Left: Cart Items -->
      <div class="cart-items">
        <div v-for="item in items" :key="item.id" class="cart-item">
          <div class="item-img">
            <img :src="item.product.image
              ? 'http://localhost:8000/storage/' + item.product.image
              : 'https://placehold.co/80x80'" :alt="item.product.name" />
          </div>
          <div class="item-info">
            <h4>{{ item.product.name }}</h4>
            <p class="item-desc">{{ item.product.description || item.product.category?.name }}</p>
            <p class="item-price">${{ parseFloat(item.product.price).toFixed(2) }}</p>
          </div>
          <div class="item-qty">
            <button @click="updateQty(item, item.quantity - 1)">-</button>
            <span>{{ item.quantity }}</span>
            <button @click="updateQty(item, item.quantity + 1)">+</button>
          </div>
          <p class="subtotal">${{ (item.product.price * item.quantity).toFixed(2) }}</p>
          <button @click="removeItem(item.id)" class="btn-remove">✕</button>
        </div>
      </div>

      <!-- Right: Order Summary -->
      <div class="order-summary">
        <h3>Order Summary</h3>
        <div class="summary-row">
          <span>Subtotal</span>
          <span>${{ total }}</span>
        </div>
        <div class="summary-divider"></div>
        <div class="summary-total">
          <span>Total: ${{ total }}</span>
          <strong>${{ total }}</strong>
        </div>
        <router-link to="/checkout" class="btn-checkout">CHECKOUT →</router-link>
        <div class="summary-badges">
          <div class="badge">
            <span>🛡️</span>
            <small>Secure</small>
          </div>
          <div class="badge">
            <span>🚚</span>
            <small>Fast Ship</small>
          </div>
          <div class="badge">
            <span>🌿</span>
            <small>Fresh</small>
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
    return { items: [] }
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
    async updateQty(item, qty) {
      if (qty < 1) return
      await api.put(`/cart/${item.id}`, { quantity: qty })
      item.quantity = qty
    },
    async removeItem(id) {
      await api.delete(`/cart/${id}`)
      this.items = this.items.filter(i => i.id !== id)
    }
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap');

.cart-page {
  padding: 2.5rem 4rem;
  background: #f4f7ee;
  min-height: 100vh;
  font-family: 'Inter', sans-serif;
}

h2 {
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  font-weight: 700;
  color: #1a2e0d;
  margin-bottom: 1.5rem;
}

/* Empty */
.empty {
  text-align: center;
  padding: 4rem;
  background: white;
  border-radius: 16px;
}
.empty p { font-size: 1.1rem; color: #5a6a4a; margin-bottom: 1rem; }
.btn-shop {
  background: #1a2e0d;
  color: white;
  padding: 0.7rem 1.8rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
}

/* Layout */
.cart-layout {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 1.5rem;
  align-items: start;
}

/* Cart Items */
.cart-items {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.cart-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  background: white;
  padding: 1.1rem 1.25rem;
  border-radius: 16px;
  box-shadow: 0 1px 8px rgba(45,106,15,0.06);
}

/* Image */
.item-img {
  width: 90px;
  height: 90px;
  border-radius: 12px;
  overflow: hidden;
  flex-shrink: 0;
}
.item-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

/* Info */
.item-info {
  flex: 1;
}
.item-info h4 {
  font-size: 0.95rem;
  font-weight: 600;
  color: #1a2e0d;
  margin-bottom: 0.2rem;
}
.item-desc {
  font-size: 0.78rem;
  color: #7aa860;
  margin-bottom: 0.3rem;
}
.item-price {
  font-size: 0.88rem;
  font-weight: 600;
  color: #3a4a2a;
}

/* Qty */
.item-qty {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: #f4f7ee;
  border-radius: 50px;
  padding: 0.25rem 0.5rem;
}
.item-qty button {
  width: 28px;
  height: 28px;
  border: 1.5px solid #d0e8b0;
  background: white;
  border-radius: 50%;
  cursor: pointer;
  font-size: 1rem;
  font-weight: 600;
  color: #2d6a0f;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
}
.item-qty button:hover { background: #2d6a0f; color: white; }
.item-qty span {
  min-width: 24px;
  text-align: center;
  font-weight: 600;
  font-size: 0.9rem;
  color: #1a2e0d;
}

/* Subtotal */
.subtotal {
  font-weight: 700;
  font-size: 0.95rem;
  color: #1a2e0d;
  min-width: 60px;
  text-align: right;
}

/* Remove */
.btn-remove {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 0.85rem;
  color: #e74c3c;
  padding: 0.3rem;
  border-radius: 50%;
  transition: background 0.2s;
}
.btn-remove:hover { background: #fde8e8; }

/* Order Summary */
.order-summary {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  box-shadow: 0 1px 8px rgba(45,106,15,0.06);
  position: sticky;
  top: 80px;
}
.order-summary h3 {
  font-size: 1.1rem;
  font-weight: 700;
  color: #1a2e0d;
  margin-bottom: 1.25rem;
}
.summary-row {
  display: flex;
  justify-content: space-between;
  font-size: 0.88rem;
  color: #7aa860;
  margin-bottom: 0.75rem;
}
.summary-divider {
  height: 1px;
  background: #e8f0e0;
  margin: 0.75rem 0;
}
.summary-total {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.25rem;
}
.summary-total span {
  font-size: 0.9rem;
  color: #5a6a4a;
}
.summary-total strong {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1a2e0d;
}
.btn-checkout {
  display: block;
  text-align: center;
  background: #1a2e0d;
  color: white;
  padding: 0.9rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 700;
  font-size: 0.88rem;
  letter-spacing: 0.08em;
  transition: background 0.2s;
  margin-bottom: 1.25rem;
}
.btn-checkout:hover { background: #2d6a0f; }

/* Badges */
.summary-badges {
  display: flex;
  justify-content: space-around;
  padding-top: 0.5rem;
  border-top: 1px solid #e8f0e0;
}
.badge {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.3rem;
}
.badge span {
  font-size: 1.3rem;
  border: 1.5px solid #d0e8b0;
  border-radius: 10px;
  padding: 0.4rem 0.6rem;
}
.badge small {
  font-size: 0.68rem;
  color: #7aa860;
  font-weight: 500;
}

/* Responsive */
@media (max-width: 900px) {
  .cart-page { padding: 1.5rem; }
  .cart-layout { grid-template-columns: 1fr; }
}
</style>