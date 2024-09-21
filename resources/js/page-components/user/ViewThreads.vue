<template>
    <Navbar />
    <div class="container">
        <div class="card border rounded">
            <div class="card-header">
                <h2>Your threads</h2>
            </div>
            <div class="card-body">

              <Breadcrumbs :data="[{name: 'My threads', link: '/', linkName: 'Home'}]" />

            </div>
        </div>
    </div>
</template>