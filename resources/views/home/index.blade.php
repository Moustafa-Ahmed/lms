@extends('layouts.public', ['title' => 'Career 180 — The Developer Learning Platform'])

@section('content')
    @include('home.partials.hero', ['totalCourses' => $totalCourses, 'featuredCourse' => $featuredCourse])
    @include('home.partials.trusted')
    @include('home.partials.features')

    <section id="courses" class="course-catalog-section py-24 lg:py-32">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <livewire:courses.course-catalog :total-count="$totalCourses" />
        </div>
    </section>

    @include('home.partials.how-it-works')
    @include('home.partials.cta')
@endsection
