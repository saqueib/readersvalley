@extends('layouts.app')

@section('content')
<div class="flex items-center">
    <div class="md:w-1/2 md:mx-auto">
        <div class="rounded bg-white shadow p-4">
            <div class="font-serif text-lg text-3xl text-center text-teal-darker p-3 rounded-t">
                {{ __('Verify your Email Address') }}
            </div>
            <div class="bg-white p-4 rounded-b">
                @if (session('resent'))
                    <div class="bg-green-lightest border border-green-light text-green-dark text-sm px-4 py-3 rounded mb-4">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                <p class="text-grey-dark">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" class="no-underline hover:underline text-teal-light">{{ __('click here to request another') }}</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
