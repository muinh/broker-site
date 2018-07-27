export default {
    loadingOff(state) {
        state.loading = false;
    },
    loadingOn(state) {
        state.loading = true;
    },
    setAuthenticated(state, payload) {
        state.authenticated = payload;
    },
    setUser(state, payload) {
        state.user = payload;
    },
    setCountries(state, payload) {
        state.countries = payload;
    }
}
