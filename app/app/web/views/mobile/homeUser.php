<?php if($isAndroid) { ?>
<div class="col-xs-12 alert appHeader fixed-header alert-dismissible" role="alert" style="margin-bottom:0px; border:none;border-radius:0px;">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<img src="<?php echo $this->config->item("logo_login_jukebox") ?>" width="25px"/><small> <?php echo $this->config->item("header_android_popup") ?></small> <a href="<?php echo $this->config->item("play_store_link") ?>" class="btn btn-xs btn-info pull-right">Get the App</a>
</div>
<?php } ?>

<div id="search-m" class="search-m">
	<div id="search-input" class="input-group" style="padding:8px;">
		<span class="input-group-addon info" id="sizing-addon1"><i class="fa fa-music"></i></span>
		<input type="text" id="inputsong" class="form-control" placeholder="Search song...">
		<span class="input-group-btn">
			<button id="closebtn" class="btn btn-default" type="button" onclick="unsearchM()"><i class="fa fa-times"></i></button>
		</span>
	</div>
	<div id="livesearch" style="box-shadow:0px 0px 5px #888;position:relative;z-index: 2001;background:white;width: 100%;overflow-y:scroll;font-size:10px;max-height:320px"></div>
</div>


	<div class="col-xs-12 header-menu-jukebox fixed-header">
		<i class="fa fa-music"></i> <?php echo $this->config->item("mp") ?>
	</div>
	
	<div class="col-xs-12 header-content-jukebox" style="padding:0px;top:15px;border-bottom:none">

		<table id="music-playlist" width="100%" class="table table-hover playlist" style="margin-bottom:65px;border-bottom:none;">
			<tr>
				<td align="center" style="padding:15px 0px 15px 0px"><img src="<?php echo $this->config->item("ajax_loader"); ?>"/></td>
			</tr>
		</table>
		<div style="position:absolute">
			<button type="button" class="btn btn-info btn-circle btn-xl float-position" onclick="searchM()"><i class="fa fa-search"></i></button>
		</div>
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
	var mostRequest;
	var flagInsert;
	
	
	Array.prototype.clean = function(deleteValue) {
		for (var i = 0; i < this.length; i++) {
			if (this[i] == deleteValue) {         
				this.splice(i, 1);
				i--;
			}
		}
		return this;
	};
	/*
	|--------------------------------------------------------------------------
	| Socket
	|--------------------------------------------------------------------------
	*/
	socket.on("connect",function() {
		// alert("connect");
		socket.emit("adduser",{username: username, loc: varLoc, userid: userid});
	});
	
	socket.on("playlist",function(data) {
		// alert("playlist");
		flagInsert = true;
		var result = JSON.parse(data);
		// console.log(result);
		if(typeof(result.error) != "undefined" && result.error == 1) {
			swal({
				title: '<?php echo $this->config->item("special_day"); ?>',
				html: '<?php echo $this->config->item("body_special_day") ?>',
				type: 'error'
			});
		} else {
			var html = "";
			totalCountCreated = [];
			if(result.data[0] != null) {
				var i = 0;
				$.each(result.data,function(x,y) {
					if(y.createby != "sponsor") lastInsert = y.createby;
					var splitLike = [], splitDislike = [];
					var like = 0,dislike = 0;
					if(typeof(totalCountCreated[y.createby]) == "undefined") {
						totalCountCreated[y.createby] = 1;
					} else {
						totalCountCreated[y.createby] += 1;
					}

					
					if(y["like"] !== null) {
						var splitLike = y["like"].split("#");
						splitLike.clean("");
						like = splitLike.length;
					}
					if(y["dislike"] !== null) {
						var splitDislike = y["dislike"].split("#");
						splitDislike.clean("");
						dislike = splitDislike.length;
					}
					
					var from = "soundcloud";
					if(y["link"].match(/youtube/)) from = "youtube";
					
					var source = '<td class="buttonLayerTd" style=";border-right:1px solid #888"><a href="'+y["link"]+'" target="_blank"><i class="fa fa-soundcloud button-source-soundcloud-row"></i></a></td>';
					if(y["link"].match(/youtube/)) source = '<td class="buttonLayerTd" style=";border-right:1px solid #888"><a href="'+y["link"]+'" target="_blank"><i class="fa fa-youtube-play button-source-youtube-row"></i></a></td>';
					
					var image = "<?php echo $this->config->item("user_default"); ?>"
					if(isValidURL(y["twitter_image"])!=true){
						image='<?php echo base_url(); ?>assets/'+y["twitter_image"];
					}
					
					var medal = "";
					var rank = "";
					var medallink = "";
					if(mostRequest.indexOf(y["createby"]) == 1) {
						medal = "<img src='<?php echo $this->config->item("medal_gold"); ?>' class='img-circle' width='15px' style='margin-left:3px;'/>";
						medallink = "<?php echo $this->config->item("medal_gold"); ?>";
						rank = "firstRank";
					} else if(mostRequest.indexOf(y["createby"]) == 2) {
						medal = "<img src='<?php echo $this->config->item("medal_silver"); ?>' class='img-circle' width='15px' style='margin-left:3px;'/>"
						medallink = "<?php echo $this->config->item("medal_silver"); ?>";
						rank = "secondRank";
					} else if(mostRequest.indexOf(y["createby"]) == 3) {
						medal = "<img src='<?php echo $this->config->item("medal_bronze"); ?>' class='img-circle' width='15px' style='margin-left:3px;'/>"
						medallink = "<?php echo $this->config->item("medal_bronze"); ?>";
						rank = "thirdRank";
					}else{
						medal = ""
						rank = "";
					}
					// console.log(i);
					if(i == 0) {
						if(like == 0) {
							var strlike = "";
						} else {
							var strlike = ""+like;
						}
						if(dislike == 0) {
							var strdislike = "";
						} else {
							var strdislike = ""+dislike;
						}
						var button = '<td>'+
														'<table width="100%">'+
															'<tr>'+
																'<td class="buttonLayerTd" style=";border-right:1px solid #888"><i class="fa fa-share-alt button-share-row" caption='+y["caption"]+' link="'+y["link"]+'"></i></td>'
																+source+
																'<td class="buttonLayerTd" id="dislike-'+y["playlist_id"]+'" title="<?php echo $this->config->item("skip_tooltip"); ?>"  style=";border-right:1px solid #888"><i class="fa fa-fast-forward" onclick=\'likedislike('+y["playlist_id"]+','+userid+',"dislike",'+dislike+',"'+y["track_id"]+'","'+y["title"]+'","'+y["genre"]+'","'+twitterImage+'","'+from+'")\'></i> '+strdislike+'</td>'+
																'<td class="buttonLayerTd" id="like-'+y["playlist_id"]+'" title="<?php echo $this->config->item("love_tooltip") ?>" ><i class="fa fa-heart" onclick=\'likedislike('+y["playlist_id"]+','+userid+',"like",'+like+',"'+y["track_id"]+'","'+y["title"]+'","'+y["genre"]+'","'+twitterImage+'","'+from+'")\'></i> '+strlike+'</td>'+
															'</tr>'+
														'</table>'+
													'</td>';
												
						if(y["like"] !== null || y["dislike"] !== null) {
							if(splitLike.indexOf(userid) != -1 || splitDislike.indexOf(userid) != -1) {
								//disabled button love sama skip
								button = '<td>'+
														'<table width="100%">'+
															'<tr>'+
																'<td class="buttonLayerTd" style=";border-right:1px solid #888"><i class="fa fa-share-alt"></i></td>'
																+source+
																'<td class="buttonLayerTd" id="dislike-'+y["playlist_id"]+'" title="<?php echo $this->config->item("skip_tooltip"); ?>" style=";border-right:1px solid #888"><i class="fa fa-fast-forward" style="color:#00aeff"></i> '+strdislike+'</td>'+
																'<td class="buttonLayerTd" id="like-'+y["playlist_id"]+'" title="<?php echo $this->config->item("love_tooltip") ?>"><i class="fa fa-heart" style="color:#dc143c"></i> '+strlike+'</td>'+
															'</tr>'+
														'</table>'+
													'</td>';
							}
						}
						
						html += '<tr class="flagPlaylistId">'+
											'<td>'+
												'<table class="table-playlist">'+
													'<tr>'+
														'<td class="image-view-user">';
															if(y["user_id"] != 0) {
											html += '<a style="cursor:pointer;" onClick="'+"detailUser('"+y['user_id']+"','"+rank+"','"+medallink+"')"+'"><img src="'+image+'" width="100%" onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" class="img-circle '+rank+'"/></a>';
																} else {
											html += '<a><img src="'+image+'" width="100%" onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" class="img-circle '+rank+'"/></a>';
																}
										html += '</td>'+
														'<td class="view-user-detail">'+
															'<table class="table-playlist-detail">'+
																'<tr>'+
																	'<td style="vertical-align:middle;color:#fff"><b class="username-user">'+medal+y["createby"]+'</b></td>'+
																	'<td rowspan="2" width="20px" align="center" style="vertical-align:middle;padding:5px">'+
																		'<img src="<?php echo $this->config->item("equalizer"); ?>" width="32px"/> '+
																	'</td>';
																	if(y["createby"] == username) {
																		html += '<td rowspan="2" align="right" style="vertical-align:top;padding:5px"><i onclick="deleteMySong(\''+y["playlist_id"]+'\')" class="fa fa-times" style="color:#fff;"></i></td>';
																	}
											html += '</tr>'+
																'<tr>'+
																	'<td class="song-desc" style="vertical-align:top;color:#fff">'+
																		'<span style="font-size:16px">';
																		if(y["title"].length > 40) {
																			html += "<marquee>"+y["title"]+"</marquee>"
																		} else {
																			html += y["title"];
																		}
															html += '</span><br/>'+
																		'<i style="font-family: \'Gloria Hallelujah\', cursive;font-size:12px">'+y["caption"]+'</i>'+
																	'</td>'+
																'</tr>'+
															'</table>'+
														'</td>'+
													'</tr>'+
												'</table>	'+
											'</td>'+				
										'</tr>'+
										'<tr class="buttonLayer">'+button+
										'</tr>';
					} else {
						html += '<tr>'+
											'<td class="listTd">'+
												'<table width="100%">'+
													'<tr>'+
														'<td class="listImage">';
															if(y["user_id"] != 0) {
											html += '<a style="cursor:pointer;" onClick="'+"detailUser('"+y['user_id']+"','"+rank+"','"+medallink+"')"+'"><img src="'+image+'" width="100%" onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" class="img-circle '+rank+'"/></a>';
																} else {
											html += '<a><img src="'+image+'" width="100%" onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" class="img-circle '+rank+'"/></a>';
																}
										html += '</td>'+
														'<td class="view-user-detail">'+
															'<table class="table-playlist-detail">'+
																'<tr>'+
																	'<td style="vertical-align:bottom"><b class="username-user">'+medal+y["createby"]+'</b></td>';
																	if(y["createby"] == username) {
																		html += '<td align="right"><i onclick="deleteMySong(\''+y["playlist_id"]+'\')" class="fa fa-times"></i></td>';
																	}
											html += '</tr>'+
																'<tr>'+
																	'<td colspan="2" class="song-desc" style="font-size:14x;vertical-align:top">';
																		if(y["title"].length > 70) {
																				html += "<marquee width='92%'>"+y["title"]+"</marquee>"
																			} else {
																				html += y["title"];
																			}
															html += '<br/>'+
																		'<i style="font-size:12px;font-family: \'Gloria Hallelujah\', cursive;">'+y["caption"]+'</i>'+
																	'</td>'+
																'</tr>'+
															'</table>'+
														'</td>'+
													'</tr>'+
												'</table>'+
											'</td>'+
										'</tr>';
					}
					i++;
				});
				// console.log(html);
				$("#music-playlist").html("");
				$("#music-playlist").append(html);
				$.each($(".button-share-row"),function(index,item) {
					$(item).hideshare({
						link: $(item).attr("link"),
						media: $(item).attr("link"),
						title: $(item).attr("caption")+" #JUKEBOX5D",
						description: $(item).attr("caption")+" #JUKEBOX5D",
						position: "bottom",
					})
				});
			} else {
				lastInsert = "";
				html = "<tr style='height:120px;'><td align='center'><?php echo $this->config->item("empty_playlist") ?></td></tr>";
				// html = "";
				$("#music-playlist").html("");
				$("#music-playlist").append(html);
			}
			
			// $("marquee").mouseover(function() {
				// this.stop();
			// }).mouseleave(function() {
				// this.start();
			// });
		}
	});
	
	socket.on("mostRequest",function(data) {
		var result = JSON.parse(data);
		var html;
		var i = 1;
		mostRequest = new Array();
		$.each(result,function(x,y) {
			if(i <= 3) {
				mostRequest[i] = y["username"];
			}
			i++;
		});
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
	function deleteMySong(playlist_id) {
		if(confirm("<?php echo $this->config->item("delete_song"); ?>")) {
			socket.emit("deleteMySong",{playlist_id: playlist_id, loc: varLoc});
		}
	}
	
	function likedislike(playlist_id,userid,option,total,track_id,title,genre,twitterImage,from) {
		socket.emit("likedislike",{playlist_id: playlist_id, userid: userid, option: option, loc: varLoc});
		if(option == "like" && total == 4) {
			insert5Love(username,track_id,from,title,genre,twitterImage);
		}
	}
	
	function insertDB(id,from,title,genre,img,link,flag) {
		// kalo flag 0 dari recent song, kalo 1 dari mostplayed atau livesearch
		if(flagInsert){
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
										flagInsert = false;
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
										jukeboxLoc(varLoc);
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
		} else {
			swal({
				title: '<?php echo $this->config->item("wait_until_success_loaded"); ?>',
				type: 'error'
			});
		}
	}
	
	function insert5Love(id,from,title,genre,img) {
		var data = {};
		data.username = "<?php echo $this->session->userdata('username_admin') ?>";
		data.userid = userid;
		data.id = id;
		data.from = from;
		data.title = title;
		data.genre = genre;
		data.loc = varLoc;
		data.img = encodeURIComponent(img);
		data.flag = 1;
		data.cap = "";
		socket.emit("insertSong",data);
		socket.emit("jukeboxLocation", loc);
		jukeboxRecent(username);
	}
	
	/*
	|--------------------------------------------------------------------------
	| END Function with Socket
	|--------------------------------------------------------------------------
	*/
	
	;(function($){
		$.fn.extend({
			donetyping: function(callback,timeout){
				timeout = timeout || 1e3; // 1 second default timeout
				var timeoutReference,
					doneTyping = function(el){
						if (!timeoutReference) return;
						timeoutReference = null;
						callback.call(el);
					};
				return this.each(function(i,el){
					var $el = $(el);
					// Chrome Fix (Use keyup over keypress to detect backspace)
					// thank you @palerdot
					$el.is(':input') && $el.on('keyup keypress paste',function(e){
						// This catches the backspace button in chrome, but also prevents
						// the event from triggering too preemptively. Without this line,
						// using tab/shift+tab will make the focused element fire the callback.
						if (e.type=='keyup' && e.keyCode!=8) return;
						
						// Check if timeout has been set. If it has, "reset" the clock and
						// start over again.
						if (timeoutReference) clearTimeout(timeoutReference);
						timeoutReference = setTimeout(function(){
							// if we made it here, our timeout has elapsed. Fire the
							// callback
							doneTyping(el);
						}, timeout);
					}).on('blur',function(){
						// If we can, fire the event since we're leaving the field
						doneTyping(el);
					});
				});
			}
		});
	})(jQuery);
	
	$(document).ready(function(){
		socket.emit("jukeboxLocation", varLoc);
		setInterval(function() { getLocationOnReady() },60000);
		
		$("#buttonFollow").click(function() {
			var userIdFollow = $("#buttonFollow").attr("user_id");
			var userNameFollow = $("#buttonFollow").attr("user_name");
			var rank = $("#buttonFollow").attr("rank");
			var medal = $("#buttonFollow").attr("medal");
			var type = $("#buttonFollow").attr("button-type");
			if(type == "following") {
				if(confirm('Are you sure you want to unfollow this user?')) {
					followUnfollow(userIdFollow,rank,medal,type);
				}
			} else {
				followUnfollow(userIdFollow,rank,medal,type);
			}
		});
		
		function followUnfollow(userIdFollow,rank,medal,type) {
			$.ajax({
				url: '<?php echo site_url() ?>/follow',
				type: "POST",
				data: {
					userIdFollow: userIdFollow,
					userId: userid,
					type: $("#buttonFollow").attr("button-type")
				},
				beforeSend: function() {
					$("#loading").show();
					$("#buttonFollow").hide();
				},
				success: function(resp) {
					if(resp) {
						$("#buttonFollow").show();
						$("#buttonFollow").attr("button-type","following");
						$("#buttonFollow").html("Unfollow");
						detailUser(userIdFollow,rank,medal);
					} else {
						//ini pesan error kalo gagal insert ke db ros
						$("#loading").hide();
						$("#buttonFollow").hide();
						$("#errorFollow").html("");
						$("#errorFollow").show();
					}
				},
				error: function() {
					$("#loading").hide();
					$("#buttonFollow").hide();
					$("#errorFollow").html("<?php echo $this->config->item("error_500"); ?>");
					$("#errorFollow").show();
				}
			});
		}
		
		$("#inputsong").donetyping(function() {
			showResult(this.value);
		});
		
		$("marquee").mouseover(function() {
			this.stop();
		}).mouseleave(function() {
			this.start();
		});
		
		function showResult(str){
				// $("#inputsong").height("300px");
				// var str = $('#myInput').val();
				$("#livesearch").html("");
				if(str == "") {
					$("#livesearch").html("");
				} else if (str.length==0) {
					$("#livesearch").html("");
					document.getElementById("livesearch").style.border="0px";
					return;
				} else if (str.length > 2) {
					var html = "";
					// delay(function(){
						$.ajax({
							url: '<?php echo site_url(); ?>/LiveSearch?q='+str,
							success: function(resp){
								// if(resp == "please login first") {
									// window.location.href = 'http://5dapps.com/music/logout.php'; //
								// } else if(resp == "Your session is timeout") {
									// window.location.href = "http://5dapps.com/music/logout.php";
								// } else {								
									$("#livesearch").html("");
									var result = JSON.parse(resp);
									var err = result['err'];
									if(err == "") {
										// console.log(1);
										$.each(result.data,function(x,y){
											//if(x != "err") {
												var from = y.from;
												var title = y.title;
												var genre = y.genre;
												var onclick = 'insertDB("'+y.track_id+'","'+from+'","'+title+'","'+genre+'","'+twitterImage+'","'+y.link+'",1)';
												if(y.from == 'soundcloud') {
													var css = 'btn-info';
													var sourceLink = "<a href='"+y.permalink_url+"' target='blank'><i class='fa fa-soundcloud button-source-soundcloud-row' style='color:#ff3a00;font-size:16px'></i></a>"
												} else {
													var css = 'btn-info';
													var sourceLink = "<a href='https://www.youtube.com/watch?v="+y["track_id"]+"' target='blank'><i class='fa fa-youtube-play button-source-youtube-row' style='color:#bb0000;font-size:18px'></i></a>"
												}
												//html += "<div class='box col-sm-12' style='border:1px solid #e5e5e5;cursor:pointer'><div class='col-sm-1'><label align='right'>"+sourceLink+"</label></div><div class='col-sm-11' style='padding:0px' onclick='return "+onclick+"'><div class='col-sm-11 font-song-light'>"+title+" </div><div class='col-sm-1' style='text-align:center'><button class='overlay btn "+css+" btn-xs' style='padding-left:7px;border-radius:50%;display:table-cell;vertical-align:middle'><i class='fa fa-play fa-1x'></i></button></div></div></div>";
												html += "<div class='box col-sm-12' onclick='return "+onclick+"' style='border:1px solid #e5e5e5;cursor:pointer'>";
												html += "<table width='100%'>";
												html += "<tr>";
												html += "<td class='icon-playlistMusic' align='center'>"+sourceLink+"</td>";
												html += "<td class='song-content' style='padding:13px'>"+title+"</td>";
												html += "<td class='icon-playlist' align='right'><i class='fa fa-play-circle' style='color:#31b0d5'></i></td>";
												html += "</tr>"
												html += "</table>";
												html += "</div>";
											//}
										})
										$("#livesearch").append(html);
									} else {
										// console.log(2);
										html = "<div class='box' style='border:1px solid #e5e5e5;padding:8px;color:red;'>"+err+"</div>"
										$("#livesearch").html(html);
									}
								//}
							}
						});
					// },500);
				}
			}
			
			$(".btn-pref .btn").click(function () {
				$(".btn-pref .btn").removeClass("btn-info").addClass("btn-default");
				// $(".tab").addClass("active"); // instead of this do the below 
				$(this).removeClass("btn-default").addClass("btn-info");   
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
	
	function detailUser(id,rank,medal){
		$("#buttonFollow").show();
		$("#errorFollow").hide("");
		$("#errorFollow").html("");
		$('#detailUserModal').modal('show');
		var genre,food,drink,hangoutPlace,recentSongUser;
		$.ajax({
				url: '<?php echo site_url(); ?>/User/Profile?id='+id+'&loc='+varLoc,
				beforeSend: function() {
					$("#loading").show();
					$("#bodyUserModel").hide();
				},
				success: function(resp){
					genre = "";
					food = "";
					drink = "";
					hangoutPlace = "";
					recentSongUser = "";
					var json= JSON.parse(resp);
					if(id == userid) {
						$("#buttonFollow").hide();
						$("#tabUser").show();
						$("#bodyTabUser").show();
					} else {
						if(json.follow.follower_data.indexOf(userid) == -1) {
							$("#buttonFollow").attr("button-type","follow");
							$("#buttonFollow").html("Follow");
							$("#tabUser").hide();
							$("#bodyTabUser").hide();
						} else {
							$("#buttonFollow").attr("button-type","following");
							$("#buttonFollow").html("Unfollow");
							$("#tabUser").show();
							$("#bodyTabUser").show();
						}
					}
					
					if(json.data["music_genre"]) { var music_genre = JSON.parse(json.data["music_genre"]) } else { var music_genre = "" };
					if(json.data["drink"]) { var drinkArr = JSON.parse(json.data["drink"]) } else { var drinkArr = "" };
					if(json.data["food"]) { var foodArr = JSON.parse(json.data["food"]) } else { var foodArr = "" };
					if(json.data["hangout_place"]) { var hangoutPlaceArr = JSON.parse(json.data["hangout_place"]) } else { var hangoutPlaceArr = "" };
					$('#userDetail-image').attr('src','<?php echo base_url(); ?>assets/'+json.data['twitter_image']);
					$('#userDetail-image').attr('class', ' img-circle ' + rank);
					if(medal != "") $('#userDetail-username').html(json.data['username']+"<img src='"+medal+"' class='img-circle' width='15px' style='margin-left:3px;'/>");
					else $('#userDetail-username').html(json.data['username']);
					genre += "<div class='col-md-3'><b style='color:#CFCFCF'>Music Genre </b> </div>";
					drink += "<div class='col-md-3'><b style='color:#CFCFCF'>Drink </b> </div>";
					food += "<div class='col-md-3'><b style='color:#CFCFCF'>Food </b> </div>";
					hangoutPlace += "<div class='col-md-3'><b style='color:#CFCFCF'>Hangout Place </b> </div>";
					if(music_genre != "") {
						genre += "<div class='col-md-9'>";
						var i = 0;
						$.each(music_genre, function(x,y) {
							if(i == music_genre.length-1) {
								genre += "<span>"+y+"</span>";
							} else {
								genre += "<span>"+y+"</span>, ";
							}
							i++;
						});
						genre += "</div";
					} else {
						genre += "<div class='col-md-9'>";
						genre += "<span>-</span>";
						genre += "</div>";
					}
					if(drinkArr != "") {
						drink += "<div class='col-md-9'>";
						var i = 0;
						$.each(drinkArr, function(x,y) {
							if(i == drinkArr.length-1) {
								drink += "<span>"+y+"</span>"
							} else {
								drink += "<span>"+y+"</span>, "
							}
							i++;
						});
						drink += "</div";
						
					} else {
						drink += "<div class='col-md-9'>";
						drink += "<span>-</span>";
						drink += "</div>";
					}
					if(foodArr != "") {
						food += "<div class='col-md-9'>";
						var i = 0;
						$.each(foodArr, function(x,y) {
							if(i == foodArr.length-1) {
								food += "<span>"+y+"</span>"
							} else {
								food += "<span>"+y+"</span>, "
							}
							i++;
						});
						food += "</div";
					} else {
						food += "<div class='col-md-9'>";
						food += "<span>-</span>";
						food += "</div>";
					}
					if(hangoutPlaceArr != "") {
						hangoutPlace += "<div class='col-md-9'>";
						var i = 0;
						$.each(hangoutPlaceArr, function(x,y) {
							if(i == hangoutPlaceArr.length-1) {
								hangoutPlace += "<span>"+y+"</span>"
							} else {
								hangoutPlace += "<span>"+y+"</span>, "
							}
							i++;
						});
						hangoutPlace += "</div";
					} else {
						hangoutPlace += "<div class='col-md-9'>";
						hangoutPlace += "<span>-</span>";
						hangoutPlace += "</div>";
					}
					if(json.data["bio"]) {
						var bio = json.data["bio"]
					} else {
						var bio = "<span class='label label-info'>-</span>"
					}
					var i = 1;
					if(json.recent != false) {
						$.each(json.recent,function(x,y){
							var from = "soundcloud";
							var icon = "<i class='fa fa-soundcloud' style='color:#ff3a00;'></i>";
							if(y["link"].match(/youtube/)){
								from = "youtube";
								icon = "<i class='fa fa-youtube-play' style='color:#bb0000;'></i>";
							}
							var onclick = 'insertDB("'+y.track_id+'","'+from+'","'+y.title+'","'+y.genre+'","'+twitterImage+'","'+y.link+'",0)';
							recentSongUser += "<tr class='row-song' onclick='"+onclick+"'>"+
																	"<td style='vertical-align:middle' align='center' width='50px'>"+icon+"</td>"+
																	"<td class='song-content'>"+i+". "+y.title+"</td>"+
																	"<td class='icon-playlist' width='50px'><i class='fa fa-play-circle'></i></td>"+
																"</tr>";
							i += 1;
						});
					} else {
						//ini tampilan ga ada recent song di detail user ros
					}
					$("#followerCount").html(json.follow.follower_count);
					$("#followingCount").html(json.follow.following_count);
					$("#buttonFollow").attr("user_id",json.data.user_id);
					$("#buttonFollow").attr("user_name",json.data.username);
					$("#buttonFollow").attr("rank",rank);
					$("#buttonFollow").attr("medal",medal);
					$('#userDetail-music-genre').html(genre);
					$('#userDetail-drink').html(drink);
					$('#userDetail-food').html(food);
					$('#userDetail-bio').html("<strong>About: </strong>" + bio);
					$('#userDetail-hangout-place').html(hangoutPlace);
					$("#tableRecentSongUser").html(recentSongUser);
					$("#loading").hide();
					$("#bodyUserModel").show();
				},
				error: function() {
					$("#loading").hide();
					$("#bodyUserModel").hide();
					$("#error").show();
					$("#error").html("<?php echo $this->config->item("error_500"); ?>");
				}
		});
	}
	
	function isValidURL(url) {
		var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
		if(RegExp.test(url)) {
			return true;
		} else {
			return false;
		}
	}
	
	function searchM()
	{
		$('#search-m').fadeIn();
		$('#overlay').fadeIn();
		$('#inputsong').focus();
	}
	
	function unsearchM()
	{
		$('#search-m').fadeOut();
		$('#overlay').fadeOut();
	}
</script>