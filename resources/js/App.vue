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
    <Date @update-status="updateStatus" @days-until-salary="daysUntilSalary" />
    <hr />
    <Salary
      :days-until-salary="calculatedDaysUntilSalary"
      @update-status="updateStatus"
    />
  </div>
</template>

<script>
import Date from "./components/Header/Date";
import Salary from "./components/Header/Salary";
export default {
  components: {
    Date,
    Salary,
  },
  data() {
    return {
      updateSuccess: false,
      updateFail: false,
      updateMsg: "",
      calculatedDaysUntilSalary: 0,
    };
  },
  methods: {
    updateStatus: function (updateStatus, updateMsg) {
      if (updateStatus) {
        this.updateSuccess = true;
        this.updateMsg = updateMsg;
      } else {
        this.updateFail = true;
        this.updateMsg = updateMsg;
      }
    },
    daysUntilSalary(days) {
      this.calculatedDaysUntilSalary = days;
    },
  },
};
</script>

<style scoped></style>
