import { storiesOf } from '@storybook/vue'
import MockAdapter from 'axios-mock-adapter'
import axios from 'axios/index'
import AssignedSearch from './AssignedSearch.vue'

const mock = new MockAdapter(axios)
mock.onGet('users').reply(200, {
  data: [
    { uuid: 1, name: 'User 1' },
    { uuid: 2, name: 'User 2' },
    { uuid: 3, name: 'User 3' },
    { uuid: 4, name: 'User 4' }
  ]
})

mock.onGet('foodfleet/stores').reply(200, {
  data: [
    { uuid: 1, name: 'Store 1' },
    { uuid: 2, name: 'Store 2' },
    { uuid: 3, name: 'Store 3' },
    { uuid: 4, name: 'Store 4' }
  ]
})

mock.onGet('foodfleet/venues').reply(200, {
  data: [
    { uuid: 1, name: 'Venues 1' },
    { uuid: 2, name: 'Venues 2' },
    { uuid: 3, name: 'Venues 3' },
    { uuid: 4, name: 'Venues 4' }
  ]
})

mock.onGet('foodfleet/events').reply(200, {
  data: [
    { uuid: 1, name: 'Events 1' },
    { uuid: 2, name: 'Events 2' },
    { uuid: 3, name: 'Events 3' },
    { uuid: 4, name: 'Events 4' }
  ]
})

// Components
storiesOf('FoodFleet|doc/AssignedSearch', module)
  .addParameters({
    backgrounds: [
      { name: 'default', value: '#f1f3f6', default: true }
    ]
  })
  .add('default', () => ({
    components: { AssignedSearch },
    data () {
      return {
        assigned_type: 1,
        assigned_uuid: ''
      }
    },
    methods: {
      selectAssigned (uuid) {
        this.assigned_uuid = uuid
      },
      changeAssignedType (type) {
        this.assigned_type = type
      }
    },
    template: `
      <v-container>
        <assigned-search
          :type="assigned_type"
          :onAssignChange="selectAssigned"
          :onTypeChange="changeAssignedType"
        />
      </v-container>
    `
  }))
