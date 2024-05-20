import { createStore } from 'vuex';

const store = createStore({
    state() {
        return {
            favoriteIds: [] // Масив ідентифікаторів улюблених товарів
        };
    },
    mutations: {
        setFavoriteIds(state, ids) {
            state.favoriteIds = ids;
        }
        // Інші мутації, які можуть знадобитися
    },
    // Інші параметри стору, які можуть знадобитися
});

export default store;
