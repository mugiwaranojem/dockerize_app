<template>
  <form class="form-signin">
    <div class="mb-4">
      <h1 class="h3 mb-3 font-weight-normal">Register</h1>
    </div>

    <div class="form-group">
      <label for="inputName">Name</label>
      <input v-model="name" type="email" id="inputName" class="form-control" placeholder="Name" autofocus="">
    </div>

    <div class="form-group">
      <label for="inputEmail">Email address</label>
      <input v-model="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
    </div>

    <div class="form-group">
      <label for="inputPassword">Password</label>
      <input v-model="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
    </div>

    <button @click.prevent="register" id="btn-submit" class="btn btn-lg btn-primary btn-block" type="submit" :disabled="loading">
      Register
      <i class="fas fa-circle-notch fa-spin loader" :class="{'d-none': !loading }"></i>
    </button>
    <a class="mt-2 d-block text-center" href="/#/user/login">Back to login page</a>
    <p class="mt-5 mb-3 text-muted text-center">© 2017-2019</p>
  </form>
</template>

<script>
import userService from '../service/userService'
import toastr from 'toastr'

export default {
  name: 'Registration',
  data () {
    return {
      name: '',
      email: '',
      password: '',
      loading: false
    }
  },
  methods: {
    register() {
      this.loading = true;

      if (!this.name.length ||
        !this.email.length ||
        !this.password.length
      ) {
        toastr.error('All fields are required');
        this.loading = false
        return
      }

      const formData = new FormData()
      formData.append('name', this.name)
      formData.append('email', this.email)
      formData.append('password', this.password)


      userService.register(formData).then(user => {
        if (user.id) {
          toastr.success('Successfully registered')
        }
      })
      .finally(() => {
        this.loading = false
      });    
    }
  },

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

#btn-submit {
  position: relative;
}

.loader {
  position: absolute;
  right: 18px;
  top: 12px;
}

</style>
