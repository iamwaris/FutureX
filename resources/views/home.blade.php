@extends('layouts.app')

@section('content')
    @include('sections.hero')
    @include('sections.live-status')
    @include('sections.snapshot')
    @include('sections.featured-content')
    @include('sections.about')
    @include('sections.schedule')
    @include('sections.community')
    @include('sections.sponsors')
    @include('sections.shop')
    @include('sections.newsletter')
@endsection
