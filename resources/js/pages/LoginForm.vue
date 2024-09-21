<script setup lang="js">

    import router from '../router'

    async function submit_login_form(data) {

        // Add a new field to the form data object with the CSRF token
        const csrfToken = document.querySelector("meta[name='csrf-token']")?.getAttribute("content");
        if (!csrfToken) throw new Error("CSRF token not found.");

        data['_token'] = csrfToken ;

        axios.post('/api/auth/login', data)
        .then(function (response) {
            const data = response.data;
            console.log(data);

            //-- if login was successful
            if(data.status === true){
                router.push('/')
            }
            else{
                swal({
                    title: "Error",
                    text: data.message,
                    icon: "error",
                })
            }

        })
        .catch(function (error) {
            console.log(error);
        });
    }
</script>

<template>
  <div class="card border rounded">
    <div class="card-header bg-light">
      <h1 class="text-center">Anonimy</h1>
    </div>
    <div class="card-body">
        <h4 class="text-center">Login to continue:</h4>

        <div class="my-3">
            <FormKit
                type="form"
                submit-label="Log in"
                form-class="mx-auto"
                :submit-attrs="{
                    inputClass: 'btn btn-primary',
                    outerClass: 'float-end'
                }"
                @submit="submit_login_form"
            >
            <FormKit
                type="text"
                label="Email"
                label-class="form-label"
                validation="required|email"
                name="email"
                input-class="form-control"
                outer-class="mb-3"
                placeholder="Enter email address"
            />
            <FormKit
                type="password"
                name="password"
                label="Password"
                placeholder="Enter your password."
                outer-class="mb-3"
                input-class="form-control"
            />
            </FormKit>
        </div>
    </div>
    <div class="card-footer mb-0">
        Don't have an account? <RouterLink to="/register">Sign up</RouterLink><br>
        Forgot your password? <RouterLink to="#">Reset Password</RouterLink>
    </div>
  </div>
</template>
