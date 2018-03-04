<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Societatea Hermes" />

	<!-- Stylesheets
	============================================= -->
	<link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700|Roboto:300,400,500,700" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="/template/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="/template/css/style.css" type="text/css" />

	<!-- One Page Module Specific Stylesheet -->
	<link rel="stylesheet" href="/template/css/onepage.css" type="text/css" />
	<!-- / -->

	<link rel="stylesheet" href="/template/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="/template/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="/template/css/et-line.css" type="text/css" />
	<link rel="stylesheet" href="/template/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="/template/css/magnific-popup.css" type="text/css" />

	<link rel="stylesheet" href="/template/css/fonts.css" type="text/css" />

	<link rel="stylesheet" href="/template/css/responsive.css" type="text/css" />
	<link rel="stylesheet" href="/css/style.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />


	<!-- Document Title
	============================================= -->
	<title>Cariere in IT</title>

</head>

<body class="stretched" data-loader="11" data-loader-color="#543456">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header" class="full-header transparent-header border-full-header dark static-sticky" data-sticky-class="not-dark" data-sticky-offset="full" data-sticky-offset-negative="100">

			<div id="header-wrap">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo">
						<a href="https://societatea-hermes.ro/" target="_blank" class="standard-logo" data-dark-logo="images/logo.png"><img src="images/logo.png" alt="Societatea Hermes Logo"></a>
						<a href="https://societatea-hermes.ro/" target="_blank" class="retina-logo" data-dark-logo="images/logo.png"><img src="images/logo.png" alt="Societatea Hermes Logo"></a>
					</div><!-- #logo end -->

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu">
						<ul class="one-page-menu" data-easing="easeInOutExpo" data-speed="1250" data-offset="65">
							<li><a href="#" data-href="#wrapper"><div>Home</div></a></li>
							<li><a href="#" data-href="#section-about"><div>About</div></a></li>
							@if($is_logged)
								<li><a href="#" data-href="#section-events"><div>Events</div></a></li>
								<li><a href="#" data-href="#section-internships"><div>Internships &amp; Job offers</div></a></li>
							@endif
							@if(false)
								<li><a href="#" data-href="#section-feedback"><div>Feedback</div></a></li>
							@endif
							<li><a href="#" data-href="#footer"><div>Contact</div></a></li>
						</ul>

					</nav><!-- #primary-menu end -->

				</div>

			</div>

		</header><!-- #header end -->

		<!-- Slider
		============================================= -->
		<section id="slider" class="slider-parallax full-screen">
			<div class="slider-parallax-inner">
				<div class="full-screen dark section nopadding nomargin noborder ohidden" style="background-image: url('images/landing.jpg'); background-size: cover; background-position: center center;">
					<div class="row nomargin" style="position: relative; z-index: 2;">
						<div class="col-md-offset-7 col-md-5 full-screen" style="background-color: rgba(0,0,0,0.45);">
							<div class="vertical-middle col-padding">
								<div class="heading-block nobottomborder bottommargin-sm">
									<h1 style="font-size: 22px;">CariereInIT</h1>
									<span style="font-size: 16px;" class="t300 capitalize ls1 notopmargin">{{$is_logged ? "Salut, ".$userData['full_name']."! " : ""}}</span>
								</div>
								@if(!$is_logged)
									<div class="col_full nobottommargin">
										<a href="{{url('/api/facebookLogin')}}">
											<button class="t400 capitalize button button-border button-light button-circle nomargin">Login participant</button>
										</a>
									</div>
								@else
									<div class="col_full nobottommargin">
										<a href="{{url('/logout')}}">
											<button class="t400 capitalize button button-border button-light button-circle nomargin">Logout</button>
										</a>
									</div>
								@endif
								<p class="nobottommargin"><small class="t300"><em>înscrie-te la evenimente, încarcă-ți CV-ul și dă startul carierei tale în IT</em></small></p>
							</div>
							<a href="#" data-scrollto="#section-about" data-easing="easeInOutExpo" data-speed="1250" data-offset="65" class="one-page-arrow dark"><i class="icon-angle-down infinite animated fadeInDown"></i></a>
						</div>
					</div>
				</div>
			</div>
		</section><!-- #slider end -->

		<!-- Content
		============================================= -->
		<section id="content">
			<div class="content-wrap nopadding">
				<div id="section-about" class="center page-section nobottompadding">
					<div class="container clearfix">
						<h2 class="divcenter bottommargin font-body" style="max-width: 700px; font-size: 40px;">Empowering your career</h2>
						<p class="lead divcenter bottommargin" style="max-width: 800px;">CariereInIT este un eveniment organizat de Societatea Hermes, care se adresează tuturor studenților și persoanelor pasionate de domeniul IT. <br />Scopul nostru este să aducem împreună angajatorii și potențialii angajați și să facilităm intrarea în mediul profesional a tinerilor programatori.</p>
						<div class="clear"></div>
					</div>
				</div>

				@if($is_logged)
					<div id="section-events" class="page-section nopadding">

						<div class="section nomargin">
							<div class="container clearfix">
								<div class="divcenter center" style="max-width: 900px;">
									<h2 class="nobottommargin t300 ls1">Events</h2>
								</div>
							</div>
						</div>

						<div class="common-height clearfix">

							<div class="col-md-4 hidden-xs" style="background: url('../images/services/main-bg.jpg') center center no-repeat; background-size: cover;"></div>
							<div class="col-md-8">
								<div class="max-height">
									<div class="row common-height grid-border clearfix">
										@foreach($events as $event)
											<div class="col-md-4 col-sm-6 col-padding cursorPointer" onclick="getEventData({{$event['id']}})">
												<div class="feature-box fbox-center fbox-dark fbox-plain nobottomborder">
			{{-- 										<div class="fbox-icon">
														<a href="#" onclick="getEventData({{$event['id']}})"></a>
													</div> --}}
													<h3>{{$event['name']}}<br /><small>{{$event['start']}} - {{$event['end']}}</small></h3>
												</div>
											</div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>

					<div id="section-internships" class="page-section nopadding">
						<div class="section nomargin">
							<div class="container clearfix">
								<div class="divcenter center" style="max-width: 900px;">
									<h2 class="nobottommargin t300 ls1">Internships &amp; Job offers</h2>
								</div>
							</div>
						</div>

						<!-- Portfolio Items
						============================================= -->
						<div id="portfolio" class="portfolio grid-container portfolio-nomargin portfolio-full portfolio-masonry mixed-masonry clearfix">
							@foreach($logos as $logo)
								<article class="portfolio-item pf-uielements pf-media wide">
									<div class="portfolio-image">
										<a href="#" onclick="getJobOffers({{$logo['img']}})">
											<img src="{{url('/api/getAvatar/'.$logo['img'])}}" alt="{{$logo['name']}}">
										</a>
										<div class="portfolio-overlay cursorPointer" onclick="getJobOffers({{$logo['img']}})">
											<div class="portfolio-desc">
												<h3><a href="#">{{$logo['name']}}</a></h3>
											</div>
										</div>
									</div>
								</article>
							@endforeach
						</div><!-- #portfolio end -->
					</div>
				@endif


				<div id="section-feedback" class="page-section">
					@if(false)
						<h2 class="center uppercase t300 ls3 font-body">Feedback</h2>

						<div class="section nobottommargin">
							<div class="container clearfix">

								<div class="row topmargin clearfix">

									<div class="ipost col-sm-6 bottommargin clearfix">
										<div class="row">
											<div class="col-md-6">
												<div class="entry-image nobottommargin">
													<a href="#"><img src="images/blog/1.jpg" alt="Paris"></a>
												</div>
											</div>
											<div class="col-md-6" style="margin-top: 20px;">
												<span class="before-heading" style="font-style: normal;">Press &amp; Media</span>
												<div class="entry-title">
													<h3 class="t400" style="font-size: 22px;"><a href="#">Global Meetup Program is Launching!</a></h3>
												</div>
												<div class="entry-content">
													<a href="#" class="more-link">Read more <i class="icon-angle-right"></i></a>
												</div>
											</div>
										</div>
									</div>

									<div class="ipost col-sm-6 bottommargin clearfix">
										<div class="row">
											<div class="col-md-6">
												<div class="entry-image nobottommargin">
													<a href="#"><img src="images/blog/2.jpg" alt="Paris"></a>
												</div>
											</div>
											<div class="col-md-6" style="margin-top: 20px;">
												<span class="before-heading" style="font-style: normal;">Inside Scoops</span>
												<div class="entry-title">
													<h3 class="t400" style="font-size: 22px;"><a href="#">The New YouTube Economy unfolds itself</a></h3>
												</div>
												<div class="entry-content">
													<a href="#" class="more-link">Read more <i class="icon-angle-right"></i></a>
												</div>
											</div>
										</div>
									</div>

									<div class="ipost col-sm-6 bottommargin clearfix">
										<div class="row">
											<div class="col-md-6">
												<div class="entry-image nobottommargin">
													<a href="#"><img src="images/blog/3.jpg" alt="Paris"></a>
												</div>
											</div>
											<div class="col-md-6" style="margin-top: 20px;">
												<span class="before-heading" style="font-style: normal;">Video Blog</span>
												<div class="entry-title">
													<h3 class="t400" style="font-size: 22px;"><a href="#">Kicking Off Design Party in Style</a></h3>
												</div>
												<div class="entry-content">
													<a href="#" class="more-link">Read more <i class="icon-angle-right"></i></a>
												</div>
											</div>
										</div>
									</div>

									<div class="ipost col-sm-6 bottommargin clearfix">
										<div class="row">
											<div class="col-md-6">
												<div class="entry-image nobottommargin">
													<a href="#"><img src="images/blog/4.jpg" alt="Paris"></a>
												</div>
											</div>
											<div class="col-md-6" style="margin-top: 20px;">
												<span class="before-heading" style="font-style: normal;">Inspiration</span>
												<div class="entry-title">
													<h3 class="t400" style="font-size: 22px;"><a href="#">Top Ten Signs You're a Designer</a></h3>
												</div>
												<div class="entry-content">
													<a href="#" class="more-link">Read more <i class="icon-angle-right"></i></a>
												</div>
											</div>
										</div>
									</div>

								</div>

							</div>
						</div>
					@endif

					<div class="container topmargin-lg clearfix">
						<div id="oc-clients" class="owl-carousel topmargin image-carousel carousel-widget" data-margin="80" data-loop="true" data-nav="false" data-autoplay="5000" data-pagi="false"data-items-xxs="2" data-items-xs="3" data-items-sm="4" data-items-md="5" data-items-lg="6">
							@foreach($logos as $logo) 
								<div class="oc-item"><a href="{{$logo['url']}}"><img src="{{url('/api/getAvatar/'.$logo['img'])}}" style="width: {{$logo['size']}}%" alt="{{$logo['name']}}"></a></div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		<footer id="footer" class="dark noborder">

			<div class="container center">
				<div class="footer-widgets-wrap">

					<div class="row divcenter clearfix">

						<div class="col-md-4">

							<div class="widget clearfix">
								<h4>Site Links</h4>

								<ul class="list-unstyled footer-site-links nobottommargin">
									<li><a href="#" data-scrollto="#wrapper" data-easing="easeInOutExpo" data-speed="1250" data-offset="70">Top</a></li>
									<li><a href="#" data-scrollto="#section-about" data-easing="easeInOutExpo" data-speed="1250" data-offset="70">About</a></li>
									<li><a href="#" data-scrollto="#section-events" data-easing="easeInOutExpo" data-speed="1250" data-offset="70">Events</a></li>
									<li><a href="#" data-scrollto="#section-internships" data-easing="easeInOutExpo" data-speed="1250" data-offset="70">Internships &amp; Job offers</a></li>
									<li><a href="#" data-scrollto="#section-feedback" data-easing="easeInOutExpo" data-speed="1250" data-offset="70">Feedback</a></li>
									<li><a href="#" data-scrollto="#footer" data-easing="easeInOutExpo" data-speed="1250" data-offset="70">Contact</a></li>
								</ul>
							</div>

						</div>

						<div class="col-md-4">

							&nbsp;

						</div>

						<div class="col-md-4">

							<div class="widget clearfix">
								<h4>Contact</h4>

								<p class="lead">Cantina Hașdeu, Complex Studențesc Hașdeu, <br />Strada Bogdan Petriceicu Hașdeu 45, Cluj-Napoca</p>

								<div class="center topmargin-sm">
									<a href="https://www.facebook.com/cariereinit/" class="social-icon inline-block noborder si-small si-facebook" target="_blank" title="Facebook">
										<i class="icon-facebook"></i>
										<i class="icon-facebook"></i>
									</a>
								</div>
							</div>

						</div>

					</div>

				</div>
			</div>

			<div id="copyrights">
				<div class="container center clearfix">
					Cariere in IT 2017 | All Rights Reserved
				</div>
			</div>

		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<div class="modal fade" id="eventData" tabindex="-1" role="dialog" aria-labelledby="eventModal">
		<div class="modal-dialog smallModal" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="eventModal">Detaliile evenimentului</h4>
				</div>
				<div class="modal-body">
					<h1 id="eventName"></h1>
					<p id="eventDescription"></p>
					<hr />
					<h2>Timeline-ul evenimentului</h2>
					<div id="timeline">
						<section id="cd-timeline" class="cd-container">
							
						</section>
					</div>
					<button class="btn btn-success" onclick="signup()">Inscrie-te pentru eveniment</button>
				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="jobOffers" tabindex="-1" role="dialog" aria-labelledby="eventModal">
		<div class="modal-dialog smallModal" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="eventModal">Oferte de internship &amp; job-uri din partea <span id="companyName"></span></h4>
				</div>
				<div class="modal-body" id="offerBody">

				</div>
				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="/template/js/jquery.js"></script>
	<script type="text/javascript" src="/template/js/plugins.js"></script>
	<script type="text/javascript" src="/js/showdown.min.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script type="text/javascript" src="/template/js/functions.js"></script>

	@if($is_logged)
		<script type="text/javascript" src="/js/main_app.js"></script>
	@endif
</body>
</html>