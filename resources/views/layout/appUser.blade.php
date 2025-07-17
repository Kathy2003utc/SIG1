<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Turismos FK</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
	
	<!-- jQuery Validation Plugin -->
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

	<!-- Bootstrap 5 CSS & JS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />

	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

	<!-- SweetAlert2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Bootstrap FileInput -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.4/css/fileinput.min.css" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.4/js/fileinput.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.5.0/js/locales/es.min.js"></script>

	<!-- DataTables -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

	<!-- Google Maps -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdYzugNC_QlesLopg6J4884TRsBzvusjg&callback=initMap">
    </script>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Arizonia&display=swap" rel="stylesheet">

	<!-- Estilos personalizados -->
	<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
	<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">
	<link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">

	<!-- Icono -->
	<link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
</head>
<body>

	<!-- NAVBAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="ftco-navbar">
		<div class="container">
			<a class="navbar-brand" href="{{ url('/') }}">Pacific<span> Agencia CRUD</span></a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="ftco-nav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item"><a href="{{ route('admin.puntos.index') }}" class="nav-link">Lista de puntos Turisticos</a></li>
			</div>
		</div>
	</nav>

	@yield('contenido')

	<!-- FOOTER -->
	<footer class="ftco-footer bg-bottom" style="background-image: url('{{ asset('images/bg_3.jpg') }}');">
		<div class="container">
			<div class="row mb-5">
				<!-- Columna 1 -->
				<div class="col-md pt-5">
					<div class="ftco-footer-widget pt-md-5 mb-4">
						<h2 class="ftco-heading-2">About</h2>
						<p>Somos estudiantes emprendedores del turismo en Ecuador.</p>
						<ul class="ftco-footer-social list-unstyled">
							<li class="ftco-animate"><a href="#"><span class="fa fa-twitter"></span></a></li>
							<li class="ftco-animate"><a href="#"><span class="fa fa-facebook"></span></a></li>
							<li class="ftco-animate"><a href="#"><span class="fa fa-instagram"></span></a></li>
						</ul>
					</div>
				</div>

				<!-- Columna 2 -->
				<div class="col-md pt-5 border-left">
					<div class="ftco-footer-widget pt-md-5 mb-4 ml-md-5">
						<h2 class="ftco-heading-2">Información</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-2 d-block">Pico Katherin</a></li>
							<li><a href="#" class="py-2 d-block">Trujillo Israel</a></li>
							<li><a href="#" class="py-2 d-block">Agente Turístico</a></li>
							<li><a href="#" class="py-2 d-block">Privacidad</a></li>
							<li><a href="#" class="py-2 d-block">Políticas empresariales</a></li>
							<li><a href="#" class="py-2 d-block">Llámanos: 0990960365, 0958615103</a></li>
						</ul>
					</div>
				</div>

				<!-- Columna 3 -->
				<div class="col-md pt-5 border-left">
					<div class="ftco-footer-widget pt-md-5 mb-4">
						<h2 class="ftco-heading-2">Experiencias</h2>
						<ul class="list-unstyled">
							<li><a href="#" class="py-2 d-block">Aventura</a></li>
							<li><a href="#" class="py-2 d-block">Hotel y Restaurante</a></li>
							<li><a href="#" class="py-2 d-block">Playa de Manta</a></li>
							<li><a href="#" class="py-2 d-block">Viaje al Oriente</a></li>
							<li><a href="#" class="py-2 d-block">Campamento en el Boliche</a></li>
							<li><a href="#" class="py-2 d-block">Fiesta en la Cobacha</a></li>
						</ul>
					</div>
				</div>

				<!-- Columna 4 -->
				<div class="col-md pt-5 border-left">
					<div class="ftco-footer-widget pt-md-5 mb-4">
						<h2 class="ftco-heading-2">¿Preguntas?</h2>
						<ul class="list-unstyled">
							<li><span class="icon fa fa-map-marker"></span> Universidad Técnica de Cotopaxi, San Felipe</li>
							<li><a href="#"><span class="icon fa fa-phone"></span> +593 981864430</a></li>
							<li><a href="#"><span class="icon fa fa-envelope"></span> fabian@yourdomain.com</a></li>
						</ul>
					</div>
				</div>
			</div>

			<!-- Copyright -->
			<div class="row">
				<div class="col-md-12 text-center">
					<p>
						Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos los derechos reservados |
						Hecho con <i class="fa fa-heart"></i> por <a href="https://colorlib.com" target="_blank">Colorlib</a>
					</p>
				</div>
			</div>
		</div>
	</footer>

	<!-- Loader -->
	<div id="ftco-loader" class="show fullscreen">
		<svg class="circular" width="48px" height="48px">
			<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
			<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#F96D00"/>
		</svg>
	</div>

	<!-- Scripts personalizados -->
	<script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
	<script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
	<script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
	<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
	<script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('js/scrollax.min.js') }}"></script>
	<script src="{{ asset('js/google-map.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>

	<style>
        .error {
            color: red;
            font-weight: bold;
        }
        .form-control.error {
            border: 1px solid red;
        }
    </style>

	@if(session('success'))
	<script>
		Swal.fire({
		icon: 'success',
		title: 'CONFIRMACIÓN',
		text: "{{ session('success') }}"
		});
	</script>
	@endif

	@if(session('error'))
	<script>
		Swal.fire({
		icon: 'error',
		title: 'Error',
		text: "{{ session('error') }}"
		});
	</script>
	@endif


</body>
</html>
