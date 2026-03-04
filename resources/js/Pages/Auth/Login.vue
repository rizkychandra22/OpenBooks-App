<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const showPassword = ref(false)

const form = useForm({
    login: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.clearErrors()

    if (!form.login) {
        form.setError('login', 'Username atau Email wajib diisi.')
    }
    if (!form.password) {
        form.setError('password', 'Password wajib diisi.')
    }

    if (form.login && form.password) {
        form.post('/login', {
            onFinish: () => form.reset('password'),
        })
    }
}

watch(() => form.login, () => {
    if (form.errors.loginError) form.clearErrors('loginError')
    if (form.errors.loginAkses) form.clearErrors('loginAkses')
})
</script>

<template>
    <Head title="Login - E-Book App" />

    <section class="login-wrap py-5">
        <div class="container">
            <div class="row justify-content-center align-items-center g-4">
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="login-promo modern-surface p-4 p-xl-5">
                        <div class="badge text-bg-light fw-semibold mb-3">Library Management</div>
                        <h1 class="modern-title h2 mb-3">Kelola koleksi buku lebih cepat dan rapi.</h1>
                        <p class="modern-subtitle mb-4">
                            Dashboard terpusat untuk buku, kategori, user, dan peminjaman dalam satu alur kerja.
                        </p>
                        <div class="promo-points">
                            <div><i class="bi bi-check-circle-fill"></i> CRUD terintegrasi di dashboard</div>
                            <div><i class="bi bi-check-circle-fill"></i> Peminjaman real-time</div>
                            <div><i class="bi bi-check-circle-fill"></i> Tampilan responsif modern</div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8 col-lg-5">
                    <div class="modern-surface login-card p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="logo-badge mx-auto mb-3">
                                <i class="bi bi-book-half"></i>
                            </div>
                            <h2 class="modern-title h4 mb-1">Welcome back</h2>
                            <p class="modern-subtitle mb-0">Masuk ke akun E-Book App</p>
                        </div>

                        <div v-if="$page.props.errors.loginAkses" class="alert alert-danger py-2 px-3 small mb-3">
                            {{ $page.props.errors.loginAkses }}
                        </div>
                        <div v-if="$page.props.flash?.message" class="alert alert-success py-2 px-3 small mb-3">
                            {{ $page.props.flash.message }}
                        </div>
                        <div v-if="form.errors.loginError" class="alert alert-danger py-2 px-3 small mb-3">
                            {{ form.errors.loginError }}
                        </div>

                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label for="login" class="form-label fw-semibold">Username / Email</label>
                                <input
                                    id="login"
                                    v-model="form.login"
                                    type="text"
                                    class="form-control modern-input"
                                    :class="{ 'is-invalid': form.errors.login }"
                                    placeholder="contoh: admin@example.com"
                                >
                                <div class="invalid-feedback">{{ form.errors.login }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <input
                                        id="password"
                                        v-model="form.password"
                                        :type="showPassword ? 'text' : 'password'"
                                        class="form-control modern-input"
                                        :class="{ 'is-invalid': form.errors.password }"
                                        placeholder="Masukkan password"
                                    >
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary password-toggle"
                                        @click="showPassword = !showPassword"
                                    >
                                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'" />
                                    </button>
                                </div>
                                <div class="invalid-feedback d-block">{{ form.errors.password }}</div>
                            </div>

                            <div class="mb-4 form-check">
                                <input id="remember" v-model="form.remember" type="checkbox" class="form-check-input">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>

                            <button type="submit" class="btn login-btn w-100" :disabled="form.processing">
                                <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                            </button>

                            <div class="d-flex align-items-center my-2">
                                <hr class="flex-grow-1 text-muted opacity-25">
                                <span class="mx-3 text-muted x-small fw-bold">ATAU</span>
                                <hr class="flex-grow-1 text-muted opacity-25">
                            </div>

                            <Link :href="route('homepage')" class="btn btn-info w-100 modern-input d-flex align-items-center justify-content-center">
                                <i class="bi bi-collection-play-fill me-2"></i> Lihat Katalog Buku
                            </Link>

                            <p class="text-center small text-muted mt-4 mb-0">
                                Belum punya akun?
                                <Link :href="route('register')" class="fw-semibold text-decoration-none text-primary">Daftar sekarang</Link>
                            </p>
                        </form>
                    </div>

                    <p class="text-center text-muted small mt-3 mb-0">
                        &copy; {{ new Date().getFullYear() }} Open Books Library System
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.login-wrap {
    min-height: 100vh;
    display: flex;
    align-items: center;
}

.login-card {
    border-radius: 24px;
}

.logo-badge {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.4rem;
    background: linear-gradient(135deg, #1e3a8a, #1e40af);
}

.modern-input {
    min-height: 46px;
    border-radius: 12px;
    border: 1px solid #d9e2ec;
}

.modern-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.15);
    border-color: #1e3a8a;
}

.password-toggle {
    border-radius: 0 12px 12px 0;
}

.login-btn {
    min-height: 46px;
    border: 0;
    border-radius: 12px;
    color: #fff;
    font-weight: 700;
    background: linear-gradient(135deg, #1e3a8a, #1e40af);
}

.login-btn:hover {
    color: #fff;
    background: linear-gradient(135deg, #2e54be, #144be3);
}

.login-promo {
    border-radius: 24px;
}

.promo-points {
    display: grid;
    gap: 0.85rem;
    color: #334155;
    font-weight: 500;
}

.promo-points i {
    color: #1e3a8a;
    margin-right: 0.55rem;
}
</style>
