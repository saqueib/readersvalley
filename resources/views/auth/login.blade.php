@extends('layouts.app')

@section('content')
<div class="flex items-center px-6 md:px-0">
    <div class="w-full max-w-md md:mx-auto">
        <div class="rounded bg-white shadow p-4">
            <div class="font-serif text-lg text-3xl text-center text-teal-darker p-3 rounded-t">
                {{ __('Sign in') }}
            </div>
            <div class="p-3 rounded-b">
                @include('auth._login_form')
            </div>
        </div>
    </div>
</div>
@endsection
