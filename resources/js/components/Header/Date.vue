<template>
  <div>
    <div class="alert-msgs mt-3">
      <div
        class="alert"
        v-bind:class="updateSuccess ? 'alert-success' : 'alert-danger'"
        v-if="updateSuccess || updateFail"
        role="alert"
      >
        {{ this.updateMsg }}
      </div>
      <div v-if="!salaryDate" class="alert alert-primary" role="alert">
        Norādi algas datumu!  
      </div>
    </div>
    <div class="row justify-content-center">
      <!-- <div class="col-8"> -->
        <form v-on:submit.prevent="updateSalaryDate">
          <div class="form-row">
            <div class="form-group">
              <h5 class="text-center">Šodienas datums: {{ currentDate }}</h5>
              <hr v-if="salaryDate"  />
              <h5 class="text-center" v-if="salaryDate">
                Algas diena: {{ salaryDate }}
              </h5>
              <h5 class="text-center" v-if="daysUntilSalary">
                Līdz algai: {{ daysUntilSalary }}
              </h5>
              <hr>
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
              <!-- <input
                v-model="salaryDate"
                v-on:change="calculateDaysUntilSalary"
                type="date"
                name="salarydate"
                id="salarydate"
                class="form-control"
              /> -->
            </div>
          </div>
          <div class="text-center">
            <button class="btn btn-success">Atjaunot</button>
          </div>
        </form>
      </div>
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
      updateSuccess: "",
      updateFail: false,
      updateMsg: "",
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
    updateSalaryDate: function () {
      axios
        .post("/api/date", {
          salaryDate: this.salaryDate,
        })
        .then((response) => {
          this.updateSuccess = true;
          this.updateMsg = response.data;
        })
        .catch((err) => {
          this.updateFail = true;
          this.updateMsg = err;
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
          this.calculateDaysUntilSalary();
        }
      })
      .catch((err) => {
        this.updateFail = true;
        this.updateMsg = err;
      });
  },
};
</script>



// <html>

// <head>

// </head>

// <body>
//     <div id="app">
//         <table class="table">
//             <thead>
//                 <tr>
//                     <td><strong>Title</strong></td>
//                     <td><strong>Description</strong></td>
//                     <td><strong>File</strong></td>
//                     <td></td>
//                 </tr>
//             </thead>
//             <tbody>
//                 <tr v-for="(row, index) in rows">

//                     <td><input type="text" v-model="row.title"></td>
//                     <td><input type="text" v-model="row.description"></td>
//                     <td>
//                         <label class="fileContainer">
//                             {{row.file.name}}
//                             <input type="file" @change="setFilename($event, row)" :id="index">
//                         </label>
//                     </td>
//                     <td>
//                         <a v-on:click="removeElement(index);" style="cursor: pointer">Remove</a>
//                     </td>


//                 </tr>
//             </tbody>
//         </table>
//         <div>
//             <button class="button btn-primary" @click="addRow">Add row</button>
//         </div>
//     </div>

//     <script type="text/javascript">
//         var app = new Vue({
//             el: "#app",
//             data: {
//                 rows: []
//             },
//             methods: {
//                 addRow: function() {
//                     var elem = document.createElement('tr');
//                     this.rows.push({
//                         title: "",
//                         description: "",
//                         file: {
//                             name: 'Choose File'
//                         }
//                     });
//                 },
//                 removeElement: function(index) {
//                     this.rows.splice(index, 1);
//                 },
//                 setFilename: function(event, row) {
//                     var file = event.target.files[0];
//                     row.file = file
//                 }
//             }
//         });
//
</script>
// </body>

// </html>