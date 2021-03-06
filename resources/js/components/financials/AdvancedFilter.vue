<template>
  <div class="full-width">
    <v-card class="pa-4 pb-100">
      <v-layout
        row
        justify-space-between
      >
        <title-link
          value="Advanced Filters"
          to="#"
          color="primary"
          class="mt-2"
        />
        <v-btn
          icon
          large
          class="mr-0 mt-2 small-btn"
          @click="close"
        >
          <v-icon class="grey--text">
            far fa-times-circle
          </v-icon>
        </v-btn>
      </v-layout>
      <v-expansion-panel
        v-model="events"
        expand
      >
        <v-expansion-panel-content>
          <template v-slot:actions>
            <v-icon small>
              $vuetify.icons.expand
            </v-icon>
          </template>
          <template
            v-slot:header
            class="pl-0"
          >
            <div class="title">
              Events
            </div>
            <a
              class="black--text underline text-xs-right mr-2"
              @click.prevent="clearAllEvents"
            >Clear all</a>
          </template>
          <v-layout
            row
            my-2
          >
            <v-flex
              sm6
              :class="{'pr-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Event tag
                <clear-button
                  v-if="filters.event_tag_uuid"
                  @clear="filters.event_tag_uuid = null; $refs.eventTag.resetTerm()"
                />
              </v-layout>
              <simple
                ref="eventTag"
                url="foodfleet/event-tags"
                term-param="filter[name]"
                results-id-key="uuid"
                :value="filters.event_tag_uuid"
                placeholder="All tags"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'event_tag_uuid')"
              />
            </v-flex>
            <v-flex
              sm6
              :class="{'pl-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Locations
                <clear-button
                  v-if="filters.location_uuid"
                  @clear="filters.location_uuid = null; $refs.location.resetTerm()"
                />
              </v-layout>
              <simple
                ref="location"
                url="foodfleet/locations"
                term-param="filter[name]"
                results-id-key="uuid"
                :value="filters.location_uuid"
                placeholder="All locations"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'location_uuid')"
              />
            </v-flex>
          </v-layout>
        </v-expansion-panel-content>
      </v-expansion-panel>
      <v-expansion-panel
        v-model="customers"
        expand
        class="mt-3"
      >
        <v-expansion-panel-content>
          <template v-slot:actions>
            <v-icon small>
              $vuetify.icons.expand
            </v-icon>
          </template>
          <template
            v-slot:header
            class="pl-0"
          >
            <div class="title">
              Customers
            </div>
            <a
              class="black--text underline text-xs-right mr-2"
              @click.prevent="clearAllCustomers"
            >Clear all</a>
          </template>
          <v-layout
            row
            my-2
          >
            <v-flex
              sm6
              :class="{'pr-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Customer name
                <clear-button
                  v-if="filters.customer_uuid"
                  @clear="filters.customer_uuid = null; $refs.customerName.resetTerm()"
                />
              </v-layout>
              <simple
                ref="customerName"
                url="foodfleet/customers"
                term-param="term"
                results-id-key="uuid"
                :value="filters.customer_uuid"
                placeholder="All customers"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'customer_uuid')"
              />
            </v-flex>
            <v-flex
              sm6
              :class="{'pl-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Customer ID
                <clear-button
                  v-if="filters.customer_uuid"
                  @clear="filters.customer_uuid = null; $refs.customerId.resetTerm()"
                />
              </v-layout>
              <simple
                ref="customerId"
                url="foodfleet/customers"
                term-param="filter[square_id]"
                results-id-key="uuid"
                :value="filters.customer_uuid"
                results-text-key="square_id"
                placeholder="All customers"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'customer_uuid')"
              />
            </v-flex>
          </v-layout>
          <v-layout
            row
            my-2
          >
            <v-flex
              sm6
              :class="{'pr-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Reference ID
                <clear-button
                  v-if="filters.customer_uuid"
                  @clear="filters.customer_uuid = null; $refs.customerReference.resetTerm()"
                />
              </v-layout>
              <simple
                ref="customerReference"
                url="foodfleet/customers"
                term-param="filter[reference_id]"
                results-text-key="reference_id"
                results-id-key="uuid"
                :value="filters.customer_uuid"
                placeholder="All customers"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'customer_uuid')"
              />
            </v-flex>
          </v-layout>
          <v-layout
            row
            my-2
          >
            <v-flex
              sm6
              :class="{'pr-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Staff name
                <clear-button
                  v-if="filters.staff_uuid"
                  @clear="filters.staff_uuid = null; $refs.staffName.resetTerm()"
                />
              </v-layout>
              <simple
                ref="staffName"
                url="foodfleet/staffs"
                term-param="term"
                results-id-key="uuid"
                :value="filters.staff_uuid"
                placeholder="All staff members"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'staff_uuid')"
              />
            </v-flex>
            <v-flex
              sm6
              :class="{'pl-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Staff ID
                <clear-button
                  v-if="filters.staff_uuid"
                  @clear="filters.staff_uuid = null; $refs.staffId.resetTerm()"
                />
              </v-layout>
              <simple
                ref="staffId"
                url="foodfleet/staffs"
                term-param="filter[square_id]"
                results-text-key="square_id"
                results-id-key="uuid"
                :value="filters.staff_uuid"
                placeholder="All staff members"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'staff_uuid')"
              />
            </v-flex>
          </v-layout>
          <v-layout
            row
            my-2
          >
            <v-flex
              sm6
              :class="{'pr-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Device
                <clear-button
                  v-if="filters.device_uuid"
                  @clear="filters.device_uuid = null"
                />
              </v-layout>
              <v-select
                v-model="filters.device_uuid"
                :items="deviceSelectables"
                placeholder="All devices"
                solo
                hide-details
              />
            </v-flex>
          </v-layout>
        </v-expansion-panel-content>
      </v-expansion-panel>
      <v-expansion-panel
        v-model="items"
        expand
        class="mt-3"
      >
        <v-expansion-panel-content>
          <template v-slot:actions>
            <v-icon small>
              $vuetify.icons.expand
            </v-icon>
          </template>
          <template
            v-slot:header
            class="pl-0"
          >
            <div class="title">
              Items
            </div>
            <a
              class="black--text underline text-xs-right mr-2"
              @click.prevent="clearAllItems"
            >Clear all</a>
          </template>
          <v-layout
            row
            my-2
          >
            <v-flex
              sm6
              :class="{'pr-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Category
                <clear-button
                  v-if="filters.category_uuid"
                  @clear="filters.category_uuid = null; $refs.category.resetTerm()"
                />
              </v-layout>
              <simple
                ref="category"
                url="foodfleet/categories"
                term-param="filter[name]"
                results-id-key="uuid"
                :value="filters.category_uuid"
                placeholder="All categories"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'category_uuid')"
              />
            </v-flex>
            <v-flex
              sm6
              :class="{'pl-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Item
                <clear-button
                  v-if="filters.item_uuid"
                  @clear="filters.item_uuid = null; $refs.item.resetTerm()"
                />
              </v-layout>
              <simple
                ref="item"
                url="foodfleet/items"
                term-param="filter[name]"
                results-id-key="uuid"
                :value="filters.item_uuid"
                placeholder="All items"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'item_uuid')"
              />
            </v-flex>
          </v-layout>
          <v-layout
            row
            my-2
          >
            <v-flex
              sm6
              :class="{'pr-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Min price
                <clear-button
                  v-if="filters.min_price"
                  @clear="filters.min_price = null"
                />
              </v-layout>
              <v-text-field
                v-model="filters.min_price"
                solo
              />
            </v-flex>
            <v-flex
              sm6
              :class="{'pl-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Max price
                <clear-button
                  v-if="filters.max_price"
                  @clear="filters.max_price = null"
                />
              </v-layout>
              <v-text-field
                v-model="filters.max_price"
                solo
              />
            </v-flex>
          </v-layout>
        </v-expansion-panel-content>
      </v-expansion-panel>
      <v-expansion-panel
        v-model="payments"
        expand
        class="mt-3 mb-5"
      >
        <v-expansion-panel-content>
          <template v-slot:actions>
            <v-icon small>
              $vuetify.icons.expand
            </v-icon>
          </template>
          <template
            v-slot:header
            class="pl-0"
          >
            <div class="title">
              Payments
            </div>
            <a
              class="black--text underline text-xs-right mr-2"
              @click.prevent="clearAllPayments"
            >Clear all</a>
          </template>
          <v-layout
            row
            my-2
          >
            <v-flex
              sm6
              :class="{'pr-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Payment type
                <clear-button
                  v-if="filters.payment_type_uuid"
                  @clear="filters.payment_type_uuid = null"
                />
              </v-layout>
              <v-select
                v-model="filters.payment_type_uuid"
                :items="paymentTypeSelectables"
                placeholder="All payment types"
                solo
                hide-details
              />
            </v-flex>
            <v-flex
              sm6
              :class="{'pl-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Transaction ID
                <clear-button
                  v-if="filters.transaction_uuid"
                  @clear="filters.transaction_uuid = null; $refs.transactionId.resetTerm()"
                />
              </v-layout>
              <simple
                ref="transactionId"
                url="foodfleet/transactions"
                term-param="filter[square_id]"
                results-text-key="square_id"
                results-id-key="uuid"
                :value="filters.transaction_uuid"
                placeholder="All transactions"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'transaction_uuid')"
              />
            </v-flex>
          </v-layout>
          <v-layout
            row
            my-2
          >
            <v-flex
              sm6
              :class="{'pr-2': $vuetify.breakpoint.mdAndUp}"
            >
              <v-layout
                row
                justify-space-between
                my-2
              >
                Payment ID
                <clear-button
                  v-if="filters.payment_uuid"
                  @clear="filters.payment_uuid = null; $refs.payment.resetTerm()"
                />
              </v-layout>
              <simple
                ref="payment"
                url="foodfleet/payments"
                term-param="filter[square_id]"
                results-text-key="square_id"
                results-id-key="uuid"
                :value="filters.payment_uuid"
                placeholder="All payments"
                background-color="white"
                class="mt-0 pt-0"
                height="48"
                not-clearable
                @input="setValue($event, 'payment_uuid')"
              />
            </v-flex>
          </v-layout>
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-card>
    <v-layout
      row
      py-4
      class="foodfleet-advancedfilter--darkbackground fixed-row"
      :style="width"
    >
      <v-flex
        sm6
        class="mr-2 ml-4"
      >
        <v-btn
          block
          large
          @click="clearAll"
        >
          Clear
        </v-btn>
      </v-flex>
      <v-flex
        sm6
        class="ml-2 mr-4"
      >
        <v-btn
          block
          large
          class="primary"
          :href="searchLink"
        >
          Apply Filters
        </v-btn>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import ClearButton from '~/components/ClearButton.vue'
