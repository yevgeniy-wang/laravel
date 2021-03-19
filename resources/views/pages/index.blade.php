@extends('layout')

@section('title', 'Homepage')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @include('auth')
    @foreach($posts as $post)
        <div class="mb-3">
            @include('partials.post', ['post' => $post])
        </div>
    @endforeach
@endsection
