<!--<script src="<?php echo base_url(); ?>assets/css/bootstrap/dist/js/bootstrap.min.js"></script>-->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url(); ?>assets/css/bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
	<!--<script src="<?php echo base_url(); ?>assets/css/bootstrap/js/modal.js"></script>-->
<?php if(isset($flag) && $flag) { // ini buat template yg lama ?>
		
<?php } else { ?>
	<footer class="footer">
      <div class="container">
        <span class="text-muted">&copy; Jukebox 5D <?php echo $this->config->item("copyright_year") ?> | <a href="https://limadigit.com/" target="_blank" style="color:white">www.limadigit.com</a> &nbsp;&nbsp;&nbsp;&nbsp;</span> <span class="text-muted2"><a href="<?php echo $this->config->item("fb_jukebox5d") ?>" target="_blank"><i class="fa fa-facebook-square fa-2x"></i></a> &nbsp; <a href="<?php echo $this->config->item("twitter_jukebox5d") ?>" target="_blank"><i class="fa fa-twitter fa-2x"></i></a>&nbsp;  <a href="<?php echo $this->config->item("ig_jukebox5d") ?>" target="_blank"><i class="fa fa-instagram fa-2x"></i></a></span>
		<span class="powered pull-right"><a style="cursor:pointer;color:white" id="howto" data-toggle="modal" data-target="#howtoModal" href="#" ><?php echo $this->config->item("ht") ?></a> &nbsp;&nbsp;|&nbsp;&nbsp; <a style="cursor:pointer;color:white" data-toggle="modal" data-target="#privacyModal" href="#"><?php echo $this->config->item("pp") ?></a> &nbsp;&nbsp;|&nbsp;&nbsp; Powered by : &nbsp;&nbsp;<img class="img-footer" src='<?php echo base_url(); ?>assets/images/youtube.png'/>&nbsp;&nbsp;&nbsp;<img class="img-footer" src='<?php echo base_url(); ?>assets/images/soundcloud.png'/></span>
      </div>
    </footer>
				
				<div class="modal fade" id="howtoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header" style="background-color:#00aeff;color:white">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel" style="font-weight:700"><i class="fa fa-info-circle"></i> <?php echo $this->config->item("how_to") ?></h4>
					  </div>
					  <div class="modal-body">
						<iframe src="<?php echo $this->config->item("video_tutorial"); ?>" width="100%" height="400" style="border:none"></iframe>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->config->item("close") ?></button>						
					  </div>
					</div>
				  </div>
				</div>
				
				<div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header" style="background-color:#00aeff;color:white">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel" style="font-weight:700"><i class="fa fa-black-tie"></i> <?php echo $this->config->item("pp") ?></h4>
					  </div>
					  <div class="modal-body">	
						<div class="row">
							<div class="col-sm-12">
								<center>
									<img src="<?php echo $this->config->item("logo5d2"); ?>" width="80px"/>
									<h2 class="form-signin-heading" style="margin-bottom:10px"><?php echo $this->config->item("privacy_policy"); ?></h2>
								</center>
									<br>
									<br>
								<?php echo $this->config->item("privacy_policy_body"); ?>
							</div>
						</div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->config->item("close"); ?></button>						
					  </div>
					</div>
				  </div>
				</div>
			
					<div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
							<div id="loading" style="display:none;text-align: center;padding-top:20px;padding-bottom:25px;">
								<img src="<?php echo $this->config->item("ajax_loader"); ?>"/>
							</div>
							<div id="error" style="display:none;text-align: center;"></div>
						  <div class="modal-body" id="bodyUserModel" style="display:none;">
								<a class="pull-right" data-dismiss="modal"><i class="fa fa-times"></i></a>
								<div class="row" style="padding:15px 0px 15px 0px">
									
									<div class="col-xs-12 text-center">																			
										
										<img id="userDetail-image" onError="this.onerror=null;this.src='<?php echo $this->config->item("user_default"); ?>';" width="120px"/>
										<h3 class="username-user" id="userDetail-username"></h3>
										<div class="col-xs-12" style="padding-bottom:10px">
										<b id="followerCount"></b> <small class="followers-text">Followers</small> | <b id="followingCount"></b> <small class="followers-text">Following</small>
										</div>
										<p id="userDetail-bio"></p>
										<div id="loading" style="text-align: center;display:none;">
											<img src="<?php echo $this->config->item("ajax_loader"); ?>"/>
										</div>
										<div id="errorFollow" style="text-align:center;display:none;"></div>
										<button class="btn btn-success btn-md" style="padding:6px 23px" id="buttonFollow" button-type="follow"><i class="fa fa-plus"></i> Follow</button>
										<!-- <button class="btn btn-danger btn-md"><i class="fa fa-envelope"></i> Message</button>-->
										<br/>
										<br/>
										<br/>
										
										
										
										<div id="tabUser" class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="..." style="display:none;">
											<div class="btn-group" role="group">
												<button type="button" class="btn btn-info" href="#tab1" data-toggle="tab" style="border-radius:0px"><span class="fa fa-user" aria-hidden="true"></span>
													<div class="hidden-xs">Profile</div>
												</button>
											</div>
											<div class="btn-group" role="group">
												<button type="button" class="btn btn-default" href="#tab2" data-toggle="tab" style="border-radius:0px"><span class="fa fa-history" aria-hidden="true"></span>
													<div class="hidden-xs"><?php echo $this->config->item("rs") ?></div>
												</button>
											</div>											
										</div>
										
										 
			
									</div>
									<br/>
									<div id="bodyTabUser" class="col-xs-12" style="display:none;">
										<div class="well" style="background-color:#fff;border-radius:0px">
										  <div class="tab-content">
											<div class="tab-pane fade in active" id="tab1">
											 <div class="row"><span id="userDetail-music-genre"></span></div>
											 <hr>
											 <div class="row"><span id="userDetail-food"></span></div>
											 <hr>
											 <div class="row"><span id="userDetail-drink"></span></div>
											 <hr>
											 <div class="row"><span id="userDetail-hangout-place"></span></div>
											 
											</div>
											<div class="tab-pane fade in" id="tab2">
												<table class="table table-striped" id="tableRecentSongUser"></table>
												<!--<table class="table table-striped text-center">
													<tr>
														<td><small>You must follow this person to see his/her recent song</small></td>
													</tr>
												</table>-->
											</div>											
										  </div>
										</div>
									</div>
									
								</div>								
						  </div>
						  <!--<div class="modal-footer">
							
						  </div>-->
						</div>
					  </div>
					</div>
<?php } ?>


</body>
</html>