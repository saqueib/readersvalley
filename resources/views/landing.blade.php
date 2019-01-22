@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex">

            <div class="w-3/4 mr-6">
                @forelse($tags as $tag)
                    <div class="box mb-6">
                        <header class="section-header">
                            <h3>
                                <span class="pb-3 pr-4 border-b border-grey-darker">
                                {{ $tag->name }}
                                </span>
                            </h3>
                        </header>

                        @include('post._story_list', ['posts' => $tag->posts()->published()->limit(4)->with('user')->latest('published_at')->get()])
                    </div>
                @empty
                    <p>No Stories yet</p>
                @endforelse
            </div>

            <div class="w-1/4 pl-6">
                <div class="sticky pin-t pt-4">
                    <h3 class="section-header">Popular on {{ config('app.name') }}</h3>

                    @include('post._story_list', ['posts' => $popular, 'noThumb' => true, 'countIt' => true])

                    <div class="text-sm border-t border-grey-light py-4">
                        <a class="footer-link" href="">Help</a>
                        <a class="footer-link" href="">Status</a>
                        <a class="footer-link" href="">Writers</a>
                        <a class="footer-link" href="">Blog</a>
                        <a class="footer-link" href="">Careers</a>
                        <a class="footer-link" href="">Privacy</a>
                        <a class="footer-link" href="">Terms</a>
                        <a class="footer-link" href="">About</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
