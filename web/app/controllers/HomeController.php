<?php

class HomeController extends BaseController {

  /*
  |--------------------------------------------------------------------------
  | Default Home Controller
  |--------------------------------------------------------------------------
  |
  | You may wish to use controllers instead of, or in addition to, Closure
  | based routes. That's great! Here is an example controller method to
  | get you started. To route to this controller, just add the route:
  |
  |	Route::get('/', 'HomeController@showWelcome');
  |
   */

  public function index()
  {
    if (Auth::check())
    {
      return Redirect::to('dashboard');
    }
    else
    {
      // Create a state token to prevent request forgery.
      // Store it in the session for later validation.
      $state = md5(rand());
      Session::put('state', $state);
      return View::make ('login', array(
        'GOOLE_CLIENT_ID' => Constants::GOOLE_CLIENT_ID,
        'FB_APP_ID' => Constants::FB_APPID,
        'STATE' => $state
      ));
    }
  }

  //get user dasboard after user login
  public function getDashboard()
  {
    if (Auth::check())
    {
      // The user is logged in...
      $user = Auth::user();
      $email = $user->email;
      $gravatar = GravatarHelper::get_gravatar ($email);
      return View::make ('dashboard')
        ->with('gravatar', $gravatar)
        ->with('user', $user);
    }
    else
    {
      return Redirect::to('/');
    }
  }

  //logout signed in user
  public function logout()
  {
    Auth::logout();
    return Redirect::to('/');
  }
}
