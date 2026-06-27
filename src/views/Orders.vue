<template>
  <div class="orders-page">
    <div class="page-header">
      <h2>My Orders</h2>
      <p class="subtitle">Track and manage your sustainable harvests.</p>
    </div>

    <div v-if="orders.length === 0" class="empty">
      don't have Order!
    </div>

    <div v-for="order in orders" :key="order.id" class="order-card">
      <div class="order-header">
        <span class="order-id"><strong>Order #{{ order.id }}</strong></span>
        <div class="header-right">
          <div class="header-meta">
            <span class="meta-label">STATUS</span>
            <span class="meta-label">TOTAL AMOUNT</span>
            <span class="meta-label">DATE</span>
          </div>
          <div class="header-values">
            <span class="status" :class="order.status">{{ order.status }}</span>
            <span class="total-amount">${{ order.total_amount }}</span>
            <span class="order-date">{{ formatDate(order.created_at) }}</span>
          </div>
        </div>
      </div>

      <div class="divider"></div>

      <div class="items-header">
        <span>PRODUCT</span>
        <span class="col-qty">QUANTITY</span>
        <span class="col-price">PRICE</span>
      </div>

      <div class="order-items">
        <div v-for="item in order.order_items" :key="item.id" class="order-item">
          <span class="item-name">{{ item.product?.name }}</span>
          <span class="col-qty item-qty">x{{ item.quantity }}</span>
          <span class="col-price item-price">${{ item.price }}</span>
        </div>
      </div>

      <div class="divider"></div>

      <div class="order-footer">
        <span class="delivery-label">🍃 Standard Carbon-Neutral Delivery</span>
        <span class="details-link">Order Details</span>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../services/api'

export default {
  data() {
    return { orders: [] }
  },
  async mounted() {
    const res = await api.get('/orders')
    this.orders = res.data
  },
  methods: {
    formatDate(date) {
      return new Date(date).toLocaleDateString()
    }
  }
}
</script>

<style scoped>
* { box-sizing: border-box; }
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&...');

.orders-page {
  min-height: 100vh;
  background: #f0f4ee;
  padding: 2rem 1.5rem;
  font-family: 'Segoe UI', system-ui, sans-serif;
}

.page-header {
  margin-bottom: 1.5rem;
}

.page-header h2 {
  font-size: 1.75rem;
  font-weight: 700;
  color: #1a2e1a;
  margin: 0 0 0.25rem 0;
  font-family: 'Playfair Display', serif;
}

.subtitle {
  font-size: 0.875rem;
  color: #5a7a5a;
  margin: 0;
}

.empty {
  text-align: center;
  padding: 3rem;
  background: white;
  border-radius: 10px;
  color: #777;
}

/* Card */
.order-card {
  background: white;
  border-radius: 10px;
  padding: 1.25rem 1.5rem;
  margin-bottom: 1rem;
  box-shadow: 0 1px 4px rgba(0,0,0,0.07);
}

/* Header */
.order-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding-bottom: 0.75rem;
}

.order-id {
  font-size: 0.95rem;
  color: #c8a84b;
}

.header-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 0.2rem;
}

.header-meta {
  display: flex;
  gap: 1.5rem;
}

.meta-label {
  font-size: 0.68rem;
  font-weight: 600;
  color: #aaa;
  letter-spacing: 0.05em;
  text-transform: uppercase;
  min-width: 80px;
  text-align: center;
}

.header-values {
  display: flex;
  gap: 1.5rem;
  align-items: center;
}

/* Status badge */
.status {
  padding: 0.2rem 0.75rem;
  border-radius: 20px;
  font-size: 0.72rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  min-width: 80px;
  text-align: center;
}
.status.pending   { background: #e8f5e9; color: #4caf50; }
.status.completed { background: #d4edda; color: #27ae60; }
.status.cancelled { background: #f8d7da; color: #e74c3c; }

.total-amount {
  font-weight: 700;
  color: #2d5a2d;
  font-size: 0.95rem;
  min-width: 80px;
  text-align: center;
}

.order-date {
  font-size: 0.82rem;
  color: #888;
  min-width: 80px;
  text-align: center;
}

/* Divider */
.divider {
  border: none;
  border-top: 1px solid #f0f0f0;
  margin: 0.25rem 0;
}

/* Items column headers */
.items-header {
  display: grid;
  grid-template-columns: 1fr 120px 100px;
  padding: 0.5rem 0;
  font-size: 0.68rem;
  font-weight: 600;
  color: #aaa;
  letter-spacing: 0.05em;
  text-transform: uppercase;
}

/* Items */
.order-items {
  display: flex;
  flex-direction: column;
}

.order-item {
  display: grid;
  grid-template-columns: 1fr 120px 100px;
  align-items: center;
  padding: 0.75rem 0;
  border-bottom: 1px solid #f5f5f5;
  font-size: 0.9rem;
}

.order-item:last-child {
  border-bottom: none;
}

.item-name {
  color: #2a3a2a;
  font-weight: 500;
}

.col-qty { text-align: center; }
.col-price { text-align: right; }

.item-qty {
  color: #c8a84b;
  font-weight: 600;
}

.item-price {
  font-weight: 700;
  color: #2d5a2d;
}

/* Footer */
.order-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 0.75rem;
}

.delivery-label {
  font-size: 0.78rem;
  color: #888;
}

.details-link {
  font-size: 0.78rem;
  color: #4a8a4a;
  font-weight: 600;
  cursor: pointer;
}

.details-link:hover {
  text-decoration: underline;
}
</style>