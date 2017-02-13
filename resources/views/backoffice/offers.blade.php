@extends('backoffice/partner')

@section('mainContent') 
	<h1 class="text-center">Offers list</h1>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-success" data-target="#addEditOfferModal" data-toggle="modal">Add offer</button>
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

	<div class="modal fade" id="addEditOfferModal" tabindex="-1" role="dialog" aria-labelledby="eventModal">
		<div class="modal-dialog smallModal" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="eventModal">Add / edit offer</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" id="title" class="form-control" required />
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<input type="text" name="description" id="description" class="form-control" required />
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
	<script type="text/javascript" src="/js/backoffice/offers.js"></script>
@stop