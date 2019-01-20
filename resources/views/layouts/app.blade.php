<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="h-screen antialiased">
    <div id="app" v-cloak>
        <nav class="bg-white mb-8 p-2 md:px-0 shadow">
            <div class="container mx-auto h-full">
                <div class="flex items-center justify-center h-12">
                    <div class="mr-6">
                        <a href="{{ url('/') }}" class="text-lg font-hairline text-black no-underline">
                            <img class="h-8 align-middle" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}">
                            <span class="font-bold font-serif">{{ config('app.name', 'Laravel') }}</span>
                        </a>
                    </div>
                    <div class="flex-1 text-right">
                        @guest
                            <a @click.prevent="showModal('login')" class="no-underline text-teal hover:text-teal-dark pr-3 text-sm" href="{{ url('/login') }}">{{ __('Sign in') }}</a>
                            <a @click.prevent="showModal('register')" class="no-underline bg-transparent text-sm text-teal hover:text-teal-dark py-2 px-4 border border-teal hover:border-teal-dark rounded" href="{{ url('/register') }}">{{ __('Get Started') }}</a>
                        @else

                            <a class="no-underline bg-transparent text-sm text-teal hover:text-white hover:bg-teal py-2 px-4 border border-teal hover:border-teal-dark rounded mr-3" href="{{ url('/post/new') }}">{{ __('New Story') }}</a>

                            <a href="{{ route('logout') }}"
                               class="no-underline text-grey hover:text-grey-dark pr-3 text-sm"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                {{ csrf_field() }}
                            </form>

                            <img class="w-10 h-10 rounded-full align-middle mr-4" src="https://pbs.twimg.com/profile_images/885868801232961537/b1F6H4KC_400x400.jpg" alt="{{ Auth::user()->name }}">

                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')

        @guest
            <modal id="login" modal-class="bg-teal-lightest">
            <div class="flex justify-center">
                <div class="w-1/2">
                    <div class="login-form">
                        <h3 class="font-serif text-4xl mb-6 text-teal-darkest text-center">Welcome back.</h3>
                        <p class="text-teal-darkest text-center mb-4">
                            Sign in to access your personalized homepage, follow authors and topics you love, and clap for stories that matter to you.
                        </p>
                        @include('auth._login_form')
                    </div>
                </div>
            </div>
        </modal>
            <modal id="register">
                Register Here
            </modal>
        @endguest
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
