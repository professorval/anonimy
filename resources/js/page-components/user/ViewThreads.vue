<template>
    <Navbar />
    <div class="container">
        <div class="card border rounded">
            <div class="card-header">
                <h2>Your threads</h2>
            </div>
            <div class="card-body">

                <Breadcrumbs :data="[{name: 'My threads', link: '/', linkName: 'Home'}]" />
                
                <div id="threads_container"></div>

                <div v-if="isLoggedIn">
                    <div v-if="threads && threads.length > 0" class="row">
                        <div v-for="(thread, index) in threads" :key="index">
                            <ThreadCard :data="thread" />
                        </div>
                    </div>
                    <div v-else class="alert alert-danger">You have no threads yet.</div>
                </div>
                <div v-else class="alert alert-danger">You're not logged in. <RouterLink to="/login">Please login</RouterLink>.</div>

            </div>
        </div>
    </div>
</template>
<script lang="js">
    import isLoggedMixin from '@/helpers/auth';
    import router from '@/router'

    export default {
        name: 'Home',
        mixins: [isLoggedMixin],
        data(){
            return {
                threads: null,
            }
        },
        created() {
            this.checkIfLogged()
            this.get_threads()
        },
        methods: {
            get_threads: async function() {
                // Add a new field to the form data object with the CSRF token
                const csrfToken = document.querySelector("meta[name='csrf-token']")?.getAttribute("content");
                if (!csrfToken) throw new Error("CSRF token not found.");

                const data = []
                data['_token'] = csrfToken ;

                //if(this.isLoggedIn){
                    try{
                        await axios.post('/api/threads/view', data)
                        .then((response) => {
                            const threads = response.data.data;

                            if(response.data.status === true ){
                                this.threads = threads;
                            }
                            else{
                                swal({
                                    title: "Error",
                                    text: "Unable to load your threads!",
                                    icon: "error"
                                })
                            }
                            
                        })
                        .catch((error) => {
                            swal({
                                title: "Error",
                                text: error.message,
                                icon: "error"
                            })
                        });
                    }
                    catch (error) {
                        console.log(error);
                    }
                //}
            }
        }
    }
</script>