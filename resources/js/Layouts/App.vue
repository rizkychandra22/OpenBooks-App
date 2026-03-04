<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user)
const role = computed(() => user.value?.role)

const isActive = (routeName) => {
    return route().current(routeName)
}
</script>

<template>
    <div class="app-shell">
        <nav class="navbar navbar-expand-lg app-navbar fixed-top">
            <div class="container py-2">
                <Link class="navbar-brand fw-bold app-brand" :href="route('homepage')">
                    <span class="brand-icon"><i class="bi bi-book-half"></i></span>
                    <span>OpenBooks</span>
                </Link>
                
                <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <i class="bi bi-list"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-3 mb-lg-0 ms-lg-4">
                        <li class="nav-item">
                            <Link class="nav-link app-link" :href="route('homepage')" :class="{ 'active': isActive('homepage') }">
                                <i class="bi bi-collection-play-fill me-1"></i> Katalog
                            </Link>
                        </li>

                        <template v-if="user">
                            <li class="nav-item">
                                <Link class="nav-link app-link" :href="route(role === 'admin' ? 'adminDashboard' : 'userDashboard')" :class="{ 'active': isActive('adminDashboard') || isActive('userDashboard') }">
                                    <i class="bi bi-speedometer2 me-1"></i> Dashboard
                                </Link>
                            </li>
                        </template>

                        <template v-if="role === 'admin'">
                            <li class="nav-item border-start ms-lg-2 ps-lg-3 d-none d-lg-block"></li>
                        </template>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <template v-if="user">
                            <span class="user-chip d-md-inline-flex">
                                <i v-if="user.role === 'admin'" class="bi bi-gem me-2 text-warning"></i>
                                <i v-else class="bi bi-person-circle me-2"></i>
                                <strong>{{ user.name }}</strong>
                            </span>
                            <Link :href="route('logout')" method="post" as="button" class="btn btn-sm app-link text-white app-btn user-chip me-2">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </Link>
                        </template>
                        <template v-else>
                            <span class="user-chip d-md-inline-flex px-3 me-2">
                                <i class="bi bi-people-fill text-white"></i>
                            </span>
                            <Link :href="route('login')" class="btn btn-sm app-link app-btn user-chip text-white px-3 me-2">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                            </Link>
                            <Link :href="route('register')" class="btn btn-sm app-link app-btn user-chip text-white px-3">
                                <i class="bi bi-person-plus me-1"></i> Daftar
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container app-main">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.app-shell { min-height: 100vh; }
.app-navbar { background: rgba(9, 20, 34, 0.86); backdrop-filter: blur(14px); border-bottom: 1px solid rgba(148, 163, 184, 0.22); }
.app-brand { color: #fff; display: inline-flex; align-items: center; gap: 10px; }
.brand-icon { width: 36px; height: 36px; border-radius: 11px; display: inline-flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0f766e, #0b5b55); color: #fff; }
.app-link { color: rgba(241, 245, 249, 0.86); font-weight: 600; }
.app-link:hover, .app-link.active { color: #5eead4 !important; }
.admin-link { color: #fb923c !important; }
.user-chip { border: 1px solid rgba(148, 163, 184, 0.4); background: rgba(15, 23, 42, 0.5); color: #e2e8f0; border-radius: 999px; padding: 0.4rem 0.8rem; font-size: 0.85rem; }
.app-btn { border-radius: 999px; border: 1px solid rgba(148, 163, 184, 0.45); color: #e2e8f0; background: rgba(15, 23, 42, 0.5); }
.app-main { padding-top: 100px; padding-bottom: 26px; }
</style>