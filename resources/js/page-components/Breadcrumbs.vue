<template>
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <RouterLink :to="data[0].link">{{ data[0].linkName }}</RouterLink>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ data[0].name }}</li>
        </ol>
    </nav>
</template>
<script lang="js">
    export default {
        name: 'Breadcrumbs',
        props: {
            data: Array
        }
    }
</script>