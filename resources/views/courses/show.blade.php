@extends('layouts.public', [
    'title' => $course->title . ' — Career 180',
    'description' => $course->description ? Str::limit($course->description, 155) : $course->title . ' — Watch HD screencasts, track your progress, and complete this structured course on Career 180.',
])

@section('content')
    @include('courses.partials.hero', ['course' => $course])
    @include('courses.partials.lessons', ['course' => $course])
@endsection
