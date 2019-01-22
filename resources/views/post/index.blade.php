@extends('layouts.app')
@section('title', 'My Posts')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-3/4 mb-6">

                <div class="mb-10">
                    <h1 class="inline font-normal text-3xl mr-auto">My Posts</h1>
                </div>

                @forelse($posts as $post)
                    <div class="my-story flex mb-4 py-3 items-center">
                        <div title="Getting Started with Gatsby and WordPress" class="py-4">
                            <h2 class="text-2xl font-normal mb-3">
                                <a href="{{ route('posts.show', $post->slug) }}" class="no-underline text-black">
                                    {{ $post->title }}
                                </a>
                            </h2>
                            <p class="mb-3 leading-normal text-grey-darkest">
                                {{ str_limit(strip_tags($post->body), 200) }}
                            </p>
                            <small class="text-grey-dark">
                                @if(is_null($post->published_at))
                                    <span class="text-red">Draft</span>
                                @else
                                    <span>Published {{ $post->published_at->diffForHumans() }}</span>
                                @endif
                                @if($post->tags->count())
                                    in {{ $post->tags->pluck('name')->implode(', ') }}
                                @endif
                                — <span>Updated {{ $post->updated_at->diffForHumans() }}</span>
                                - <a class="no-underline text-black hover:underline" href="{{ route('posts.edit', $post->id) }}">Edit</a>
                                — <action-btn delete-element=".my-story" url="{{ route('api.posts.destroy', $post->id) }}">Delete</action-btn>
                            </small>
                        </div>
                        <a href="{{ route('posts.show', $post->slug) }}" class="no-underline ml-auto hidden lg:block">
                            <div class="w-32 h-32 rounded ml-4 bg-cover" style="background-image: url('{{ $post->featured_image }}');"></div>
                        </a>
                    </div>
                @empty
                    <p>No Stories yet.</p>
                @endforelse

            </div>
        </div>

        <div class="flex justify-center items-center mb-12">
            <a href="{{ $posts->previousPageUrl() }}" class="btn-secondary {{ $posts->previousPageUrl() ?? 'disabled' }}">Prev</a>
            <p class="text-grey-dark mr-3">total {{ $posts->total() }}</p>
            <a href="{{ $posts->nextPageUrl() }}" class="btn-secondary {{ $posts->nextPageUrl() ?? 'disabled' }}">Next</a>
        </div>
    </div>
@endsection
