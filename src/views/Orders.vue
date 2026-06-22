<template>
  <div>
    <h2>📦 My Orders</h2>

    <div v-if="orders.length === 0" class="empty">
      មិនទាន់មាន Order នៅឡើយ!
    </div>

    <div v-for="order in orders" :key="order.id" class="order-card">
      <div class="order-header">
        <span><strong>Order #{{ order.id }}</strong></span>
        <span class="status" :class="order.status">{{ order.status }}</span>
        <span>${{ order.total_amount }}</span>
        <span>{{ formatDate(order.created_at) }}</span>
      </div>

      <div class="order-items">
        <div v-for="item in order.order_items" :key="item.id" class="order-item">
          <span>{{ item.product?.name }}</span>
          <span>x{{ item.quantity }}</span>
          <span>${{ item.price }}</span>
        </div>
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
h2 { margin-bottom: 1.5rem; }
.empty { text-align: center; padding: 3rem; background: white; border-radius: 10px; }
.order-card {
  background: white;
  border-radius: 10px;
  padding: 1.5rem;
  margin-bottom: 1rem;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.order-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 1rem;
}
.status {
  padding: 0.3rem 0.8rem;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: bold;
}
.status.pending { background: #ffeaa7; color: #d35400; }
.status.completed { background: #d4edda; color: #27ae60; }
.status.cancelled { background: #f8d7da; color: #e74c3c; }
.order-item {
  display: flex;
  justify-content: space-between;
  padding: 0.3rem 0;
  border-bottom: 1px solid #eee;
  font-size: 0.9rem;
}
</style>