@extends('layouts.master')

@section('head')
@parent
@stop

@section('content')
<div class="col-md-12 well">
  <div class="col-md-3">
    <a href="https://en.gravatar.com/" target="_blank">
    <img data-src="holder.js/140x140" class="img-rounded" alt="icon" 
    src="{{ $gravatar }}" style="width: 120px; height: 120px; margin-top: 20px;">
    </a>
  </div>
  <div class="col-md-9">
    <h3>Welcome {{ $user->first_name }} {{ $user->last_name }} </h3>
    <form role="form">
      <div class="form-group">
        <label>Email address:</label>
        <input type="email" class="form-control" value="{{$user->email}}">
      </div>
      <div class="form-group">
        <label>FirstName: </label>
        <input type="text" class="form-control" value="{{$user->first_name}}">
      </div>
      <div class="form-group">
        <label>LastName: </label>
        <input type="text" class="form-control" value="{{$user->last_name}}">
      </div>
      <div class="form-group">
        <label>Gender: </label>
        <input type="text" class="form-control" value="{{$user->gender}}">
      </div>
    </form>
  </div>
</div>
@stop

@section('javascript')
<!-- Last part of BODY element in file index.html -->
@parent
@stop

