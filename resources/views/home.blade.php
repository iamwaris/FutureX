@extends('layouts.app')

@section('content')
    @foreach ($sections as $section)
        @includeIf('sections.' . $section->key)
    @endforeach
@endsection
