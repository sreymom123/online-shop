<template>
  <div class="home">

    <!-- HERO SECTION -->
    <section class="hero">
      <div class="hero-overlay"></div>
      <div class="hero-content">
        <p class="hero-eyebrow">Farm Fresh</p>
        <h1 class="hero-title">Good food,<br><span>Good life</span></h1>
        <p class="hero-sub">Organic fruits, vegetables & more delivered fresh to your door.</p>
        <div class="hero-actions">
          <router-link to="/products" class="btn-primary">Shop Now →</router-link>
          <router-link to="/products" class="btn-outline">Explore Categories</router-link>
        </div>
        <div class="hero-badges">
          <div class="badge-item">
            <span class="badge-icon">🌱</span>
            <div>
              <strong>100% Organic</strong>
              <p>Certified & Natural</p>
            </div>
          </div>
          <div class="badge-item">
            <span class="badge-icon">🚚</span>
            <div>
              <strong>Fast Delivery</strong>
              <p>On-Time, Every Time</p>
            </div>
          </div>
          <div class="badge-item">
            <span class="badge-icon">♻️</span>
            <div>
              <strong>Sustainably Sourced</strong>
              <p>Good for You & Planet</p>
            </div>
          </div>
        </div>
      </div>
      <div class="hero-tag">
        <span>🌿</span>
        <div>
          <strong>Always Fresh</strong>
          <small>GreenBasket</small>
        </div>
      </div>
    </section>

    <!-- CATEGORIES SECTION -->
    <section class="categories">
      <p class="section-eye">SHOP BY CATEGORY</p>
      <h2 class="section-title">Best of Nature, Handpicked for You</h2>

      <div v-if="loading" class="loading">Loading products...</div>

      <div v-else class="product-grid">
        <router-link
          v-for="product in products"
          :key="product.id"
          :to="`/products/${product.id}`"
          class="product-card"
        >
          <div class="product-img-wrap">
            <img
              :src="product.image ? `http://localhost:8000/storage/${product.image}` : require('@/assets/placeholder.svg')"
              :alt="product.name"
            />
          </div>
          <div class="product-info">
            <p class="product-category">{{ product.category?.name || 'Fresh' }}</p>
            <h3 class="product-name">{{ product.name }}</h3>
            <p class="product-price">${{ parseFloat(product.price).toFixed(2) }}</p>
            <span class="product-link">Shop Now →</span>
          </div>
        </router-link>
      </div>
    </section>

    <!-- WHY CHOOSE US SECTION -->
    <section class="why-us">
      <p class="section-eye">OUR VALUES</p>
      <h2 class="why-title">Why Choose Online Shop?</h2>
      <div class="why-grid">
        <div class="why-card">
          <div class="why-icon">🌱</div>
          <h3>100% Organic</h3>
          <p>We source directly from certified organic farms to ensure the highest quality produce.</p>
        </div>
        <div class="why-card">
          <div class="why-icon">🚚</div>
          <h3>Fast Delivery</h3>
          <p>Our packaging is 100% eco-friendly, and we use fast, reliable delivery methods.</p>
        </div>
        <div class="why-card">
          <div class="why-icon">👥</div>
          <h3>Community First</h3>
          <p>We support local farmers and ensure fair trade practices across our entire supply chain.</p>
        </div>
      </div>
    </section>

    <!-- STATS SECTION -->
    <section class="stats">
      <p class="stats-title">Trusted by Thousands of Happy Customers</p>
      <div class="stats-divider">❤️</div>
      <div class="stats-grid">
        <div class="stat-item">
          <span class="stat-icon">👥</span>
          <strong>10K+</strong>
          <p>Happy Customers</p>
        </div>
        <div class="stat-item">
          <span class="stat-icon">🛒</span>
          <strong>500+</strong>
          <p>Organic Products</p>
        </div>
        <div class="stat-item">
          <span class="stat-icon">🌾</span>
          <strong>50+</strong>
          <p>Local Farmers</p>
        </div>
        <div class="stat-item">
          <span class="stat-icon">👍</span>
          <strong>99%</strong>
          <p>Positive Feedback</p>
        </div>
      </div>
    </section>

  </div>
