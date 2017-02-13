@extends('backoffice/backoffice_template')

@section('content')
	<h1 class="text-center">Please login</h1>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="form-control" required />
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control" required />
				</div>
				<button class="btn btn-success" onclick="login()">Login</button>
			</div>
		</div>
	</div>
@stop

@section('extraJs')
	<script type="text/javascript" src="/js/backoffice/login.js"></script>
@stop