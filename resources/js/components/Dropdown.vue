<template>
    <div v-click-outside="hide">
        <div v-on:click.prevent="toggle">
            <slot name="trigger"></slot>
        </div>
        <slot name="content" v-if="isVisible"></slot>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                isVisible: false
            }
        },
        watch: {
            isVisible(val) {
                if (val) {
                    this.$emit('showing');
                }
            }
        },
        methods: {
            toggle() {
                this.isVisible = !this.isVisible;
            },
            hide() {
                this.isVisible = false;
            },
        }
    }
</script>
