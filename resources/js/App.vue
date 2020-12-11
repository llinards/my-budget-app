<template>
  <div class="container mt-3">
    <div class="alert-msgs mt-3">
      <div
        class="alert"
        v-bind:class="updateSuccess ? 'alert-success' : 'alert-danger'"
        v-if="updateSuccess || updateFail"
        role="alert"
      >
        {{ this.updateMsg }}
      </div>
    </div>
    <Date v-on:updateStatus="updateStatus" />
    <hr />
    <Salary v-on:updateStatus="updateStatus" />
  </div>
</template>

<script>
import Date from "./components/Header/Date";
import Salary from "./components/Header/Salary";
export default {
  name: "app",
  components: {
    Date,
    Salary,
  },
  data() {
    return {
      updateSuccess: "",
      updateFail: false,
      updateMsg: "",
    };
  },
  methods: {
    updateStatus: function (updateStatus) {
      if (updateStatus.updateSuccess) {
        this.updateSuccess = true;
        this.updateMsg = updateStatus.updateMsg;
      } else {
        this.updateFail = true;
        this.updateMsg = updateStatus.updateMsg;
      }
    },
  },
};
</script>

<style scoped></style>