</template>

<script>
import api from '../services/api'

export default {
  data() {
    return {
      products: [],
      loading: true
    }
  },
  async mounted() {
    try {
      const res = await api.get('/products')
      const all = res.data.data || res.data
      this.products = all.slice(0, 10)
    } catch (e) {
      console.error(e)
    } finally {
      this.loading = false
    }
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=Inter:wght@400;500;600&display=swap');

.home {
  font-family: 'Inter', sans-serif;
  color: #1a2e0d;
  background: #f9faf6;
}

/* ── HERO ── */
.hero {
  position: relative;
  display: flex;
  align-items: center;
  width: 100%;
  min-height: calc(98vh - 54px);
  background-color: #f9faf6;
  background-image: url('../assets/hero.png');
  background-size: 100%;
  background-position: center;
  background-repeat: no-repeat;
  box-sizing: border-box;
  overflow: hidden;
  padding: 3rem 5rem;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(
    to right,
    rgba(249,250,246,1.0) 0%,
    rgba(249,250,246,0.95) 40%,
    rgba(249,250,246,0.20) 70%,
    rgba(249,250,246,0.0) 100%
  );
  z-index: 0;
}

.hero-content {
  position: relative;
  z-index: 1;
  max-width: 520px;
}

.hero-eyebrow {
  font-size: 1.1rem;
  font-weight: 700;
  color: #3a7a1a;
  letter-spacing: 0.02em;
  margin-bottom: 0.5rem;
  font-style: italic;
  font-family: 'Playfair Display', serif;
}

.hero-title {
  font-family: 'Playfair Display', serif;
  font-size: 3.8rem;
  font-weight: 800;
  line-height: 1.05;
  color: #1a2e0d;
  margin-bottom: 1rem;
}
.hero-title span { color: #2d6a0f; }

.hero-sub {
  font-size: 0.95rem;
  color: #4a5e3a;
  max-width: 360px;
  line-height: 1.65;
  margin-bottom: 1.75rem;
}

.hero-actions {
  display: flex;
  gap: 0.75rem;
  margin-bottom: 2.5rem;
  flex-wrap: wrap;
}

.btn-primary {
  background: #1e3a0d;
  color: white;
  padding: 0.75rem 1.8rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: background 0.2s;
  border: 2px solid #1e3a0d;
}
.btn-primary:hover { background: #152a08; border-color: #152a08; }

.btn-outline {
  border: 2px solid #8a9a7a;
  color: #2a3a1a;
  padding: 0.75rem 1.8rem;
  border-radius: 50px;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
  background: rgba(255,255,255,0.6);
  transition: all 0.2s;
}
.btn-outline:hover { border-color: #2d6a0f; color: #2d6a0f; background: rgba(255,255,255,0.9); }

.hero-badges {
  display: flex;
  gap: 1.75rem;
  flex-wrap: wrap;
}
.badge-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.8rem;
}
.badge-icon { font-size: 1.3rem; }
.badge-item strong { display: block; font-size: 0.8rem; color: #1a2e0d; font-weight: 700; }
.badge-item p { color: #6a7a5a; margin: 0; font-size: 0.72rem; }

/* Always Fresh tag */
.hero-tag {
  position: absolute;
  bottom: 28px;
  right: 32px;
  z-index: 1;
  background: #1e3a0d;
  color: white;
  padding: 0.7rem 1.1rem;
  border-radius: 14px;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.78rem;
}
.hero-tag span { font-size: 1.2rem; }
.hero-tag strong { display: block; font-size: 0.82rem; font-weight: 700; line-height: 1.2; }
.hero-tag small { font-size: 0.68rem; color: #a8c888; }

/* ── CATEGORIES ── */
.categories {
  padding: 4rem 5rem;
  background: #ffffff;
  text-align: center;
  width: 100%;
  box-sizing: border-box;
}
.section-eye {
  font-size: 0.7rem;
  font-weight: 700;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  color: #5a8a2e;
  margin-bottom: 0.5rem;
}
.section-title {
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  font-weight: 700;
  color: #1a2e0d;
  margin-bottom: 2rem;
}
.loading { color: #5a8a2e; padding: 1rem; }
.product-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 1rem;
}
.product-card {
  text-decoration: none;
  color: inherit;
  background: #f8faf5;
  border-radius: 14px;
  overflow: hidden;
  border: 1px solid #e0ead0;
  transition: transform 0.2s, box-shadow 0.2s;
  text-align: left;
}
.product-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(45,106,15,0.12); }
.product-img-wrap { height: 220px; overflow: hidden; }
.product-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
.product-card:hover .product-img-wrap img { transform: scale(1.05); }
.product-info { padding: 0.75rem; }
.product-category { font-size: 0.68rem; color: #5a8a2e; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.2rem; }
.product-name { font-size: 0.88rem; font-weight: 600; color: #1a2e0d; margin-bottom: 0.3rem; }
.product-price { font-size: 1rem; font-weight: 700; color: #2d6a0f; margin-bottom: 0.4rem; }
.product-link { font-size: 0.75rem; color: #5a8a2e; font-weight: 600; }

/* ── WHY CHOOSE US ── */
.why-us {
  padding: 4rem 5rem;
  background: #f4f7ee;
  text-align: center;
  width: 100%;
  box-sizing: border-box;
}
.why-title {
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  font-weight: 700;
  color: #1a2e0d;
  margin-bottom: 2.5rem;
}
.why-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2rem;
  max-width: 900px;
  margin: 0 auto;
}
.why-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem;
}
.why-icon {
  width: 72px; height: 72px;
  background: #b8f0a0;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.8rem;
  margin-bottom: 0.5rem;
}
.why-card h3 { font-size: 1rem; font-weight: 700; color: #1a2e0d; }
.why-card p { font-size: 0.85rem; color: #5a6a4a; line-height: 1.6; max-width: 260px; text-align: center; }

/* ── STATS ── */
.stats {
  background: #1a2e0d;
  color: white;
  padding: 3rem 5rem;
  text-align: center;
  width: 100%;
  box-sizing: border-box;
}
.stats-title { font-size: 1rem; color: #a8c888; margin-bottom: 0.4rem; }
.stats-divider { font-size: 1rem; margin-bottom: 1.75rem; }
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; max-width: 700px; margin: 0 auto; }
.stat-item { display: flex; flex-direction: column; align-items: center; gap: 0.3rem; }
.stat-icon { font-size: 1.5rem; }
.stat-item strong { font-size: 1.6rem; font-weight: 700; color: white; }
.stat-item p { font-size: 0.8rem; color: #a8c888; margin: 0; }

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
  .hero { padding: 2.5rem 2rem; min-height: 70vh; }
  .hero-overlay { background: linear-gradient(to right, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.85) 50%, rgba(255,255,255,0.2) 100%); }
  .hero-title { font-size: 2.8rem; }
  .product-grid { grid-template-columns: repeat(3, 1fr); }
  .why-grid { grid-template-columns: 1fr; }
  .categories, .why-us, .stats { padding: 2.5rem 2rem; }
}
@media (max-width: 768px) {
  .hero { padding: 2rem 1.25rem; min-height: 80vh; background-position: right center; }
  .hero-overlay { background: linear-gradient(to right, rgba(255,255,255,0.97) 0%, rgba(255,255,255,0.9) 55%, rgba(255,255,255,0.3) 100%); }
  .hero-title { font-size: 2.2rem; }
  .hero-tag { bottom: 16px; right: 16px; }
  .product-grid { grid-template-columns: repeat(2, 1fr); }
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
  .hero-badges { gap: 1rem; }
}
@media (max-width: 480px) {
  .hero { min-height: 85vh; }
  .hero-title { font-size: 1.8rem; }
  .product-grid { grid-template-columns: 1fr; }
  .hero-actions { flex-direction: column; }
  .btn-primary, .btn-outline { text-align: center; justify-content: center; }
}
</style>
