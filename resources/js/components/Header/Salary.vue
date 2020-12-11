<template>
  <div>
    <div>
      <p>Kopā ienākumi: {{ totalIncome }} EUR</p>
      <p>Alga: {{ mainSalary }} EUR</p>
      <button @click="updateSalary = !updateSalary">Atjaunot pamatalgu</button>
    </div>
    <form v-if="updateSalary">
      <label for="mainSalary">Pamatalga EUR:</label>
      <input
        type="number"
        name="mainSalary"
        id="mainSalary"
        v-model="mainSalary"
      />
      <button @click.prevent="changeSalary">Saglabāt</button>
    </form>
  </div>
</template>
<script>
export default {
  name: "Salary",
  data() {
    return {
      mainSalary: 0,
      totalIncome: 0,
      updateSalary: false,
    };
  },
  watch: {
    mainSalary(mainSalary) {
      this.totalIncome = mainSalary;
    },
  },
  methods: {
    changeSalary: function () {
      axios
        .post("/api/salary", {
          amount: this.mainSalary,
          isMainSalary: true,
        })
        .then((response) => {
          this.updateSalary = false;
          this.reportUpdateStatus(true, response.data);
        })
        .catch((err) => {
          this.reportUpdateStatus(false, err);
        });
    },
    reportUpdateStatus: function (status, msg) {
      const updateStatus = {
        updateSuccess: status,
        updateMsg: msg,
      };
      return this.$emit("updateStatus", updateStatus);
    },
  },
  mounted() {
    axios
      .get("/api/salary")
      .then((response) => {
        if (response.data != "") {
          this.mainSalary = response.data.amount;
        }
      })
      .catch((err) => {
        this.reportUpdateStatus(false, err);
      });
  },
};
</script>