@extends('layouts.client')
@section('title', $pageTitle ?? env('APP_NAME'))

@section('content')
    <x-header />
    {{ $slot }}
    <x-footer/>
@endsection
