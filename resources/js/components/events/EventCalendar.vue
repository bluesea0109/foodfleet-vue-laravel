<template>
  <v-container>
    <v-progress-linear
      v-if="isLoading"
      indeterminate
      height="10"
    />
    <v-layout
      wrap
      row
    >
      <v-flex
        xs8
        class="text-xs-left"
      >
        <v-layout
          wrap
          row
        >
          <v-btn
            large
            color="grey"
            class="ml-0 mt-0 white--text"
            @click="moveToToday"
          >
            Today
          </v-btn>
          <v-flex
            xs4
            ml-2
            class="text-xs-left"
          >
            <v-select
              v-model="currentMonth"
              :items="months"
              label="Month"
              solo
              hide-details
            />
          </v-flex>
          <v-flex
            xs2
            ml-3
            class="text-xs-left"
          >
            <v-select
              v-model="currentYear"
              :items="years"
              label="Year"
              solo
              hide-details
            />
          </v-flex>
        </v-layout>
      </v-flex>
      <v-flex
        xs3
        offset-xs1
        class="text-xs-right"
      >
        <v-select
          v-model="type"
          :items="typeOptions"
          label="Type"
          solo
          hide-details
        />
      </v-flex>
      <v-flex
        xs12
        mb-3
        mt-3
      >
        <v-sheet>
          <v-calendar
            ref="calendar"
            v-model="currentDate"
            :type="type"
            color="primary"
          >
            <template v-slot:day="{ date }">
              <template v-for="event in eventsMap[date]">
                <div
                  :key="event.name"
                  full-width
                  offset-x
                  class="white--text clickable"
                  :class="statusColorMaps[event.status_id]"
                  @click="clickEvent(event)"
                  v-text="event.name"
                />
              </template>
            </template>
          </v-calendar>
        </v-sheet>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>

import _ from 'lodash'
import moment from 'moment'

const DATE_FORMAT = 'YYYY-MM-DD'

export default {
  props: {
    events: {
      type: Array,
      default: () => []
    },
    type: {
      type: String,
      default: 'month'
    },
    yearRange: {
      type: Array,
      default: () => [2017, 2020]
    },
    date: {
      type: String,
      default: '2019-1-1'
    }
  },
  data () {
    const currentDate = moment(this.date)
    return {
      typeOptions: [
        { text: 'Day', value: 'day' },
        { text: '4 Day', value: '4day' },
        { text: 'Week', value: 'week' },
        { text: 'Month', value: 'month' }
      ],
      years: _.range.apply(this, this.yearRange),
      months: [
        { text: 'January', value: 1 },
        { text: 'February', value: 2 },
        { text: 'March', value: 3 },
        { text: 'April', value: 4 },
        { text: 'May', value: 5 },
        { text: 'June', value: 6 },
        { text: 'July', value: 7 },
        { text: 'August', value: 8 },
        { text: 'September', value: 9 },
        { text: 'October', value: 10 },
        { text: 'November', value: 11 },
        { text: 'December', value: 12 }
      ],
      currentMonth: currentDate.month() + 1,
      currentYear: currentDate.year(),
      currentDate: currentDate.format(DATE_FORMAT),
      statusColorMaps: {
        1: 'accent',
        2: 'warning',
        3: 'success',
        4: 'secondary',
        5: 'accent'
      }
    }
  },
  computed: {
    eventsMap () {
      return this.scheduleHandle()
    }
  },
  watch: {
    currentYear (yearValue) {
      this.moveDate({
        month: this.currentMonth,
        year: yearValue
      })
    },
    currentMonth (monthValue) {
      this.moveDate({
        month: monthValue,
        year: this.currentYear
      })
    }
  },
  methods: {
    moveToToday () {
      const calendarToday = this.$refs.calendar.times.today
      this.currentYear = calendarToday.year
      this.currentMonth = calendarToday.month
    },
    scheduleHandle () {
      const map = {}
      this.events.forEach(evt => {
        const occurrences = _.get(evt, 'schedule.schedule_occurrences', null)
        if (_.isEmpty(occurrences)) {
          const startMoment = moment(evt.start_at, DATE_FORMAT)
          const endMoment = moment(evt.end_at, DATE_FORMAT)
          let startDate = startMoment.format(DATE_FORMAT)
          const endDate = endMoment.format(DATE_FORMAT)
          while (startDate <= endDate) {
            map[startDate] = map[startDate] || []
            map[startDate].push(evt)
            startDate = startMoment.add(1, 'days').format(DATE_FORMAT)
          }
        } else {
          occurrences.forEach(occurrence => {
            const startAt = moment(occurrence.start_at, DATE_FORMAT).format(DATE_FORMAT)
            map[startAt] = map[startAt] || []
            map[startAt].push(evt)
          })
        }
      })
      return map
    },
    moveDate (date) {
      const currentDate = moment(this.currentDate)
      let years = 0
      let months = 0
      if (date.year) {
        years = date.year - currentDate.year()
      }
      if (date.month) {
        months = date.month - (currentDate.month() + 1)
      }
      this.$emit('change-date', date)
      this.$refs.calendar.move(years * 12 + months)
    },
    clickEvent (evt) {
      this.$emit('click-event', evt)
    }
  }
}

</script>

<style>
  .v-calendar-weekly__day {
    overflow: visible;
  }
  .clickable {
    cursor: pointer;
  }
</style>
