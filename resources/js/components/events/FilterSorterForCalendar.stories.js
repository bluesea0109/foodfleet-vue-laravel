import { storiesOf } from '@storybook/vue'
import { action } from '@storybook/addon-actions'
import MockAdapter from 'axios-mock-adapter'
import axios from 'axios/index'

// Components
import FilterSorterForCalendar from './FilterSorterForCalendar.vue'

let statuses = [
  { id: 1, name: 'Draft' },
  { id: 2, name: 'Pending' },
  { id: 3, name: 'Confirmed' },
  { id: 4, name: 'Past' },
  { id: 5, name: 'Cancelled' }
]

const mock = new MockAdapter(axios)
mock.onGet('/companies?filter[type_key]=host').reply(200, {
  data: [
    { uuid: 1, name: 'company 1' },
    { uuid: 2, name: 'company 2' },
    { uuid: 3, name: 'company 3' },
    { uuid: 4, name: 'company 4' }
  ]
})
mock.onGet('/users?filter[type]=1').reply(200, {
  data: [
    { uuid: 1, name: 'user 1' },
    { uuid: 2, name: 'user 2' },
    { uuid: 3, name: 'user 3' },
    { uuid: 4, name: 'user 4' }
  ]
})

storiesOf('FoodFleet|components/event/FilterSorterForCalendar', module)
  .addParameters({
    backgrounds: [
      { name: 'default', value: '#f1f3f6', default: true }
    ]
  })
  .add('default', () => ({
    components: { FilterSorterForCalendar },
    methods: {
      filterEvents (params) {
        action('Run')(params)
      }
    },
    template: `
      <v-container style="background-color: rgba(0,0,0,.2)">
        <filter-sorter-for-calendar
          @runFilter="filterEvents"
        />
      </v-container>
    `
  }))
  .add('with statuses', () => ({
    components: { FilterSorterForCalendar },
    data () {
      return {
        statuses: statuses,
        filters: {
          name: '',
          status_id: null,
          host_uuid: null,
          manager_uuid: null
        }
      }
    },
    methods: {
      filterEvents (params) {
        action('Run')(params)
      }
    },
    template: `
      <v-container style="background-color: rgba(0,0,0,.2)">
        <filter-sorter-for-calendar
          :filters="filters"
          :statuses="statuses"
          @runFilter="filterEvents"
        />
      </v-container>
    `
  }))
