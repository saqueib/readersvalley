<template>
    <div>
        <input type="file" class="hidden" :id="'imageUpload'+_uid" accept="image/*" v-on:change="uploadSelectedImage">

        <div class="mb-0">
            Please <label :for="'imageUpload'+_uid" class="cursor-pointer underline">upload</label> an image
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    import axios from 'axios';
    export default {
        props: ['postId'],
        data() {
            return {
                imageUrl: '',
                uploadProgress: 100,
            }
        },
        methods: {
            /**
             * Upload the selected image.
             */
            uploadSelectedImage(event) {
                let file = event.target.files[0];
                let formData = new FormData();
                    formData.append('image', file, file.name);

                if(this.postId) {
                    formData.append('post_id', this.postId);
                }

                this.$emit('uploading');
                axios.post('/api/image-upload', formData, {
                    onUploadProgress: progressEvent => {
                        this.$emit('progressing', {progress: Math.round((progressEvent.loaded * 100) / progressEvent.total)});
                    }
                }).then(response => {
                    this.$emit('changed', {url: response.data.url});
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>
