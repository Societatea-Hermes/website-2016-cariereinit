@extends('backoffice/admin')

@section('mainContent') 
	<h1 class="text-center">Users list</h1>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-success" data-target="#addEditPartnerModal" data-toggle="modal">Add partner</button>
			</div>
		</div>
		<hr />
		<div class="row">
			<div class="col-md-12">
				<table id="grid"></table>
				<div id="gridPager"></div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addEditPartnerModal" tabindex="-1" role="dialog" aria-labelledby="userModal">
		<div class="modal-dialog smallModal" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="userModal">Add partner</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" name="username" id="username" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" id="password" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="password_confirmation">Password Confirm</label>
						<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="full_name">Full name</label>
						<input type="text" name="full_name" id="full_name" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" id="email" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="site_url">Site url</label>
						<input type="text" name="site_url" id="site_url" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="package_id">Package</label>
						<select name="package_id" id="package_id" class="form-control"></select>
					</div>
					<div class="form-group">
						<label for="avatar">Logo</label>
						<input type="file" name="avatar" id="avatar" class="form-control" required />
					</div>
				</div>
				<div class="modal-footer">
					<button onclick="closeAndClear()" class="btn btn-default">Close</button>
					<button onclick="save()" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
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
	<script type="text/javascript" src="/js/backoffice/users.js"></script>
@stop