<script lang="js">
    export default {
        name: 'HomeLoggedIn',
        props: {
            user: {
                type: Object,
                required: true
            }
        }
    }
</script>

<template>
    <Navbar />
    <div class="container">
        <div class="card border rounded">
            <div class="card-body">
                <h1 class="text-center">Welcome, {{user.name}}!</h1>
                <p>Create a thread, share the link and start recievening anonymous messages now!</p>
                <ul>
                    <li><RouterLink to="/threads/create">Create a thread</RouterLink></li>
                    <li><RouterLink to="/threads/view">View threads</RouterLink></li>
                </ul>
            </div>
        </div>
    </div>
</template>
