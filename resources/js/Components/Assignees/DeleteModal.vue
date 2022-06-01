<template>
    <v-dialog v-model="dialog" width="500">
        <template v-slot:activator="{ on, attrs }">
            <v-btn text color="red lighten-2" dark v-bind="attrs" v-on="on">Delete</v-btn>
        </template>
        
        <v-card>
            <v-card-title class="text-h5 red lighten-2">Delete Confirmation</v-card-title>
            
            <v-spacer></v-spacer>
            
            <v-card-text class="mt-4">Are you sure you want to delete this record?</v-card-text>
            
            <v-divider></v-divider>
            
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" text @click="onClickYes">Yes</v-btn>
                <v-btn color="secondary" text @click="dialog = false">No</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>
</template>

<script>
export default {
    name: "DeleteModal",

    props: ["deleteId"],

    data() {
        return {
            dialog: false,
        }
    },

    methods: {
        onClickYes () {
            this.dialog = false
            this.$emit('delete-confirmation', this.deleteId) 
        }
    }

}
</script>

<style>

</style>