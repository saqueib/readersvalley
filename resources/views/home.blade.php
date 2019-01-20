@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="mb-10">
            <h1 class="inline font-semibold text-3xl mr-auto">Posts</h1>
        </div>

        <div>
            <div class="border-t border-very-light flex items-center">
                <div title="Teating moca" class="py-4"><h2 class="text-xl font-semibold mb-3"><a
                                href="/wink/posts/bb7ef2ee-4c45-4eb0-8f2b-2613d69f862d"
                                class="no-underline text-text-color">
                            Teating moca
                        </a></h2>
                    <p class="mb-3">This is going to be awesome</p>
                    <small class="text-light"><!----> <!----> <span class="text-red">Draft</span>
                        — Updated 21 hours ago
                        <!----></small>
                </div>
                <a href="/wink/posts/bb7ef2ee-4c45-4eb0-8f2b-2613d69f862d" class="no-underline ml-auto hidden lg:block">
                    <div class="w-16 h-16 rounded-full bg-light flex items-center justify-center text-4xl text-contrast">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="fill-current w-8">
                            <path d="M0 6c0-1.1.9-2 2-2h3l2-2h6l2 2h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6zm10 10a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0-2a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"></path>
                        </svg>
                    </div>
                </a>
            </div>
            @foreach(range(1, 10) as $item)
            <div class="border-t border-very-light flex items-center">
                <div title="Getting Started with Gatsby and WordPress" class="py-4">
                    <h2 class="text-xl font-normal mb-3">
                        <a href="/wink/posts/71b9709e-b589-4b43-961f-1bb9ccde7bb4" class="no-underline text-black">
                            #{{$item}} Getting Started with Gatsby and WordPress
                        </a>
                    </h2>
                    <p class="mb-3 text-grey-darkest">
                        Earlier this week I began rebuilding my blog using GatsbyJS + WordPress. As I
                        familiarized with...
                    </p>
                    <small class="text-grey-dark">
                        <span>Published 19 hours ago</span>
                        — Updated 9 hours ago
                    </small>
                </div>
                <a href="/wink/posts/71b9709e-b589-4b43-961f-1bb9ccde7bb4" class="no-underline ml-auto hidden lg:block">
                    <div class="w-16 h-16 rounded-full bg-cover"
                         style="background-image: url('https://pbs.twimg.com/profile_images/885868801232961537/b1F6H4KC_400x400.jpg');"></div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
@endsection
