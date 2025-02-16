@extends('moderators::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('moderators.name') !!}</p>
@endsection
