<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Assignee Edit
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <edit-assignee :assignee="assignee" :errors="errors"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import EditAssignee from '@/Components/Assignees/EditAssignee'

    export default {
        components: {
            AppLayout,
            EditAssignee,
        },

        props: {
            assignee: {},
            errors: {}
        }
    }
</script>
