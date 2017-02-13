@extends('backoffice/admin')

@section('mainContent') 
	<h1 class="text-center">Packages list</h1>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-success" data-target="#addEditPackageModal" data-toggle="modal">Add package</button>
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

	<div class="modal fade" id="addEditPackageModal" tabindex="-1" role="dialog" aria-labelledby="eventModal">
		<div class="modal-dialog smallModal" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="eventModal">Add / edit package</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="package_name">Name</label>
						<input type="text" name="package_name" id="package_name" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="logo_size">Logo size</label>
						<input type="text" name="logo_size" id="logo_size" class="form-control" required />
					</div>
				</div>
				<div class="modal-footer">
					<button onclick="closeAndClear()" class="btn btn-default">Close</button>
					<button onclick="save()" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>
@stop

@section('extraJs')
	@parent
	<script type="text/javascript" src="/js/backoffice/packages.js"></script>
@stop