@extends('layouts.public', ['title' => 'Career 180 — The Developer Learning Platform'])

@section('content')
    @include('home.partials.hero', ['totalCourses' => $totalCourses])
    @include('home.partials.trusted')
    @include('home.partials.features')
    
    <section id="courses" class="bg-gray-50 py-20">
        <div class="max-w-6xl mx-auto px-6">
            <livewire:courses.course-catalog :total-count="$totalCourses" />
        </div>
    </section>

    @include('home.partials.how-it-works')
    @include('home.partials.cta')
@endsection
