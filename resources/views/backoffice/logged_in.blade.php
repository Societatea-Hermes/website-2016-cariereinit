@extends('backoffice/backoffice_template')

@section('extraCss')
	<link rel="stylesheet" type="text/css" href="/vendor/grid/css/ui.jqgrid-bootstrap.css">
@stop

@section('content')
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Cariere in it</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li>
						<a href="{{url('/backoffice')}}">Home</a>
					</li>
					@yield('menuItems')
					<li>
						<a href="{{url('/backoffice/profile')}}">Edit profile</a>
					</li>
					<li>
						<a href="{{url('/logout')}}">Logout</a>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

	@yield('mainContent')
@stop

@section('extraJs')
	<script type="text/javascript" src="/vendor/grid/js/i18n/grid.locale-ro.js"></script>
	<script type="text/javascript" src="/vendor/grid/js/jquery.jqGrid.min.js"></script>
	<script type="text/javascript" src="/vendor/grid/plugins/grid.postext.js"></script>
@stop