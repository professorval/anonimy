<template>
    <div class="card my-2">
        <div class="card-body">
            <p><small><i>On {{ this.format_date(data.created_at) }}, someone said:</i></small></p>
            <p class="py-0 my-0">{{ this.data.content }}</p>
        </div>
    </div>
</template>
<script lang="js">
    import format_date from '@/helpers/functions';
    export default {
        name: 'MessageCard',
        props: {
            data: Array
        },
        methods: {
            ...format_date,
        }
    }
</script>