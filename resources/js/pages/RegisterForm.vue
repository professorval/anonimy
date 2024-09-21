<script setup lang="js">

    import router from '../router'

    async function submit_registration_form(data) {

        //-- get the content of meta name="csrf-token"
        const token = document.querySelector("meta[name='csrf-token']").getAttribute("content");

        //-- add a new field to the form data object with the csrf token
        data['_token'] = token;

        axios.post('/api/auth/register', data)
        .then(function (response) {
            const data = response.data;
            console.log(data);

            if(data.status === true) {
                swal({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                    button: "OK",
                }).then(() => {
                    router.push('/login')
                });
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
      <h4 class="text-center">Create an account:</h4>

      <div class="my-3">
        <div class="my-2">
          <div class="register">
            <FormKit
              type="form"
              submit-label="Submit"
              form-class="mx-auto"
              :submit-attrs="{
                inputClass: 'btn btn-primary',
                outerClass: 'float-end'
              }"
              @submit="submit_registration_form"
            >

            <!-- csrf token -->
            <input type="hidden" name="_token" :value="csrf">

            <!-- Name -->
            <FormKit
                type="text"
                name="name"
                label="Name"
                placeholder="Your full name"
                validation="required"
                input-class="form-control"
                outer-class="mb-3"
                value="Aaron"
              />

            <!-- Email -->
            <FormKit
                type="email"
                name="email"
                label="Email"
                placeholder="Your email address"
                validation="required|email"
                input-class="form-control"
                outer-class="mb-3"
                value="a@a.com"
              />

            <!-- Date of birth -->
            <FormKit
                type="date"
                name="dob"
                label="Date of birth"
                help="Enter your birth day"
                validation-visibility="live"
                input-class="form-control"
                outer-class="mb-3"
                value="2006-01-01"
            />

            <!-- Password -->
            <FormKit
                type="password"
                name="password"
                label="Password"
                placeholder="Your password"
                validation="required|min:6"
                input-class="form-control"
                outer-class="mb-3"
                value="12345678"
              />

              <!-- Repeat password -->
              <FormKit
                type="password"
                name="password_confirmation"
                label="Password"
                placeholder="Repeat password"
                validation="required|min:6"
                input-class="form-control"
                outer-class="mb-3"
                value="12345678"
              />
            </FormKit>

            <br /><br />
            <p>Already have an account? <RouterLink to="/login">Login</RouterLink></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
