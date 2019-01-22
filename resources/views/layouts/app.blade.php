<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') &bull; {{ config('app.name', 'Laravel') }}</title>

    <!-- Highlight JS sheets -->
    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.13.1/build/highlight.min.js"></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <script>window.App = {post:{}, tags: []};</script>
    @stack('header')

</head>
<body class="h-screen antialiased">
<div id="app">
    <vue-progress-bar></vue-progress-bar>
    <app inline-template>
        <div>
            <nav class="bg-white mb-8 p-2 md:px-0 shadow">
                <div class="container mx-auto h-full">

                    <div class="flex items-center justify-center h-12">
                        <div class="mr-6">

                            <a href="{{ url('/') }}" class="text-lg font-hairline text-black no-underline">
                                <img class="h-8 align-middle" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}">
                                <span class="font-bold font-serif">{{ config('app.name', 'Laravel') }}</span>
                            </a>

                            <span v-if="saving" v-cloak class="text-grey text-sm pl-3">Saving...</span>
                        </div>
                        {{--left side--}}

                        <div class="flex-1 text-right">

                            @guest
                                <a class="btn-clear"
                                   href="{{ url('/login') }}">{{ __('Sign in') }}</a>
                                <a class="btn-outline"
                                   href="{{ url('/register') }}">{{ __('Get Started') }}</a>
                            @else
                                <div class="flex justify-end" v-cloak>
                                    @if(in_array($routeName = request()->route()->getName(), ['posts.create', 'posts.edit']))
                                        <a @click.prevent="showPublishingModal" :class="{'disabled': !isPublishable}" class="btn-outline" href="#">
                                            @{{ post.published_at ? 'Update...' : 'Ready to Publish...' }}
                                        </a>

                                        <dropdown class="relative ml-2">
                                            <button slot="trigger" type="button" class="focus:outline-none mt-1 pr-2">
                                                <svg class="svgIcon-use" width="25" height="25"><path d="M5 12.5c0 .552.195 1.023.586 1.414.39.39.862.586 1.414.586.552 0 1.023-.195 1.414-.586.39-.39.586-.862.586-1.414 0-.552-.195-1.023-.586-1.414A1.927 1.927 0 0 0 7 10.5c-.552 0-1.023.195-1.414.586-.39.39-.586.862-.586 1.414zm5.617 0c0 .552.196 1.023.586 1.414.391.39.863.586 1.414.586.552 0 1.023-.195 1.414-.586.39-.39.586-.862.586-1.414 0-.552-.195-1.023-.586-1.414a1.927 1.927 0 0 0-1.414-.586c-.551 0-1.023.195-1.414.586-.39.39-.586.862-.586 1.414zm5.6 0c0 .552.195 1.023.586 1.414.39.39.868.586 1.432.586.551 0 1.023-.195 1.413-.586.391-.39.587-.862.587-1.414 0-.552-.196-1.023-.587-1.414a1.927 1.927 0 0 0-1.413-.586c-.565 0-1.042.195-1.432.586-.39.39-.586.862-.587 1.414z" fill-rule="evenodd"></path></svg>
                                            </button>

                                            <div slot="content" class="dropdown-content" v-cloak>
                                                <div v-if="!isPublishable">
                                                    <p class="p-4 text-center leading-loose text-grey-dark">Options will be available once you type your story</p>
                                                </div>

                                                <a href="{{ route('posts.create') }}" class="dropdown-item">New Story</a>

                                                <div v-if="isPublishable">
                                                    <a @click.prevent="showPublishingModal" href="#" class="dropdown-item">Add featured image</a>
                                                    <a href="" class="dropdown-item border-t border-grey-light text-red-dark">Delete</a>
                                                </div>
                                            </div>
                                        </dropdown>
                                    @else
                                        <a class="btn-outline" href="{{ route('posts.create') }}">{{ __('New Story') }}</a>
                                    @endif

                                    <dropdown class="relative ml-2">
                                        <button slot="trigger" type="button" class="focus:outline-none">
                                            <img src="{{ auth()->user()->avatar }}"
                                                 class="rounded-full w-8 h-8 align-middle"
                                                 title="{{ auth()->user()->name }}">
                                        </button>

                                        <div slot="content" class="dropdown-content" v-cloak>
                                            <a href="{{ route('posts.index') }}" class="dropdown-item">My Posts</a>
                                            <a href="{{ route('logout') }}"
                                               class="dropdown-item text-grey-dark"
                                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </dropdown>
                                </div>
                            @endguest
                        </div>
                        {{--right side--}}

                    </div>
                </div>
            </nav>

            <main v-cloak>
                @yield('content')
            </main>
        </div>
    </app>
</div>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@stack('footer')
</body>
</html>
