<link href="<?php echo base_url(); ?>bootstrap/docs/examples/signin/signin.css" rel="stylesheet">
<style>
	.loader {
	color: #00aeff;
	font-size: 15px;
	margin: 100px auto;
	width: 1em;
	height: 1em;
	border-radius: 50%;
	position: relative;
	text-indent: -9999em;
	-webkit-animation: load4 1.3s infinite linear;
	animation: load4 1.3s infinite linear;
	-webkit-transform: translateZ(0);
	-ms-transform: translateZ(0);
	transform: translateZ(0);
}
@-webkit-keyframes load4 {
	0%,
	100% {
		box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
	}
	12.5% {
		box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
	}
	25% {
		box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
	}
	37.5% {
		box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
	}
	50% {
		box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
	}
	62.5% {
		box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
	}
	75% {
		box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
	}
	87.5% {
		box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
	}
}
@keyframes load4 {
	0%,
	100% {
		box-shadow: 0 -3em 0 0.2em, 2em -2em 0 0em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 0;
	}
	12.5% {
		box-shadow: 0 -3em 0 0, 2em -2em 0 0.2em, 3em 0 0 0, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
	}
	25% {
		box-shadow: 0 -3em 0 -0.5em, 2em -2em 0 0, 3em 0 0 0.2em, 2em 2em 0 0, 0 3em 0 -1em, -2em 2em 0 -1em, -3em 0 0 -1em, -2em -2em 0 -1em;
	}
	37.5% {
		box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 0, 2em 2em 0 0.2em, 0 3em 0 0em, -2em 2em 0 -1em, -3em 0em 0 -1em, -2em -2em 0 -1em;
	}
	50% {
		box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 0em, 0 3em 0 0.2em, -2em 2em 0 0, -3em 0em 0 -1em, -2em -2em 0 -1em;
	}
	62.5% {
		box-shadow: 0 -3em 0 -1em, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 0, -2em 2em 0 0.2em, -3em 0 0 0, -2em -2em 0 -1em;
	}
	75% {
		box-shadow: 0em -3em 0 -1em, 2em -2em 0 -1em, 3em 0em 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0.2em, -2em -2em 0 0;
	}
	87.5% {
		box-shadow: 0em -3em 0 0, 2em -2em 0 -1em, 3em 0 0 -1em, 2em 2em 0 -1em, 0 3em 0 -1em, -2em 2em 0 0, -3em 0em 0 0, -2em -2em 0 0.2em;
	}
}
</style>

<script>
	var emailAddress;
	function validateEmail(email) {
		var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		return re.test(email);
	}
	
	function validate()
	{			
		email = $('#emailAddress').val();
		if (email == "") 
		{
			$('#error').show();
			$('#cetak-error').html('Please enter your email');
			$('#email').focus();
		}
		else if (validateEmail(email) == false) 
		{
			$('#error').show();
			$('#cetak-error').html('Please enter valid email');
			$('#email').focus();
		}
		else 
		{
			$.ajax({											
				url: '<?php echo site_url() ?>/forgotPassword/changepassword',
				type:'post',												
				data:{type : 'add' , mail : email},
				beforeSend: function()
				{
					$("#formReg").hide();
					$(".loader").show();
				},
				success: function(resp)
				{
					var result = JSON.parse(resp);
					// console.log(result.error_string);
					
					$("#formReg").show();
					$(".loader").hide();						
					if(result.error_string == "empty email")
					{
						$('#error').show();
						$('#cetak-error').html('We could not find your account with that information');
					}
					else if(result.error_string == "mail not found") 
					{
						$('#error').show();
						$('#cetak-error').html('Mail not found. Please check your email input');
					}
					else if(result.error_string  == 'update failed')
					{
						$('#error').show();
						$('#cetak-error').html('Search information failed. Please try again.');
					}
					else if(result.error_string  == 'update success')
					{
						swal("Congratulation!", "Check your email inbox or spam to set your new password. Thank you.", "success");
						setTimeout(function(){
							window.location.href = "<?php echo site_url(); ?>";
						},3000);
					}
				},
				error: function() {
					$("#submit").show();
					$('#error').show();
					$('#cetak-error').html('Connection Error. Please use another.');
				}
			});				
		}
	}
</script>

<body>
	<div class="container">
			<div class="col-sm-8 col-sm-offset-2  boxT">
					<div class="header clearfix">
						<img src="<?php echo $this->config->item("logo_blue") ?>" width="200px"/>			
						<p class="pull-right" style="padding-top:14px">							
							<small>Remember the password? <a href="<?php echo base_url() ?>"><?php echo $this->config->item("sign_in"); ?></a></small>
						</p>
					</div>
						<div class="col-md-12">								
							<div class="loader" style="display:none">Loading...</div>
							<form id="formReg" class="form-signin">
								<div class="form-group">
								<label for="exampleInputEmail1">Find your account.</label>
								<input type="text" id="emailAddress" name="email-address" class="form-control" placeholder="Email address..">
								</div>								 
								<div id="error" class="form-group" style="display:none">
									<div class="alert alert-warning alert-dismissible" style="margin-bottom:0px" role="alert">														
										 <strong><small id="cetak-error"></small></strong>
									</div>
								</div>
								<div class="form-group">
									<button id="submit" type="button" class="btn btn-primary btn-lg btn-block" data-loading-text="Loading..." onclick="validate()">Search</button>
								</div>
							</form>
						</div>
			</div>
	</div>
		
	</body>