@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    {{-- <h1>Dashboard</h1> --}}
@stop

@section('content')
	<p class="text-center">Selamat Datang</p>
	<div class="text-center">
		<img src="{{url(config('websetting.logo_tni'))}}" style="width: 20%">
	</div>
    <h1 class="text-center">{{config('websetting.name')}}</h1>
    <h3 class="text-center">{{config('websetting.sub_name')}}</h3>

@stop