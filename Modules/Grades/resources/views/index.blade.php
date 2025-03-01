@extends('grades::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('grades.name') !!}</p>
@endsection
