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
		<div class="modal-dialog modal-lg" role="document">
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
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="description">Description (supports markdown syntax: <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">Help</a>)</label>
								<textarea name="description" id="description" class="form-control descriptionTextArea" onkeyup="changePreview()" required></textarea>
							</div>
						</div>
						<div class="col-md-6">
							<h3>Description preview</h3>
							<div class="well">
								<div id="offerPreview"></div>
							</div>
						</div>
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