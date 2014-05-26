@extends('layouts.master')

@section('head')
@parent
@stop

@section('content')
  <center class="jumbotron">
    <h2>Login With Facebook or Google </h2>
    @include('login_google')
    @include('login_fb')
  </center>
@stop

@section('javascript')
<!-- Last part of BODY element in file index.html -->
@parent
@stop

