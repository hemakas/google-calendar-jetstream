<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Events Create
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <edit-event 
                    :event="event" 
                    :assignees="assignees" 
                    :errors="errors" 
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EditEvent from '@/Components/Events/EditEvent'

    export default {
        components: {
            AppLayout,
            EditEvent,
        },

        props: {
            event: {},
            assignees: {},
            errors: {}
        }
    }
</script>
