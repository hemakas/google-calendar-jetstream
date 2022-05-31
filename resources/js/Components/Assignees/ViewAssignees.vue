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
                <tr v-for="assignee in assignees" :key="assignee.id" class="bg-white border-b">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ assignee.id }}
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
                        
                        <a :href="`assignees/${assignee.id}/edit`" class="text-green-200 hover:text-blue-600 transition duration-300 ease-in-out mr-4">Edit</a>
                        
                        <!-- <form @submit.prevent="deleteAssignee(assignee.id)">
                          <button type="submit" class="text-red-400 hover:text-red-600 transition duration-300 ease-in-out" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                        </form> -->

                      </div>
                    </div>
                  </td>

                  <delete-modal />

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
      this.$options.components.DeleteModal = require('./DeleteModal.vue').default
    },
    
    data() {
      return {
        deleteId: null,
      }
    },
      
      components: {
          // Pagination
        },

      props: {
        assignees: {},
      },
      
      methods: {
        deleteAssignee(id) {
          this.deleteId = id
        },
        
        submit() {
          this.$inertia.delete(`/assignees/${this.deleteId}`)
          location.reload()
        },
      },

  }
</script>

<style>

</style>