<script src='https://www.google.com/recaptcha/api.js'></script>
<style type="text/css">
		#map {
        height: 300px;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
		
		
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
        function initAutocomplete() {
			var map = new google.maps.Map(document.getElementById('map'), {
				center: {lat: -33.8688, lng: 151.2195},
				zoom: 15,
				// mapTypeId: 'roadmap'
			});
			// Create the search box and link it to the UI element.
			var input = document.getElementById('pac-input');
			var searchBox = new google.maps.places.SearchBox(input);
			map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
			var marker = new google.maps.Marker({
				map: map,
				draggable:true,
			});
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
					var pos = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};
					marker.setPosition(pos);
					map.setCenter(pos);
					document.getElementById("lat").value = marker.position.lat();
					document.getElementById("long").value = marker.position.lng();
				}, function() {
					handleLocationError(true, infoWindow, map.getCenter());
				});
			} else {
				// Browser doesn't support Geolocation
				handleLocationError(false, infoWindow, map.getCenter());
			}


			// Bias the SearchBox results towards current map's viewport.
			map.addListener('bounds_changed', function() {
				searchBox.setBounds(map.getBounds());
			});

			var markers = [];
			// Listen for the event fired when the user selects a prediction and retrieve
			// more details for that place.
			searchBox.addListener('places_changed', function() {
				var places = searchBox.getPlaces();

				if (places.length == 0) {
					return;
				}

				// Clear out the old markers.
				markers.forEach(function(marker) {
					marker.setMap(null);
				});
				markers = [];

				// For each place, get the icon, name and location.
				var bounds = new google.maps.LatLngBounds();
				places.forEach(function(place) {
					if (!place.geometry) {
						console.log("Returned place contains no geometry");
						return;
					}

					// Create a marker for each place.
					markers.push(marker.setPosition(place.geometry.location));
					document.getElementById("lat").value = marker.position.lat();
					document.getElementById("long").value = marker.position.lng();
					if (place.geometry.viewport) {
						// Only geocodes have viewport.
						bounds.union(place.geometry.viewport);
					} else {
						bounds.extend(place.geometry.location);
					}
				});
				map.fitBounds(bounds);
			});
			marker.addListener("click",function() {
				document.getElementById("lat").value = this.position.lat();
				document.getElementById("long").value = this.position.lng();
			});
			marker.addListener("dragend",function() {
				document.getElementById("lat").value = this.position.lat();
				document.getElementById("long").value = this.position.lng();
			});
		}

		function handleLocationError(browserHasGeolocation, infoWindow, pos) {
			infoWindow.setPosition(pos);
			infoWindow.setContent(browserHasGeolocation ?
														'Error: The Geolocation service failed.' :
														'Error: Your browser doesn\'t support geolocation.');
		}
		function clickAdmin()
		{
			$('#infoAdmin').show();
			$('#infoUser').hide();
			$('.latlongAdmin').show();
			$('#text-guide').show();
		}
		
		function clickUser()
		{
			$('#infoUser').show();
			$('#infoAdmin').hide();
			$('.latlongAdmin').hide();
			$('#text-guide').hide();
		}
		function register(){
			$.ajax({											
					url: '<?php echo site_url(); ?>/register/process',
					type:'post',												
					data: $('#formReg').serialize(),
					beforeSend: function()
					{
						$("#formReg").hide();
						$(".loader").show();
					},
					success: function(resp)
					{
						$("#formReg").show();
						$(".loader").hide();						
						var json=JSON.parse(resp);
						if(json.status==true){
							swal("<?php echo $this->config->item("registered_title"); ?>", "<?php echo $this->config->item("registered_body") ?>", "success");
							setTimeout(function(){
								window.location.href = "<?php echo base_url(); ?>";
							},4000);
						}else{
							$("#submit").show();
							grecaptcha.reset();
						$('#error').show();
						$('#cetak-error').html(json.message);
						}
					},
					error: function() {
						$("#submit").show();
						$('#error').show();
						$('#cetak-error').html('<?php echo $this->config->item("error_500") ?>');
					}
				});				
		}
