<div class="col-lg-12 header-menu-jukebox fixed-header">
	<i class="fa fa-user"></i> <?php echo $this->config->item("edit_profile"); ?>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/lib/js/jquery.form.min.js"></script>
  <script>
  		$(document).ready(function(){
				var options = { 
					target:   '#output',   // target element(s) to be updated with server response 
					beforeSubmit:  beforeSubmit,  // pre-submit callback 
					uploadProgress: OnProgress,
					success:       afterSuccess,  // post-submit callback 
					resetForm: true        // reset the form after successful submit 
				}; 

				$("marquee").mouseover(function() {
					this.stop();
				}).mouseleave(function() {
					this.start();
				});

				var max= 5;
				if( $("input[type=checkbox]:checked").length == max ){
					$("input[type=checkbox]").attr('disabled', 'disabled');
					$("input[type=checkbox]:checked").removeAttr('disabled');
				}else{
					$("input[type=checkbox]").removeAttr('disabled');
				}
				
				$('#MyUploadForm').submit(function() { 
					$(this).ajaxSubmit(options);
					// return false to prevent standard browser submit and page navigation 
					return false; 
				});
				
				$("input[type=checkbox]").change(function(){
					if( $("input[type=checkbox]:checked").length == max ){
						$("input[type=checkbox]").attr('disabled', 'disabled');
						$("input[type=checkbox]:checked").removeAttr('disabled');
					}else{
						$("input[type=checkbox]").removeAttr('disabled');
					}
				});
			});
			function OnProgress(event, position, total, percentComplete)
			{
				//Progress bar
				// progressbar.width(percentComplete + '%') //update progressbar percent complete
				// statustxt.html(percentComplete + '%'); //update status text
				// if(percentComplete>50)
					// {
						// statustxt.css('color','#fff'); //change status text to white after 50%
					// }
				$("#back").hide();
				$("#save").hide();
				$("#changePassword").hide();
			}
			
			function afterSuccess(resp)
			{
				if(resp == 2) {
					$("#output").html("<?php echo $this->config->item("upload_failed"); ?>");
					$("#back").show();
					$("#save").show();
					$("#changePassword").show();
					$('#submit-btn').show(); //hide submit button
					$('#loading-img').hide(); //hide submit button
				} else {
					twitterImage = resp;
					$("#myImage").attr("src",twitterImage);
					$("#output").hide();
					$("#recentImage").attr("src",'<?php echo base_url(); ?>assets/'+resp);
					$("#back").show();
					$("#save").show();
					$("#changePassword").show();
					$('#submit-btn').show(); //hide submit button
					$('#loading-img').hide(); //hide submit button
				}
			}
			
			function beforeSubmit() {
			//check whether browser fully supports all File API
				if (window.File && window.FileReader && window.FileList && window.Blob) {
					if( !$('#imageInput').val()) { //check empty input filed 
						$("#output").html("Are you kidding me?");
						return false
					}
					var fsize = $('#imageInput')[0].files[0].size; //get file size
					var ftype = $('#imageInput')[0].files[0].type; // get file type
					//allow only valid image file types 
					switch(ftype) {
						case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
							break;
						default:
							$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
						return false
					}
					
					//Allowed file size is less than 1 MB (1048576)
					if(fsize>1048576) 
					{
						$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
						return false
					}
					
					//Progress bar
					// progressbox.show(); //show progressbar
					// progressbar.width(completed); //initial value 0% of progressbar
					// statustxt.html(completed); //set status text
					// statustxt.css('color','#000'); //initial color of status text
					
					$('#submit-btn').hide(); //hide submit button
					$('#loading-img').show(); //hide submit button
					$("#output").html("");  
				}
				else
				{
					//Output error to older unsupported browsers that doesn't support HTML5 File API
					$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
					return false;
				}
			}

			//function to format bites bit.ly/19yoIPO
			function bytesToSize(bytes) {
				var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
				if (bytes == 0) return '0 Bytes';
				var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
				return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
			}
			function validate() {
				var form = document.getElementById("formEditProfile");
				form.submit();
			}
