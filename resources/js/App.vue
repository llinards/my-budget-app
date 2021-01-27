<template>
  <div>
    <div class="row">
      <div class="container">
        <div class="alert-msgs" v-if="updateSuccess || updateFail">
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
        <div class="col-md-6">
          <Date
            @update-status="updateStatus"
            @days-until-salary="daysUntilSalary"
          />
        </div>
        <div class="col-md-6">
          <Salary
            :days-until-salary="calculatedDaysUntilSalary"
            @update-status="updateStatus"
          />
        </div>
      </div>
    </div>
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
