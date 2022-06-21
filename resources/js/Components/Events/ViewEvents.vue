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
                    Title
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                    Description
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                    Started on
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                    Ended on
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                    Assigned to
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                    Assigned by
                  </th>
                  <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4">
                    Action
                  </th>
                </tr>
              </thead>
              
              <tbody>
                <!-- table data -->
                <tr v-for="(event, index) in events" :key="event.id" class="bg-white border-b">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ index + 1 }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ event.title }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ event.description }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <span class="text-blue-600">{{ formatDateTime(event.start) }}</span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <span class="text-red-600">{{ formatDateTime(event.end) }}</span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <ul>
                      <li v-for="(user, index) in event.users" :key="user.id">
                        {{ index + 1 }} / {{ user.name }}
                      </li>
                    </ul>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                   Assigend by
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <div class="flex items-center justify-center">
                      <div class="inline-flex" role="group">
                      
                        <!-- edit button -->
                        <v-btn text color="blue lighten-2" :href="`events/${event.id}/edit`" dark>Edit</v-btn>
                        
                        <!-- delete button -->
                        <delete-modal :deleteId="event.id" @delete-confirmation="deleteConfirmation"/>

                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- pagination -->
          <!-- <pagination class="mg-1" :links="events.links"/> -->

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
        deleteId: null
      }
    },
    
    components: {
        // Pagination
      },

    props: {
      events: {},
    },
    
    methods: {
      deleteConfirmation (id) {
        this.$inertia.delete(`/events/${id}`)
        location.reload()
      },

      formatDateTime (date) {
        date = new Date(date)
        
        let year = date.getFullYear()
        let month = (1 + date.getMonth()).toString().padStart(2, '0')
        let day = date.getDate().toString().padStart(2, '0')

        let hour = date.getHours()
        let hours = ((hour + 11) % 12 + 1)

        let minutes = date.getMinutes()
        minutes = minutes == 0 ? "00" : minutes
        
        let suffix = hour >= 12 ? "PM" : "AM";

        return month + '/' + day + '/' + year + ' | ' + hours + ':' + minutes + ' ' + suffix;
      },
    },

    

}
</script>

<style>

</style>