<template>
  <div>
    <p>Ienākumi:</p>
    <form>
      <label for="mainSalary">Pamatalga EUR:</label>
      <input
        type="text"
        name="mainSalary"
        id="mainSalary"
        v-model="mainSalary"
      />
      <!-- <button @click="addIncome">Pievienot ienākumus</button> -->
      <!-- <div v-for="salary in salaries" v-bind:key="salary.id"></div> -->
    </form>
  </div>
</template>
<script>
export default {
  name: "Salary",
  data() {
    return {
      mainSalary: 0,
      salaries: [{}],
    };
  },
  methods: {
    addIncome() {},
  },
};
</script>