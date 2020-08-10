<template>
<v-hover :disabled="!editable">
    <template v-slot:default="{ hover }">
        <v-card flat :width="width" :height="height">
            <v-img
                :ref="ref"
                :src="src"
                width="100%" height="100%"
                contain
            >
                <template v-slot:placeholder>
                    <v-skeleton-loader
                        type="image"
                        width="100%" height="100%"
                        :boilerplate="false"
                        class="mx-auto"
                    />
                </template>
            </v-img>
            <v-fade-transition>
                <v-overlay v-if="hover" absolute>
                    <v-file-input
                        prepend-icon="mdi-upload"
                        accept="image/*"
                        hide-input rounded dark
                        @change="imgSelected"
                    />
                </v-overlay>
            </v-fade-transition>
        </v-card>
    </template>
</v-hover>
</template>

<script>
import Helper from "@/util/Helper";
export default {
    name: 'editableImage',
    props: {
        editable: {
            default: true,
            type: Boolean,
            required: false,
        },
        src: {
            type: String,
        },
        width: {
            default: '100%',
            required: false,
        },
        height: {
            default: '100%',
            required: false,
        }
    },
    data: () => ({
        ref: Helper.randStr(),
        modal: false,
        newImg: null,
    }),
    methods: {
        imgSelected(file) {
            const vm = this
            let fr = new window.FileReader()
            this.newImg = file
            const previewSelected = function () {
                // console.log(vm.$refs[vm.ref])
                vm.$emit('image:changed', {file, base64: fr.result})
                // vm.$refs[vm.ref].$props.src = fr.result
            }
            fr.addEventListener('load', previewSelected)
            fr.readAsDataURL(this.newImg)
        }
    },
}
</script>