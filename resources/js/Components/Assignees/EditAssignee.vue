<template>
  <v-app>
    <v-form ref="form" @submit.prevent="submit" v-model="valid" lazy-validation class="pa-md-6">
      <v-row class="justify-center">
        <v-col cols="12" md="6">
      
          <!-- name -->
          <v-text-field v-model="form.name" :rules="nameRules" label="Name" required></v-text-field>
          <p v-if="errors.name" class="text-red-500 text-xs italic mt-3">{{ errors.name }}</p>

          <!-- email -->
          <v-text-field v-model="form.email" :rules="emailRules" label="Email" required></v-text-field>
          <p v-if="errors.email" class="text-red-500 text-xs italic mt-3">{{ errors.email }}</p>

          <!-- save button -->
          <v-btn type="submit" :disabled="!valid" color="success" class="mr-4" @click="validate">
            Save
          </v-btn>

          <!-- reset button -->
          <v-btn color="error" class="mr-4" @click="reset">
            Clear
          </v-btn>
        </v-col>
      </v-row>
    </v-form>
  </v-app>
</template>


<script>
export default {
  
  props: {
    assignee: {},
    errors: {}
  },

  data () {
    return {
      form: {
        name: this.assignee.name,
        email: this.assignee.email,
      },
      
      valid: true,

      nameRules: [
        v => !!v || 'Title is required',
        v => v.length <= 35 || 'Max 35 characters allowed'
      ],
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+/.test(v) || 'E-mail must be valid',
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
      this.$inertia.put(`/assignees/${this.assignee.id}`, this.form)
    },

    reset () {
      this.$refs.form.reset()
    },

  },
}
</script>

<style>

</style>