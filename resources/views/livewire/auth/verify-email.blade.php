@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-black text-gray-900 mb-2">Verify your email</h1>
        <p class="text-gray-500">Please verify your email address to continue</p>
    </div>

    <div class="flex flex-col gap-6">
        <p class="text-center text-gray-600">
            {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <p class="text-center font-medium text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </p>
        @endif

        <div class="flex flex-col items-center justify-between space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button 
                    type="submit" 
                    class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed"
                    onclick="this.disabled=true;this.innerText='Sending...';this.form.submit();"
                >
                    {{ __('Resend verification email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit" 
                    class="text-sm text-gray-500 hover:text-gray-700 font-medium"
                    onclick="this.disabled=true;"
                >
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
