<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({

    props: {
        for: {
            type: String,
            required: true
        }
    },
    emits: ['add'],
    methods: {
        addItem() {
            const inputElement = (this.$refs.inputElement as HTMLInputElement);
            const value = inputElement?.value;
            if (value) {
                this.$emit('add', value);
                inputElement.value = ''; // Clear the input after emitting the event
            } else {
                alert('Input must not be blank.')
            }

        }
    }
});


</script>

<template>
    <div class="flex mt-2 space-x-2 w-full">
        <input ref="inputElement" type="text" id="new-task" name="new-task" :placeholder="('Add new ' + this.for)"
               class="bg-gray-50 border-1 border-gray-300 text-gray-900 text-xs
                   rounded-lg focus:ring-blue-500 focus:border-blue-500
                   block w-full md:w-3/4 lg:w-1/2 xl:w-1/2 2xl:w-1/3 p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
        <button type="button" @click="addItem"
                class="bg-blue-500 hover:bg-blue-700 text-white text-xs py-0.5 px-2
            rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Add {{ this.for }}
        </button>
    </div>
</template>

<style scoped>

</style>
