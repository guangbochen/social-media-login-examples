@section('head')
@parent
<script type="text/javascript">
  // This function is called when someone finishes with the FB_Login Button.  
  function fb_login() {
    FB.login(function(response) {
      if (response.status === 'connected') {
        var access_token = response.authResponse.accessToken; //get access token
        $("#fb_token").val(access_token);
        $("#fb_login_form").submit();
      } else {
      //user hit cancel button
      console.log('User cancelled login or did not fully authorize.');
      }
    }, {
      scope: 'publish_stream,email' //defines access scope
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{{ $FB_APP_ID }}',
      cookie     : true,  // enable cookies to allow the server to access 
      // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.0' // use version 2.0
    });
  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>
@stop

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->
<div>
  <a href="#" onclick="fb_login();" class="fb-button">
    <i class="fa fa-facebook"></i>
    <div class="fb-text-container">
      Sign in with Facebook
    </div>
  </a>
  <form action="api/signin/fb" method="post" id="fb_login_form" class="hidden">
    <input type="text" class="hidden" name="fb_access_token" id="fb_token">
    <input type="text" class="hidden" name="state" value="{{ $STATE }}">
  </form>
</div>
