<template>
  <div id="app">
    <navbar></navbar>
    <img src="img/logo.png">
    <hello></hello>
  </div>
</template>

<script>
import Hello from './components/Hello'
import Navbar from './components/navigation/navbar.vue'

export default {
  name: 'app',
  components: {
    Hello,
    Navbar
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
