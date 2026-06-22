<template>
  <div class="cart">
    <h2>🛒 Cart</h2>

    <div v-if="items.length === 0" class="empty">
      Cart ទទេ! <router-link to="/products">Shop Now</router-link>
    </div>

    <div v-else>
      <div v-for="item in items" :key="item.id" class="cart-item">
        <img :src="item.product.image
          ? 'http://localhost:8000/storage/' + item.product.image
          : 'https://placehold.co/80x80'" />

        <div class="item-info">
          <h4>{{ item.product.name }}</h4>
          <p>${{ item.product.price }}</p>
        </div>

        <div class="item-qty">
          <button @click="updateQty(item, item.quantity - 1)">-</button>
          <span>{{ item.quantity }}</span>
          <button @click="updateQty(item, item.quantity + 1)">+</button>
        </div>

        <p class="subtotal">${{ (item.product.price * item.quantity).toFixed(2) }}</p>

        <button @click="removeItem(item.id)" class="btn-remove">❌</button>
      </div>

      <div class="cart-total">
        <strong>Total: ${{ total }}</strong>
        <router-link to="/checkout" class="btn-checkout">Checkout</router-link>
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
h2 { margin-bottom: 1.5rem; }
.empty { text-align: center; padding: 3rem; background: white; border-radius: 10px; }
.cart-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  background: white;
  padding: 1rem;
  border-radius: 10px;
  margin-bottom: 1rem;
}
.cart-item img { width: 80px; height: 80px; object-fit: cover; border-radius: 5px; }
.item-info { flex: 1; }
.item-qty { display: flex; align-items: center; gap: 0.5rem; }
.item-qty button {
  width: 30px; height: 30px;
  border: 1px solid #ddd;
  background: white;
  cursor: pointer;
  border-radius: 3px;
}
.subtotal { font-weight: bold; min-width: 60px; }
.btn-remove { background: none; border: none; cursor: pointer; font-size: 1.2rem; }
.cart-total {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: white;
  padding: 1.5rem;
  border-radius: 10px;
  font-size: 1.2rem;
}
.btn-checkout {
  padding: 0.8rem 2rem;
  background: #27ae60;
  color: white;
  border-radius: 5px;
  text-decoration: none;
}
</style>