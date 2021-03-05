@extends($privilege == 2 ? 'backoffice/partner' : 'backoffice/admin')

@section('mainContent') 
	<h1 class="text-center">Edit profile</h1>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<tr>
						<th>Name</th>
						<td>{{$full_name}}</td>
					</tr>
					<tr>
						<th>Username</th>
						<td>{{$username}}</td>
					</tr>
					<tr>
						<th>Password</th>
						<td><button class="btn btn-danger" data-toggle="modal" data-target="#resetPassModal">Change password</button></td>
					</tr>
					<tr>
						<th>Email</th>
						<td>{{$email}}</td>
					</tr>
				</table>
			</div>
		</div>
		@if($privilege == 2) 
			<hr />
			<h2 class="text-center">Edit logo</h2>
			<div class="row">
				<div class="col-md-6">
					Existing logo <br />
					<img style="max-width: 300px" src="/api/getAvatar/{{$id}}" />
				</div>
				<div class="col-md-6">
					Change logo <br />
					<div class="form-group">
						<label for="avatar">Logo</label>
						<input type="file" name="avatar" id="avatar" class="form-control" required />
					</div>
					<button class="btn btn-success" onclick="saveLogo()">Change logo</button>
				</div>
			</div>
		@endif
	</div>

	<div class="modal fade" id="resetPassModal" tabindex="-1" role="dialog" aria-labelledby="resetPassModal">
		<div class="modal-dialog smallModal" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="resetPassModal">Reset password</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="reset_password">Password</label>
						<input type="password" name="reset_password" id="reset_password" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="reset_password_confirmation">Password Confirm</label>
						<input type="password" name="reset_password_confirmation" id="reset_password_confirmation" class="form-control" required />
					</div>
				</div>
				<div class="modal-footer">
					<button onclick="closeAndClearResetPass()" class="btn btn-default">Close</button>
					<button onclick="doPasswordReset()" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
@stop

@section('extraJs')
	@parent
	<script type="text/javascript" src="/js/backoffice/profile.js"></script>
@stop