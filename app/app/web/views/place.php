<body onload="getLocationOnReady()">
    <div class="container">
		<div class="form-signin">
			<div class="col-lg-12 boxT">
				<center><img src="<?php echo $this->config->item("logo_login_jukebox"); ?>" width="100px" />
				<br/>
				<br/>
				<input type="hidden" id="lat" name="lat"/>
				<input type="hidden" id="long" name="long"/>
				<small style="font-family: 'Lato', sans-serif;font-size:10px;"><i><?php echo $this->config->item("subtitle") ?></i> </small></center>
				<br>
				<center>
					<a target="_blank" href='<?php echo $this->config->item("play_store_link") ?>'><img alt='undefined' width="150px" src='<?php echo $this->config->item("google_play_logo"); ?>'/></a>
					<a target="_blank" href='<?php echo $this->config->item("app_store_link") ?>'><img alt='undefined' width="150px" src='<?php echo $this->config->item("app_store_logo"); ?>'/></a>
				</center>
				<br>
					<center><label id="error" style="color:red;display:none;"></label></center>
					<div class="panel panel-default" id="boxLocation" style="display:none;">
						<div class="panel-heading"><i class="fa fa-unlock-alt"></i> <?php echo $this->config->item("choose_admin"); ?> <i class="fa fa-refresh pull-right" style="cursor:pointer" onclick="getLocationOnReady()"></i></div>
							<div class="panel-body" id="boxAllLocation" style="background-color:transparent;max-height:155px;overflow-y:auto">
							</div>
						
					</div>
					
					<div id="loading" style="text-align: center;">
						<img src="<?php echo $this->config->item("ajax_loader"); ?>"/>						
					</div>
					
					<center id="cancelPlay" style="display:none;"><small><?php echo $this->config->item("cancel_play"); ?> <a href="<?php echo site_url(); ?>/login/logout"><?php echo $this->config->item("sign_out"); ?></a></small></center>
			</div>
		</div>
    </div>
</body>

<script>
	var userid = '<?php echo $this->session->userdata("user_id"); ?>';
	var interval;
	function getLocation(loc,idAdmin, usernameAdmin, latlong) {
		$("#boxLocation").hide();
		$("#cancelPlay").hide();
		$("#loading").show();
		$.ajax({
			url:"<?php echo site_url(); ?>/place/updatelocation",
			type: "POST",
			data: {
				location: loc,
				ida: idAdmin,
				usernameAdmin: usernameAdmin,
				latlong: latlong
			},
			success: function(resp) {
				var result = JSON.parse(resp);
				if(result.status) {
					location.href = "<?php echo site_url(); ?>/home"
				} else {
					$("#error").html(result.message);
					$("#error").show();
				}
			}
		});
	}
	
	function refreshLocation(position) {
		// getLocationOnReady();
		$.ajax({
			url:"<?php echo site_url(); ?>/place/getAllAdmin",
			type: "POST",
			data: {
				lat: position.coords.latitude,
				long: position.coords.longitude
			},
			beforeSend: function() {
				$("#boxLocation").hide();
				$("#cancelPlay").hide();
				$("#loading").show();
			},
			success: function(resp) {
				// console.log(resp);
				$("#boxAllLocation").html("");
				$("#boxLocation").show();
				$("#cancelPlay").show();
				$("#loading").hide();
				var result = JSON.parse(resp);
				var allLocation = result.all_location;
				var html = "";
				if(result.status) {
					$.each(allLocation, function(x,y) {
						var split = y.split("#");
						var onclick = 'getLocation("'+x+'","'+split[1]+'","'+split[2]+'","'+split[3]+'#'+split[4]+'")';
						html += "<a onclick='"+onclick+"' style='cursor:pointer'>"+
											"<div class='col-xs-12' style='margin-bottom:15px;'>"+
												"<div class='col-xs-4' style='padding-right:0px' align='right'>"+
													"<i class='fa fa-map-marker fa-3x icon-color'></i>"+
												"</div>"+
												"<div class='col-xs-8' align='left'>"+
													"<label class='icon-color' style='cursor:pointer;font-size:14px;padding-top:2px;font-family: 'Lato', sans-serif;'>"+x+" <br/> <small style='color:#888;font-size:10px'> "+split[0]+" M </small></label>"+
												"</div>"+
											"</div>"+
										"</a>";
					});
				} else {
					html += "<span style='color:red;'>"+result.status_string+"</span>"
				}
				$("#boxAllLocation").html(html);
			},
			error: function() {
				$("#boxLocation").show();
				$("#cancelPlay").show();
				$("#loading").hide();
				$("#error").html("<?php echo $this->config->item("error_500"); ?>")
				$("#error").show();
			}
		});
	}

	
	function getLocationOnReady() {
		clearInterval(interval);
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition,error, {timeout: 30000,enableHighAcuracy: true});
		} else {
			alert("Please allow your Geolocation.");
		}
	}
	
	function error(error) {
		alert("Unable to retrieve your location. Try user other browsers !");
		console.log(error);
		interval = setInterval(getLocationOnReady, 15000);
	}
	
	function showPosition(position) {
		// if(userid == 8) {
			// document.getElementById("lat").value = "-6.274571418762207";
			// document.getElementById("long").value = "106.74540710449219";
		// } else {
			if(typeof position!="undefined"){
			    console.log(position);
                document.getElementById("lat").value = position.coords.latitude;
                document.getElementById("long").value = position.coords.longitude;
                refreshLocation(position);
            }
		// }
	}
</script>