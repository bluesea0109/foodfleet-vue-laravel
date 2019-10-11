<template>
  <v-layout
    column
    fill-height
  >
    <v-layout
      row
      class="subheading font-weight-bold"
    >
      <v-flex
        v-if="uploading"
      >
        <v-progress-linear v-model="uploadPercentage" />
        <div>{{ uploadPercentage }}%</div>
      </v-flex>
      <v-flex
        v-else
      >
        <div>File: {{ value.name }}</div>
      </v-flex>
    </v-layout>
    <v-layout
      row
      wrap
      justify-space-between
    >
      <v-flex
        xs5
      >
        <v-btn
          block
          color="primary"
          @click="launchFilePicker"
        >
          Upload file
        </v-btn>
      </v-flex>
      <v-flex
        xs5
      >
        <v-btn
          block
          color="error"
          @click="remove"
        >
          Delete File
        </v-btn>
      </v-flex>
    </v-layout>

    <input
      v-show="false"
      ref="file"
      type="file"
      @change="onFileChange($event.target.files)"
    >

    <!-- error dialog displays any potential errors -->
    <v-dialog
      v-model="errorDialog"
      max-width="300"
    >
      <v-card>
        <v-card-text class="subheading">
          {{ errorText }}
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn
            flat
            @click="errorDialog = false"
          >
            Got it!
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>

const MB = 1024 * 1024

export default {
  name: 'FileUploader',
  model: {
    prop: 'value',
    event: 'onValueChange'
  },
  props: {
    value: {
      type: Object,
      default: () => {
        return { name: '', src: '' }
      }
    },
    maxFileSize: {
      type: Number,
      default: 100
    }
  },
  data () {
    return {
      cancel: '',
      errorDialog: false,
      errorText: '',
      uploadPercentage: 0,
      uploading: false
    }
  },
  computed: {
    maxInBytes () {
      return MB * this.maxFileSize
    }
  },
  methods: {
    launchFilePicker () {
      this.$refs.file.click()
    },
    async onFileChange (file) {
      if (file.length > 0) {
        let fileSouce = file[0]
        let size = fileSouce.size - this.maxInBytes

        if (size > 1) {
          this.showError(`Your file is too big! Please select a file under ${this.maxFileSize}MB`)
        } else {
          // const fileSrc = await this.submitFile(fileSouce)
          const fileSrc = 'mock'
          if (fileSrc) {
            this.$emit('onValueChange', { name: fileSouce.name, src: fileSrc })
          }
        }
      }
    },
    showError (text) {
      this.errorText = text
      this.errorDialog = true
    },
    remove () {
      this.$refs.file.value = ''
      this.$emit('onValueChange', { name: '', src: '' })
    }
  }
}
</script>

<style scoped>

</style>