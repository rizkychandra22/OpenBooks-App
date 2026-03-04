<script setup>
import AppLayout from '@/Layouts/App.vue'
import { Head, Link } from '@inertiajs/vue3'
import { defineProps, computed, onMounted } from 'vue'

const props = defineProps({
    book: Object
})

const cleanDescription = computed(() => {
    if (!props.book.description) return 'Tidak ada deskripsi tersedia.';
    return props.book.description.replace(/(\r\n|\n|\r){3,}/g, '\n\n').trim();
})

onMounted(() => {
    console.log("Detail Book Open Library:", props.book)
})
</script>

<template>
    <AppLayout>
        <Head :title="'Detail - ' + book.title" />

        <div class="hero-section text-center py-4">
            <h1 class="display-5 fw-bold text-primary mb-2 text-shadow">Detail Koleksi Digital</h1>
            <p class="text-secondary mx-auto mb-0" style="max-width: 600px;">
                Baca sinopsis lengkap dan informasi detail mengenai buku pilihan Anda.
            </p>
        </div>

        <div class="container pb-5">
            <Link :href="route('homepage')" class="btn btn-action-read rounded-pill px-4 py-1 mb-4 fw-bold shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Katalog
            </Link>

            <div class="row g-4">
                <div class="col-lg-3 col-md-5">
                    <div class="book-card card border-0 shadow-lg">
                        <div class="book-cover-wrapper">
                            <img v-if="book.cover_url" 
                                class="card-img-top book-cover" 
                                :src="book.cover_url" 
                                :alt="book.title"
                            >
                            <div v-else class="book-placeholder">
                                <i class="bi bi-book-half"></i>
                            </div>
                        </div>

                        <div class="card-body bg-white p-4">
                            <h5 class="card-title fw-bold mb-2 text-dark" style="line-height: 1.4;">{{ book.title }}</h5>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-person-circle me-1"></i> {{ book.author }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-7">
                    <div class="book-card card border-0 shadow-lg h-100 p-1">
                        <div class="card-body bg-white p-4 p-md-5">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
                                <h2 class="fw-bold text-danger m-0" style="line-height: 1.2;">
                                    {{ book.title }}
                                </h2>

                                <a :href="`https://openlibrary.org/works/${book.external_id}`" target="_blank"
                                    class="btn btn-action-read rounded-pill px-4 py-1 fw-bold shadow-sm flex-shrink-0">
                                    <i class="bi bi-book-half me-2"></i> Mulai Membaca
                                </a>
                            </div>
                            
                            <div class="category-section mb-5 mt-2 border-top border-bottom py-4 bg-light-subtle rounded-3 px-3">
                                <small class="text-muted d-block fw-bold text-uppercase mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">
                                    Kategori / Tags
                                </small>
                                <div class="d-flex flex-wrap gap-2">
                                    <span v-for="tag in book.category_name.split(', ')" :key="tag" 
                                        class="badge bg-white text-secondary border rounded-pill px-3 py-2 shadow-sm text-start" 
                                        style="font-size: 0.75rem; font-weight: 600; white-space: normal; word-break: break-word; max-width: 100%;">
                                        {{ tag }}
                                    </span>
                                </div>
                            </div>

                            <div class="synopsis-section">
                                <h5 class="fw-bold text-dark mb-3">
                                    <i class="bi bi-card-text me-2 text-primary"></i>Sinopsis & Deskripsi
                                </h5>
                                <div class="description-text text-secondary mb-5">
                                    {{ cleanDescription }}
                                </div>
                            </div>

                            <div class="mt-auto d-flex flex-row align-items-center flex-wrap gap-4 gap-md-5 pt-4 border-top">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box bg-info-subtle p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-hash text-info fs-5"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.6rem;">Katalog ID</small>
                                        <span class="text-dark fw-bold small">#{{ book.external_id }}</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box bg-success-subtle p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.6rem;">Status</small>
                                        <span class="text-dark fw-bold small">Tersedia Digital</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box bg-primary-subtle p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-translate text-primary fs-5"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.6rem;">Bahasa</small>
                                        <span class="text-dark fw-bold small">Indonesia (ID)</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box bg-warning-subtle p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-upc-scan text-warning fs-5"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 0.6rem;">No. ISBN</small>
                                        <span class="text-dark fw-bold small">{{ book.isbn }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.hero-section h1 { letter-spacing: -0.03em; }
.text-shadow { text-shadow: 0 4px 12px rgba(177, 17, 17, 0.3); }

.book-card {
    border-radius: 24px;
    overflow: hidden;
    background: #ffffff;
    transition: transform 0.3s ease;
}

.book-cover-wrapper {
    position: relative;
    height: 400px; /* Sedikit lebih tinggi untuk detail agar cover lebih jelas */
    overflow: hidden;
}

.book-cover {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.book-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: #f8fafc; color: #cbd5e1; font-size: 5rem;
}

.description-text {
    font-size: 1.05rem;
    text-align: justify;
    line-height: 1.6;
    white-space: pre-line;
    color: #475569 !important;
}

.btn-action-read {
    background: #0f172a;
    border: none;
    color: #ffffff;
    transition: all 0.3s ease;
}

.btn-action-read:hover {
    background: #14b8a6;
    transform: translateX(-5px);
    box-shadow: 0 5px 15px rgba(20, 184, 166, 0.4);
}

/* Responsif Adjustments */
@media (max-width: 768px) {
    .book-cover-wrapper { height: 300px; }
    .card-body { padding: 1.5rem !important; }
}
</style>