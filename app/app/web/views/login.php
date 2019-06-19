	<style>
		h1
		{
			margin: 0;
			padding: 10px 0;
			font-size: 5.0em;
			font-weight: 700;
			color: #fff;
			font-family: 'Palanquin Dark', sans-serif;
		}

		.login-or {
			position: relative;
			font-size: 18px;
			color: #aaa;
			margin-top: 10px;
							margin-bottom: 10px;
			padding-top: 10px;
			padding-bottom: 10px;
		}
		.span-or {
			display: block;
			position: absolute;
			left: 50%;
			top: 2px;
			margin-left: -10px;
			background-color: rgb(245, 245, 245);
			width: 20px;
			text-align: center;
			font-size:12px;
		}
		.hr-or {
			background-color: #cdcdcd;
			height: 1px;
			margin-top: 0px !important;
			margin-bottom: 0px !important;
		}

		#buttonFb, #buttonPath
		{
			box-shadow: 0 4px 2px -2px #888;
			line-height:1.5;
		}

		#buttonFb:hover, #buttonPath:hover
		{
			box-shadow: 0px 0px 6px #1C86EE;
		}


		@media (min-width: 769px)
		{
			#logo-path
			{
				padding-bottom:6px;
			}
		}

		@media (max-width: 768px)
		{
			#logo-path
			{
				padding-top:6px;
			}
		}




	</style>
	<meta name="google-signin-client_id" content="384147661510-v63lrqj3laham6aaru2ep6ogjvalbupl.apps.googleusercontent.com">
