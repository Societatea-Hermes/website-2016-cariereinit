@extends('backoffice/logged_in')

@section('extraCss')
	@parent
	<link rel="stylesheet" type="text/css" href="/vendor/datetimepicker/css/bootstrap-datetimepicker.min.css">
@stop

@section('menuItems')
	<li>
		<a href="{{url('/backoffice/events')}}">Events</a>
	</li>
	<li>
		<a href="{{url('/backoffice/packages')}}">Packages</a>
	</li>
	<li>
		<a href="{{url('/backoffice/users')}}">Users</a>
	</li>
@stop

@section('extraJs')
	@parent
	<script type="text/javascript" src="/vendor/moment/moment.min.js"></script>
	<script type="text/javascript" src="/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
@stop
