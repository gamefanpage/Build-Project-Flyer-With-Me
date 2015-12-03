@extends('layout')

@section('content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h1>Register</h1>

			<hr>

			<form action="/auth/register" method="POST">
				{!! csrf_field() !!}

				<div class="form-group">
					<label for="name">Name:</label>
					<input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
				</div>

				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
				</div>

				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" class="form-control" required>
				</div>

				<div class="form-group">
					<label for="password_confirmation">Confirm Password:</label>
					<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-default">Register</button>
				</div>
			</form>

			@include('errors')
		</div>
	</div>

@stop