<template>
  <div>
    <form v-on:submit.prevent="updateSalaryDate">
      <ul class="list-group mb-3">
        <li class="list-group-item">
          <h5 class="text-center m-0 font-weight-bold">
            Šodienas datums: {{ currentDate }}
          </h5>
        </li>
        <li class="list-group-item">
          <h5 class="text-center m-0 font-weight-bold" v-if="salaryDate">
            Algas diena: {{ salaryDate }}
          </h5>
        </li>
        <li class="list-group-item">
          <h5 class="text-center m-0 font-weight-bold" v-if="salaryDate">
            {{ calculateDaysUntilSalary }}
          </h5>
        </li>
        <li class="list-group-item">
          <h5 class="text-center m-0 font-weight-bold pb-3">
            Jauns algas datums:
          </h5>
          <input
            v-model="salaryDate"
            type="date"
            name="salarydate"
            id="salarydate"
            class="form-control"
          />
        </li>
      </ul>
      <div class="mb-3">
        <button class="btn btn-success">Atjaunot</button>
      </div>
    </form>
  </div>
</template>
<script>
import moment from "moment";
export default {
  emit: ["update-status", "days-until-salary"],
  data() {
    return {
      currentDate: "",
      salaryDate: "",
    };
  },
  watch: {},
  computed: {
    calculateDaysUntilSalary(salaryDate, currentDate) {
      let from = this.salaryDate;
      let to = this.currentDate;
      let diff = Math.abs(
        moment(from, "YYYY-MM-DD")
          .startOf("day")
          .diff(moment(to, "YYYY-MM-DD").startOf("day"), "days")
      );
      if (diff === 0) {
        return "Šodien jābūt algas dienai!";
      } else if (diff < 0) {
        return "Algai vajadzēja jau būt! :(";
      }
      this.$emit("days-until-salary", diff);
      return "Līdz algai: " + diff;
    },
  },
  methods: {
    dateFunction: function () {
      let currentDate = moment().format("YYYY-MM-DD");
      this.currentDate = currentDate;
    },
    updateSalaryDate: function () {
      axios
        .post("/api/date", {
          salaryDate: this.salaryDate,
        })
        .then((response) => {
          this.$emit("update-status", true, response.data);
        })
        .catch((err) => {
          this.$emit("update-status", false, err);
        });
    },
    fetchData: function () {
      axios
        .get("/api/date")
        .then((response) => {
          if (response.data != "") {
            this.salaryDate = response.data.salaryDate;
          }
        })
        .catch((err) => {
          this.$emit("update-status", false, err);
        });
    },
  },
  created() {
    this.dateFunction();
    this.fetchData();
  },
};
</script>
<style scoped>
</style>