</head>
<body>

 <div class="container">
 	<form class="form-signin" id="formsignin" method="post">

				<div class="col-lg-12 boxT">
					<center><img src="<?php echo $this->config->item("logo_login_jukebox"); ?>" width="100px" />
					<br/>
					<br/>
					<small style="font-family: 'Lato', sans-serif;font-size:10px;"><i><?php echo $this->config->item("subtitle") ?></i> </small></center>
					<br>
					<center>
						<a target="_blank" href='<?php echo $this->config->item("play_store_link") ?>'><img alt='undefined' width="150px" src='<?php echo $this->config->item("google_play_logo"); ?>'/></a>
						<a target="_blank" href='<?php echo $this->config->item("app_store_link") ?>'><img alt='undefined' width="150px" src='<?php echo $this->config->item("app_store_logo"); ?>'/></a>
					</center>
					<br>
						<div  class="fb-login-button" data-max-rows="1" data-size="large" data-button-type="continue_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false" style="padding-right: 90px"></div>
						<button type="button" id="logout_fb" style="display:none;"  >Logout Facebook</button>
					<div id="boxLogin">
						<!-- Login via FB -->
						<!-- <a onclick="checkLogin()" style="display:none;text-align:center;border-radius:0px;font-size:13px;margin-bottom:10px" id="buttonFb" class="btn btn-block btn-md btn-social btn-facebook"> -->


							<!-- <span class="fa fa-facebook" style="border:none"></span> <?php echo $this->config->item("facebook_login"); ?> -->
						<!-- </a> -->
						<!-- Login via FB -->

						<!-- Login via Google+ -->
						<div class="g-signin2" data-width="270" data-onsuccess="onSignIn" style="display:none;text-align:left;margin-bottom:10px" id="buttonGp" data-longtitle="true"></div>
						<!-- Login via Google+ -->

						<!-- Login via Path -->
						<a class="btn btn-block btn-md btn-social btn-pinterest" style="display:none;text-align:center;border-radius:0px;font-size:13px" onclick="PopupCenterDual('https://partner.path.com/oauth2/authenticate?response_type=code&client_id=<?php echo $this->config->item('path_client_id') ?>','Jukebox 5D','500','300')" id="buttonPath">
							<span style="border:none;"><img id="logo-path" src="<?php echo $this->config->item("path_logo"); ?>" width="18px"/></span> <?php echo $this->config->item("path_login"); ?>
						</a>
						<!-- Login via Path -->

						<div class="login-or">
							<hr class="hr-or">
						</div>
						<div class="alert alert-danger" role="alert" align="center" id="error">
						</div>
						<!--<center><label id="error" style='color:red;display:none;'></label></center>-->
						<!--<input type="hidden" id="lat" name="lat"/>
						<input type="hidden" id="long" name="long"/>-->
						<label for="inputEmail" class="sr-only"><?php echo $this->config->item("username"); ?></label>
						<input type="text" name="username"  id="username" class="form-control" placeholder="Email" required autofocus>
						<label for="inputPassword" class="sr-only"><?php echo $this->config->item("password"); ?></label>
						<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
						<small>
							<a class="pull-left" href="<?php echo site_url(); ?>/forgotPassword"><i class="fa fa-lock" aria-hidden="true"></i> <?php echo $this->config->item("forgot_pass") ?></a>
							<a class="pull-right" href="<?php echo site_url(); ?>/register"><i class="fa fa-user-plus" aria-hidden="true"></i> <?php echo $this->config->item("sign_up") ?></a></small>
						<br>
						<button style="display:none; margin-top:5px" id="buttonIn" class="btn btn-md btn-danger btn-block" type="button"><?php echo $this->config->item("sign_in"); ?></button>
						<center><label id="wait" style="color:red;"><?php echo $this->config->item("get_location"); ?></label></center>
					</div>

					<div id="loading" style="display:none;text-align: center;">
						<img src="<?php echo $this->config->item("ajax_loader"); ?>"/>
					</div>
					<br>
					<center>
						<small style='color:#888'><?php echo $this->config->item("copyright") ?> <a href='https://limadigit.com/' target='_blank'><?php echo $this->config->item("5D"); ?></a></small><br/>
					</center>
				</div>

      </form>


 </div>
 <script src="<?php echo base_url(); ?>assets/js/googlePlatform.js" async defer></script>
 <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
 <script type="text/javascript">
 	var path_name = '<?= ("" !== $this->session->userdata("path_name")) ? $this->session->userdata("path_name") : "" ?>';
 	var path_image = '<?= ("" !== $this->session->userdata("path_image")) ? $this->session->userdata("path_image") : "" ?>';
 	var path_email = '<?= ("" !== $this->session->userdata("path_email")) ? $this->session->userdata("path_email") : "" ?>';

 	function PopupCenterDual(url, title, w, h) {
		// Fixes dual-screen position Most browsers Firefox
		var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
		width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
		height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

		var left = ((width / 2) - (w / 2)) + dualScreenLeft;
		var top = ((height / 2) - (h / 2)) + dualScreenTop;
		var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

		// Puts focus on the newWindow
		if (window.focus) {
			newWindow.focus();
		}
	}

	function ajaxLogin(name, email, image, from) {
		$.ajax({
			url : '<?php echo site_url(); ?>/Login/SosmedLogin',
			type : 'POST',
			data : {
				name : name,
				email : email,
				// lat : $("#lat").val(),
				// long : $("#long").val(),
				image : image,
				from : from
			},
			beforeSend: function() {
				$("#boxLogin").hide();
				$("#loading").show();
			},
			success : function(response){
				var json=JSON.parse(response);
				if(json.status){
					if(json.isAdmin) {
						location.href="<?php echo $this->config->item("http_server") ?>/home";
					} else {
						location.href="<?php echo $user_home; ?>/place";
					}
				}else{
					console.log(json.message);
					$("#boxLogin").show();
					$("#loading").hide();
					$("#error").html("<small><b>"+json.message+"</b></small>");
					$("#error").show();
				}
			},
			error : function() {
				$("#boxLogin").show();
				$("#loading").hide();


				$("#error").html("<small><b><?php echo $this->config->item("error_500") ?></b></small>");
				$("#error").show();
			}
		});
	}

	function pathLogin() {
		if(path_name != "" && path_image != "" && path_email != "") {
			ajaxLogin(path_name, path_email, path_image, "path");
		}
	}

 	$(document).ready(function(){
 		// getLocation();
		$("#error").hide();
		pathLogin();
		interval = setInterval(function(){checkInput()},1000);
		$('#password').keydown(function (event) {
			var keypressed = event.keyCode || event.which;
			if (keypressed == 13) {
				doLogin();
			}
		});
		$("#buttonIn").click(function() {
			doLogin();
		});
 	});

 	function onSignIn(googleUser) {
		var profile = googleUser.getBasicProfile();
		ajaxLogin(profile.getName(), profile.getEmail(), profile.getImageUrl, "googleplus");
	}

 	function doLogin() {
		$("#boxLogin").hide();
		$("#loading").show();
		$.ajax({
			url : "<?php echo $user_home; ?>/login/process",
			type: "POST",
			data : {
				username : $("#username").val(),
				password : $("#password").val(),
				// lat : $("#lat").val(),
				// long: $("#long").val()
			},
			success : function(resp){
				var json=JSON.parse(resp);
				if(json.status){
					if(json.isAdmin) {
						location.href="<?php echo $this->config->item("http_server") ?>/home";
					} else {
						location.href="<?php echo $user_home; ?>/place";
					}
				}else{
					$("#boxLogin").show();
					$("#loading").hide();
					$("#error").html("<b><small>"+json.message+"</small></b>");
					$("#error").show();
				}
			},
			error : function() {
				$("#boxLogin").show();
				$("#loading").hide();
				$("#error").html("<b><small><?php echo $this->config->item("error_500") ?></small></b>");
				$("#error").show();
			}
		});
	}

 	// function showPosition(position) {
		// document.getElementById("lat").value = position.coords.latitude;
		// document.getElementById("long").value = position.coords.longitude;
		// pathLogin();
	// }

	function checkInput() {
		if($("#lat").val() == "") {
			$("#buttonIn").hide();
			$("#buttonFb").hide();
			$("#buttonGp").hide();
			$("#buttonPath").hide();
			$("#wait").show();
		} else {
			$("#buttonIn").show();
			$("#buttonFb").show();
			$("#buttonGp").show();
			$("#buttonPath").show();
			$("#wait").hide();
			clearInterval(interval);
		}
	}

 	// function getLocation() {
		// if (navigator.geolocation) {
			// navigator.geolocation.getCurrentPosition(showPosition);
		// } else {
			// console.log("Geolocation is not supported by this browser.");
		// }
	// }
	// function statusChange(response){
	// 	var token=response.authResponse.accessToken;
	// 	if (response.status === 'connected') {
	// 	      FB.api('/me','get', { access_token: token, fields: 'id,name,gender,email' }, function(response) {
	// 			  var nameFb=response.name;
	// 			  var emailFb=response.email;
	// 			  FB.api("/me/picture?width=180&height=180",{ access_token: token },  function(response2) {
	// 				  console.log(response2.data.url);
	// 				  ajaxLogin(nameFb, emailFb, response2.data.url, "fb");
	// 			  });
	// 	      });
	// 	    }
	// }




	// function checkLogin() {
	// 	FB.getLoginStatus(function(response) {
	// 		statusChangeCallback(response);
	// 	}, {scope: 'public_profile,email'});

	// }

	// window.fbAsyncInit = function() {
	//   FB.init({
	//     appId      : '514132985440691',
	//     cookie     : true,  // enable cookies to allow the server to access  the session
	//     xfbml      : true,
	//     version    : 'v2.11'
	//   });
	// };


	// (function(d, s, id) {
	// 	var js, fjs = d.getElementsByTagName(s)[0];
	// 	if (d.getElementById(id)) return;
	// 	js = d.createElement(s); js.id = id;
	// 	js.src = "//connect.facebook.net/en_US/sdk.js";
	// 	fjs.parentNode.insertBefore(js, fjs);
	// }(document, 'script', 'facebook-jssdk'));



	// window.fbAsyncInit = function() {
 //    FB.init({
 //      appId      : '514132985440691',
 //      cookie     : true,  // enable cookies to allow the server to access
 //                          // the session
 //      xfbml      : true,  // parse social plugins on this page
 //      version    : 'v2.11' // use graph api version 2.8
 //    });


 //      (function(d, s, id) {
 //    var js, fjs = d.getElementsByTagName(s)[0];
 //    if (d.getElementById(id)) return;
 //    js = d.createElement(s); js.id = id;
 //    js.src = "https://connect.facebook.net/en_US/sdk.js";
 //    fjs.parentNode.insertBefore(js, fjs);
 //  }(document, 'script', 'facebook-jssdk'));

</script>


<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
    			var token=response.authResponse.accessToken;
      testAPI(token);
    } else {
      // The person is not logged into your app or we are unable to tell.
      // document.getElementById('status').innerHTML = 'Please log ' +
      //   'into this app.';

    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
      // console.log(response);
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '514132985440691',
      cookie     : true,  // enable cookies to allow the server to access
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.11' // use graph api version 2.8
    });

    // Now that we've initialized the JavaScript SDK, we call
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function(response) {

      statusChangeCallback(response);

      // console.log(response);
    });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI(token) {

    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me','get', { access_token: token, fields: 'id,name,gender,email' }, function(response) {
      console.log('Successful login for: ' + response.name);
      console.log(response);
      			var nameFb=response.name;
				  var emailFb=response.email;
					  ajaxLogin(nameFb, emailFb, '', "fb");
						// $('#logout_fb').css('display','block')
      // document.getElementById('status').innerHTML =
      //   'Thanks for logging in, ' + response.name + '!';
    });
  }

	$('#logout_fb').click(function(){

		// FB.getLoginStatus(function(response) {
		// 	console.log(response.status)
    //     if (response.status === 'connected') {
    //         FB.logout(function(response) {
    //             document.location.reload();
    //         });
    //     }
    // });
	})
</script>
