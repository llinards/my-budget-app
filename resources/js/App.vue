<template>
  <div class="container mt-3">
    <Date />
    <hr />
  </div>
</template>

<script>
import Date from "./components/Header/Date";
export default {
  name: "app",
  components: {
    Date,
  },
};
</script>

<style scoped>
 .container {
   border-top: 1px solid rgba(0,0,0,.1);
 }
</style>