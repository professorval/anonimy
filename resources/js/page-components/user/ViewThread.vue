<template>
    <Navbar />
    <div class="card my-2">
        <div class="card-body">
            <Breadcrumbs :data="[{name: 'View thread', link: '/threads/view', linkName: 'Threads'}]" />

            <div class="card-text">
                <h3>{{ this.thread.title }}</h3>

                <div v-if="owner === true" class="row">
                    <div v-if="messages && messages.length > 0" class="row">
                        <small><i>You created this thread on: {{ this.format_date(this.thread.created_at) }}</i></small>
                        <div v-for="(message, index) in messages" :key="index">
                            <MessageCard :data="message" />
                        </div>

                        <div>
                            <small>Thread Actions:</small>
                            <hr class="my-0">
                            <small>
                                <span title="Delete" @click="thread_delete(data.slug)" class="btn btn-sm text-danger"><font-awesome-icon icon="square-xmark" /> Delete this thread</span> | 
                                <span title="Disable comments" class="btn btn-sm">Disable comments</span>
                            </small>
                        </div>
                    </div>
                    <div v-else>
                        <hr>
                        <p class="text-muted"><i>No messages yet. Share the thread with people to get started.</i></p>
                        <button @click="shareThread" class="btn btn-primary btn-sm">Share Thread</button>
                    </div>
                </div>

                <div v-else>
                    <small>Created by {{ this.thread.user_name }} on {{ this.format_date(this.thread.created_at) }} </small>
                    <hr>

                    <!-- Reply this thread -->
                    <div class="mt-2">
                        <FormKit
                            type="form"
                            submit-label="Submit"
                            form-class="mx-auto"
                            :submit-attrs="{
                                inputClass: 'btn btn-primary',
                                outerClass: 'float-end'
                            }"
                            @submit="submit_thread_reply"
                            id="reply-form"
                            ref="replyForm"
                            >
                            <FormKit
                                type="textarea"
                                name="content"
                                :label=this.reply_label
                                placeholder="Your message here..."
                                validation="required"
                                input-class="form-control"
                                outer-class="mb-3"
                                v-model="formData.content"
                            />
                        </FormKit>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script lang="js">
    import { ref } from 'vue';
    import router from '@/router'
    import isLoggedMixin from '@/helpers/auth';
    import format_date from '@/helpers/functions';

    export default {
        name: 'Home',
        mixins: [isLoggedMixin],
        data(){
            return {
                thread: {
                    title: null
                },
                owner: false,
                messages: {},
                reply_label: '',
                formData: {
                    content: ''
                }
            }
        },
        created() {
            this.checkIfLogged()
            this.get_thread(this.$route.params.slug)
        },
        methods: {
            get_thread: async function(slug) {
                const csrfToken = document.querySelector("meta[name='csrf-token']")?.getAttribute("content");
                if (!csrfToken) throw new Error("CSRF token not found.");

                let data = {
                    '_token': csrfToken,
                    'slug': slug
                }

                try{
                    await axios.post('/api/threads/get', data)
                    .then((response) => {

                        if(response.data.status === true){
                            this.thread = response.data.data.thread
                            this.messages = response.data.data.messages

                            if(response.data.owner === true){
                                this.owner = true
                            }

                            this.reply_label = 'Reply to ' + this.thread.user_name + ':'
                            console.log(response.data);
                        }
                        else{
                            swal({
                                title: "Error",
                                text: response.data.message,
                                icon: "error",
                            }).then(() => {
                                router.push('/');
                            });
                        }

                    })
                }catch (error){
                    console.log(error);
                }

            },
            submit_thread_reply: async function(data) {

                //-- get the content of meta name="csrf-token"
                const token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

                //-- add a new field to the form data object with the csrf token
                data['_token'] = token;
                data['slug'] = this.$route.params.slug;

                axios.post('/api/messages/create', data)
                .then((response) => {
                    const data = response.data;

                    if(data.status === true) {
                        swal({
                            title: "Success",
                            text: data.message,
                            icon: "success",
                        })

                        //-- reset form
                        this.resetForm();

                    }
                    else{
                        //-- get the first error message from the array of errors
                        let first_error = Object.values(data.errors)[0][0];

                        swal({
                            title: "Error",
                            text: first_error,
                            icon: "error",
                        });
                    }

                });
                
            },
            resetForm() {
                if (this.$refs.replyForm) {
                    this.$refs.replyForm.reset();
                } else {
                    console.error("Form reference is not defined.");
                }
            },
            ...format_date
        }
    }
</script>