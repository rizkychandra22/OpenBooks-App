<script setup>
import AppLayout from '@/Layouts/App.vue'
import { Head, Link, usePage } from '@inertiajs/vue3'
import { computed, defineProps, onMounted } from 'vue'

const page = usePage()
const props = defineProps({
    allBooks: Array 
})

const admin = computed(() => 
    page.props.auth?.user?.role === 'admin'
)
const books = computed(() => props.allBooks || [])

onMounted(() => {
    console.log("Data allBooks Open Library:", props.allBooks)
})
</script>

<template>
    <AppLayout>
        <Head title="Katalog Buku Digital" />

        <div class="hero-section text-center mb-5 py-4">
            <h1 class="display-5 fw-bold text-primary mb-3 text-shadow">Jelajahi Dunia Lewat Kata</h1>
            <p class="text-secondary mx-auto" style="max-width: 600px;">
                Temukan koleksi buku favorit dan terbaik anda dari berbagai genre. Baca kapan saja dan di mana saja dengan mudah.
            </p>
        </div>

        <div class="row g-4">
            <div v-for="book in books" :key="book.id" class="col-md-6 col-lg-3">
                <div class="book-card card h-100 border-0 shadow-lg">
                    <div class="book-cover-wrapper">
                        
                        <!-- COVER -->
                        <img v-if="book.cover_url" 
                            class="card-img-top book-cover"
                            loading="lazy"
                            :src="book.cover_url" 
                            :alt="book.title"
                        >

                        <!-- PLACEHOLDER -->
                        <div v-else class="book-placeholder">
                            <i class="bi bi-book-half"></i>
                        </div>

                        <div class="book-badge">
                            {{ book.category_name }}
                        </div>
                    </div>

                    <div class="card-body bg-white d-flex flex-column p-4">
                        <h5 class="card-title fw-bold mb-1 text-dark">
                            {{ book.title }}
                        </h5>

                        <p class="text-muted small mb-3">
                            <i class="bi bi-person-fill me-1"></i>
                            {{ book.author }}
                        </p>

                        <div v-if="admin" class="mt-auto">
                            <Link :href="route('adminDashboard')" 
                                class="btn btn-sm btn-action-read w-100 rounded-pill fw-bold">
                                Kelola Buku
                            </Link>
                        </div>

                        <div v-else class="mt-auto">
                            <Link :href="route('book.detail', book.external_id)" 
                                class="btn btn-sm btn-action-read w-100 rounded-pill fw-bold">
                                Lihat Detail
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.hero-section h1 {
    letter-spacing: -0.03em;
}

.text-shadow {
    text-shadow: 0 4px 12px rgba(177, 17, 17, 0.5);
}

/* Kartu dengan warna cerah dan bayangan lembut */
.book-card {
    transition: all 0.5s ease;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    background: #ffffff;
}

.book-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
}

.book-cover-wrapper {
    position: relative;
    height: 280px;
    overflow: hidden;
}

.book-cover {
    width: 100%;
    height: 100%;
    object-fit: none;
    transition: transform 0.6s ease;
}

.book-card:hover .book-cover {
    transform: scale(1.1);
}

/* Placeholder dengan gradasi cerah */
.book-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    color: #cbd5e1;
    font-size: 5rem;
}

.book-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(20, 184, 166, 0.9); /* Teal cerah */
    backdrop-filter: blur(4px);
    color: #ffffff;
    padding: 6px 14px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 800;
    text-transform: uppercase;
    box-shadow: 0 4px 10px rgba(20, 184, 166, 0.3);
}

/* Tombol tetap dengan aksen gelap agar kontras di atas kartu putih */
.btn-action-read {
    background: #0f172a;
    border: none;
    color: #ffffff;
    padding: 10px;
    transition: all 0.3s ease;
}

.btn-action-read:hover {
    background: #14b8a6;
    color: #ffffff;
    box-shadow: 0 5px 15px rgba(20, 184, 166, 0.4);
}

.text-dark {
    color: #1e293b !important;
}

.text-muted {
    color: #64748b !important;
}
</style>