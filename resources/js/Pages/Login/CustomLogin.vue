<template>
  <v-row justify="center">
    <v-col cols="12" sm="10" md="8" lg="6">
      <v-divider class="mt-36"></v-divider>
      <v-card>
        
        <v-card-title> Login </v-card-title>
        
        <v-form ref="form" @submit.prevent="submit" v-model="valid" lazy-validation class="pa-md-6">
          <v-card-text>          
            <!-- email -->
            <v-text-field ref="email" v-model="email" :rules="emailRules" :error-messages="errorMessages" label="Email"></v-text-field>

            <!-- password -->
            <v-text-field ref="password" v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="passwordRules" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Password" @click:append="show1 = !show1"></v-text-field>
          </v-card-text>
          
          <v-card-actions>
            <v-btn class="mr-4" @click="reset" text>Reset</v-btn>
            
            <!-- <v-spacer></v-spacer> -->

            <v-btn type="submit" :disabled="!valid" class="mr-4" @click="validate" text>Login</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>  
  export default {
    
    props: {
      errors: {}
    },
    
    data () {
      return {
        form: {
          email: null,
          password: null,
        },
        
        emailRules: [
          v => !!v || 'E-mail is required',
          v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        
        passwordRules: [
          v => !!v || 'Password is required'
        ],

        valid: true,
        show1: false,
      }
    },

    watch: {
      name () {
        this.errorMessages = ''
      },
    },

    methods: {
      validate () {
        this.$refs.form.validate()

        if (this.valid) {
          this.$inertia.post(`/custom_login/validate`, this.form)
        }
      },

      reset () {
        this.$refs.form.reset()
      },


    },
  }
</script>

<style>

</style>