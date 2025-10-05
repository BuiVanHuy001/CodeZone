@extends('layouts.client')

@section('content')
    <x-client.banner-area :$hotCourses/>

    <x-client.categories-area/>

    <x-client.courses-area :$popularCourses/>

    <x-client.blogs-area/>
@endsection
