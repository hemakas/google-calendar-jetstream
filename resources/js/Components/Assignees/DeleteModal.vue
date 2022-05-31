<template>
    <v-dialog v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="red lighten-2" dark v-bind="attrs" v-on="on">Delete</v-btn>
        </template>
        
        <v-card>
            <v-card-title class="text-h5 grey lighten-2">Delete Confirmation</v-card-title>
            
            <v-card-text>Are you sure you want to delete this record?</v-card-text>
            
            <v-divider></v-divider>
            
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" text @click="dialog = false">Yes</v-btn>
                <v-btn color="primary" text @click="dialog = false">No</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>
</template>

<script>
export default {
    name: "DeleteModal",

    data() {
        return {
            dialog: false,
        }
    },

}
</script>

<style>

</style>