import { storiesOf } from '@storybook/vue'
import { action } from '@storybook/addon-actions'
import MockAdapter from 'axios-mock-adapter'
import axios from 'axios/index'

// Components
import FilterSorter from './FilterSorter.vue'

let statuses = [
  { value: 1, text: 'Draft' },
  { value: 2, text: 'Pending' },
  { value: 3, text: 'Revision' },
  { value: 4, text: 'Rejected' },
  { value: 5, text: 'Approved' },
  { value: 6, text: 'On hold' }
]

let sortables = [
  { value: '-created_at', text: 'Newest' },
  { value: 'created_at', text: 'Oldest' },
  { value: 'title', text: 'Title (A - Z)' },
  { value: '-title', text: 'Title (Z - A)' }
]

const mock = new MockAdapter(axios)
mock.onGet('foodfleet/store-tags').reply(200, {
  data: [
    { uuid: 1, name: 'Store Tag 1' },
    { uuid: 2, name: 'Store Tag 2' },
    { uuid: 3, name: 'Store Tag 3' },
    { uuid: 4, name: 'Store Tag 4' }
  ]
})
mock.onGet('foodfleet/addresses').reply(200, {
  data: [
    { uuid: 1, name: 'Address 1' },
    { uuid: 2, name: 'Address 2' },
    { uuid: 3, name: 'Address 3' },
    { uuid: 4, name: 'Address 4' }
  ]
})

storiesOf('FoodFleet|fleet-member/FilterSorter', module)
  .addParameters({
    backgrounds: [
      { name: 'default', value: '#f1f3f6', default: true }
    ]
  })
  .add('default', () => ({
    components: { FilterSorter },
    methods: {
      filterDocs (params) {
        action('Run')(params)
      }
    },
    template: `
      <v-container>
        <filter-sorter
          @runFilter="filterDocs"
        />
      </v-container>
    `
  }))
  .add('with statuses', () => ({
    components: { FilterSorter },
    data () {
      return {
        statuses: statuses
      }
    },
    methods: {
      filterDocs (params) {
        action('Run')(params)
      }
    },
    template: `
      <v-container>
        <filter-sorter
          :statuses="statuses"
          @runFilter="filterDocs"
        />
      </v-container>
    `
  }))
  .add('with sortables', () => ({
    components: { FilterSorter },
    data () {
      return {
        sortables: sortables
      }
    },
    methods: {
      filterDocs (params) {
        action('Run')(params)
      }
    },
    template: `
      <v-container>
        <filter-sorter
          :sortables="sortables"
          @runFilter="filterDocs"
        />
      </v-container>
    `
  }))
