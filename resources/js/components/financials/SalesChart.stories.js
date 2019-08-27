import { storiesOf } from '@storybook/vue'

// Components
import SalesChart from './SalesChart.vue'

const sales = [
  { value: 4, date: '2018-03-01' },
  { value: 10, date: '2018-03-02' },
  { value: 20, date: '2018-03-03' },
  { value: 12, date: '2018-03-04' },
  { value: 32, date: '2018-03-05' },
  { value: 7, date: '2018-03-06' },
  { value: 7, date: '2018-03-07' }
]

storiesOf('FoodFleet|financials/SalesChart', module)
  .addParameters({
    backgrounds: [
      { name: 'white', value: '#c5dbe3', default: true },
      { name: 'blue', value: '#205a80' }
    ]
  })
  .add('default title', () => {
    return {
      components: { SalesChart },
      data () {
        return {
          sales: sales
        }
      },
      template: `
          <v-container>
            <v-layout row>
              <v-flex xs12 sm8>
                <v-card class="pa-4">
                  <sales-chart
                      :sales="sales"
                  />
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
      `
    }
  })
  .add('custom title', () => {
    return {
      components: { SalesChart },
      data () {
        return {
          sales: sales
        }
      },
      template: `
        <v-container>
          <v-layout row>
            <v-flex xs12 sm8>
              <v-card class="pa-4">
                <sales-chart
                    title="Different title"
                    :sales="sales"
                />
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
    `
    }
  })
