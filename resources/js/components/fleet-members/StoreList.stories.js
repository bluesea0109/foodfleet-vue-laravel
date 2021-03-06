import { storiesOf } from '@storybook/vue'
import { action } from '@storybook/addon-actions'

// Components
import StoreList from './StoreList.vue'
import { FIXTURE_STORE_STATUSES } from '../../../../tests/Javascript/__data__/storeStatuses'

let stores = [
  {
    uuid: 1,
    status: 1,
    name: 'sint1233',
    type: {
      id: 1,
      value: 1,
      name: 'Mobile',
      text: 'Mobile'
    },
    events: [
      { uuid: 1 },
      { uuid: 2 },
      { uuid: 3 }
    ],
    tags: [
      { uuid: 1, name: 'Asian' },
      { uuid: 2, name: 'Vietnamese' }
    ],
    addresses: [{ uuid: 1, city: 'Salvador', street: 'Rua' }],
    created_at: '2019-09-24T06:33:05.000000Z',
    updated_at: '2019-09-24T11:14:21.000000Z',
    state_of_incorporation: 'MX',
    owner_uuid: '07b49e1c-e7b1-49e7-8957-9780d1ac4abe',
    owner: {
      uuid: '07b49e1c-e7b1-49e7-8957-9780d1ac4abe',
      company_name: 'Laravel',
      name: 'Colleague 4 User',
      first_name: 'Colleague 4',
      last_name: 'User'
    }
  },
  {
    uuid: 2,
    status: 2,
    name: 'sint1233',
    type: {
      id: 1,
      value: 1,
      name: 'Stationary',
      text: 'Stationary'
    },
    events: [
      { uuid: 1 },
      { uuid: 2 }
    ],
    tags: [
      { uuid: 1, name: 'Asian' },
      { uuid: 2, name: 'Vietnamese' },
      { uuid: 3, name: 'Asian Fusion' }
    ],
    addresses: [{ uuid: 1, city: 'Los Angeles', street: 'Road' }],
    created_at: '2019-09-24T06:33:05.000000Z',
    updated_at: '2019-09-24T11:14:21.000000Z',
    state_of_incorporation: 'MX',
    owner_uuid: '07b49e1c-e7b1-49e7-8957-9780d1ac4abe',
    owner: {
      uuid: '07b49e1c-e7b1-49e7-8957-9780d1ac4abe',
      company_name: 'Laravel',
      name: 'Colleague 4 User',
      first_name: 'Colleague 4',
      last_name: 'User'
    }
  },
  {
    uuid: 3,
    status: 3,
    name: 'sint1233',
    type: {
      id: 1,
      value: 1,
      name: 'Stationary',
      text: 'Stationary'
    },
    events: [
      { uuid: 1 },
      { uuid: 2 },
      { uuid: 3 }
    ],
    tags: [
      { uuid: 1, name: 'Asian' },
      { uuid: 2, name: 'Vietnamese' },
      { uuid: 3, name: 'Asian Fusion' }
    ],
    addresses: [{ uuid: 1, city: 'San Jose', street: 'Street' }],
    created_at: '2019-09-24T06:33:05.000000Z',
    updated_at: '2019-09-24T11:14:21.000000Z',
    state_of_incorporation: 'MX',
    owner_uuid: '07b49e1c-e7b1-49e7-8957-9780d1ac4abe',
    owner: {
      uuid: '07b49e1c-e7b1-49e7-8957-9780d1ac4abe',
      company_name: 'Laravel',
      name: 'Colleague 4 User',
      first_name: 'Colleague 4',
      last_name: 'User'
    }
  }
]

export const Empty = () => ({
  components: { StoreList },
  data () {
    return {
      stores: [],
      statuses: FIXTURE_STORE_STATUSES,
      pagination: {
        page: 1,
        rowsPerPage: 10,
        totalItems: 5
      },
      sorting: {
        descending: false,
        sortBy: ''
      }
    }
  },
  template: `
      <store-list
        :stores="stores"
        :statuses="statuses"
        :rows-per-page="pagination.rowsPerPage"
        :page="pagination.page"
        :total-items="pagination.totalItems"
        :sort-by="sorting.sortBy"
        :descending="sorting.descending"
      />
    `
})

export const Populated = () => ({
  components: { StoreList },
  data () {
    return {
      stores: stores,
      statuses: FIXTURE_STORE_STATUSES,
      pagination: {
        page: 1,
        rowsPerPage: 10,
        totalItems: 5
      },
      sorting: {
        descending: false,
        sortBy: ''
      }
    }
  },
  methods: {
    view (params) {
      action('manage-view')(params)
    },
    del (params) {
      action('manage-delete')(params)
    },
    multipleDelete (params) {
      action('manage-multiple-delete')(params)
    },
    changeStatus (status, store) {
      action('change-status')(status, store)
    },
    changeStatusMultiple (status, stores) {
      action('change-status-multiple')(status, stores)
    }
  },
  template: `
      <store-list
        :stores="stores"
        :statuses="statuses"
        :rows-per-page="pagination.rowsPerPage"
        :page="pagination.page"
        :total-items="pagination.totalItems"
        :sort-by="sorting.sortBy"
        :descending="sorting.descending"
        @manage-view="view"
        @manage-delete="del"
        @manage-multiple-delete="multipleDelete"
        @change-status="changeStatus"
        @change-status-multiple="changeStatusMultiple"
      />
    `
})

storiesOf('FoodFleet|components/fleet-members/StoreList', module)
  .addParameters({
    backgrounds: [
      { name: 'default', value: '#f1f3f6', default: true }
    ]
  })
  .add('Empty', Empty)
  .add('Populated', Populated)
