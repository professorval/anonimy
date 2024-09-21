<script lang="js">
    import isLoggedMixin from '@/helpers/auth';

    export default {
        name: 'Home',
        mixins: [isLoggedMixin],
        created() {
            this.checkIfLogged()
        },
        methods: {
            submit_create_thread_form: async function(data) {

                // Add a new field to the form data object with the CSRF token
                const csrfToken = document.querySelector("meta[name='csrf-token']")?.getAttribute("content");
                if (!csrfToken) throw new Error("CSRF token not found.");

                data['_token'] = csrfToken ;

                try{
                    await axios.post('/api/threads/create', data)
                    .then(function (response) {
                        const data = response.data;
                        console.log(data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
                catch (error) {
                    console.log(error);
                }

            },
        }
    }
</script>

<template>
    <Navbar />
    <div class="container" v-if="user !== null">
        <div class="card border rounded">
            <div class="card-header">
                <h2>Create a thread</h2>
            </div>
            <div class="card-body">

                <Breadcrumbs :data="[{name: 'Create threads', link: '/', linkName: 'Home'}]" />

                <FormKit
                    type="form"
                    submit-label="Create"
                    form-class="mx-auto"
                    :submit-attrs="{
                        inputClass: 'btn btn-primary',
                        outerClass: 'float-end'
                    }"
                    @submit="submit_create_thread_form"
                >

                    <!-- Name -->
                    <FormKit
                        type="text"
                        name="title"
                        label="Thread Title *"
                        placeholder="What would you like to tell me?"
                        validation="required"
                        input-class="form-control"
                        outer-class="mb-3"
                        value="What would you like to tell me"
                    />

                </FormKit>
                

            </div>
        </div>
    </div>
</template>