</script>
<div class="col-lg-12 header-content-jukebox" style="top:15px;border-bottom:none;border-top:none;padding-bottom:90px">
	<center><img id="recentImage" onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="<?= (!filter_var($image, FILTER_VALIDATE_URL) === false)? $image : base_url().'assets/'.$image ?>" width="200px;"/></center>
	<p class="help-block" align="center" style="font-size:10px"><br>Image Type allowed: Jpeg, Jpg, Png and Gif. | Maximum Size 1 MB</p>
	<div class="col-lg-12">
	<center>
		<form action="<?php echo site_url(); ?>/EditProfile/upload" onSubmit="return false" method="post" enctype="multipart/form-data" id="MyUploadForm">
			<input id="imageInput" name="image_file" type="file" class="form-control" style="width:210px;float:left;">
			<button type="submit" class="btn btn-info" id="submit-btn">Upload</button>
			<img src="<?php echo $this->config->item("ajax_loader"); ?>" id="loading-img" style="display:none;" alt="Please Wait"/>
			<div id="output"></div>
		</form>
	</center>
	</div>
	<br>
	
	<div class="col-lg-12">
		<form id="formEditProfile" action="<?php echo site_url(); ?>/EditProfile/process" method="post" class="form-horizontal" enctype="multipart/form-data">
			<?php if(isset($_GET['err'])){ ?>
			<div id="error" class="alert alert-danger" role="alert">
				<small id="cetak-error"><b><?php echo $_GET['err']; ?></b></small>
			</div>
			<?php } ?>
		
			<input type="hidden" value="mobile" name="m"/>
			<div class="form-group">
				<label>Username</label>
				<input type="text" class="form-control" name="newUsername" placeholder="username" value="<?php echo $username; ?>">
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
			</div>
			<div class="form-group">
				<label><?php echo $this->config->item("about_title") ?></label>
				<textarea name="about" id="about" rows="6" class="form-control" placeholder="You're Bio"><?php echo $bio; ?></textarea>
			</div>
			
			<div class="form-group">
						<label><?php echo $this->config->item("music_genre_title") ?></label>
						<div class="checkbox">
						<?php
							$i = 1;
							foreach($this->config->item("genre") as $val) { 
								$check = "";
								if(in_array($val,$music_genre)) $check = "checked";
								if($i == 1) {
									echo '<div class="col-xs-6">';
									echo '<label>';
					  				echo '<input type="checkbox" id="genre" name="genre[]" value="'.$val.'" '.$check.'/> '.$val;
									echo '</label><br/>';
								} else if($i == count($this->config->item("genre"))/2) {
									echo '<label>';
					  				echo '<input type="checkbox" id="genre" name="genre[]" value="'.$val.'" '.$check.'/> '.$val;
									echo '</label><br/>';
									echo "</div>";	
								} else {
									echo '<label>';
						  			echo '<input type="checkbox" id="genre" name="genre[]" value="'.$val.'" '.$check.'/> '.$val;
									echo '</label><br/>';
								}
								if($i == count($this->config->item("genre"))/2) $i = 0;
								$i++;
							} 
						?>
						</div>
						</div>
			</div>
			<br/>
			<div class="form-group">
				<label><?php echo $this->config->item("food_title") ?></label>				
				<input type="text" id="food" name="food" value="<?php echo $food; ?>" data-role="tagsinput" class="form-control" style="margin-top:15px" placeholder="ex: Nasi goreng,Nasi capcay">
			</div>
			
			<div class="form-group">
				<label><?php echo $this->config->item("drink_title") ?></label>
				<input type="text" id="drink" name="drink" value="<?php echo $drink; ?>" data-role="tagsinput" class="form-control" style="margin-top:15px" placeholder="ex: Es teh tawar,Es teh manis">
			</div>
			
			<div class="form-group">
				<label><?php echo $this->config->item("hangout_place_title") ?></label>
				<input type="text" id="hangout_place" name="hangout_place" value="<?php echo $hangout_place; ?>" data-role="tagsinput" class="form-control" style="margin-top:15px" placeholder="ex: Rotishop,Blackseed">
			</div>
			<br/>
			<button type="button" id="save" onclick="validate()" class="btn btn-info btn-block">Save Change</button>
			
			<center>
				<small>
					<br>
					Do you want to change your password?<br> <a id="changePassword" href="#" data-toggle="modal" data-target="#changePass2">Yes, change my password</a>.
					<br>
				</small>
			</center>
		</form>
		<div class="modal fade" id="changePass2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="top:12%">
			<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<form action="<?php echo site_url(); ?>/EditProfile/changePassword" method="post">
					<div class="modal-header" style="background-color:#00aeff;color:white">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel" style="font-weight:700"><i class="fa fa-unlock-alt"></i> Change Password</h4>
					</div>
					<div class="modal-body">
					<input type="hidden" value="mobile" name="m"/>
					<div class="form-group">
						<label>Old Password</label>
						<input type="password" id="oldpass" name="oldpass" class="form-control" placeholder="Old Password" required />
					</div>
					<div class="form-group">
						<label>New Password</label>
						<input type="password" id="newpass" name="newpass" class="form-control" placeholder="New Password" required />
					</div>
					<div class="form-group">
						<label>Retype New Password</label>
						<input type="password" id="retype" name="retype" class="form-control" placeholder="Retype New Password" required />
					</div>						
					</div>
					<div class="modal-footer">
					<button type="submit" class="btn btn-info">Submit</button>						
					</div>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>