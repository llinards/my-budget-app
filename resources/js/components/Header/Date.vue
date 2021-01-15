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
            <h5 class="text-center font-weight-bold" v-if="salaryDate">
              {{ calculateDaysUntilSalary }}
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
      return "Līdz algai: " + diff;
    },
  },
  methods: {
    dateFunction: function () {
      let currentDate = moment().format("YYYY-MM-DD");
      this.currentDate = currentDate;
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
