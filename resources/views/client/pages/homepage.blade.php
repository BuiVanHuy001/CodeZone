@extends('layouts.client')

@section('content')
    <x-client.banner-area/>
    <x-client.categories-area/>
    <x-client.courses-area
        :$courses
    />
    <x-client.blogs-area/>
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
        </svg>
    </div>
@endsection
