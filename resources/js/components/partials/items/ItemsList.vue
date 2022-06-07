<template>
  <div>
    hellowx 2 {{gridItems.length}}
  </div>
</template>

<script>
export default {
  computed: {
    gridItems() {
      return this.$store.state.items.loadedItems
    }
  }
}
</script>