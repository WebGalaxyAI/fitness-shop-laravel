import { createStore } from 'vuex';

const store = createStore({
    state() {
        return {
            favoriteIds: [],
            cartItems: [],
        };
    },
    mutations: {
        setFavoriteIds(state, ids) {
            state.favoriteIds = ids;
        },
        setCartItems(state, items) {
            state.cartItems = Array.isArray(items) ? items : [];
        },
    },
    getters: {
        cartCount: (state) => state.cartItems.reduce((sum, i) => sum + (i.quantity || 0), 0),
        cartProductIds: (state) => state.cartItems.map((i) => i.id),
    },
});

export default store;
