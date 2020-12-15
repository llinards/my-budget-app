<template>
  <div>
    <div class="row justify-content-center">
      <form v-on:submit.prevent="updateSalaryDate">
        <div class="form-row">
          <div class="form-group">
            <h5 class="text-center">Šodienas datums: {{ currentDate }}</h5>
            <hr v-if="salaryDate" />
            <h5 class="text-center" v-if="salaryDate">
              Algas diena: {{ salaryDate }}
            </h5>
            <h5 class="text-center font-weight-bold" v-if="daysUntilSalary">
              Līdz algai: {{ daysUntilSalary }}
            </h5>
            <hr />
            <label class="text-center" for="salarydata"
              >Jauns algas datums:</label
            >
            <input
              v-model="salaryDate"
              type="date"
              name="salarydate"
              id="salarydate"
              class="form-control"
            />
          </div>
        </div>
        <div class="text-center">
          <button class="btn btn-success">Atjaunot</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import moment from "moment";
export default {
  name: "Date",
  data() {
    return {
      currentDate: "",
      daysUntilSalary: 0,
      salaryDate: "",
    };
  },
  watch: {
    salaryDate(salaryDate, currentDate) {
      this.calculateDaysUntilSalary(salaryDate, currentDate);
    },
  },
  methods: {
    dateFunction: function () {
      let currentDate = moment().format("YYYY-MM-DD");
      this.currentDate = currentDate;
    },
    calculateDaysUntilSalary: function (salaryDate, currentDate) {
      let from = this.salaryDate;
      let to = this.currentDate;
      let diff = Math.abs(
        moment(from, "YYYY-MM-DD")
          .startOf("day")
          .diff(moment(to, "YYYY-MM-DD").startOf("day"), "days")
      );
      return (this.daysUntilSalary = diff);
    },
    reportUpdateStatus: function (status, msg) {
      const updateStatus = {
        updateSuccess: status,
        updateMsg: msg,
      };
      return this.$emit("updateStatus", updateStatus);
    },
    updateSalaryDate: function () {
      axios
        .post("/api/date", {
          salaryDate: this.salaryDate,
        })
        .then((response) => {
          this.reportUpdateStatus(true, response.data);
        })
        .catch((err) => {
          this.reportUpdateStatus(false, err);
        });
    },
  },
  mounted() {
    this.dateFunction();
    axios
      .get("/api/date")
      .then((response) => {
        if (response.data != "") {
          this.salaryDate = response.data.salaryDate;
        }
      })
      .catch((err) => {
        this.reportUpdateStatus(false, err);
      });
  },
};
</script>