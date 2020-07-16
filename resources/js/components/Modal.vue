<template>
    <div class="modal__container fixed w-screen h-screen top-0 left-0 grid grid-center grid-cols-3" :class="{hidden: modalhidden}">
        <div class="modal__overlay absolute w-full h-full bg-gray-500 opacity-25"></div>

        <div class="modal col-start-2 col-span-1 w-full relative bg-white rounded-lg shadow-lg flex flex-col justify-between">

            <div class="modal__header m-2 px-4 py-2 border-b-2 border-gray-300">
                <div class="modal__header__title">
                    <h1 class="text-lg text-gray-600 uppercase font-medium">{{ title }}</h1>
                </div>
                
                <div
                    @click="closeModal()"
                    class="modal__header__close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 p-1 text-gray-800 text-sm z-50 rounded-full hover:text-white hover:bg-red-400"
                >
                    <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>

            <div class="modal__body m-2 px-2 py-1 pb-4 flex flex-col">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title'],

        data() {
            return {
                modalhidden: true
            }
        },

        methods: {
            closeModal() {
                this.modalhidden = true
            },
            openModal() {
                this.modalhidden = true
            },
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
