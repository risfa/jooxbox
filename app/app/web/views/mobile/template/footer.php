




<?php if(isset($flag) && $flag) { // ini buat template yg lama ?>
		
<?php } else { ?>
<div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="top:12%">
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
					<!--<button class="btn btn-danger btn-md"><i class="fa fa-envelope"></i> Message</button>-->
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


<footer class="footer">
		  <div class="container">
			<span class="text-muted pull-left">&copy; Jukebox 5D  <?php echo $this->config->item("copyright_year") ?> | www.limadigit.com &nbsp;&nbsp;&nbsp;&nbsp;</span> <span class="text-muted2 pull-right">Powered by: &nbsp;&nbsp;&nbsp;<img src='<?php echo base_url(); ?>assets/images/youtube.png' width="55px"/>&nbsp;&nbsp;&nbsp;<img src='<?php echo base_url(); ?>assets/images/soundcloud.png' width="40px"/></span>
		  </div>
		</footer>
		
<?php } ?>


<script src="<?php echo base_url(); ?>assets/css/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--<script src="<?php echo base_url(); ?>assets/css/bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>-->
<!--<script src="<?php echo base_url(); ?>assets/css/bootstrap/js/modal.js"></script>-->

</body>
</html>