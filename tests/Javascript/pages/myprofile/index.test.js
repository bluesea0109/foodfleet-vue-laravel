import { mount } from '@vue/test-utils'
import createLocalVue from 'vue-cli-plugin-freshinup-ui/utils/testing/createLocalVue'
import { FIXTURE_USER } from 'tests/__data__/user'
import Component from '~/pages/myprofile/index.vue'
import createStore from 'tests/createStore'

describe('My profile page', () => {
  let localVue, mock, store
  beforeEach(() => {
    const vue = createLocalVue({ validation: true })
    localVue = vue.localVue
    mock = vue.mock
    mock
      .onGet('api/currentUser').reply(200, FIXTURE_USER)
      .onGet('api/users/1').reply(200, { data: FIXTURE_USER })
      .onAny().reply(config => {
        console.warn('No mock match for ' + config.url, config)
        return [404, {}]
      })
    store = createStore({
      currentUser: FIXTURE_USER
    })
  })
  afterEach(() => {
    mock.restore()
  })
  it('snapshot of page', async () => {
    const wrapper = mount(Component, {
      localVue: localVue,
      store
    })
    expect(wrapper.element).toMatchSnapshot()
  })
})
