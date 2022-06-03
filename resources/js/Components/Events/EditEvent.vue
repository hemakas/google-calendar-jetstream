<template>
  <v-app>
    <v-form ref="form" @submit.prevent="submit" v-model="valid" lazy-validation class="pa-md-4 mx-lg-auto">

      <!-- title -->
      <v-text-field v-model="form.title" :rules="titleRules" label="Title" required></v-text-field>

      <!-- description -->
      <v-textarea name="input-7-1" v-model="form.description" label="Description" value="" class="mb-4" required></v-textarea>

      <v-row>
        <v-col cols="12" md="3">
          <!-- start date-->
          <v-menu v-model="startDateMenu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
            <template v-slot:activator="{ on, attrs }">
              <v-text-field v-model="form.startDate" label="Start Date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
            </template>
            <v-date-picker v-model="form.startDate" @input="startDateMenu = false"></v-date-picker>
          </v-menu>
        </v-col>
        
        <v-col cols="12" md="3">
          <!-- start time-->
          <v-dialog ref="startTimeRef" v-model="startTimeModal" :return-value.sync="form.startTime" persistent width="290px">
            <template v-slot:activator="{ on, attrs }">
              <v-text-field v-model="form.startTime" label="Start Time" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"></v-text-field>
            </template>
            
            <v-time-picker v-if="startTimeModal" v-model="form.startTime" full-width>
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="startTimeModal = false">
                Cancel
              </v-btn>
              <v-btn text color="primary" @click="$refs.startTimeRef.save(form.startTime)">
                OK
              </v-btn>
            </v-time-picker>
          </v-dialog>
        </v-col>

        <v-col cols="12" md="3">
          <!-- end date-->
          <v-menu v-model="endDateMenu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
            <template v-slot:activator="{ on, attrs }">
              <v-text-field v-model="form.endDate" label="End Date" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
            </template>
            <v-date-picker v-model="form.endDate" @input="endDateMenu = false"></v-date-picker>
          </v-menu>
        </v-col>
        
        <v-col cols="12" md="3">
          <!-- end time-->
          <v-dialog ref="endTimeRef" v-model="endTimeModal" :return-value.sync="form.endTime" persistent width="290px">
            <template v-slot:activator="{ on, attrs }">
              <v-text-field v-model="form.endTime" label="End Time" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"></v-text-field>
            </template>
            
            <v-time-picker v-if="endTimeModal" v-model="form.endTime" full-width>
              <v-spacer></v-spacer>
              <v-btn text color="primary" @click="endTimeModal = false">
                Cancel
              </v-btn>
              <v-btn text color="primary" @click="$refs.endTimeRef.save(form.endTime)">
                OK
              </v-btn>
            </v-time-picker>
          </v-dialog>
        </v-col>
      </v-row>
      
      <v-row>
        <v-col cols="12" md="6" class="mb-4">
          <!-- assignee -->
          <v-select v-model="form.selectedAssignees" :items="items" :menu-props="{ maxHeight: '400' }" label="Assignee" multiple hint="Select whom to assign" persistent-hint></v-select>
        </v-col>
      </v-row>

      <!-- submit button -->
      <v-btn type="submit" :disabled="!valid" color="success" class="mr-4" @click="validate">
        Submit
      </v-btn>

      <!-- reset button -->
      <v-btn color="error" class="mr-4" @click="reset">
        Reset
      </v-btn>

    </v-form>
  </v-app>
</template>

<script>
export default {
  props: {
    event: {},
    assignees: {},
    errors: {}
  },
  
  data () {
    return {
      form: {
        title: this.event.title,
        description: this.event.description,
        startDate: this.event.start.split(" ")[0],
        startTime: this.event.start.split(" ")[1],
        endDate: this.event.end.split(" ")[0],
        endTime: this.event.end.split(" ")[1],
        selectedAssignees: [],
      },
      
      startDateMenu: false,
      startTimeModal: false,
      endDateMenu: false,
      endTimeModal: false,
      valid: true,
      items: [],

      titleRules: [
        v => !!v || 'Title is required'
      ],
      descriptionRules: [
        
      ],
      
    }
  },

  methods: {
    validate () {
      this.$refs.form.validate()

      if (this.valid) {
        this.submit()
      }
    },

    submit() {
      this.$inertia.post(`/events/store`, this.form)
    },

    reset () {
      this.$refs.form.reset()
    },

    resetValidation () {
      this.$refs.form.resetValidation()
    },

    populateAssignee () {
      const items = []
      for (let i = 0; i < Object.keys(this.assignees).length; i++) {
        items.push(this.assignees[i].name + ' - ' + this.assignees[i].email + ' - ' + this.assignees[i].id)
      }

      this.items = items
    },
  },

  mounted () {
    this.populateAssignee ()
  },
}
</script>

<style>

</style>