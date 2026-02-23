@extends('layouts.public', ['title' => $course->title . ' — Career 180'])

@section('content')
    @include('courses.partials.hero', ['course' => $course])
    @include('courses.partials.lessons', ['course' => $course])
@endsection
