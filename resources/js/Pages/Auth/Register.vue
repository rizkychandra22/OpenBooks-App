<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)

const form = useForm({
  name: '',
  username: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form.clearErrors()
  form.post(route('register.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  })
}
</script>

<template>
  <Head title="Register - E-Book App" />

  <section class="login-wrap py-5">
    <div class="container">
      <div class="row justify-content-center align-items-center g-4">
        <div class="col-lg-5 d-none d-lg-block">
          <div class="login-promo modern-surface p-4 p-xl-5">
            <div class="badge text-bg-light fw-semibold mb-3">Create Member Account</div>
            <h1 class="modern-title h2 mb-3">Buat akun dan mulai gunakan perpustakaan digital.</h1>
            <p class="modern-subtitle mb-4">
              Setelah daftar, akun otomatis menjadi member dan bisa langsung login untuk meminjam buku.
            </p>
            <div class="promo-points">
              <div><i class="bi bi-check-circle-fill"></i> Akses katalog buku</div>
              <div><i class="bi bi-check-circle-fill"></i> Tambah buku ke wishlist</div>
              <div><i class="bi bi-check-circle-fill"></i> Kelola riwayat peminjaman</div>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-8 col-lg-5">
          <div class="modern-surface login-card p-4 p-md-5">
            <div class="text-center mb-4">
              <div class="logo-badge mx-auto mb-3">
                <i class="bi bi-person-plus-fill"></i>
              </div>
              <h2 class="modern-title h4 mb-1">Create account</h2>
              <p class="modern-subtitle mb-0">Daftarkan akun member baru</p>
            </div>

            <form @submit.prevent="submit">
              <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="form-control modern-input"
                  :class="{ 'is-invalid': form.errors.name }"
                  placeholder="Masukkan nama lengkap"
                >
                <div class="invalid-feedback">{{ form.errors.name }}</div>
              </div>

              <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input
                  id="username"
                  v-model="form.username"
                  type="text"
                  class="form-control modern-input"
                  :class="{ 'is-invalid': form.errors.username }"
                  placeholder="Masukkan username"
                >
                <div class="invalid-feedback">{{ form.errors.username }}</div>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  class="form-control modern-input"
                  :class="{ 'is-invalid': form.errors.email }"
                  placeholder="Masukkan email"
                >
                <div class="invalid-feedback">{{ form.errors.email }}</div>
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
                    placeholder="Minimal 8 karakter"
                  >
                  <button type="button" class="btn btn-outline-secondary password-toggle" @click="showPassword = !showPassword">
                    <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'" />
                  </button>
                </div>
                <div class="invalid-feedback d-block">{{ form.errors.password }}</div>
              </div>

              <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                <div class="input-group">
                  <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    :type="showPasswordConfirmation ? 'text' : 'password'"
                    class="form-control modern-input"
                    :class="{ 'is-invalid': form.errors.password_confirmation }"
                    placeholder="Ulangi password"
                  >
                  <button type="button" class="btn btn-outline-secondary password-toggle" @click="showPasswordConfirmation = !showPasswordConfirmation">
                    <i :class="showPasswordConfirmation ? 'bi bi-eye-slash' : 'bi bi-eye'" />
                  </button>
                </div>
                <div class="invalid-feedback d-block">{{ form.errors.password_confirmation }}</div>
              </div>

              <button type="submit" class="btn login-btn w-100" :disabled="form.processing">
                <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                <i class="bi bi-person-plus-fill me-1"></i> Daftar
              </button>

              <p class="text-center small text-muted mt-3 mb-0">
                Sudah punya akun?
                <Link :href="route('login')" class="fw-semibold text-decoration-none">Masuk sekarang</Link>
              </p>
            </form>
          </div>
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
  background: linear-gradient(135deg, #0f766e, #0b5b55);
}

.modern-input {
  min-height: 46px;
  border-radius: 12px;
  border: 1px solid #d9e2ec;
}

.modern-input:focus {
  box-shadow: 0 0 0 0.2rem rgba(15, 118, 110, 0.15);
  border-color: #0f766e;
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
  background: linear-gradient(135deg, #0f766e, #0b5b55);
}

.login-btn:hover {
  color: #fff;
  background: linear-gradient(135deg, #219188, #0f988f);
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
  color: #0f766e;
  margin-right: 0.55rem;
}
</style>
