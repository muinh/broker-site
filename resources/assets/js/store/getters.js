export default {
    getUser(state) {
        let user = Object.assign({}, state.user);
        let autoFill = {
            email: user.email,
            first_name: user.FirstName,
            last_name: user.LastName,
            phone: user.phone,
            currency: user.currency,
            country: user.country,
            state: null,
            city: null,
            address1: null,
            zip_code: null,
        };
        return Object.assign({}, autoFill);
    }
}