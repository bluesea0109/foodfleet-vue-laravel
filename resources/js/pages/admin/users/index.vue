<template>
  <div>
    <v-flex
      d-inline-flex
      align-center
      ma-2
    >
      <h2 class="white--text">
        {{ pageTitle }}
      </h2>
      <v-btn
        slot="activator"
        color="primary"
        dark
        class="ml-4"
        @click="userNew"
      >
        New User
      </v-btn>
    </v-flex>
    <v-divider />

    <br>
    <user-filter
      v-if="!isLoading"
      :sortables="sortables"
      @runFilter="filterUsers"
    />
    <user-list
      v-if="!isLoading"
      :users="users"
      :levels="userlevels"
      :statuses="userstatuses"
      :is-loading="isLoading || isLoadingList"
      :rows-per-page="pagination.rowsPerPage"
      :page="pagination.page"
      :total-items="pagination.totalItems"
      :sort-by="sorting.sortBy"
      :descending="sorting.descending"
      :headers="headers"
      :item-actions="itemActions"
      class="users-list"
      must-sort
      @paginate="onPaginate"
      @change-status="changeStatus"
      @change-level="changeLevel"
      @manage-view="userView"
      @manage-edit="userEdit"
      @manage-delete="deleteUser"
      @manage-multiple-delete="deleteMultiple"
    >
      <template v-slot:item-inner-name,email="{ item }">
        <div class="subheading">
          {{ item.name }}
        </div>
        {{ item.email }}
      </template>
      <template v-slot:item-inner-user_type="{ item }">
        <template v-if="item.user_type">
          {{ item.user_type.name }}
        </template>
      </template>
      <template v-slot:item-inner-company_name="{ item }">
        {{ item.company_name }}
      </template>
    </user-list>

    <v-dialog
      v-model="deleteUserDialog"
      max-width="500"
    >
      <simple-confirm
        :class="{ 'deleting': deletablesProcessing }"
        :title="deleteDialogTitle"
        ok-label="Yes"
        cancel-label="No"
        @ok="deleteUsers"
        @cancel="deleteUserDialog = false"
      >
        <div class="py-5 px-2">
          <template v-if="deletablesProcessing">
            <div class="text-xs-center">
              <p class="subheading">
                Processing, please wait...
              </p>
              <v-progress-circular
                :rotate="-90"
                :size="200"
                :width="15"
                :value="deletablesProgress"
                color="primary"
              >
                {{ deletablesStatus }}
              </v-progress-circular>
            </div>
          </template>
          <template v-else>
            <p class="subheading">
              <span v-if="deletables.length < 2">User</span>
              <span v-else> Users</span>
              : {{ deleteableNames }}
            </p>
          </template>
        </div>
      </simple-confirm>
    </v-dialog>
  </div>
</template>

<script>
import { mapGetters, mapActions, mapState } from 'vuex'
import UserList from 'fresh-bus/components/datatable/user-list.vue'
import userFilter from 'fresh-bus/components/users/FilterSorter.vue'
import simpleConfirm from 'fresh-bus/components/SimpleConfirm.vue'
import { deletables } from 'fresh-bus/components/mixins/Deletables'
import get from 'lodash/get'

