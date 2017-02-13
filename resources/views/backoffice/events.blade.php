@extends('backoffice/admin')

@section('mainContent') 
	<h1 class="text-center">Events list</h1>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-success" data-target="#addEditEventModal" data-toggle="modal">Add event</button>
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

	<div class="modal fade" id="addEditEventModal" tabindex="-1" role="dialog" aria-labelledby="eventModal">
		<div class="modal-dialog smallModal" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="eventModal">Add / edit event</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" id="name" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<input type="text" name="description" id="description" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="date_start">Date start</label>
						<input type="text" name="date_start" id="date_start" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="date_end">Date end</label>
						<input type="text" name="date_end" id="date_end" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="description">Max participants</label>
						<input type="text" name="max_participants" id="max_participants" class="form-control" />
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
	<script type="text/javascript" src="/js/backoffice/events.js"></script>
@stop