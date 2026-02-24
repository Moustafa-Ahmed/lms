@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-black text-gray-900 mb-2">Reset password</h1>
            <p class="text-gray-500">Please enter your new password below</p>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm text-center">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email address</label>
                <input type="email" name="email" id="email" value="{{ request('email') }}" required
                    autocomplete="email" placeholder="you@example.com"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all outline-none">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New password</label>
                <input type="password" name="password" id="password" required autocomplete="new-password"
                    placeholder="Enter new password"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all outline-none">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm
                    password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    autocomplete="new-password" placeholder="Confirm new password"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all outline-none">
            </div>

            <button type="submit"
                class="w-full py-3 px-4 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed"
                onclick="this.disabled=true;this.innerText='Resetting...';this.form.submit();">
                {{ __('Reset password') }}
            </button>
        </form>
    </div>
@endsection
