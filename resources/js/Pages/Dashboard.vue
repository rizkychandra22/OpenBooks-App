<script setup>
import { Head, usePage, Link } from '@inertiajs/vue3'
import App from '../Layouts/App.vue'
import { computed } from 'vue'

defineOptions({ layout: App })

// Props tetap ada untuk menerima data dari Controller
const props = defineProps({
    stats: { type: Object, default: () => ({}) },
    myLoans: { type: Array, default: () => [] },
    loans: { type: Array, default: () => [] },
})

const page = usePage()
const user = computed(() => page.props.auth.user)
const role = computed(() => user.value?.role)
</script>

<template>
    <Head title="Dashboard - Openov" />

    <section class="mb-4">
        <div class="hero-banner modern-surface p-4 p-lg-5">
            <h1 class="modern-title h3 mb-2">Halo, {{ user?.name }}.</h1>
            <p class="modern-subtitle mb-0">
                {{ role === 'admin' ? 'Silakan mulai kelola data buku dan member anda.' : 'Jelajahi katalog dan mulai bangun koleksi bukumu.' }}
            </p>
        </div>
    </section>

    <section class="row g-3 mb-4">
        <template v-if="role === 'admin'">
            <div class="col-sm-6 col-md-3">
                <div class="stats-card stats-1">
                    <small>Total Buku</small>
                    <h3>{{ stats?.total_books || 0 }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="stats-card stats-2">
                    <small>Total Member</small>
                    <h3>{{ stats?.total_users || 0 }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="stats-card stats-3">
                    <small>Akses Baca</small>
                    <h3>{{ stats?.total_loans || 0 }}</h3>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="stats-card stats-4">
                    <small>Kategori</small>
                    <h3>{{ stats?.total_categories || 0 }}</h3>
                </div>
            </div>
        </template>

        <template v-else>
            <div class="col-sm-6">
                <div class="stats-card stats-1">
                    <small>Sedang Dibaca</small>
                    <h3>{{ stats?.my_borrowed || 0 }}</h3>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="stats-card stats-2">
                    <small>Koleksi Saya</small>
                    <h3>{{ stats?.my_wishlist || 0 }}</h3>
                </div>
            </div>
        </template>
    </section>

    <section class="modern-surface p-5 text-center">
        <div class="opacity-60">
            <i class="bi bi-database-exclamation fs-1 d-block mb-3"></i>
            <h5 class="fw-bold">Belum Ada Aktivitas</h5>
            <p class="small">
                {{ role === 'admin' ? 'Data akses baca akan muncul di sini setelah member mulai berinteraksi dengan katalog.' : 'Koleksi buku Anda akan muncul di sini setelah Anda menambahkan buku ke koleksi.' }}
            </p>
            <Link :href="route('homepage')" class="btn btn-sm btn-modern-primary mt-2">
                Buka Katalog
            </Link>
        </div>
    </section>
</template>

<style scoped>
.hero-banner {
    border-radius: 24px;
    position: relative;
    overflow: hidden;
    background: #fff;
}
.hero-banner::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, rgba(15, 118, 110, 0.08), rgba(249, 115, 22, 0.05));
    pointer-events: none;
}
.modern-surface {
    background: #fff;
    border: 1px solid #ff00ff;
    border-radius: 20px;
}
.stats-card {
    border-radius: 16px;
    padding: 1rem 1.1rem;
    color: #fff;
    min-height: 104px;
}
.stats-card small {
    display: block;
    opacity: 0.86;
}
.stats-card h3 {
    font-weight: 800;
    margin: 0.2rem 0 0;
}
.stats-1 { background: linear-gradient(135deg, #0db66f, #08b66d); }
.stats-2 { background: linear-gradient(135deg, #dba000, #bd8b00); }
.stats-3 { background: linear-gradient(135deg, #ea580c, #c2410c); }
.stats-4 { background: linear-gradient(135deg, #2563eb, #1d4ed8); }

.btn-modern-primary {
    background: #0f766e;
    color: #fff;
    border: 1px solid #0f766e;
    border-radius: 8px;
    padding: 0.5rem 1.25rem;
}
.btn-modern-primary:hover {
    background: #0b5b55;
    color: #fff;
}
</style>