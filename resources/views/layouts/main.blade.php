<!doctype html>
<html lang="{{App::getLocale()}}">
  <head>
  	<title>@yield('title') - Exams</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="shortcut icon" href="{{('/images/favicon.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/jquery.toast.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    @yield('styles')
  </head>
  <body>
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar" class="d-flex">
				<div class="d-flex flex-column justify-content-between p-4">
	        <ul class="list-unstyled components mb-5">

	          <li>
              <a href="{{route('index')}}">Inicio</a>
            </li>
            @if (Auth::user()->administrador == 1)
              <li>
                <a href="{{route('materias')}}">Materias</a>
              </li>
            @endif
            @if (Auth::user()->administrador == 1 || Auth::user()->facilitador == 1)
              <li>
                <a href="#examenSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Examenes</a>
                <ul class="collapse list-unstyled" id="examenSubmenu">
                  @if (Auth::user()->administrador == 1)
                  <li>
                      <a href="/examenes">Todos</a>
                  </li>

                  <li>
                      <a href="/examenes/create">Nuevo Examen</a>
                  </li>
                  @endif

                  <li>
                      <a href="/examenes/completados">Completados</a>
                  </li>
                </ul>
              </li>
            @endif
            @if (Auth::user()->administrador == 1)
              <li>
                <a href="{{route('panel_usuarios')}}">Panel De Usuarios</a>
              </li>
            @endif
	        </ul>
	        <div class="footer">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              {{-- Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a> --}}
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <a href="http://seguratesting.com/" target="_blank">Pedro Segura</a>
            </div>
	      </div>
    	</nav>
        <!-- Page Content  -->
      <div id="content" class="">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>
            <div>
              <ul class="nav navbar-nav ml-auto flex-row">
                <li class="nav-item active">
                  <span class="nav-link">{{Auth::user()->name}}</span>
                </li>
                <li class="nav-item align-self-center">
                  <a href="/password/change">
                    <i class="fa fa-key btn btn-link text-warning btn-sm text-decoration-none" aria-hidden="true"></i>
                  </a>
                </li>
                <li class="nav-item align-self-center" style="cursor: pointer">
                  <i onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="fa fa-power-off btn btn-link btn-sm text-decoration-none" aria-hidden="true"></i>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form> 
                
              </ul>
            </div>
          </div>
        </nav>
        <section class="p-3">
          @yield('content')
        </section>
      </div>
		</div>

    <script src="{{asset('/js/jquery.js')}}"></script>
    <script src="{{asset('/js/popper.js')}}"></script>
    <script src="{{asset('/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('/plugins/MDB/js/mdb.min.js')}}"></script>
    <script src="{{asset('/js/vue.js')}}"></script>
    <script src="{{asset('/js/vee-validate.js')}}"></script>
    <script src="{{asset('/js/jquery.toast.js')}}"></script>
    <script src="{{asset('/js/moment.js')}}"></script>
    <script src="{{asset('/js/axios.js')}}"></script>
    <script src="{{asset('/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('/js/loadingoverlay.js')}}"></script>
    <script src="{{asset('/js/jquery.countdown.min.js')}}"></script>
    
    
    <script src="{{asset('/js/main.js')}}"></script>

    <script>
      var homepath = "{{url('/')}}";

    </script>

    @yield('scripts')
  </body>
</html>