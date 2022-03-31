<template>
  <withLabel :item="item">
      <span>{{item.settings.tax_for}} {{item.settings.tax_percent}} <span>%</span></span>
  </withLabel>
</template>

<script>
import withLabel from "./withLabel";

export default {
  name: "inputTax",
  props: ['item'],
  components: {
    withLabel
  },
}

</script>

<style scoped>

</style>