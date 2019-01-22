<template>
    <button @click="process" :class="{'loading': loading}" class="text-red-darker outline-none appearance-none no-underline text-sm">
        <slot>Delete</slot>
    </button>
</template>

<script type="text/ecmascript-6">
    import axios from 'axios';
    import { findAncestor } from "../utils";

    export default {
        name: 'ActionBtn',
        props: {
            url: {default:''},
            deleteElement: null,
            payload: {},
            method: {default: 'delete'}
        },
        data() {
            return {
                loading: false
            }
        },
        methods: {
            beforeAction() {
                return window.confirm('Are you sure you want to do this?');
            },

            process() {
                if(this.beforeAction()) {
                    this.$Progress.start()
                    axios({
                        method: this.method,
                        url: this.url,
                        data: this.payload || {}
                    }).then(this.afterAction).catch((err) => {
                        this.$Progress.finish()
                        this.$emit('error', err)
                    })
                }
            },

            afterAction(res) {
                this.$Progress.finish()

                if(this.deleteElement) {
                    findAncestor(this.$el, this.deleteElement).classList.remove('flex')
                    findAncestor(this.$el, this.deleteElement).classList.add('hidden')
                }
            }
        }
    }
</script>
