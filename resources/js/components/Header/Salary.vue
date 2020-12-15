<template>
  <div>
    <div class="row justify-content-center align-items-center flex-column">
      <div class="container">
        <div class="col-6">
          <div class="mb-3">
            <ul class="list-group">
              <li class="list-group-item">
                <h5 class="text-center m-0 font-weight-bold">
                  Kopā ienākumi: {{ totalIncome }} EUR
                </h5>
                <p class="text-center m-0">Alga: {{ mainSalary }} EUR</p>
              </li>
              <li class="list-group-item">
                <h5 class="text-center m-0 font-weight-bold">
                  Konta atlikums: {{ currentBalance }} EUR
                </h5>
                <p class="m-0">
                  Kontā nevajadzētu būt mazāk par:
                  {{ balanceShouldNotBeBelow }} EUR
                </p>
              </li>
              <li class="list-group-item">
                <h5 class="text-center m-0 font-weight-bold">
                  Dienas likme: {{ dailyRate }} EUR
                </h5>
                <p class="m-0">
                  Aprēķinātā dienas likme no atlikuma:
                  {{ calculatedDailyRate }} EUR
                </p>
              </li>
            </ul>
          </div>
          <div class="text-center">
            <button
              class="btn btn-success"
              data-toggle="modal"
              data-target="#updateSalary"
            >
              Atjaunot datus
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="updateSalary" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <form class="mt-3">
              <div class="form-group text-center">
                <label for="mainSalary">Alga:</label>
                <input
                  type="number"
                  name="mainSalary"
                  id="mainSalary"
                  v-model="mainSalary"
                  class="form-control"
                />
              </div>
              <div class="form-group text-center">
                <label for="dailyRate">Dienas likme:</label>
                <input
                  type="number"
                  name="dailyRate"
                  id="dailyRate"
                  v-model="dailyRate"
                  class="form-control"
                />
              </div>
              <div class="form-group text-center">
                <label for="currentBalance">Konta atlikms:</label>
                <input
                  type="number"
                  name="currentBalance"
                  id="currentBalance"
                  v-model="currentBalance"
                  class="form-control"
                />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Aizvērt
            </button>
            <button
              type="button"
              data-dismiss="modal"
              class="btn btn-success"
              @click.prevent="changeSalary"
            >
              Saglabāt
            </button>
          </div>
        </div>
      </div>
    </div>
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
      calculatedDailyRate: 0,
      dailyRate: 0,
      currentBalance: 0,
      balanceShouldNotBeBelow: 0,
    };
  },
  watch: {
    mainSalary(mainSalary) {
      this.totalIncome = mainSalary;
    },
    currentBalance() {
      this.calculateDailyRate();
    },
    dailyRate() {
      // Vuex
      this.balanceShouldNotBeBelow = parseFloat(this.dailyRate * 14).toFixed(2);
    },
  },
  methods: {
    changeSalary: function () {
      axios
        .post("/api/salary", {
          amount: this.mainSalary,
          dailyRate: this.dailyRate,
          currentBalance: this.currentBalance,
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
    calculateDailyRate: function () {
      this.calculatedDailyRate = parseFloat(this.currentBalance / 14).toFixed(
        2
      );
    },
  },
  mounted() {
    axios
      .get("/api/salary")
      .then((response) => {
        if (response.data != "") {
          this.mainSalary = response.data.amount;
          this.dailyRate = response.data.dailyRate;
          this.currentBalance = response.data.currentBalance;
        }
      })
      .catch((err) => {
        this.reportUpdateStatus(false, err);
      });
  },
};
</script>