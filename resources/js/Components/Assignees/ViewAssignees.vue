<template>
  <v-app>
    
    <div class="flex flex-col">
      <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-4 inline-block min-w-full sm:px-6 lg:px-8">
          <div class="overflow-hidden">
            
            <table class="min-w-full text-center">
              <thead class="border-b bg-gray-50">
                <tr>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                    #
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                    Name
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                    Email Address
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                    Action
                  </th>
                </tr>
              </thead>
              
              <tbody>
                <!-- table data -->
                <tr v-for="(assignee, index) in assignees" :key="assignee.id" class="bg-white border-b">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ index + 1 }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ assignee.name }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ assignee.email }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <div class="flex items-center justify-center">
                      <div class="inline-flex" role="group">
                        
                        <!-- edit button -->
                        <v-btn text color="blue lighten-2" :href="`assignees/${assignee.id}/edit`" dark>Edit</v-btn>
                        
                        <!-- delete button -->
                        <delete-modal :deleteId="assignee.id" @delete-confirmation="deleteConfirmation"/>

                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>

            </table>
          </div>

          <!-- pagination -->
          <!-- <pagination class="mg-1" :links="assignees.links"/> -->

        </div>
      </div>
    </div>
    
  </v-app>
</template>

<script>

  export default {
    beforeCreate: function () {
      this.$options.components.DeleteModal = require('../Elements/DeleteModal.vue').default
    },
    
    data() {
      return {
        deleteId: null,
      }
    },

    props: {
      assignees: {},
    },
    
    methods: {
      deleteConfirmation (id) {
        this.$inertia.delete(`/assignees/${id}`)
        location.reload()
      }
    },

  }
</script>

<style>

</style>