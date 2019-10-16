<template>
  <div id="app">
    <nav class="navbar navbar-default navbar-expand-xl navbar-light mb-5">
      <div class="navbar-header d-flex col">
        <a class="navbar-brand" href="#"><i class="fa fa-cube"></i>Blog<b>Site</b></a>     
        <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
          <span class="navbar-toggler-icon"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <!-- Collection of nav links, forms, and other content for toggling -->
      <div v-if="hasSession" id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
        <ul class="nav navbar-nav">
          <li class="nav-item active"><a href="/#/" class="nav-link">Home</a></li>
        </ul>
        <ul  class="nav navbar-nav navbar-right ml-auto">
          <li class="nav-item dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle user-action" aria-expanded="false"> Paula Wilson <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li>
                <a href="#" class="dropdown-item">
                  <i class="fa fa-sign-out" aria-hidden="true"></i>Logout
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    
      <div class="container">
        <router-view/>
      </div>
    
  </div>
</template>

<script>
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.min.css'

export default {
  name: 'App',
  data() {
    return {
      hasSession: localStorage.getItem('token')
    }
  }
}
</script>

<style>
@import "toastr";

#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

.navbar {
  background: #fff;
  padding-left: 16px;
  padding-right: 16px;
  border-bottom: 1px solid #d6d6d6;
  box-shadow: 0 0 4px rgba(0,0,0,.1);
}

.navbar-default {
    background-color: #f8f8f8;
    border-color: #e7e7e7;
}
.navbar-header {
  max-width: 160px;
}

body {
  background-color: #f5f5f5;
}

h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>
