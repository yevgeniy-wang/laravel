@extends('layout')

@section('title', 'Login')

@section('content')
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <form action="" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email : </label>
            <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password : </label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="mb-3">
            <input type="submit" class="btn btn-primary mb-3" value="Login">
        </div>
        <div class="mb-3">
            @if($errors->has('password'))
                @foreach($errors->get('password') as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
        </div>
        @csrf
    </form>
    <div class="mb-3">
        <a class="btn btn-primary" href="{{ $gitHubLink }}">Login via GitHub</a>
    </div>
    <div class="mb-3">
        <a class="btn btn-primary" href="{{ $yahooLink }}">Login via Yahoo</a>
    </div>
@endsection

