@extends('layout')

@section('content')
	<h1>Selling Your Home?</h1>

	<hr>

	<form method="POST" action="/flyers" enctype="multipart/form-data">
		@include('flyers.form')
	</form>
@stop