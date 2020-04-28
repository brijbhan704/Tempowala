<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{ url('/') }}/vendors/jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form class="form-horizontal" id="loginForm" role="form" method="POST" action="{{ route('login') }}">
              {{ csrf_field() }}
              <h1>Login Form</h1>
              @if ($errors->has('email'))
                  <span class="help-block text-left">
                      <strong>{{ $errors->first('email') }}</strong>
                  </span>
              @endif
              @if ($errors->has('password'))
                  <span class="help-block text-left">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif
              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
              </div>
              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                <input id="password" type="password" class="form-control" name="password" required>
              </div>

              <div class="form-group">
                  <div class="col-md-12 text-left">
                      <button type="button" id="loginFormBtn" class="btn btn-primary">
                          Login
                      </button>
                  </div>
              </div>

              <div class="clearfix"></div>


            </form>
          </section>
        </div>
        <script>
        var IV = '1234567890123412';
        var KEY = '201707eggplant99';
        function encrypt(str) {
            key = CryptoJS.enc.Utf8.parse(KEY);// Secret key
            var iv= CryptoJS.enc.Utf8.parse(IV);//Vector iv
            var encrypted = CryptoJS.AES.encrypt(str, key, { iv: iv, mode: CryptoJS.mode.CBC, padding: CryptoJS.pad.Pkcs7});
            return encrypted.toString();
        }

        jQuery(document).ready(function(){
          jQuery("#loginFormBtn").click(function(){    

                            
              var email = jQuery('#email').val();                            
              encryptedEmail = encrypt(email);              
              var password = jQuery('#password').val();                            
              encryptedPassword = encrypt(password);    

              jQuery('#email').val(encryptedEmail);
              jQuery('#password').val(encryptedPassword);
              jQuery("#loginForm").submit(); // Submit the form
            });
        });


        
        /**
        * encryption
        */
        
</script>
        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
              <div class="clearfix"></div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
