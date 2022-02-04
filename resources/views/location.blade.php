@extends('layouts.web')

@section('title')
    {{$location->location}}
@endsection

@section('content')

    <p>
        @if ($location->visited)
            I have visited {{$location->location}}
        @else
            I'd like to visit {{$location->location}}
        @endif
    </p>

    <a class="btn btn-primary btn-sm mt-4" href="/"><i class="bi bi-chevron-left"></i> Back to my locations</a>

@endsection