import Simple from 'fresh-bus/components/search/simple'
import TitleLink from 'fresh-bus/components/TitleLink'
import reduce from 'lodash/reduce'
import isFunction from 'lodash/isFunction'

/**
 * Safe stop event propagation
 *
 * @param event
 */
export function stopEventPropagation (event) {
  if (event && isFunction(event.stopPropagation)) {
    event.stopPropagation()
  }
}

export default {
  components: { ClearButton, Simple, TitleLink },
  props: {
    maxWidthBottomRow: {
      type: Number,
      default: 422
    },
    baseFilters: {
      type: Object,
      default: () => ({})
    },
    advancedFilters: {
      type: Object,
      default: () => ({})
    },
    paymentTypes: {
      type: Array,
      required: true
    },
    devices: {
      type: Array,
      required: true
    }
  },
  data () {
    return {
      events: [true],
      customers: [true],
      items: [true],
      payments: [true],
      filters: {
        ...this.advancedFilters
      }
    }
  },
  computed: {
    paymentTypeSelectables () {
      return this.createSelectables(this.paymentTypes)
    },
    deviceSelectables () {
      return this.createSelectables(this.devices)
    },
    searchLink () {
      let finalFilters = { ...this.baseFilters, ...this.filters }
      let preparedParams = reduce(finalFilters, (result, value, key) => {
        let param = ''
        if (value) {
          if ((Array.isArray(value) && value.length > 0) || !Array.isArray(value)) {
            param = '&' + key + '=' + value
          }
        }
        return result + param
      }, '')
      return '/admin/financials/transactions?' + encodeURI(preparedParams.slice(1))
    },
    width () {
      return {
        'width': this.maxWidthBottomRow + 'px'
      }
    }
  },
  methods: {
    createSelectables (selectables) {
      let mappedSelectables = selectables.map((item) => {
        return { value: item.uuid, text: item.name }
      })
      mappedSelectables.unshift({ value: null, text: 'All' })
      return mappedSelectables
    },
    close () {
      this.$emit('close')
    },
    setValue (object, key) {
      this.filters[key] = object ? object.uuid : null
    },
    clearAllEvents (event) {
      stopEventPropagation(event)
      this.filters.event_tag_uuid = this.filters.location_uuid = null
      this.$refs.eventTag.resetTerm()
      this.$refs.location.resetTerm()
    },
    clearAllCustomers (event) {
      stopEventPropagation(event)
      this.filters.customer_uuid = this.filters.staff_uuid = this.filters.device_uuid = null
      this.$refs.customerName.resetTerm()
      this.$refs.customerId.resetTerm()
      this.$refs.customerReference.resetTerm()
      this.$refs.staffId.resetTerm()
      this.$refs.staffName.resetTerm()
    },
    clearAllItems (event) {
      stopEventPropagation(event)
      this.filters.category_uuid = this.filters.item_uuid = this.filters.min_price = this.filters.max_price = null
      this.$refs.category.resetTerm()
      this.$refs.item.resetTerm()
    },
    clearAllPayments (event) {
      stopEventPropagation(event)
      this.filters.payment_type_uuid = this.filters.transaction_uuid = this.filters.payment_uuid = null
      this.$refs.transactionId.resetTerm()
      this.$refs.payment.resetTerm()
    },
    clearAll () {
      this.clearAllEvents()
      this.clearAllCustomers()
      this.clearAllItems()
      this.clearAllPayments()
    }
  }
}
</script>
<style lang="styl" scoped>
  /deep/ .v-text-field > .v-input__control > .v-input__slot:before {
    border-style: hidden;
  }
  /deep/ .v-text-field--box > .v-input__control > .v-input__slot {
    min-height: 0;
  }
  /deep/ .v-autocomplete.v-text-field--enclosed:not(.v-text-field--solo):not(.v-text-field--single-line) .v-select__slot > input {
    margin-bottom: 7px;
  }
  /deep/ .v-expansion-panel {
    box-shadow: none;
  }
  /deep/ .v-expansion-panel__header {
    padding-left: 0px;
    padding-right: 0px;
  }
  /deep/ .v-expansion-panel__body {
    border-top: 1px dotted #8c8b8b;
  }
  .dotted-bottom {
    border-bottom: 1px dotted #8c8b8b;
  }
  .small-btn {
    width: 25px;
    height: 25px;
  }
  .underline {
    text-decoration: underline;
  }
  .v-card {
    border-radius: 6px 6px 0px 0px;
  }
  /deep/ .v-text-field--box.v-text-field--single-line input {
    margin-top: 0px;
  }
  /deep/ .v-input--checkbox .v-input__slot {
    margin-bottom: 0px;
  }
  .fixed-row {
    position: fixed;
    bottom: 0px;
    width: var(--max-width-bottom-row)px;
  }
  .pb-100 {
    padding-bottom: 100px !important;
  }
  .full-width {
    width: 100%;
  }
  /deep/ .v-autocomplete .v-input__slot {
    padding: 0 12px
  }
  .foodfleet-advancedfilter--darkbackground {
    background-color: #192530
  }
</style>
