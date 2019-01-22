<template>
    <transition name="modal">
        <div class="z-50 fixed pin overflow-y-scroll modal-mask" @click="handleClicks">
            <div class="bg-white rounded shadow-lg max-w-md mx-auto my-10 p-5 modal-container">
                <slot/>
            </div>
        </div>
    </transition>
</template>

<script type="text/ecmascript-6">
    export default {
        data() {
            return {}
        },
        created() {
            document.addEventListener('keydown', this.handleEscape);
            document.body.classList.add('overflow-hidden');
        },
        destroyed() {
            document.removeEventListener('keydown', this.handleEscape);
            document.body.classList.remove('overflow-hidden');
        },
        methods: {
            /**
             * Handle esc button
             */
            handleEscape(e) {
                e.stopPropagation();

                if (e.keyCode == 27) {
                    this.close();
                }
            },

            /**
             * Close the modal.
             */
            close() {
                this.$emit('close');
            },

            /**
             * Handle a click on the modal.
             */
            handleClicks(e) {
                if (e.target.classList.contains('modal-mask')) {
                    this.close();
                }
            }
        }
    }
</script>

<style>
    .modal-mask {
        background: rgba(255, 255, 255, 0.75);
    }

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>
