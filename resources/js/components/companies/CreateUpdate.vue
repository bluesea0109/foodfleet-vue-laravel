<script>
import CreateUpdate from 'fresh-bus/components/pages/admin/companies/CreateUpdate.vue'

export default {
  extends: CreateUpdate,
  props: {
    isAdmin: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      disableStatus: !this.isAdmin
    }
  },
  watch: {
    isAdmin () {
      this.disableStatus = !this.isAdmin
    }
  }
}
</script>
