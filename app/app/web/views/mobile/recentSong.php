<?php if($isAndroid) { ?>
<div class="col-xs-12 alert appHeader fixed-header alert-dismissible" role="alert" style="margin-bottom:0px; border:none;border-radius:0px;">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<img src="<?php echo $this->config->item("logo_login_jukebox") ?>" width="25px"/><small> <?php echo $this->config->item("header_android_popup") ?></small> <a href="<?php echo $this->config->item("play_store_link") ?>" class="btn btn-xs btn-info pull-right">Get the App</a>
</div>
<?php } ?>
<div class="col-xs-12 header-menu-jukebox fixed-header">
	<i class="fa fa-history"></i> <?php echo $this->config->item("rs") ?>
</div>
<div class="col-xs-12 header-content-jukebox" style="padding:0px;top:15px;border-bottom:none">
	<table class="table table-striped" style="margin-bottom:65px;border-top:none;border-bottom:none" id="tableRecentSong">
		<tr>
			<td align="center"><img src="<?php echo $this->config->item("ajax_loader"); ?>"/></td>
		</tr>
	</table>		
</div>

<script src="<?php echo $this->config->item("socketjs") ?>" type="text/javascript"></script>
<script type="text/javascript">
	window.onerror = function(message, file, lineNumber) {
	  //return true;
	}
	var socket = io.connect('<?php echo $this->config->item("port_server") ?>', {secure: true, port:8443});
	var username = '<?php echo $username; ?>';
	var userid = '<?php echo $id; ?>';
	var twitterImage = '<?php echo $image; ?>';
	var status = '<?php echo $status; ?>';
	var varLoc = '<?php echo $loc_id; ?>';
	var latlong = '<?php echo $this->session->userdata("latlong"); ?>';
	var totalCountCreated = [];
	var recent, lastInsert;
	
	/*
	|--------------------------------------------------------------------------
	| Socket
	|--------------------------------------------------------------------------
	*/
	socket.on("connect",function() {
		socket.emit("adduser",{username: username, loc: varLoc, userid: userid});
	});
	
	socket.on("playlist",function(data) {
		var result = JSON.parse(data);
		if(result.data[0] != null) {
			$.each(result.data,function(x,y) {
				if(y.createby != "sponsor") lastInsert = y.createby;
				if(typeof(totalCountCreated[y.createby]) == "undefined") {
					totalCountCreated[y.createby] = 1;
				} else {
					totalCountCreated[y.createby] += 1;
				}
			});
		} else {
			lastInsert = "";
		}
	});
	
	socket.on("recentSong",function(data) {
		var result = JSON.parse(data);
		var i = 1;
		recent = "";
		if(result[0] != null) {
			$.each(result,function(x,y) {
				var from = "soundcloud";
				var icon = "<i class='fa fa-soundcloud' style='color:#ff3a00;'></i>";var icon = "<i class='fa fa-soundcloud' style='color:#ff3a00;'></i>";
				if(y["link"].match(/youtube/)) {
					from = "youtube";
					icon = "<i class='fa fa-youtube-play' style='color:#bb0000;'></i>";
				}
				var insert = 'insertDB("'+y["track_id"]+'","'+from+'","'+y["title"]+'","'+y["genre"]+'","'+twitterImage+'","'+y["link"]+'",0)'
				recent += "<tr onclick='return "+insert+"' class='row-song'>"+
										"<td class='icon-playlistMusic'>"+icon+"</td>"+
										"<td class='song-content' style='padding:13px'>"+i+". "+y["title"]+"</td>"+
										"<td class='icon-playlist'><i class='fa fa-play-circle' ></i></td>"+
									"</tr>";
				i++;
			});
		} else {
			recent = "<tr><td class='song-content' align='center' style='color:red;'><?php echo $this->config->item("recent_song_title"); ?></td></tr>";
		}
		$("#tableRecentSong").html("");
		$("#tableRecentSong").append(recent);
	});
	
	/*
	|--------------------------------------------------------------------------
	| END Socket
	|--------------------------------------------------------------------------
	*/
	
	/*
	|--------------------------------------------------------------------------
	| Function with Socket
	|--------------------------------------------------------------------------
	*/
	function insertDB(id,from,title,genre,img,link,flag) {
		// kalo flag 0 dari recent song, kalo 1 dari mostplayed atau livesearch
		if(typeof(totalCountCreated[username]) == "undefined" || totalCountCreated[username] < 2) {
				if(lastInsert != username) {
					swal({
						title: "<?php echo $this->config->item("add_song"); ?>",
						text: title,
						type: "warning",
						showCancelButton: true,   
						confirmButtonColor: '#3085d6',   
						cancelButtonColor: '#d33',   
						confirmButtonText: 'Yes!',   
						cancelButtonText: 'No',   
						confirmButtonClass: 'confirm-class',   
						cancelButtonClass: 'cancel-class',   
						closeOnConfirm: false
					},
					function(isConfirm) {   
						if (isConfirm) {
							swal({
								html: '<img width="70px" src="<?php echo $this->config->item("captions") ?>"/><h2><?php echo $this->config->item("caption_title"); ?></h2><p class="lead emoji-picker-container"><input onkeyup="checkLength(this)" id="input-field-caption" type="email" class="form-control" placeholder="<?php echo $this->config->item("caption_example") ?>" data-emojiable="true"></p><br/><p style="color:#888"><?php echo $this->config->item("empty_caption"); ?></p><label id="errCaption" style="color:red;display:none;"><?php echo $this->config->item("max_caption_text"); ?></label>',
								showCancelButton: false,
								closeOnConfirm: false 
							},
							function(isConfirm) {
								if(isConfirm) {
									var caption = $('#input-field-caption').val();
									var data = {};
									data.username = username;
									data.userid = userid;
									data.id = id;
									data.from = from;
									data.title = title;
									data.genre = genre;
									data.loc = varLoc;
									data.img = encodeURIComponent(img);
									data.cap = encodeURIComponent(caption);
									data.flag = flag;
									data.link = link;
									socket.emit("insertSong",data);
									swal("<?php echo $this->config->item("success_insert_song_title"); ?>","<?php echo $this->config->item("success_insert_song_body"); ?>", "success");
									$("#livesearch").html("");
									$("#inputsong").val("");
									$("#closebtn").trigger("click");
									socket.emit("jukeboxLocation", loc);
									jukeboxRecent(username);
								}
							});
						}
					});
				} else {
					swal({
						title: '<?php echo $this->config->item("already_insert_title"); ?>',
						html: '<?php echo $this->config->item("already_insert_body"); ?>',
						type: 'error'
					});
				}
		} else {
			swal({
				title: '<?php echo $this->config->item("max_two_song_per_user"); ?>',
				type: 'error'
			});
		}
	}
	
	/*
	|--------------------------------------------------------------------------
	| END Function with Socket
	|--------------------------------------------------------------------------
	*/
	
	$(document).ready(function(){
		socket.emit("jukeboxLocation", varLoc);
		socket.emit("getRecentSong",{userid: userid, loc: varLoc});
		setInterval(function() { getLocationOnReady() },60000);
		$("marquee").mouseover(function() {
			this.stop();
		}).mouseleave(function() {
			this.start();
		});
	});
	
	function getLocationOnReady() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		} else {
			alert("Please allow your Geolocation.");
		}
	}
	
	function showPosition(position) {
		if(showDistanceFromServer(position.coords.latitude, position.coords.longitude) > 500) { //500 in meters
			location.href = "<?php echo site_url(); ?>/place";
		} else {
			checkAdminIsLogin(varLoc);
		}
	}
	
	function checkAdminIsLogin(idAdmin) {
		$.ajax({
			url: '<?php echo site_url(); ?>/home/checkAdminIsLogin?id='+idAdmin,
			success: function(resp) {
				var result = JSON.parse(resp);
				if(result.flag_login == 0) {
					alert("Admin is logout, please change your location");
					location.href = "<?php echo site_url(); ?>/place";
				}
			},
			error: function() {
				console.log("<?php echo $this->config->item("error_500"); ?>");
			}
		})
	}
	
	function showDistanceFromServer(latitude, longitude) {
		var split = latlong.split("#");
		var lat2 = split[0];
		var lon2 = split[1];
		var R = 6371; // Radius of the earth in km
		var dLat = deg2rad(lat2-latitude);  // deg2rad below
		var dLon = deg2rad(lon2-longitude); 
		var a = 
			Math.sin(dLat/2) * Math.sin(dLat/2) +
			Math.cos(deg2rad(latitude)) * Math.cos(deg2rad(lat2)) * 
			Math.sin(dLon/2) * Math.sin(dLon/2)
			; 
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
		var d = R * c; // Distance in km
		return d.toFixed(1);
	}
	
	function deg2rad(deg) {
		return deg * (Math.PI/180)
	}
</script>