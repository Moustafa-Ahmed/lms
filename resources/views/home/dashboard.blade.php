@extends('layouts.public', ['title' => 'My Courses — Career 180'])

@section('content')
    <div class="dash-page min-h-screen pb-16">
        {{-- Greeting --}}
        <div class="dash-hero fade-up">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <p class="dash-greeting">Welcome back</p>
                <h1 class="dash-name">{{ $user->name }}</h1>
            </div>
        </div>

        <livewire:dashboard />
    </div>
@endsection
