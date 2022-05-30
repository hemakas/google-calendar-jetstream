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
                <tr v-for="event in events" :key="event.id" class="bg-white border-b">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ event.id }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ event.title }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ event.description }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ event.start }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ event.end }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    assigned to
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    assigned by
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <div class="flex items-center justify-center">
                      <div class="inline-flex" role="group">
                        
                        <a :href="`events/${event.id}/edit`" class="text-green-500 hover:text-green-600 transition duration-300 ease-in-out mr-4">Edit</a>
                        
                        <form @submit.prevent="deleteEvent(event.id)">
                          <button type="submit" class="text-red-600 hover:text-red-700 transition duration-300 ease-in-out" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete</button>
                        </form>

                      </div>
                    </div>
                  </td>

                  <!-- delete confirmation modal -->
                  <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog relative w-auto pointer-events-none">
                      <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                          <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Delete confirmation</h5>
                          <button type="button" class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body relative p-4">Are you sure you want to delete this recored?</div>
                        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">

                          <!-- confirm delete button  -->
                          <form @submit.prevent="submit">
                            <button type="submit" class="inline-block px-6 py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out mr-3">Ok</button>
                          </form>

                          <!-- modal close button -->
                          <button type="button" class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">Cancle</button>
                        </div>
                      </div>
                    </div>
                  </div>
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
      deleteEvent(id) {
        this.deleteId = id
      },
      
      submit() {
        this.$inertia.delete(`/events/${this.deleteId}`)
        location.reload()
      },
    },

}
</script>

<style>

</style>