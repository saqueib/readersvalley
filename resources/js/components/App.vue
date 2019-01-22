<script type="text/ecmascript-6">
    import _ from 'lodash'
    import axios from 'axios'
    import {slugify} from "../utils";

    export default {
        name: 'App',

        data() {
            return {
                tags: [],
                imageUploading: false,
                draft: true,
                showPublishModal: false,
                showPublishModal: false,
                publishing: false,
                uploading: false,

                post: {
                    title: '',
                    slug: '',
                    body: '',
                    featured_image: '',
                    tags: [],
                    meta: {
                        discription: ''
                    },
                },
                saving: false
            }
        },

        mounted () {
            this.$Progress.finish()

            if(window.App.post.id) {
                this.post = window.App.post;
                this.tags = window.App.tags;
                this.draft = false;
            }
        },

        created () {
            this.$Progress.start()
        },

        methods: {
            /**
             * Update the post body
             */
            updatePostBody(content) {
                this.post.body = content
            },

            /**
             * Show publishing modal.
             */
            showPublishingModal() {
                if(!this.draft) {
                    this.showPublishModal = true;
                }
            },

            /**
             * Close the publishing modal.
             */
            closePublishingModal() {
                this.showPublishModal = false;
            },

            /**
             * Publish post.
             */
            publishPost() {
                this.post.published_at = 'now'
                this.publishing = true;
                this.savePost();
                this.closePublishingModal();
                window.location.reload();
            },

            /**
             * Update posts featured image.
             */
            updateFeaturedImage({url}) {
                this.post.featured_image = url;
                this.savePost();
            },

            /**
             * Save a post.
             */
            savePost() {
                this.saving = true
                let method = this.post.id ? 'put' : 'post';
                let url = this.post.id ? `/api/posts/${this.post.id}` : '/api/posts/';
                this.post.tags = this.post.tags.map((item) => item.slug ? item.slug : item);

                return axios({method, url, data: this.post}).then(({data}) => {
                    this.saving = this.publishing = false

                    if(data.id) {
                        if(this.draft) {
                            // update the url
                            window.history.pushState({}, "", `${data.id}/edit`);
                            window.location.reload();
                        }

                        this.post = data
                    }
                    }).catch((err) => {
                        this.saving = this.publishing  = false
                    })
            },

            /**
             * Add new tag.
             */
            addTag(tag) {
                this.post.tags.push(tag)
            },

            /**
             * Tag label.
             */
            customLabel(item) {
                if(item.slug) return item.slug

                return item;
            }
        },

        watch: {
            'post.title': _.debounce(function(val) {
                if (val) this.post.slug = slugify(val);
            }, 600),
            'post.body': _.debounce(function(val) {
                if (val && this.post.title && !this.showPublishModal) this.savePost()
            }, 5000)
        },

        computed: {
            isPublishable() {
                return this.post.title && this.post.body;
            },
            allTags() {
                return this.tags;
            }
        }
    }
</script>
