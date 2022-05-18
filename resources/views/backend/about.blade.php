@extends('layouts.backend.app')

@section('breadcrumbs')
    {!! Breadcrumbs::render('about') !!}
@endsection

@section('content')
    Welcome {{ Auth::user()->name }}
@endsection