@extends('layouts.app')
@section('title', 'New Posts')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-center pt-5">
            <div class="w-3/4">
                <input v-model="post.title" type="text" class="inline mb-10 w-full outline-none font-normal text-3xl" placeholder="Post title..." />
                <editor @openingImageUploader="showModal('image-uploader')" @input="updatePostBody"></editor>
            </div>
        </div>
    </div>
@endsection
