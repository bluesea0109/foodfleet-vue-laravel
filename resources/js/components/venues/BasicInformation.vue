<template>
  <v-card>
    <v-card-title>
      <h3>Basic Information</h3>
      <v-progress-linear
        v-if="loading"
        indeterminate
      />
    </v-card-title>
    <v-divider />
    <v-layout pa-3>
      <v-flex
        xs8
        pr-3
      >
        <v-flex
          xs12
        >
          <div class="mb-2 text-uppercase grey--text font-weight-bold">
            Venue name
          </div>
          <v-text-field
            v-model="name"
            placeholder="Name"
            single-line
            outline
          />
        </v-flex>
        <v-flex
          xs12
        >
          <div class="mb-2 text-uppercase grey--text font-weight-bold">
            Address line 1
          </div>
          <v-text-field
            v-model="address_line_1"
            placeholder="Address 1"
            single-line
            outline
          />
        </v-flex>
        <v-flex
          xs12
        >
          <div class="mb-2 text-uppercase grey--text font-weight-bold">
            Address line 2
          </div>
          <v-text-field
            v-model="address_line_2"
            placeholder="Address 2"
            single-line
            outline
          />
        </v-flex>
        <v-layout row>
          <v-flex xs8>
            <div class="mb-2 text-uppercase grey--text font-weight-bold">
              Owned by
            </div>
            <v-flex
              v-if="hasOwner"
              xs12
              sm6
              md8
              align-center
              layout
            >
              <v-avatar
                :tile="false"
                :size="80"
                color="grey lighten-4"
              >
                <img
                  :src="get(owner, 'avatar')"
                  alt="avatar"
                >
              </v-avatar>
              <div class="mx-2 px-2">
                <div class="primary--text subheading">
                  {{ get(owner, 'name') }}
                </div>
                <div class="grey--text text--darken-2">
                  {{ get(owner, 'email') }}
                </div>
                <div class="grey--text text--darken-2">
                  {{ get(owner, 'mobile_phone') }}
                </div>
              </div>
            </v-flex>
          </v-flex>
          <v-flex
            xs4
            layout
            column
            align-content-center
            justify-center
          >
            <v-dialog
              v-model="changeUserDialog"
              max-width="500"
            >
              <template v-slot:activator="{ on }">
                <v-btn
                  depressed
                  color="primary"
                  @click="changeUserDialog = true"
                >
                  Change user
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <v-layout
                    row
                    space-between
                    align-center
                  >
                    <v-flex>
                      <h4>Change user</h4>
                    </v-flex>
                    <v-btn
                      small
                      round
                      color="grey"
                      class="white--text"
                      @click="changeUserDialog = false"
                    >
                      <v-flex>
                        <v-icon
                          small
                          class="white--text"
                        >
                          fa fa-times
                        </v-icon>
                      </v-flex>
                      <v-flex>
                        Close
                      </v-flex>
                    </v-btn>
                  </v-layout>
                </v-card-title>
                <v-divider />
                <v-card-text>
                  Owner
                  <simple
                    url="users"
                    term-param="term"
                    results-id-key="uuid"
                    :value="owner.uuid"
                    placeholder="Search / Select owner"
                    background-color="white"
                    class="mt-0 pt-0"
                    height="48"
                    not-clearable
                    solo
                    flat
                    @input="selectOwner"
                  />
                </v-card-text>
              </v-card>
            </v-dialog>
          </v-flex>
        </v-layout>
      </v-flex>
      <v-flex
        xs4
        pl-3
      >
        <div>
          MAP coming soon
          <div
            style="background-color: #e5e5e5; width: 100%;
height: 480px"
          />
        </div>
      </v-flex>
    </v-layout>
    <v-divider />
    <v-card-actions class="pa-3 d-flex justify-space-between">
      <div class="d-flex">
        <div>
          <v-btn
            depressed
            @click="onCancel"
          >
            Cancel
          </v-btn>
          <v-btn
            depressed
            color="primary"
            :loading="loading"
            @click="save"
          >
            {{ isEditing ? 'Save Changes' : 'Submit' }}
          </v-btn>
        </div>
        <div class="text-xs-right">
          <v-btn
            depressed
            :loading="loading"
            :disabled="!isEditing"
            @click="onDeleteVenue"
          >
            Delete Venue
          </v-btn>
        </div>
      </div>
    </v-card-actions>
  </v-card>
</template>
<script>
import MapValueKeysToData from '../../mixins/MapValueKeysToData'
import pick from 'lodash/pick'
import keys from 'lodash/keys'
import get from 'lodash/get'
import Simple from 'fresh-bus/components/search/simple'

export const DEFAULT_VENUE = {
  uuid: '',
  name: '',
  address_line_1: '',
  address_line_2: '',
  owner_uuid: '',
  owner: {
    uuid: '',
    name: '',
    email: '',
    mobile_phone: '',
    avatar: ''
  }
}
export default {
  components: {
    Simple
  },
  mixins: [MapValueKeysToData],
  props: {
    loading: { type: Boolean, default: false }
  },
  data () {
    return {
      ...DEFAULT_VENUE,
      changeUserDialog: false
    }
  },
  computed: {
    hasOwner () {
      return get(this.owner, 'uuid')
    },
    isEditing () {
      return this.uuid
    }
  },
  methods: {
    get,
    selectOwner (user) {
      this.owner = Object.assign({}, this.owner, user)
      this.owner_uuid = user.uuid
    },
    onCancel () {
      this.$emit('cancel')
    },
    onDeleteVenue () {
      this.$emit('delete', pick(this, keys(this.value)))
    }
  }
}
</script>
