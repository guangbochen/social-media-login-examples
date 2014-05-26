<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Social Meida Login Example with Laravel</title>
<!-- load css -->
<link href="/css/main.css" type="text/css" rel="stylesheet" >
@section('head')
@show
</head>
<body>
<div class="container">
  <div class="header">
    <ul class="nav nav-pills pull-right">
      @if(Auth::check())
      <li>
      <a class="dropdown-toggle" data-toggle="dropdown"> 
        <img data-src="holder.js/140x140" class="img-rounded" alt="icon" 
        src="{{ \GravatarHelper::get_gravatar (Auth::user()->email ) }}" style="width: 22px; height: 22px;">
        {{ Auth::user()->first_name }}
        <span class="caret"></span>
      </a>
      <ul class="dropdown-menu">
        <li class="dropdown-header">User Center</li>
        <li class="divider"></li>
        <li><a role="menuitem" tabindex="-1" href="/dashboard">Dashboard</i></a></li>
        <li><a role="menuitem" tabindex="-1" href="/logout"><i class="fa fa-sign-out"> Sign out</i></a></li>
      </ul>
      </li>
      @else
      <li><a href="#">Login</a></li>
      @endif
    </ul>
    <h3 class="text-muted">Login with Social Media</h3>
  </div>


  @yield('content')


  <div class="footer">
    <p>© copyright <a href="https://github.com/guangbochen/social-media-login-examples" target="_blank">
      guangbochen/social-media-login-examples</a> 2014</p>
  </div>
</div> <!-- /container -->


<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
@section('javascript')
@show
</body>
</html>
