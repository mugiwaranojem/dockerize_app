<template>
  <form class="form-signin">
    <div class="mb-4">
<!--       <img class="mb-4" src="/docs/4.3/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72"> -->
      <h1 class="h3 mb-3 font-weight-normal">Sign In</h1>
    </div>

    <div class="form-group">
      <label for="inputEmail">Email address</label>
      <input v-model="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
      
    </div>

    <div class="form-group">
      <label for="inputPassword">Password</label>
      <input v-model="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
      
    </div>

    <p>Not yet registered? <a href="/#/user/register">Register here</a></p>

    <button @click.prevent="login" class="btn btn-lg btn-primary btn-block" :disabled="loading">
      <i class="fas fa-circle-notch fa-spin loader" :class="{'d-none': !loading }"></i>Sign in
    </button>
    <p class="mt-5 mb-3 text-muted text-center">© 2017-2019</p>
  </form>
</template>

<script>
import userService from '../service/userService'
import toastr from 'toastr'

export default {
  name: 'Login',
  data () {
    return {
      email: '',
      password: '',
      loading: false
    }
  },
  methods: {
    login() {
      const formData = new FormData();
      formData.append('email', this.email);
      formData.append('password', this.password);

      this.loading = true;

      if (!this.email.length ||
        !this.password.length
      ) {
        toastr.error('All fields are required');
        this.loading = false
        return
      }

      userService.login(formData).then(response => {
        
        if (response.error) {
          if (response.error === 'user_not_found') {
            toastr.error('Invalid email or passowrd')
          } else {
            toastr.error('Unknown error occured')
          }
        }

        if (response.token) {
          localStorage.setItem('token', response.token);

          location.href = '/#/'
        }
        
      })
      .catch(()=> {
        toastr.error('Unknown error occured')
      })
      .finally(() => {
        this.loading = false
      });
    }
  },
  mounted () {
    
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.form-signin {
    width: 100%;
    max-width: 420px;
    padding: 15px;
    margin: auto;
}

.form-group {
  text-align: left;
}

</style>
