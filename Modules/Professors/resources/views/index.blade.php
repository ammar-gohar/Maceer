@extends('professors::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('professors.name') !!}</p>
@endsection
