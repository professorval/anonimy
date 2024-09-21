<template>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-2">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Anonimy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" @click="visible=!visible">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse" id="collapsibleNavbar" :class="!visible?'collapse':''" >
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><font-awesome-icon icon="house" /> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <font-awesome-icon icon="user" />
                            Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" @click="logoutNow">
                            <font-awesome-icon icon="power-off" /> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> 
</template>
<script lang="js">
    import router from '../router'

    export default {
        data() {
            return {
                visible: false,
            };
        },
        methods: {
            toggleNavbar() {
                this.visible = !this.visible;
            },
            logoutNow: async function () {
                //-- make axios call to /logout endpoint to clear session and cookies
                await axios.get('/logout')
                    .then(response => {
                        if(response.data.status === true){
                            //-- reload this route
                            router.go()
                        }
                    })
                    .catch(error => {
                        console.log('Error logging out:', error);
                    });
            },
        },
    }

</script>
<style scoped>
    .navbar-collapse {
        transition: all 1s ease-in-out;
    }
    .nav-link{
        padding: 5px;
        border-radius: 5px;
    }
</style>