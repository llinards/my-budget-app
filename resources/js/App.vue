<template>
  <div class="container mt-3">
    <div class="alert-msgs mt-3" v-if="updateSuccess || updateFail">
      <div
        class="alert alert-dismissible"
        v-bind:class="updateSuccess ? 'alert-success' : 'alert-danger'"
        role="alert"
      >
        {{ this.updateMsg }}
        <button
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
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
      updateSuccess: false,
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
