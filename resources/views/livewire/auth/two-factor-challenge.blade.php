@extends('layouts.auth')

@section('title', 'Two-Factor Challenge')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8">
    <div
        class="relative w-full h-auto"
        x-data="{
            showRecoveryInput: {{ $errors->has('recovery_code') ? 'true' : 'false' }},
            code: '',
            recovery_code: '',
            toggleInput() {
                this.showRecoveryInput = !this.showRecoveryInput;
                this.code = '';
                this.recovery_code = '';
                this.$dispatch('clear-2fa-auth-code');
                this.$nextTick(() => {
                    this.showRecoveryInput
                        ? this.$refs.recovery_code?.focus()
                        : this.$dispatch('focus-2fa-auth-code');
                });
            },
        }"
    >
        <div x-show="!showRecoveryInput" class="text-center mb-6">
            <h1 class="text-2xl font-black text-gray-900 mb-2">Authentication Code</h1>
            <p class="text-gray-500">Enter the code from your authenticator app</p>
        </div>

        <div x-show="showRecoveryInput" class="text-center mb-6">
            <h1 class="text-2xl font-black text-gray-900 mb-2">Recovery Code</h1>
            <p class="text-gray-500">Enter one of your emergency recovery codes</p>
        </div>

        <form method="POST" action="{{ route('two-factor.login.store') }}">
            @csrf

            <div class="space-y-5">
                <div x-show="!showRecoveryInput">
                    <div class="flex items-center justify-center my-5">
                        <input
                            type="text"
                            name="code"
                            x-model="code"
                            maxlength="6"
                            placeholder="000000"
                            class="w-40 text-center text-2xl font-mono tracking-widest px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none"
                        >
                    </div>
                </div>

                <div x-show="showRecoveryInput" class="my-5">
                    <input
                        type="text"
                        name="recovery_code"
                        x-ref="recovery_code"
                        x-bind:required="showRecoveryInput"
                        autocomplete="one-time-code"
                        x-model="recovery_code"
                        placeholder="Recovery code"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all outline-none"
                    >
                    @error('recovery_code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg disabled:opacity-70 disabled:cursor-not-allowed"
                    onclick="this.disabled=true;this.innerText='Verifying...';this.form.submit();"
                >
                    {{ __('Continue') }}
                </button>
            </div>

            <div class="mt-5 text-center">
                <button type="button" @click="toggleInput()" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    <span x-show="!showRecoveryInput">Or login using a recovery code</span>
                    <span x-show="showRecoveryInput">Or login using an authentication code</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
