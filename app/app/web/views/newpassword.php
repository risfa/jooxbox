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
	var newPass, cNewPass, id;
	function validate()
	{			
		newPass = $('#newPass').val();
		cNewPass = $('#cNewPass').val();
		id = <?php echo $user_id; ?>;
		
		if (newPass == "") 
		{
			$('#error').show();
			$('#cetak-error').html('Please enter your new password.');
			$('#newPass').focus();
		}
		else if (cNewPass == "") 
		{
			$('#error').show();
			$('#cetak-error').html('Please confirm your new password.');
			$('#cNewPass').focus();
		}
		else if (newPass != cNewPass) 
		{
			$('#error').show();
			$('#cetak-error').html('Your new password not match.');
			$('#cNewPass').focus();
		}			
		else 
		{
			
			$.ajax({											
				url: '<?php echo site_url() ?>/forgotPassword/changepassword',
				type:'post',												
				data:{type : 'edit', pass : newPass, uid : id},
				beforeSend: function()
				{
					$("#formReg").hide();
					$(".loader").show();
				},
				success: function(resp)
				{
					var result = JSON.parse(resp);
					
					$("#formReg").show();
					$(".loader").hide();						
					if(result.error_string == 'update failed')
					{
						$('#error').show();
						$('#cetak-error').html('Failed change password. please try again.');
					}
					else if(result.error_string == 'param not complete')
					{
						$('#error').show();
						$('#cetak-error').html('Failed change password. You must fill all the field');
					}
					else if(result.error_string == 'empty type')
					{
						$('#error').show();
						$('#cetak-error').html('Failed change password. Empty type.');
					}
					else if(result.error_string == 'update success')
					{
						swal("Congratulation!", "Your password was changed, go to login page to try it.", "success");
						setTimeout(function(){
							window.location.href = "<?php echo site_url() ?>";
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
								<label class="sr-only">New Password</label>
									<input type="password" id="newPass" class="form-control" placeholder="New Password" required autofocus>
									<label class="sr-only">Confirm New Password</label>
									<input type="password" id="cNewPass" class="form-control" placeholder="Confirm New Password" required>		
									<div id="error" class="form-group" style="display:none">
										<div class="alert alert-warning alert-dismissible" style="margin-bottom:0px" role="alert">														
											 <strong><small id="cetak-error"></small></strong>
										</div>
								  </div>
									<button class="btn btn-lg btn-primary btn-block" type="button" onclick="validate()">Submit</button>
							</form>
						</div>
			</div>
	</div>
		
	</body>