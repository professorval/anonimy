<template>
    <div class="card my-2">
        <div class="card-body">
            <h5 class="card-title">
                <RouterLink :to="format_slug(data.slug)">{{ data.title }}</RouterLink>
            </h5>
            <div class="card-text">
                <p><small><i>Created on: {{ this.format_date(data.created_at) }}</i></small></p>
                <p class="float-end mb-0">
                    <span title="Share" @click="thread_share(data.slug)" class="btn mx-0"><font-awesome-icon icon="share-from-square" /></span>
                    <span title="Delete" @click="thread_delete(data.slug)" class="btn text-danger"><font-awesome-icon icon="square-xmark" /></span>
                </p>
            </div>
        </div>
    </div>
</template>
<script lang="js">
    export default {
        name: 'ThreadCard',
        props: {
            data: Array
        },
        methods: {
            format_date(date) {
                return new Date(date).toLocaleDateString() + ' at ' + new Date(date).toLocaleTimeString()
            },
            format_slug(slug) {
                return '/thread/'+ slug;
            },
            thread_share(slug) {
                let full_slug = import.meta.env.VITE_APP_URL + 'thread/'+ slug;

                console.log(full_slug)

                // copy to clipboard
                navigator.clipboard.writeText(full_slug).then(() => {
                    swal({
                        title: "Link copied to clipboard!",
                        icon: "success",
                    })
                }, () => {
                    alert('Failed to copy text');
                });
            },
            thread_delete: async function (slug) {
                console.log(slug);
            }
        }
    }
</script>