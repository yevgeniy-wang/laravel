@extends('layout')

@section('content')
    <div class="mb-3">
        <p>Your continent code is: {{ $geoService->continentCode() }}</p>
    </div>
    <div class="mb-3">
        <p>Your country code is: {{ $geoService->countryCode() }}</p>
    </div>
@endsection
