<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {computed, ref} from "vue";
import NavLink from "@/Components/NavLink.vue";
import IconCounter from "@/Components/IconCounter.vue";
import CatalogMenuModal from "@/Components/Catalog/CatalogMenuModal.vue";
import LanguageSelector from "@/Components/LanguageSelector.vue";
import Link from "@/Components/Link.vue";
import {usePage} from "@inertiajs/vue3";
import { useStore } from 'vuex';

const store = useStore();
const page = usePage()
const showingNavigationDropdown = ref(false);

store.commit('setFavoriteIds', Object.values(page.props.favoriteIds));
const favoriteIds = computed(() => store.state.favoriteIds);


function isActive(path) {
    return route().current() === path || route().current().includes(path);
}

function logout() {
    this.$inertia.delete(route('logout'))
}

</script>

<template>
    <header>
        <nav class="nav bg-dark-site border-b border-header">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex items-center mr-6">
                            <Link :href="route('home')">
                                <ApplicationLogo
                                    class="block h-9 w-auto fill-current text-gray-800"
                                />
                            </Link>
                        </div>
                        <!-- Navigation Links -->
                        <div class="hidden md:flex md:items-center md:gap-6">
                            <NavLink :href="route('home')"
                                     :active="route().current('home')"
                            >
                                {{ __('Main') }}
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden md:flex md:items-center md:ml-6 md:gap-6">
                        <LanguageSelector/>
                        <!-- Settings Dropdown -->
                        <div v-if="$page.props.auth.user" class="ml-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-gray focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">{{ __('Personal office') }}</DropdownLink>
                                    <DropdownLink v-if="$page.props.auth.canAccessAdminPanel" :inertia="false" href="/admin">{{ __('Admin') }}</DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        {{ __('Go out') }}
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                        <template v-else>
                            <NavLink v-if="$page.props.canRegister"
                                     :href="route('register')"
                                     :active="route().current('register')"
                                     class="nav-link nav-link--white">
                                {{ __('Register') }}
                            </NavLink>
                            <NavLink v-if="$page.props.canLogin"
                                     :active="route().current('login')"
                                     :href="route('login')"
                                     class="nav-link nav-link--white">
                                <span
                                    class="mr-1"
                                >{{ __('Sign in') }}
                                    </span>
                                <i class="fa-solid fa-user pt-[0.15em]"></i>
                            </NavLink>
                        </template>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center md:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center p-2 rounded-md text-white focus:outline-none transition duration-150 ease-in-out"
                        >
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path
                                    :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                class="md:hidden"
            >
                <div class="pt-2 pb-3 space-y-1">
                    <ResponsiveNavLink :href="route('home')" :active="route().current('home')">
                        {{ __('Main') }}
                    </ResponsiveNavLink>
                    <ResponsiveNavLink v-if="$page.props.canRegister"
                                       :active="route().current('register')"
                                       :href="route('register')">
                        {{ __('Register') }}
                    </ResponsiveNavLink>
                    <ResponsiveNavLink v-if="$page.props.canLogin"
                                       :active="route().current('login')"
                                       :href="route('login')">
                                <span
                                    class="mr-1"
                                >{{ __('Sign in') }}
                                    </span>
                        <i class="fa-solid fa-user pt-[0.15em]"></i>
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div v-if="$page.props.auth.user" class="pt-4 pb-1 border-t border-gray-800">
                    <div class="px-4">
                        <div class="font-medium text-white">
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="font-medium text-sm text-gray-400">{{ $page.props.auth.user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">{{ __('Personal office') }}</ResponsiveNavLink>
                        <ResponsiveNavLink v-if="$page.props.auth.canAccessAdminPanel" :inertia="false" href="/admin">{{ __('Admin') }}</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                            {{ __('Go out') }}
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Page Heading -->
        <div class="bg-dark-site shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
                <div class="flex items-center justify-center">
                    <CatalogMenuModal/>
                </div>
                <div class="hidden sm:grid sm:grid-cols-3 md:grid-cols-4 sm:gap-2 lg:flex lg:items-center lg:gap-6">
                    <NavLink href="#"><span class="text-white">{{ __('Brands') }}</span></NavLink>
                    <NavLink href="#"><span class="text-white">{{ __('Service') }}</span></NavLink>
                    <NavLink href="#"><span class="text-white">{{ __('Services') }}</span></NavLink>
                    <NavLink href="#"><span class="text-white">{{ __('Support') }}</span></NavLink>
                    <NavLink href="#"><span class="text-white">{{ __('About Company') }}</span></NavLink>
                    <NavLink href="#"><span class="text-white">{{ __('Blog') }}</span></NavLink>
                    <NavLink href="#"><span class="text-white">{{ __('Where to Buy') }}</span></NavLink>
                </div>

                <div class="flex items-center gap-6">
                    <IconCounter :href="route('favorites')" :count="favoriteIds.length">
                        <img src="/img/front/heart.svg" alt="heart">
                    </IconCounter>
                    <IconCounter :count="0" href="#">
                        <img src="/img/front/cart.svg" alt="cart">
                    </IconCounter>
                </div>
                <slot name="header"/>
            </div>
        </div>
    </header>
</template>

<style scoped lang="scss">
@import "./resources/scss/_variables.scss";

.bg-dark-site {
    background: $main-dark;
}

.border-header {
    border-bottom-color: rgba(133, 143, 164, 0.15);
}

.c-text-gray {
    color: $text-gray;
}

.nav-link {
    color: $text-gray;
    text-align: right;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 140%;

    &:hover {
        color: #FFF;
    }

    &--white {
        color: #FFF;
    }
}
</style>