</script>
		<div class="container">
			<div class="col-lg-12 boxT">	
					<div class="header clearfix">
						<img src="<?php echo $this->config->item("logo_blue"); ?>" width="200px"/>
						
						<p class="pull-right" style="padding-top:14px">							
							<small>Already have an account? <a href="<?php echo base_url(); ?>"><?php echo $this->config->item("sign_in") ?></a></small>
						</p>
					</div>
						<div class="col-md-12">
							<div class="loader" style="display:none">Loading...</div>
							<form class="form-horizontal" id="formReg">
							  <div class="form-group">
								<label class="col-sm-3 control-label"><?php echo $this->config->item("registered_as") ?></label>
								<div class="col-sm-9">
									<div class="radio">
									  <label><input id="admin" type="radio" name="status" onclick="clickAdmin()" value="admin" checked><?php echo $this->config->item("admin"); ?></label>
									</div>
									<div class="radio">
									  <label><input id="user" type="radio" name="status" onclick="clickUser()" value="user"><?php echo $this->config->item("user"); ?></label>
									</div>
								</div>
							  </div>
							  <div id="infoAdmin" class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
									<div class="alert alert-success" role="alert">
										<?php echo $this->config->item("choose_admin_register"); ?>
									</div>
								</div>
							  </div>
							  <div id="infoUser" class="form-group" style="display:none">
								<div class="col-sm-offset-3 col-sm-9">
									<div class="alert alert-success" role="alert">
										<?php echo $this->config->item("choose_user_register"); ?>
									</div>
								</div>
							  </div>
								
								<input id="pac-input" class="controls" type="text" placeholder="Search Box">
								
								<div class="col-sm-offset-3 col-sm-9" id="text-guide">
									
									<h5><small><?php echo $this->config->item("add_location"); ?></small></h5>									
									<div id="map" class="latlongAdmin"></div><br/>																											
									<h5><small style="color:red"><?php echo $this->config->item("add_location_notif"); ?></small></h5>
									<br/>
								</div>
								
								 <div class="form-group latlongAdmin hidden">
									<label class="col-sm-3 control-label">Latitude</label>
									<div class="col-sm-9">
									  <input type="text" id="lat" name="lat" class="form-control" placeholder="Latitude">
									</div>
								  </div>
								
								<div class="form-group latlongAdmin hidden">
								<label class="col-sm-3 control-label">Longitude</label>
								<div class="col-sm-9">
								  <input type="text" id="long" name="long" class="form-control" placeholder="Longitude">
								</div>
							  </div>
							<div id="error" class="form-group" style="display:none">
								<div class="col-sm-offset-3 col-sm-9">
									<div class="alert alert-warning alert-dismissible" style="margin-bottom:0px" role="alert">														
										 <strong><small id="cetak-error"></small></strong>
									</div>
								</div>
							  </div>	
							  <div class="form-group">
								<label class="col-sm-3 control-label"><?php echo $this->config->item("address"); ?></label>
								<div class="col-sm-9">								  
								  <textarea id="address" name="address" class="form-control" placeholder="Address"></textarea>								  
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-sm-3 control-label"><?php echo $this->config->item("email"); ?></label>
								<div class="col-sm-9">
								  <input type="email" id="email" name="email" class="form-control" placeholder="Email">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-sm-3 control-label"><?php echo $this->config->item("username"); ?></label>
								<div class="col-sm-9">
								  <input type="text" id="username" name="username" class="form-control" placeholder="Username">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-sm-3 control-label"><?php echo $this->config->item("password"); ?></label>
								<div class="col-sm-9">
								  <input type="password" id="password" name="password" class="form-control" placeholder="Password">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-sm-3 control-label"><?php echo $this->config->item("re-pass"); ?></label>
								<div class="col-sm-9">
								  <input type="password" name="cpassword" id="retype" class="form-control" placeholder="Re-type password">
								</div>
							  </div>
							  <div class="form-group">
								<label class="col-sm-3 control-label">Captcha</label>
								<div class="col-sm-9">
									<div class="g-recaptcha" data-sitekey="6Lc_qQkUAAAAAN1D5SY-df3NkxOXBpJlm7jkYmNV"></div>
								 	<h5><small>By click "Register" you agree with term & condition</small></h5>
								</div>
							  </div>
							  <div class="form-group">
								<div class="col-sm-offset-3 col-sm-9">
								  <button id="submit" type="button" class="btn btn-primary" onclick="register()"><?php echo $this->config->item("register"); ?></button>									
								</div>
							  </div>
							</form>
						</div>
			</div>
	</div>					
<script async defer src="<?php echo $this->config->item("google_maps_script"); ?>"></script>
			