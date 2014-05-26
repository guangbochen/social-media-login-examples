@section('head')
@parent
<!-- extending header goes here -->
<!-- Place this asynchronous JavaScript just before your </body> tag -->
<meta name="google-signin-clientid" content="{{ $GOOLE_CLIENT_ID }}" />
<meta name="google-signin-scope" content="https://www.googleapis.com/auth/plus.profile.emails.read https://www.googleapis.com/auth/plus.login" />
<meta name="google-signin-requestvisibleactions" content="https://schemas.google.com/AddActivity" />
<meta name="google-signin-cookiepolicy" content="single_host_origin" />

<script type="text/javascript">
 (function() {
   var po = document.createElement('script');
   po.type = 'text/javascript'; po.async = true;
   po.src = 'https://apis.google.com/js/client:plusone.js?onload=render';
   var s = document.getElementsByTagName('script')[0];
   s.parentNode.insertBefore(po, s);
 })();

/* Executed when the APIs finish loading via po.src= ?onload=render */
function render() {
  // Additional params including the callback, the rest of the params will
  // come from the page-level configuration.
  var additionalParams = {
    'callback': signinCallback
  };

  // Attach a click listener to a button to trigger the flow.
  var signinButton = document.getElementById('google_sign_btn');
    signinButton.addEventListener('click', function() {
      gapi.auth.signIn(additionalParams); // Will use page level configuration
    });
}

/**
 * Calls the server endpoint to connect the app for the user. The client
 * sends the one-time authorization code to the server and the server
 * exchanges the code for its own tokens to use for offline API access.
 * For more information, see:
 *   https://developers.google.com/+/web/signin/server-side-flow
 */
function signinCallback(authResult) {
  if (authResult['access_token']) {
    // The user is signed in
    $("#g_access_code").val(authResult['code']);
    $("#google_login_form").submit();
  } else if (authResult['error']) {
    // There was an error, which means the user is not signed in.
    console.log(authResult['error']);
  }
}
</script>
@stop
<!-- g-signin class will use page level configuration to login Google user -->
<div id="google_sign_btn">
  <span class="g_icon"><i class="fa fa-google"></i></span>
  <span class="g_buttonText">Sign in with Google</span>
</div>
<!-- hidden google login form -->
<form action="api/signin/google" method="post" id="google_login_form" class="hidden">
  <input type="text" class="hidden" name="g_access_code" id="g_access_code">
  <input type="text" class="hidden" name="state" value="{{ $STATE }}">
</form>


