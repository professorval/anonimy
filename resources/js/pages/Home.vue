<script lang="js">
    import isLoggedMixin from '../helpers/auth';

    export default {
        name: 'Home',
        mixins: [isLoggedMixin],
        created() {
            this.checkIfLogged()
        },
    }
</script>

<template>
    <div class="container">
        <div class="card border rounded">
            <div class="card-body">
                
                <div v-if="user !== null">
                    <HomeLoggedIn :user="this.user" />
                </div>

                <div v-else>
                    <HomeLoggedOut />
                </div>

                <Footer />
                
            </div>
        </div>
    </div>
</template>