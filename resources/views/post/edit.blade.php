@extends('layouts.app')
@section('title', 'Editing '.$post->title)

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-3/4 mb-6">
                <div class="mb-10">
                    <input v-model="post.title" value="{{ $post->title }}" type="text" class="inline mb-10 w-full outline-none font-normal text-3xl" placeholder="Post title..." />
                    <editor @opening-image-uploader="imageUploaderOpen" value="{{ $post->body }}" @input="updatePostBody"></editor>
                </div>
            </div>
        </div>
    </div>

    <modal v-if="showPublishModal" @close="closePublishingModal">
        <h2 class="font-semibold mb-5">@{{ post.published_at ? 'Update Post' : 'Publish Now' }}</h2>

        <div>
            <div class="input-group">
                <img v-if="post.featured_image" :src="post.featured_image" class="mb-3 max-w-full">

                <label class="input-label">Featured Image</label>
                <image-picker key="featuredImgUploader"
                              class="mt-5"
                              :post-id="post.id"
                              @changed="updateFeaturedImage"
                              @uploading="uploading = true"></image-picker>
            </div>

            <div class="input-group">
                <label class="input-label">Slug</label>
                <input rows="2" v-model="post.slug" ref="slug" class="input" placeholder="Post slug"/>
            </div>

            <div class="input-group">
                <label class="input-label mb-3">Tags</label>
                <multiselect
                        v-model="post.tags"
                        tag-placeholder="Add this as new tag"
                        placeholder="Search or add a tag"
                        :custom-label="customLabel"
                        :options="allTags"
                        :multiple="true" :taggable="true" @tag="addTag"></multiselect>
            </div>

        </div>

        <button class="btn-sm btn-outline mt-10" @click="publishPost">
            @{{ post.published_at ? 'Update' : 'Publish' }}
        </button>

        <button v-if="!post.published_at" :class="{'loading': saving}" class="btn-sm btn-secondary mt-10" @click="savePost">
            @{{ saving ? 'Saving...' : 'Save Draft' }}
        </button>
        <button class="btn-clear text-grey mt-10" @click="closePublishingModal">Cancel</button>

        <span class="p-px-2 text-grey-dark" v-if="publishing">Publishing...</span>

    </modal>
@endsection

@push('header')
    <script>
        window.App.post = @json($post);
        window.App.tags = @json($tags);
    </script>
@endpush
