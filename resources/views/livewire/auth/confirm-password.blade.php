@extends('layouts.auth')

@section('title', 'Confirm Password')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-black text-gray-900 mb-2">Confirm password</h1>
        <p class="text-gray-500">This is a secure area. Please confirm your password before continuing.</p>
    </div>

    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm text-center">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.confirm.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input
                type="password"
                name="password"
                id="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none"
            >
        </div>

        <button
            type="submit"
            class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed"
            onclick="this.disabled=true;this.innerText='Confirming...';this.form.submit();"
        >
            {{ __('Confirm') }}
        </button>
    </form>
</div>
@endsection
