@extends('layout')

@section('title', 'Tags')

@section('content')

    <div class="mb-3">
        <a class="btn btn-secondary" href="{{ route('admin') }}">Back</a>
    </div>

    @include('auth')

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        @forelse($tags as $tag)
            <tr>
                <td>{{ $tag->id }}</td>
                <td>{{ $tag->title }}</td>
                <td>{{ $tag->slug }}</td>
                <td>{{ $tag->created_at->diffforhumans() }}</td>
                <td>
                    <p><a class="btn btn-primary" href="{{ route('tag-edit', $tag->id) }}">Update</a></p>
                    <p><a class="btn btn-primary" href="{{ route('tag-destroy', $tag->id) }}">Delete</a></p>
                </td>
            </tr>
        @empty
            <tr>
                <th><p>no tags</p></th>
            </tr>
        @endforelse
    </table>
    @include('paginator', ['table' => $tags])
    <div class="mb-3">
        <a class="btn btn-primary" href="{{ route('tag-create') }}">Add new tag</a>
    </div>
@endsection
