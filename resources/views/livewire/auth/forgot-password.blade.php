@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-black text-gray-900 mb-2">Forgot password?</h1>
        <p class="text-gray-500">Enter your email to receive a reset link</p>
    </div>

    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
            <input
                type="email"
                name="email"
                id="email"
                required
                autofocus
                placeholder="you@example.com"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none"
            >
        </div>

        <button
            type="submit"
            class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed"
            onclick="this.disabled=true;this.innerText='Sending...';this.form.submit();"
        >
            {{ __('Email password reset link') }}
        </button>
    </form>

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
            {{ __('Or, return to log in') }}
        </a>
    </div>
</div>
@endsection