export default {
  layout: 'admin',
  components: {
    UserList,
    userFilter,
    simpleConfirm
  },
  mixins: [deletables],
  data () {
    return {
      pageTitle: 'Users',
      deleteUserDialog: false,
      user: {},
      lastFilterParams: {},
      headers: [
        { text: 'Status', sortable: true, value: 'status', align: 'center' },
        { text: 'Name / Email', value: 'name,email', align: 'left' },
        { text: 'User Type', sortable: true, value: 'user_type', align: 'center' },
        { text: 'Company', value: 'company_name', align: 'left' },
        { text: 'BUS Role', sortable: true, value: 'level', align: 'center' },
        { text: 'Manage', sortable: false, value: 'manage', align: 'center' }
      ],
      itemActions: [
        { action: 'view', text: 'View' },
        { action: 'edit', text: 'Edit' },
        { action: 'delete', text: 'Delete' }
      ]
    }
  },
  computed: {
    isLoadingList () {
      return get(this.$store, 'state.users.pending.items', true)
    },
    ...mapGetters('users', {
      users: 'items',
      pagination: 'pagination',
      sorting: 'sorting',
      sortBy: 'sortBy'
    }),
    ...mapGetters('page', ['isLoading']),
    ...mapGetters('userLevels', { 'userlevels': 'items' }),
    ...mapGetters('userTypes', { 'userTypes': 'items' }),
    ...mapGetters('userStatuses', { 'userstatuses': 'items' }),
    ...mapState('users', ['sortables']),
    deleteDialogTitle () {
      return this.deletables.length < 2 ? 'Are you sure you want to delete this user?' : 'Are you sure you want to delete the following users?'
    },
    deleteableNames () {
      return this.deletables.map((user) => {
        return user.name
      }).join(', ')
    }
  },
  methods: {
    ...mapActions('page', {
      setPageLoading: 'setLoading'
    }),

    changeStatus (status, user) {
      this.$store.dispatch('users/patchItem', { data: { status }, params: { id: user.id } }).then(() => {
        this.filterUsers(this.lastFilterParams)
      })
    },
    changeLevel (level, user) {
      this.$store.dispatch('users/patchItem', { data: { level }, params: { id: user.id } }).then(() => {
        this.filterUsers(this.lastFilterParams)
      })
    },
    userNew () {
      this.$router.push({ path: '/admin/users/new' })
    },
    userView (user) {
      this.$router.push({ path: '/admin/users/' + user.id })
    },
    userEdit (user) {
      this.$router.push({ path: '/admin/users/' + user.id + '/edit' })
    },
    deleteUserDialogUp (user) {
      this.deleteUserDialog = true
      this.user = user
    },
    deleteUser (user) {
      this.deleteDialogUp(user)
    },
    async deleteUsers () {
      this.deletablesProcessing = true
      this.deletablesProgress = 0
      this.deletablesStatus = ''
      let dispatcheables = []

      this.deletables.forEach((user) => {
        dispatcheables.push(this.$store.dispatch('users/deleteItem', { getItems: false, params: { id: user.id } }))
      })

      let chunks = this.chunk(dispatcheables, this.deletablesParrallelRequest)
      let doneCount = 0

      for (let i in chunks) {
        await Promise.all(chunks[i])
        doneCount += chunks[i].length
        this.deletablesStatus = doneCount + ' / ' + this.deletables.length + ' Done'
        this.deletablesProgress = doneCount / this.deletables.length * 100
        await this.sleep(this.deletablesSleepTime)
      }

      this.filterUsers(this.lastFilterParams)
      await this.sleep(500)
      this.deleteUserDialog = false
      this.deletablesProcessing = false
    },
    deleteMultiple (users) {
      this.deleteDialogUp(users)
    },
    deleteDialogUp (users) {
      if (!Array.isArray(users)) {
        users = [users]
      }
      this.deleteUserDialog = true
      this.deletables = users
    },
    onPaginate (value) {
      this.$store.dispatch('users/setPagination', value)
      this.$store.dispatch('users/getItems', { params: { include: ['user_type'] } })
    },
    filterUsers (params) {
      this.lastFilterParams = params
      this.$store.dispatch('users/setSort', params.sort)
      this.$store.dispatch('users/setFilters', {
        ...this.$route.query,
        ...this.lastFilterParams
      })
      this.$store.dispatch('users/getItems', { params: { include: ['user_type'] } })
    }
  },
  beforeRouteEnterOrUpdate (vm, to, from, next) {
    vm.$store.dispatch('page/setLoading', true)
    vm.$store.dispatch('users/setFilters', {
      ...vm.$route.query
    })
    Promise.all([
      vm.$store.dispatch('userLevels/getUserlevels'),
      vm.$store.dispatch('userTypes/getItems'),
      vm.$store.dispatch('userStatuses/getUserstatuses')
    ])
      .then(() => {
        if (next) next()
      })
      .catch((error) => console.error(error))
      .then(() => vm.$store.dispatch('page/setLoading', false))
  }
}
</script>
