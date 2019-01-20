<template>
    <transition name="modal">
        <div v-if="isModalOpen" class="modal-mask" :class="{ fixed: fixed }">
            <div class="modal-wrapper">
                <div class="modal-container" :class="modalClasses">

                    <a class="float-right cursor-pointer text-grey hover:text-grey-dark text-3xl font-light appearance-none" @click="close()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>

                    <div class="modal-body">
                        <slot> Body Content... </slot>
                    </div>

                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'modal',
        props: {
            id: {default: 'modalBox'},
            fixed: {default: false},
            size: {default: 'medium'},
            modalClass: {default: ''},
            shown: null
        },

        created() {
            this.close();
            document.addEventListener('keydown', this.handleEscape);
            document.body.classList.add('overflow-hidden');
        },

        destroyed() {
            document.removeEventListener('keydown', this.handleEscape);
            document.body.classList.remove('overflow-hidden');
        },

        computed: {
            isModalOpen() {
                if (this.$root.modals[this.id + 'IsOpen']) {

                    if (typeof this.shown === "function") {
                        this.shown();
                    }

                    return true;
                }

                return false;
            },

            modalClasses() {
                return `${this.modalClass} ${this.size} rounded shadow`;
            }
        },

        methods: {
            close() {
                this.$root.$set(this.$root.modals, this.id + 'IsOpen', false);
            },
            handleEscape(e) {
                e.stopPropagation();
                if (e.keyCode == 27) {
                    this.close();
                }
            }
        }
    }
</script>

<style>
    .modal-mask {
        position: absolute;
        z-index: 1050;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: table;
        transition: opacity .3s ease;
        background: rgba(255, 255, 255, 0.75);
    }

    .modal-mask.fixed {
        position: fixed;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 70%;
        min-width: 300px;
        margin: 1em auto;
        padding: 0.5em 1em;
        transition: all .3s ease;
    }

    .modal-container.large {
        width: 70%;
        min-width: 300px;
    }

    .modal-container.medium {
        width: 60%;
        min-width: 260px;
    }

    .modal-container.small {
        width: 40%;
        min-width: 200px;
        padding: 6px 30px;
    }

    .modal-header > h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

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
