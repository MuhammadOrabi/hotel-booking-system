<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- jQuery UI -->
    <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- styles -->
    <link href="/css/styles.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    @yield('style')

<!-- Scripts -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
  </head>
  <body>
  	 <div id="app">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                        @else
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/home') }}">Dashboard</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{ url('/register') }}">Register</a></li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

    <div class="page-content">
    	<div class="row">
		  <div class="col-md-2">
		  	<div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                    <!-- Main menu -->
                    <?php 
                    	use Illuminate\Support\Facades\Route;
						$currentPath= Route::getFacadeRoot()->current()->uri();
                    ?>
                    <li @if($currentPath == 'home') class="current" @endif>
                    	<a href="{{ url('/home') }}"><i class="glyphicon glyphicon-home"></i> Dashboard</a>
                	</li>
                    <li @if($currentPath == '#') class="current" @endif>
                    	<a href="{{ url('/calendar') }}"><i class="glyphicon glyphicon-calendar"></i> Calendar</a>
                	</li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-list"></i> Rooms
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                   	  	    <li @if($currentPath == 'types/settings') class="current" @endif >
                   	  	    	<a href="{{ url('/types/settings') }}">Room Types</a>
               	  	    	</li>
	                        <li @if($currentPath == 'rooms/settings') class="current" @endif>
	                        	<a href="{{ url('/rooms/settings') }}" >Rooms</a>
	                        </li>
	                        <li @if($currentPath == 'reservation/update') class="current" @endif>
	                        	<a href="{{ url('/reservation/update') }}" >Cancel Reservations</a>
	                        </li>
	                        <li @if($currentPath == 'available/rooms') class="current" @endif>
	                        	<a href="{{ url('/available/rooms') }}">list available rooms</a>
                        	</li>
	                        <li @if($currentPath == 'not_available/rooms') class="current" @endif>
	                        	<a href="{{ url('/not_available/rooms') }}">list not available rooms</a>
                        	</li>
                        </ul>
                    </li>
                    <li @if($currentPath == '/reservations') class="current" @endif>
                    	<a href="{{ url('/reservations') }}"><i class="glyphicon glyphicon-list"></i>Reservations</a>
                	</li>
                    <li @if($currentPath == '#') class="current" @endif>
                    	<a href="#"><i class="glyphicon glyphicon-record"></i> Buttons</a>
                	</li>
                    <li @if($currentPath == '#') class="current" @endif>
                    	<a href="#"><i class="glyphicon glyphicon-pencil"></i> Editors</a>
                	</li>
                    <li @if($currentPath == '#') class="current" @endif><a href="#">
                    	<i class="glyphicon glyphicon-tasks"></i> Forms</a>
                	</li>
                    <li class="submenu">
                         <a href="#">
                            <i class="glyphicon glyphicon-list"></i> Pages
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                            <li @if($currentPath == '#') class="current" @endif></li>
                        </ul>
                    </li>
                </ul>
             </div>
		  </div>
		  <div class="col-md-10">
		  		@yield('content')
		  </div>
		</div>
    </div>

 
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/app.js"></script>
    @yield('scripts')
    <script src="/js/custom.js"></script>  
    </body>
</html>