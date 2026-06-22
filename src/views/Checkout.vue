<template>
  <div class="checkout">
    <h2>Checkout</h2>

    <div v-if="message" class="success">{{ message }}</div>

    <div class="order-summary">
      <h3>Order Summary</h3>
      <div v-for="item in items" :key="item.id" class="order-item">
        <span>{{ item.product.name }} x{{ item.quantity }}</span>
        <span>${{ (item.product.price * item.quantity).toFixed(2) }}</span>
      </div>
      <div class="total">
        <strong>Total: ${{ total }}</strong>
      </div>
    </div>

    <div class="form-group">
      <label>Delivery Address</label>
      <textarea v-model="address" placeholder="Enter your address..." rows="3"></textarea>
    </div>

    <button @click="placeOrder" :disabled="loading" class="btn-order">
      {{ loading ? 'Processing...' : '✅ Place Order' }}
    </button>
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
.checkout { max-width: 600px; margin: 0 auto; }
h2 { margin-bottom: 1.5rem; }
.order-summary {
  background: white;
  padding: 1.5rem;
  border-radius: 10px;
  margin-bottom: 1.5rem;
}
.order-item {
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 0;
  border-bottom: 1px solid #eee;
}
.total { margin-top: 1rem; font-size: 1.2rem; text-align: right; }
.form-group { margin-bottom: 1rem; }
label { display: block; margin-bottom: 0.3rem; font-weight: bold; }
textarea {
  width: 100%;
  padding: 0.7rem;
  border: 1px solid #ddd;
  border-radius: 5px;
}
.btn-order {
  width: 100%;
  padding: 1rem;
  background: #27ae60;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 1.1rem;
  cursor: pointer;
}
.success { color: green; margin-bottom: 1rem; font-size: 1.1rem; }
</style>