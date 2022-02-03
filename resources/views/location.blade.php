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

@endsection
