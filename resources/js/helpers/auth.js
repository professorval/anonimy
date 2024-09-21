import axios from 'axios';

const isLoggedMixin = {
    data() {
        return {
            user: null,
            isLoggedIn: false,
        };
    },
    methods: {
        checkIfLogged: async function () {
            try {
                // Add a new field to the form data object with the CSRF token
                const csrfToken = document.querySelector("meta[name='csrf-token']")?.getAttribute("content");
                if (!csrfToken) throw new Error("CSRF token not found.");

                const data = { _token: csrfToken };

                const response = await axios.post(import.meta.env.VITE_APP_URL+'api/auth/sessionStatus', data);
                console.log('Call complete: ', response.data);

                if (response.data.status === true) {
                    this.user = response.data.user;
                    this.isLoggedIn = true;
                } 
                else {
                    this.user = null;
                    this.isLoggedIn = false;
                    console.log('NOT Logged in!');
                }
            } catch (error) {
                console.error('Error checking login status:', error);
                this.isLoggedIn = false;
            }
        },
    }
};

export default isLoggedMixin;