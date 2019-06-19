

<script type="text/javascript">
	var socket = io.connect('<?php echo $this->config->item("port_server") ?>');
    var splitLike = [], splitDislike = [];
    var canLove=true;
    var userid = '<?php echo $id; ?>';
	var username = '<?php echo str_replace("'","",$username); ?>';
	var varLoc = '<?php echo $loc_id; ?>';
	var twitterImage = '<?php echo $image; ?>';
	var status = '<?php echo $status; ?>';
	var prevWeekChart = <?php echo json_encode($prev_week_chart) ?>;
	var str, mostPlayed, recent, midHeight, mostRequest;
	var totalCountCreated = [];
	var lastInsert;
	var chat;
	var flagInsert;
	var skip = 3;
	var dynamicTitle = "<?php echo $this->config->item("title"); ?>";
	var latlong = '<?php echo $this->session->userdata("latlong"); ?>';
	var globalVar;



	/*
	|--------------------------------------------------------------------------
	| Socket
	|--------------------------------------------------------------------------
	*/
	socket.on("connect",function() {
		socket.emit("getChatFileWeb",{username: username, loc: varLoc});
		socket.emit("adduser",{username: username, loc: varLoc, userid: userid})
	});
	socket.on("playlist",function(data) {

		var skip = 3;
		flagInsert = true;
		var result = JSON.parse(data);
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
					if(y.createby != "sponsor") lastInsert = y.user_id;
                    splitLike = [], splitDislike = [];
					var like = 0,dislike = 0;
					if(typeof(totalCountCreated[y.user_id]) == "undefined") {
						totalCountCreated[y.user_id] = 1;
					} else {
						totalCountCreated[y.user_id] += 1;
					}
					if(y["like"] !== null) {
						var splitLike = y["like"].split("#");
						splitLike.clean("");
						like = splitLike.length;
						skip += like;
					}
					if(y["dislike"] !== null) {
						var splitDislike = y["dislike"].split("#");
						splitDislike.clean("");
						dislike = splitDislike.length;
					}
					var from = "soundcloud";
					if(y["link"].match(/youtube/)) from = "youtube";
					var source = '<td class="buttonLayerTd" style=";border-right:1px solid #d2d2d2"><a href="'+y["link"]+'" target="_blank"><i class="fa fa-soundcloud button-source-soundcloud-row"></i></a></td>';
					if(y["link"].match(/youtube/)) source = '<td class="buttonLayerTd" style=";border-right:1px solid #d2d2d2"><a href="'+y["link"]+'" target="_blank"><i class="fa fa-youtube-play button-source-youtube-row"></i></a></td>';
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
						rank = "rankDefault";
					}
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


						//INI BUAT YOUTUBE

							// onclick='return "+onclick+"'
						// data-target="#myModal"

						// onClick=\'selectDBStream("'+y[track_id]+'","'+y[link]+'","'+y[title]+'")\'
				// "'+y["track_id"]+'","'+y["link"]+'","'+y.title+'"

					var onClick3 = 'selectDBStream("'+y["track_id"]+'","'+y["link"]+'");';
					 var test13 = 'test123(123);'

						var button = '<td>'+
														'<table width="100%">'+
															'<tr>'+
																'<td class="buttonLayerTd" style="border-right:1px solid #d2d2d2"><i class="fa fa-share-alt  button-share-row" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->config->item("share_tooltip"); ?>" caption='+y["caption"]+' link="'+y["link"]+'"></i></td>'
																+
																'<td class="buttonLayerTd" style="border-right:1px solid #d2d2d2"><a onclick='+onClick3+'   class="hover_green"  style="cursor:pointer; " data-toggle="modal" data-target="#myModal2"><i tooltip="Add to my Library" class="fa fa-plus"data-toggle="tooltip" data-placement="bottom" title="Add to my Library" ></i></a></td>'
																+
																'<td class="buttonLayerTd" style=";border-right:1px solid #d2d2d2"><i id="dislike-'+y["playlist_id"]+'"  class="fa fa-fast-forward button-skip-row" data-toggle="tooltip" data-placement="bottom" title="'+skip+'<?php echo $this->config->item("skip_tooltip"); ?>" onclick=\'likedislike('+y["playlist_id"]+','+userid+',"dislike",'+dislike+',"'+y["track_id"]+'","'+y["title"]+'","'+y["genre"]+'","'+twitterImage+'","'+from+'","'+y["link"]+'")\'></i> '+strdislike+'</td>'+
																'<td class="buttonLayerTd"><i id="like-'+y["playlist_id"]+'" class="fa fa-heart button-love-row" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<?php echo $this->config->item("love_tooltip") ?>" onclick=\'likedislike('+y["playlist_id"]+','+userid+',"like",'+like+',"'+y["track_id"]+'","'+y["title"]+'","'+y["genre"]+'","'+twitterImage+'","'+from+'","'+y["link"]+'")\'></i> '+strlike+'</td>'+
															'</tr>'+
														'</table>'+
													'</td>';
						if(y["like"] !== null || y["dislike"] !== null) {
							if(splitLike.indexOf(userid) != -1 || splitDislike.indexOf(userid) != -1) {
                                canLove=true;
								//disabled button love sama skip
								button = '<td>'+
														'<table width="100%">'+
															'<tr>'+
																'<td class="buttonLayerTd" style=";border-right:1px solid #d2d2d2"><i class="fa fa-share-alt button-share-row" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->config->item("share_tooltip"); ?>" caption='+y["caption"]+' link="'+y["link"]+'"></i></td>'
																+
																'<td class="buttonLayerTd" style="border-right:1px solid #d2d2d2"><a  class="hover_green"class="hover_green" style="cursor:pointer; " data-toggle="modal" data-target="#myModal"><i tooltip="Add to my Playlist!" class="fa fa-plus"data-toggle="tooltip" data-placement="bottom" title="Add to my Playlist!" ></i></a></td>'
																+
																'<td class="buttonLayerTd" title="'+skip+'<?php echo $this->config->item("skip_tooltip"); ?>" style=";border-right:1px solid #d2d2d2"><i id="dislike-'+y["playlist_id"]+'" class="fa fa-fast-forward" data-toggle="tooltip" data-placement="bottom" title="'+skip+'<?php echo $this->config->item("skip_tooltip"); ?>" style="color:#00aeff"></i> '+strdislike+'</td>'+
																'<td class="buttonLayerTd"><i id="like-'+y["playlist_id"]+'" class="fa fa-heart" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<?php echo $this->config->item("love_tooltip") ?>" style="color:#dc143c"></i> '+strlike+'</td>'+
															'</tr>'+
														'</table>'+
													'</td>';
							}else{
                                canLove=false;
                            }
						}
						dynamicTitle = y["title"];
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
																	'<td style="vertical-align:middle;color:#fff;"><b class="username-user">'+y["createby"]+medal+'</b></td>'+
																	'<td rowspan="2" width="20px" align="center" style="vertical-align:middle;padding:15px">'+
																		'<img src="<?php echo $this->config->item("equalizer"); ?>" width="34px"/> '+
																	'</td>';
																	if(y["user_id"] == userid) {
																		html += '<td rowspan="2" align="right" style="vertical-align:top;padding:5px"><i onclick="deleteMySong(\''+y["playlist_id"]+'\')" class="fa fa-times button-delete-row" style="color:#fff;"></i></td>';
																	}
											html += '</tr>'+
																'<tr>'+
																	'<td class="song-desc" style="vertical-align:top;color:#fff;font-family:"Gloria Hallelujah", cursive;">'+
																		'<span style="font-size:16px">';
																		if(y["title"].length > 250) {
																			html += "<marquee  >"+y["title"]+"</marquee><input type='hidden' id='judul_lagunya' value='"+y["title"]+"'>"
																		} else {
																			html += y["title"];
																		}
														html += '</span><br/>'+
																		'<i style="font-family: \'Gloria Hallelujah\', cursive;font-size:13px">'+y["caption"]+'</i>'+
																	'</td>'+
																'</tr>'+
															'</table>'+
														'</td>'+
													'</tr>'+
												'</table>	'+
											'</td>'+
										'</tr>';
										if(y.user_id != 0) {
											html += '<tr class="buttonLayer">'+button+'</tr>';
										};
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
										html +=	'</td>'+
														'<td class="view-user-detail">'+
															'<table class="table-playlist-detail">'+
																'<tr>'+
																	'<td style="vertical-align:bottom"><b class="username-user">'+y["createby"]+medal+'</b></td>';
																	if(y["user_id"] == userid) {
																		html += '<td align="right"><i onclick="deleteMySong(\''+y["playlist_id"]+'\')" class="fa fa-times button-delete-row"></i></td>';
																	}
											html += '</tr>'+
																'<tr>'+
																	'<td colspan="2" class="song-desc" style="font-size:14x;vertical-align:top">';
																		if(y["title"].length > 250) {
																			html += "<marquee  >"+y["title"]+"</marquee><input type='hidden' id='judul_lagunya' value='"+y["title"]+"'>"
																		} else {
																			html += y["title"];
																		}
														html += '<br/>'+
																		'<i style="font-size:13px;font-family: \'Gloria Hallelujah\', cursive;">'+y["caption"]+'</i>'+
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
				$("#music-playlist").html("");
				$("#music-playlist").append(html);
				$('[data-toggle="tooltip"]').tooltip();
				$.each($(".button-share-row"),function(index,item) {
					$(item).hideshare({
						link: $(item).attr("link"),
						media: $(item).attr("link"),
						title: $(item).attr("caption")+" #JUKEBOX5D",
						description: $(item).attr("caption")+" #JUKEBOX5D",
						position: "bottom",
					})
				});
				scrlsts();
			} else {
				document.title = "<?php echo $this->config->item("title"); ?>";
				lastInsert = "";
				html = "<tr style='height:120px;'><td align='center'><?php echo $this->config->item("empty_playlist") ?></td></tr>";
				$("#music-playlist").html("");
				$("#music-playlist").append(html);
			}
			$("marquee").mouseover(function() {
				this.stop();
			}).mouseleave(function() {
				this.start();
			});
		}
	});
	socket.on("mostRequest",function(data) {
		// console.log(data);
		var result = JSON.parse(data);
		var html = "";
		var i = 1;
		mostRequest = new Array();
		if(result[0] != null) {
			$.each(result,function(x,y) {
				var image = "<?php echo $this->config->item("user_default");?>";
				if(isValidURL(y["twitter_image"])!=true){
					image='<?php echo base_url(); ?>assets/'+y["twitter_image"];;
				}
				if(i <= 3) {
					mostRequest[i] = y["name"];
				}
				var rank = "";
				var medallink = "";
				if(i == 1) {
					medallink = "<?php echo $this->config->item("medal_gold"); ?>";
					rank = "firstRank";
				} else if (i == 2) {
					medallink = "<?php echo $this->config->item("medal_silver"); ?>";
					rank = "secondRank";
				} else if(i == 3) {
					medallink = "<?php echo $this->config->item("medal_bronze"); ?>";
					rank = "thirdRank";
				}
				else{
					rank = "rankDefault";
				}
				if(i <= 5) {
					html += "<tr class='song-content' style='cursor:pointer;' onClick='"+'detailUser("'+y["user_id"]+'","'+rank+'","'+medallink+'")'+"'>";
					if(i == 1){
						html += "<td align='center'><img src='<?php echo $this->config->item("medal_gold"); ?>' class='img-circle' width='20px'/></td>";
					}
					else if(i == 2)
					{
						html += "<td align='center'><img src='<?php echo $this->config->item("medal_silver"); ?>' class='img-circle' width='20px'/></td>";
					}
					else if(i == 3){
						html += "<td align='center'><img src='<?php echo $this->config->item("medal_bronze"); ?>' class='img-circle' width='20px'/></td>";
					}
					else{
						html += "<td align='center'></td>";
					}
					html += "<td align='center'><img src='"+image+"' class='img-circle' width='20px'/></td>"+
							"<td>"+i+".</td>"+
							"<td>"+y["name"]+"</td>"+
							"<td align='center'><span class='badge' style='font-size:9px'>"+y["counter"]+"</span></td>"+
						"</tr>";
				}
				i++;
			});
		} else {
			html = "<tr class='song-content'><td colspan='4' align='center' style='color:red;font-weight:bold;font-size:13px;'><?php echo $this->config->item("king_queen"); ?></td></tr>"
		}
		$("#table-most-request").html(html);
	})
	socket.on("mostPlayed",function(data) {
		var result = JSON.parse(data);
		var i = 1;
		mostPlayed = "";
		if(result[0] != null) {
			$.each(result,function(x,y) {
				var from = "soundcloud";
				var icon = "<i class='fa fa-soundcloud' style='color:#ff3a00;'></i>";
				if(y["link"].match(/youtube/)) {
					from = "youtube";
					icon = "<i class='fa fa-youtube-play' style='color:#bb0000;'></i>";
				}
				var insert = 'insertDB("'+y["track_id"]+'","'+from+'","'+y["title"]+'","'+y["genre"]+'","'+twitterImage+'","'+y["link"]+'",1)'
				mostPlayed += "<tr onclick='return "+insert+"' class='row-song'><td style='vertical-align:middle' align='center'>"+icon+" </td><td class='song-content'>"+i+". "+y["title"]+"</td><td class='icon-playlist'><i class='fa fa-play-circle' ></i></td></tr>";
				i++;
			});
		} else {
			mostPlayed = "<tr><td class='song-content' align='center' style='color:red;'><?php echo $this->config->item("most_played_title"); ?></td></tr>"
		}
		if($("#mostplayed").hasClass("active-box")) {
			$("#table-tap").html("");
			$("#table-tap").append(mostPlayed);
		}
		prevWeeklyChart();
	})
	socket.on("recentSong",function(data) {
		var result = JSON.parse(data);
		var i = 1;
		recent = "";
		if(result.length > 0) {
			$.each(result,function(x,y) {
				var from = "soundcloud";
				var icon = "<i class='fa fa-soundcloud' style='color:#ff3a00;'></i>";
				if(y["link"].match(/youtube/)){
					from = "youtube";
					icon = "<i class='fa fa-youtube-play' style='color:#bb0000;'></i>";
				}
				var insert = 'insertDB("'+y["track_id"]+'","'+from+'","'+y["title"]+'","'+y["genre"]+'","'+twitterImage+'","'+y["link"]+'",0)'
				recent += "<tr onclick='return "+insert+"' class='row-song'><td style='vertical-align:middle' align='center'>"+icon+" </td><td class='song-content'>"+i+". "+y["title"]+"</td><td class='icon-playlist'><i class='fa fa-play-circle' ></i></td></tr>";
				i++;
			});
		} else {
			recent = "<tr><td class='song-content' align='center' style='color:red;'><?php echo $this->config->item("recent_song_title"); ?></td></tr>";
		}
		if($("#suggestion").hasClass("active-box")) {
			$("#table-tap").html("");
			$("#table-tap").append(recent);
		}
	});
	socket.on("getAllMessage", function(data) {
		var result = JSON.parse(data);
		chat = "";
		// console.log(data);
		$.each(result, function(x,y) {
			if(y != "flagFirstTime") {
				var date = new Date(y.created);
				// console.log(date);
				var dd = date.getDate();
				var mm = date.getMonth()+1; //January is 0!
				var yyyy = date.getFullYear();
				var hours = date.getHours();
				// console.log(hours);
				hours = (hours<10?'0':'') + hours;
				// console.log(hours);
				var minutes = (date.getMinutes()<10?'0':'') + date.getMinutes();
				// console.log(y.created);
				chat += '<div class="chat-row">';
				chat += '<div class="row" style="margin-left:0px;margin-right:0px">';
				if(isValidURL(y.images)!=true){
					y.images='<?php echo base_url(); ?>assets/'+y.images;
				}
				var chatUser = base64.decode(y.chat);
				var splitReply = chatUser.split("<?php echo $this->config->item("delimiter") ?>");
				if(splitReply.length > 2) {
					var addReply = "addReply('"+y.username+"','"+splitReply[2]+"')";
					if(y.username == username) {
						chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user" style="padding:2px 2px 2px 10px"><label class="direct-chat-text2" style="float:right" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b> <small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small><br/><div class="col-xs-12 box-reply2"><b class="title">'+splitReply[0]+'</b><br/><label class="chatText">'+window.emojiPicker.unicodeToImage(splitReply[1])+'</label></div>'+window.emojiPicker.unicodeToImage(splitReply[2])+'</label></div>';
						chat += '<div class="col-xs-2 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
					} else {
						chat += '<div class="col-xs-2 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
						chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user"><label class="direct-chat-text" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b><br/><div class="col-xs-12 box-reply2"><b class="title">'+splitReply[0]+'</b><br/><label class="chatText">'+window.emojiPicker.unicodeToImage(splitReply[1])+'</label></div>'+window.emojiPicker.unicodeToImage(splitReply[2])+'</label><br/><small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small></div>';
					}
				} else {
					var addReply = "addReply('"+y.username+"','"+chatUser+"')";
					if(y.username == username) {
						chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user" style="padding:2px 2px 2px 10px"><label class="direct-chat-text2" style="float:right" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b> <small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small><br/>'+window.emojiPicker.unicodeToImage(chatUser)+'</label><br/></div>';
						chat += '<div class="col-xs-2 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
					} else {
						chat += '<div class="col-xs-2 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
						chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user"><label class="direct-chat-text" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b><br/>'+window.emojiPicker.unicodeToImage(chatUser)+'</label><br/><small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small></div>';
					}
				}
				chat += '</div>';
				chat += '</div>';
			}
		});
		$("div#box-chat").append(chat);
		$('div#box-chat').animate({scrollTop: $('div#box-chat')[0].scrollHeight}, 2000);
	});
	socket.on("whosLogin",function(data) {
		var result = JSON.parse(data);
		var html = "";
		var nomor = 1;
		for(var i=result.length-1;i>=0;i--) {
			var split = result[i].split('<?php echo $this->config->item("delimiter") ?>');
			var rank = "";
			var medallink = "";
			html += "<tr class='song-content' style='cursor:pointer;' onClick='"+'detailUser("'+split[1]+'","","")'+"'>";
			html += "<td>"+nomor+".</td>";
			html += "<td>"+split[0]+"</td>";
			if(result[i].match("admin"))
			{
				html += "<td align='center'><i class='fa fa-laptop'></i></td>";
			}
			else
			{
				html += "<td align='center'><i class='fa fa-user'></i></td>";
			}
			html += "</tr>";
			nomor++;
		}
		$("#whosLogin").html(html);
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
	function chat() {
		socket.on('message2', function(data) {
			var result = JSON.parse(data);
			// console.log(result);
			chat = "";
			var audio = new Audio("<?php echo $this->config->item("notif"); ?>");
			$.each(result, function(x,y) {
				if(! ('Notification' in window) ){
					swal('Web Notification is not supported','',"warning");
					return;
				}
				var chatUser = base64.decode(y.chat);
				var splitReply = chatUser.split("<?php echo $this->config->item("delimiter") ?>");
				if(y.username != username) {
					audio.play();
					Notification.requestPermission(function(permission){
						if(splitReply.length > 2) {
							var notification = new Notification(y.username,{body: splitReply[2],icon: y.images});
						} else {
							var notification = new Notification(y.username,{body: chatUser,icon: y.images});
						}
						notification.onclick = function() {
							window.focus(); this.cancel();
						};
						setTimeout(function(){
							notification.close(); //closes the notification
						},5000);
					});
				}
				var date = new Date(y.created);
				var dd = date.getDate();
				var mm = date.getMonth()+1; //January is 0!
				var yyyy = date.getFullYear();
				var hours = date.getHours();
				var minutes = (date.getMinutes()<10?'0':'') + date.getMinutes();
				chat += '<div class="chat-row">';
				chat += '<div class="row" style="margin-left:0px;margin-right:0px">';
				if(isValidURL(y.images)!=true){
					y.images='<?php echo base_url(); ?>assets/'+y.images;
				}
				if(splitReply.length > 2) {
					var addReply = "addReply('"+y.username+"','"+splitReply[2]+"')";
					if(y.username == username) {
						chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user" style="padding:2px 2px 2px 10px"><label class="direct-chat-text2" style="float:right" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b> <small class="chat-time" style="float:right">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small><br/><div class="col-xs-12 box-reply2"><b class="title">'+splitReply[0]+'</b><br/><label class="chatText">'+window.emojiPicker.unicodeToImage(splitReply[1])+'</label></div>'+window.emojiPicker.unicodeToImage(splitReply[2])+'</label></div>';
						chat += '<div class="col-xs-2 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
					} else {
						chat += '<div class="col-xs-2 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
						chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user"><label class="direct-chat-text" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b><br/><div class="col-xs-12 box-reply2"><b class="title">'+splitReply[0]+'</b><br/><label class="chatText">'+window.emojiPicker.unicodeToImage(splitReply[1])+'</label></div>'+window.emojiPicker.unicodeToImage(splitReply[2])+'</label><br/><small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small></div>';
					}
				} else {
					var addReply = "addReply('"+y.username+"','"+chatUser+"')";
					if(y.username == username) {
						chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user" style="padding:2px 2px 2px 10px"><label class="direct-chat-text2" style="float:right" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b> <small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small><br/>'+window.emojiPicker.unicodeToImage(chatUser)+'</label><br/></div>';
						chat += '<div class="col-xs-2 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
					} else {
						chat += '<div class="col-xs-2 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
						chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user"><label class="direct-chat-text" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b><br/>'+window.emojiPicker.unicodeToImage(chatUser)+'</label><br/><small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small></div>';
					}
				}
				chat += '</div>';
				chat += '</div>';
			});
			$("div#box-chat").append(chat);
			$('div#box-chat').animate({scrollTop: $('div#box-chat')[0].scrollHeight}, 500);
		});
	}
	function post() {
		username = $("#username").val();
		str = $("#post").html();
		var titleReply = $("#titleReply").html();
		var bodyReply = $("#bodyReply").html();
		// console.log(str);
		var data = {};
		if(username == "") {
			alert("<?php echo $this->config->item("empty_username"); ?>");
		} else if(str == "") {
			alert("<?php echo $this->config->item("empty_message"); ?>");
		} else {
			var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			var hours = today.getHours();
			var minutes = today.getMinutes();
			var seconds = today.getSeconds();
			if(dd<10) {
				dd='0'+dd
			}
			if(mm<10) {
				mm='0'+mm
			}
			var regex = /(<([^>]+)>)/ig
			if(titleReply != "" && bodyReply != "") var str = titleReply + "<?php echo $this->config->item("delimiter") ?>" + bodyReply + "<?php echo $this->config->item("delimiter") ?>" + $("#post").html();
			today = yyyy+'/'+mm+'/'+dd+' '+hours+':'+minutes+':'+seconds;
			data.username = username;
			data.userid = userid;
			data.chat = base64.encode(str.replace(/'/g, "\\'").replace(regex, ""));
			data.image = twitterImage;
			data.time = today;
			data.loc = varLoc;
			socket.emit("message2",data);
			$("#titleReply").html("");
			$("#bodyReply").html("");
			closeReply();
			$("#inputpost").val("");
			$("#post").html("");
			$("#post").focus();
		}
	}
	function deleteMySong(playlist_id) {
		if(confirm("<?php echo $this->config->item("delete_song"); ?>")) {
			socket.emit("deleteMySong",{playlist_id: playlist_id, loc: varLoc});
		}
	}
	function insert5Love(id,from,title,genre,img,link) {
		var data = {};
		data.username = "<?php echo $this->session->userdata('username_admin') ?>";
		data.userid = "<?php echo $this->session->userdata("user_id_admin") ?>";
		data.id = id;
		data.from = from;
		data.title = title;
		data.genre = genre;
		data.loc = varLoc;
		data.img = encodeURIComponent("images/jukebox-admin.png");
		data.flag = 1;
		data.cap = "";
		data.link = link;
		socket.emit("insertSong",data);
		jukeboxLoc(varLoc);
		jukeboxRecent(userid);
	}

	function insertPlaylist(){
		// alert('YUHU!');
		// playlist_selector
		// document.getElementById("playlist_selector").style.color = "blue";

	}

		function selectDB(id,link,title){

			//var getValue = $('.popup').attr("myModal");


			// alert(""+id+""+link+""+title);
			var track_id = id;
			var link = link;
			var title = title;
			// var playlist_id = $('#selectBox').val();
			// // var playlist_id = 123;
			// var playlist_id = $('#selectBox').val();
			// attr('id')
			$('#myModal').modal('show');


								   			$('#savePlaylist').click(function () {
								                    $.ajax({
								                        url : "<?php echo  site_url().'/Home/addItem'; ?>",
								                        type : "POST",
								                        data : {
								                	            "track_id": track_id,
												        		"link": link,
												        		"title": title,
												        		"playlist_id":$('#selectBox').find(":selected").val()
																},
								                        success : function (response) {
								                        	var json = JSON.parse(response);
								                        	if(json.status){
								                            alert(""+title +" - added into playlist : "+$('#selectBox').find(":selected").text()+" ");
								                            getPlaylist();
								                            $('#myModal').modal('hide');
								                            document.location.href='https://jukebox5d.com/app/index.php/home';

								                        	}else{
								                        		alert("Music sudah tersedia di library");
								                        	}


								                        }
								                    })
								                });

			// $.ajax({
   //      type: "POST",
   //      url: '<?php echo site_url('Home/addItem'); ?>',
   //      data: {
   //      		"track_id": track_id,
   //      		"link": link,
   //      		"title": title,
   //      		"playlist_id":playlist_id

   //      		},  // fix: need to append your data to the call
   //      success: function (data) {


   //      }
   //  });
			// alert("success");
		}


// getplaylis
function getPlaylist() {
                playlist_number=1;
                $.ajax({
                    url : "<?php echo  site_url().'/Playlist/getPlaylistUser'; ?>",
                    type : "GET",
                    success : function (response) {
                        var json=JSON.parse(response);
                        if(json.status){
                            var html="";
                            $.each(json.data,function (k,v) {
                                var row='<a role="button" data-toggle="collapse" data-parent="#accordion-'+v.playlist_id+'" href="#collapse-'+playlist_number+'" aria-expanded="true" aria-controls="collapse-'+playlist_number+'">'+
                                    '<div class="panel-heading user-playlist-box" role="tab" id="heading-'+playlist_number+'"  style="margin-bottom:5px">'+
                                    '<h4 class="panel-title">'+v.playlist_name+'</h4>'+
                                    '</div></a>'+'<div id="collapse-'+playlist_number+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'+playlist_number+'">'+
                                    '<div class="panel-body">'+
                                    '<table class="table table-striped" id="tbl-playlist-'+v.playlist_id+'">';
                               getPlaylistDetail(v.playlist_id,"tbl-playlist-"+v.playlist_id);
                                row+='</table>'+
                                    '<button class="btn btn-primary add-playlistItem" data-plid="'+v.playlist_id+'" data-plname="'+v.playlist_name+'"><i class="fa fa-plus"></i> Add Song</button> '+
                                    '<button class="btn btn-danger del-playlist" data-plid="'+v.playlist_id+'"><i class="fa fa-trash"></i> Delete Library</button> '+
                                    '<button class="btn btn-info edit-playlist" data-plid="'+v.playlist_id+'" data-plname="'+v.playlist_name+'"><i class="fa fa-trash"></i> Edit Library Name</button>'+
                                    '</div>'+
                                    '</div>';
                                html+=row;
                                playlist_number++;
                            });
                            // $('#panel-playlist').html(html);
                        }
                    }
                });
            }


//end getplaylist


// getplaylistDetail


 function getPlaylistDetail(playlist_id,id) {
			    var num=1;
			    var html="";
                $.ajax({
                    url : "<?php echo  site_url().'/Playlist/getPlaylistUserItem/'; ?>"+playlist_id,
                    type : "GET",
                    success : function (response) {
                        var json=JSON.parse(response);
                        if(json.status){
                            $.each(json.data,function (k,v) {
                            	 var string = "^[0-9]*$";
                              if(!v.track_id.match(string)){

                                   var icon = '<i class="fa fa-youtube-play" style="color:#bb0000"></i>';
                                }else if(v.track_id.match(string)){
                                   var icon = '<i class="fa fa-soundcloud" style="color:#bb0000"></i>';
                                }else{
                                  var icon = '<i class = "fa fa-cross"> </i>';
                                }
                                html += '<tr class="row-song-playlist-user">' +
                                    '<td style="vertical-align: middle" align="center">'+icon+'<i class="fa fa-youtube-play" style="color:#bb0000"></i></td>' +
                                    '<td class="song-content">' + num + '. ' + v.title + '</td>' +
                                    '<td class="icon-playlist" style="text-align: center">' +
//                                    '<button class="btn btn-xs btn-success"><i class="fa fa-play"></i> Play</button>'+
                                    '<button class="btn btn-warning btn-xs delete-itempl" data-plid="'+playlist_id+'" data-pllink="'+encodeURI(v.link)+'"><i class="fa fa-times"></i> Remove</button>' +
                                    '</td>' +
                                    '</tr>';
                                num++;
                            });
                           $("#"+id).html(html);
                        }
                    }
                });
            }



// end getplaylistDetail

	function insertDB(id,from,title,genre,img,link,flag) {
		// kalo flag 0 dari recent song, kalo 1 dari mostplayed atau livesearch
		$('#detailUserModal').modal('hide');
		if(flagInsert) {
			if(typeof(totalCountCreated[userid]) == "undefined" || totalCountCreated[userid] < 2) {
					if(lastInsert != userid) {
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
										jukeboxRecent(userid);
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
	function likedislike(playlist_id,userid,option,total,track_id,title,genre,twitterImage,from,link) {
		$("i#like-"+playlist_id).prop("onclick", null);
		$("i#dislike-"+playlist_id).prop("onclick", null);
        //if(canLove) {
            socket.emit("likedislike", {playlist_id: playlist_id, userid: userid, option: option, loc: varLoc});
        //}
		if(option == "like" && total == 4) {
			insert5Love(track_id,from,title,genre,twitterImage,link);
		}
	}

					function selectDBStream(id,link){

			//var getValue = $('.popup').attr("myModal");


			// alert(""+id+""+link+""+title);
			var track_id = id;
			var link = link;
			var title = dynamicTitle;
			// var playlist_id = 123;
			// var playlist_id = $('#selectBox').val();
			// var playlist_id = $('#selectBox').find(":selected").val();
			// attr('id')
			$('#myModal').modal('show');


								   			$('#savePlaylist').click(function () {

								                    $.ajax({
								                        url : "<?php echo  site_url().'/Home/addItem'; ?>",
								                        type : "POST",
								                        data : {
								                	            "track_id": track_id,
												        		"link": link,
												        		"title": title,
												        		"playlist_id":$('#selectBox').find(":selected").val()
																},
								                        success : function (response) {
								                        	if(response){
								                            alert(""+title +" - added into playlist : "+$('#selectBox').find(":selected").text()+" ");
								                            getPlaylist();
								                            $('#myModal').modal('hide');
								                            location.reload();
								                            // $("#savePlaylist").html();


								                        	}else {
								                        		alert("Kesalahan process ");
								                        	}
								                        }
								                    })
								                });

			// $.ajax({
   //      type: "POST",
   //      url: '<?php echo site_url('Home/addItem'); ?>',
   //      data: {
   //      		"track_id": track_id,
   //      		"link": link,
   //      		"title": title,
   //      		"playlist_id":playlist_id

   //      		},  // fix: need to append your data to the call
   //      success: function (data) {


   //      }
   //  });
			// alert("success");
		}

	function jukeboxRecent(userid) {
		socket.emit("getRecentSong",{userid: userid, loc: varLoc});
	}
	function jukeboxLoc(loc) {
		socket.emit("jukeboxLocation", loc);
	}
	/*
	|--------------------------------------------------------------------------
	| END Function with Socket
	|--------------------------------------------------------------------------
	*/
	/*
	|--------------------------------------------------------------------------
	| Extend function
	|--------------------------------------------------------------------------
	*/
	Array.prototype.clean = function(deleteValue) {
		for (var i = 0; i < this.length; i++) {
			if (this[i] == deleteValue) {
				this.splice(i, 1);
				i--;
			}
		}
		return this;
	};
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
	/*
	|--------------------------------------------------------------------------
	| END Extend function
	|--------------------------------------------------------------------------
	*/
	/*
	|--------------------------------------------------------------------------
	| My Function "USER"
	|--------------------------------------------------------------------------
	*/
	function formatLocalDate(date) {
		var now = new Date(date),
				tzo = -now.getTimezoneOffset(),
				dif = tzo >= 0 ? '+' : '-',
				pad = function(num) {
						var norm = Math.abs(Math.floor(num));
						return (norm < 10 ? '0' : '') + norm;
				};
		return now.getFullYear()
				+ '-' + pad(now.getMonth()+1)
				+ '-' + pad(now.getDate())
				+ 'T' + pad(now.getHours())
				+ ':' + pad(now.getMinutes())
				+ ':' + pad(now.getSeconds())
				+ dif + pad(tzo / 60)
				+ ':' + pad(tzo % 60);
	}
	function prevWeeklyChart() {
		if(prevWeekChart.length > 0) {
			$.each(prevWeekChart, function(x,y) {
				//tampilannya disini ros
				//ini tampilan kalo ada prevWeekChart
			})
		} else {
			//ini tampilan kalo ga ada prevWeekChart
		}
	}
	function getMostPlayed() {
		if(mostPlayed != "" && typeof(mostPlayed) != "undefined") {
			$("#table-tap").html("");
			$("#table-tap").append(mostPlayed);
		}
	}
	function scrlsts() {
		document.title = "\u25B6 " + dynamicTitle + "     ";
		// dynamicTitle = dynamicTitle.substring(1, dynamicTitle.length) + dynamicTitle.substring(0, 1);
		// setTimeout("scrlsts()", 500);
	}
	function getRecent() {
		if(recent != "" && typeof(recent) != "undefined") {
			$("#table-tap").html("");
			$("#table-tap").append(recent);
		}
	}
	function suggestion(){
		getRecent();
		$("#mostplayed").removeClass("active-box");
		$("#suggestion").addClass("active-box");
	}
	function mostplayed(){
		getMostPlayed();
		$("#suggestion").removeClass("active-box");
		$("#mostplayed").addClass("active-box");
	}
	function checkLength(str) {
		if (str.value.length > 50) {
			$(".confirm").hide();
			$("#errCaption").show();
		} else {
			$(".confirm").show();
			$("#errCaption").hide();
		}
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
					// console.log(resp);return;
					genre = "";
					food = "";
					drink = "";
					hangoutPlace = "";
					recentSongUser = "";
					var json = JSON.parse(resp);
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
					// console.log(drinkArr);
					if(json.data["food"]) { var foodArr = JSON.parse(json.data["food"]) } else { var foodArr = "" };
					if(json.data["hangout_place"]) { var hangoutPlaceArr = JSON.parse(json.data["hangout_place"]) } else { var hangoutPlaceArr = "" };
					$('#userDetail-image').attr('src','<?php echo base_url(); ?>assets/'+json.data['twitter_image']);
					$('#userDetail-image').attr('class', ' img-circle ' + rank);
					if(medal != "") $('#userDetail-username').html(json.data['username']+"<img src='"+medal+"' class='img-circle' width='15px' style='margin-left:3px;'/>");
					else $('#userDetail-username').html(json.data['username']);
					genre += "<div class='col-md-3'><b style='color:#CFCFCF'>Music Genre </b> </div>";
					drink += "<div class='col-md-3'><b style='color:#CFCFCF'>Drink </b></div> ";
					food += "<div class='col-md-3'><b style='color:#CFCFCF'>Food </b></div> ";
					hangoutPlace += "<div class='col-md-3'><b style='color:#CFCFCF'>Hangout Place </b></div> ";
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
						genre += "</div>";
					} else {
						genre += "<span> - </span>"
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
						drink += "</div>";
					} else {
						drink += "<span>-</span>"
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
						food += "</div>";
					} else {
						food += "<span>-</span>"
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
						hangoutPlace += "</div>";
					} else {
						hangoutPlace += "<span>-</span>"
					}
					if(json.data["bio"]) {
						var bio = json.data["bio"]
					} else {
						var bio = "<span>-</span>"
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
							var onclick = 'insertDBB("'+y.track_id+'","'+from+'","'+y.title+'","'+y.genre+'","'+twitterImage+'","'+y.link+'",0)';
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
					$('#userDetail-bio').html("<strong>About: </strong><br/>" + bio + "<br/><br/>");
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
	function addReply(username,text) {
		$("#titleReply").html(username);
		$("#bodyReply").html(text);
		$("#replyChat").show();
		$("#post").focus();
	}
	function closeReply() {
		$("#titleReply").html("");
		$("#bodyReply").html("");
		$("#replyChat").hide();
	}
	$(document).ready(function(){
		jukeboxLoc(varLoc);
		jukeboxRecent(userid);
		chat();
		getLocationOnReady()
		setInterval(function() { getLocationOnReady() },60000);
		$("#inputsong").donetyping(function() {
			showResult(this.value);
		});
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

		// start function


			function getPlaylist() {
                playlist_number=1;
                $.ajax({
                    url : "<?php echo  site_url().'/Playlist/getPlaylistUser'; ?>",
                    type : "GET",
                    success : function (response) {
                        var json=JSON.parse(response);
                        if(json.status){
                            var html="";
                            $.each(json.data,function (k,v) {
                                var row='<a role="button" data-toggle="collapse" data-parent="#accordion-'+v.playlist_id+'" href="#collapse-'+playlist_number+'" aria-expanded="true" aria-controls="collapse-'+playlist_number+'">'+-
                                    '<div class="panel-heading user-playlist-box" role="tab" id="heading-'+playlist_number+'"  style="margin-bottom:5px">'+
                                    '<h4 class="panel-title">'+v.playlist_name+'</h4>'+
                                    '</div></a>'+'<div id="collapse-'+playlist_number+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'+playlist_number+'">'+
                                    '<div class="panel-body">'+
                                    '<table class="table table-striped" id="tbl-playlist-'+v.playlist_id+'">';
                               getPlaylistDetail(v.playlist_id,"tbl-playlist-"+v.playlist_id);
                                row+='</table>'+
                                    '<button class="btn btn-primary add-playlistItem" data-plid="'+v.playlist_id+'" data-plname="'+v.playlist_name+'"><i class="fa fa-plus"></i> Add Song</button> '+
                                    '<button class="btn btn-danger del-playlist" data-plid="'+v.playlist_id+'"><i class="fa fa-trash"></i> Delete Library</button> '+
                                    '<button class="btn btn-info edit-playlist" data-plid="'+v.playlist_id+'" data-plname="'+v.playlist_name+'"><i class="fa fa-trash"></i> Edit Library Name</button>'+
                                    '</div>'+
                                    '</div>';
                                html+=row;
                                playlist_number++;
                            });
                            $('#panel-playlist').html(html);
                        }
                    }
                });
            }


		// end function
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
								var err = result.err;
								if(err == "") {
									// console.log(1);
									$.each(result.data,function(x,y){
										//if(x != "err") {
											var from = y.from;
											var title = y.title;
											var duration_youtube = y.duration_youtube;
											var duration_soundcloud = y.duration_soundcloud;
											var genre = y.genr;
											var onclick = 'insertDB("'+y.track_id+'","'+from+'","'+title.substring(0, 20)+'","'+genre+'","'+twitterImage+'","'+y.link+'",1)';
											// var onclick = "insertDB('"+y.track_id+"',"+from+","+title+","+genre+","+twitterImage+","+y.link+",1)";
											var onclick2 = 'selectDB("'+y.track_id+'","'+y.link+'","'+title+'")';

								   			// $('#savePlaylist').click(function () {

								      //               $.ajax({
								      //                   url : "<?php echo  site_url().'/Home/addItem'; ?>",
								      //                   type : "POST",
								      //                   data : {
								      //           	            "track_id": y.track_id,
												  //       		"link": y.link,
												  //       		"title": y.title,
												  //       		"playlist_id":123,
								      //                   },
								      //                   success : function (response) {
								      //                       alert("berhasil");
								      //                   }
								      //               })
								      //           });


											if(y['from'] == 'soundcloud') {
												var css = 'btn-info';
												var sourceLink = "<a href='"+y.link+"' target='blank'><i class='fa fa-soundcloud button-source-soundcloud-row' style='color:#ff3a00;font-size:16px'></i></a>"
												var duration = millisToMinutesAndSeconds(y.duration_soundcloud);
											} else {
												var css = 'btn-info';
												var sourceLink = "<a href='"+y.link+"' target='blank'><i class='fa fa-youtube-play button-source-youtube-row' style='color:#bb0000;font-size:18px'></i></a>"
												var duration = y.duration_youtube;
											}
											html += "<div class='box col-xs-12' style='border:1px solid #e5e5e5;padding:10px 8px 8px 8px;'><div class='col-xs-1'><label align='right'>"+sourceLink+"</label></div><div class='col-xs-11' style='padding:0px; height:5px;' ><div class='col-xs-11 font-song-light' style='display:table-cell;vertical-align:middle;'>"+title+ " - " +duration+" </div><div class='col-xs-1' style='text-align:center'><button onclick='return "+onclick+"' class='overlay btn "+css+" btn-xs' style='width:24px; height:24px;padding-left:7px;border-radius:50%;display:table-cell;vertical-align:middle;cursor:pointer;'><i class='fa fa-play fa-1x'></i></button> <button onclick='return "+onclick2+"' class='fa fa-plus fa-1x btn btn-danger' style='border-radius:50%;display:table-cell;vertical-align:middle;cursor:pointer;margin-left: -50px; padding:0; height: 24px;margin-top-40px;width:24px;margin-top: -44px;'></button> </div></div></div>";
										//}

										// <button class='overlay btn btn-danger btn-xs' style='padding-left:7px;border-radius:180%;display:table-cell;vertical-align:middle;margin-left:-40px; margin-top:-40px;' ><i class='fa fa-plus fa-1x' onClick='insertPlaylist()' data-toggle='modal' data-target='#myModal' style='margin-left:-2px;'></i></button>
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
		//Back to top Scroll Function
		$(function(){
				$(document).on( 'scroll', function(){
					if ($(window).scrollTop() > 100) {
					$('.scroll-top-wrapper').addClass('show');
				} else {
					$('.scroll-top-wrapper').removeClass('show');
				}
			});
			$('.scroll-top-wrapper').on('click', scrollToTop);
		});


		function scrollToTop() {
			verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
			element = $('body');
			offset = element.offset();
			offsetTop = offset.top;
			$('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
		}
		//END Back to top Scroll Function
		$("#klikLyrics").click(function(){
			if($("#songLyrics").hasClass("flagShow")) {
				$("#songLyrics").removeClass("flagShow");
				$("#songLyrics").fadeOut();
			} else {
				$("#songLyrics").addClass("flagShow");
				$("#songLyrics").fadeIn();
			}
		});
		$("#btnEmot").click(function() {
			$('[data-toggle=popover]').popover("toggle");
		})
		$('[data-toggle=popover]').popover({
				content: $('#myPopoverContent').html(),
				html: true
		})
		// $("#inputsong").css({"text-indent":"-5000px","display":"inline-block"});
		$("#inputsong").css({"text-indent":"0px","display":"inline-block"});
		$("#search-gate").css({"display":"block"});
		// $("#label-music").click(function() {
			// if($(".search-box").hasClass("flagFocus")) {
				// $(".search-box").removeClass("flagFocus");
				// $(".search-box").css("text-indent", "-5000px");
				// $("#livesearch").html("");
			// } else {
				// $(".search-box").css("text-indent", "");
				// $(".search-box").addClass("flagFocus");
			// }
		// });
		// emoticon script
		// Initializes and creates emoji set from sprite sheet
		window.emojiPicker = new EmojiPicker({
			emojiable_selector: '[data-emojiable=true]',
			assetsPath: '<?php echo $this->config->item("emoji_path"); ?>',
			popupButtonClasses: 'fa fa-smile-o'
		});
		// Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
		// You may want to delay this step if you have dynamically created input fields that appear later in the loading process
		// It can be called as many times as necessary; previously converted input fields will not be converted again
		window.emojiPicker.discover();
		// emoticon script
		setTimeout(function() {
			getMostPlayed();
		},1000);
		$('#post').keydown(function (event) {
			var keypressed = event.keyCode || event.which;
			if (keypressed == 13) {
				$("#buttonclick").trigger("click");
			}
		});
		$("#howto").click(function(){
			$('#myModal').modal('show');
		});
		var heightWindows = $(window).height();
		if(heightWindows > 780)
		{
			function relative_sticky(id, topSpacing){
			if(!topSpacing){ var topSpacing = 0; }
			var el_top = parseFloat(document.getElementById(id).getBoundingClientRect().top);
					el_top = el_top - parseFloat(document.getElementById(id).style.top);
					el_top = el_top * (-1);
					el_top = el_top + topSpacing;
					if(el_top > 0){
					document.getElementById(id).style.top = el_top + "px";
					} else{
					document.getElementById(id).style.top = "0px";
					}
			}
			window.onscroll = function(){
					relative_sticky("sidebarRight", 58);
					relative_sticky("sidebarLeft", 58);
			}
		}
		else if(heightWindows > 650 && heightWindows < 780)
		{
			$(function() {
					var offset = $("#sidebarLeft").offset();
					var resultScroll = heightWindows - (heightWindows/10);
					var topPadding = - (heightWindows - resultScroll) + 25;
					$(window).scroll(function() {
							if ($(window).scrollTop() > offset.top) {
									$("#sidebarLeft").stop().animate({
											marginTop: $(window).scrollTop() - offset.top + topPadding
									});
							}
							else {
									$("#sidebarLeft").stop().animate({
											marginTop: 0
									});
							};
					});
			});
			$(function() {
					var offset = $("#sidebarRight").offset();
					var resultScroll = heightWindows - (heightWindows/10);
					var topPadding = - (heightWindows - resultScroll) + 25;
					$(window).scroll(function() {
							if ($(window).scrollTop() > offset.top) {
									$("#sidebarRight").stop().animate({
											marginTop: $(window).scrollTop() - offset.top + topPadding
									});
							}
							else {
									$("#sidebarRight").stop().animate({
											marginTop: 0
									});
							};
					});
			});
		}
		else if(heightWindows > 600 && heightWindows < 650)
		{
			$(function() {
					// if($(window).scrollTop() > midHeight)
					// {
						// $("#sidebarLeft").stop();
					// }
					// alert(heightWindows);
					var offset = $("#sidebarLeft").offset();
					var resultScroll = heightWindows - (heightWindows/10);
					var topPadding = - (heightWindows - resultScroll) - 15;
					$(window).scroll(function() {
							// alert(midHeight);
							if ($(window).scrollTop() > offset.top) {
									// alert($(window).scrollTop() - offset.top + topPadding);
									$("#sidebarLeft").stop().animate({
											marginTop: $(window).scrollTop() - offset.top + topPadding
									});
							}
							else {
									$("#sidebarLeft").stop().animate({
											marginTop: 0
									});
							};
					});
			});
			$(function() {
				// if ($(window).scroll() > midHeight) {
					// $("#sidebarRight").stop().animate({
								// marginTop: 0
						// });
				// }
					var offset = $("#sidebarRight").offset();
					var resultScroll = heightWindows - (heightWindows/10);
					var topPadding =  - (heightWindows - resultScroll) - 15;
					$(window).scroll(function() {
							if ($(window).scrollTop() > offset.top) {
									$("#sidebarRight").stop().animate({
											marginTop: $(window).scrollTop() - offset.top + topPadding
									});
							}
							else {
									$("#sidebarRight").stop().animate({
											marginTop: 0
									});
							};
					});
			});
		}
		else
		{
			$(function() {
					// if($(window).scrollTop() > midHeight)
					// {
						// $("#sidebarLeft").stop();
					// }
					// alert(heightWindows);
					var offset = $("#sidebarLeft").offset();
					var resultScroll = heightWindows - (heightWindows/10);
					var topPadding = - (heightWindows - resultScroll) - 36;
					$(window).scroll(function() {
							// alert(midHeight);
							if ($(window).scrollTop() > offset.top) {
									$("#sidebarLeft").stop().animate({
											marginTop: $(window).scrollTop() - offset.top + topPadding
									});
							}else {
									$("#sidebarLeft").stop().animate({
											marginTop: 0
									});
							};
					});
			});
			$(function() {
				// if ($(window).scroll() > midHeight) {
					// $("#sidebarRight").stop().animate({
								// marginTop: 0
						// });
				// }
					var offset = $("#sidebarRight").offset();
					var resultScroll = heightWindows - (heightWindows/10);
					var topPadding =  - (heightWindows - resultScroll) - 36;
					$(window).scroll(function() {
							if ($(window).scrollTop() > offset.top) {
									$("#sidebarRight").stop().animate({
											marginTop: $(window).scrollTop() - offset.top + topPadding
									});
							}else {
									$("#sidebarRight").stop().animate({
											marginTop: 0
									});
							};
					});
			});
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
		if(showDistanceFromServer(position.coords.latitude, position.coords.longitude) > 1000) { //1000 in meters
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
		var R = 6378137; // Radius of the earth in m
		var dLat = deg2rad(lat2-latitude);  // deg2rad below
		var dLon = deg2rad(lon2-longitude);
		var a =
			Math.sin(dLat/2) * Math.sin(dLat/2) +
			Math.cos(deg2rad(latitude)) * Math.cos(deg2rad(lat2)) *
			Math.sin(dLon/2) * Math.sin(dLon/2)
			;
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
		var d = R * c; // Distance in m
		// console.log(d);
		return d.toFixed(1);
	}
	function deg2rad(deg) {
		return deg * (Math.PI/180)
	}
	function isValidURL(url){
			var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
			if(RegExp.test(url)){
					return true;
			}else{
					return false;
			}
	}
    getPlaylist();
    function getPlaylist() {
        $.ajax({
            url : "<?php echo  site_url().'/Playlist/getPlaylistUser'; ?>",
            type : "GET",
            success : function (response) {
                var json=JSON.parse(response);
                if(json.status){
                    var html="";
                    $.each(json.data,function (k,v) {
                        var row='<li class="dropdown dropdown-submenu">'+
                            '<a tabindex="-1" href="#" class="dropdown-toggle" data-toggle="dropdown"> '+
                            v.playlist_name+
                            '</a>'+
                            '<ul class="dropdown-menu" style="width:500px;max-height:500px;overflow-y:auto;">'+
                            '<table class="table table-striped" id="playlist-'+v.playlist_id+'">';

                        getPlaylistDetail(v.playlist_id);
                        row+='</table></ul>'+
                            '</li>';
                        html+=row;
                    });
                    html+='<li role="separator" class="divider"></li>';
                    html+='<li><a href="<?php echo site_url(); ?>/EditProfile">Manage Library</a></li>';
                    $('#user-menu').html(html);
                }else{
                    var html="";
                    html+='<li><a href="<?php echo site_url(); ?>/EditProfile">Manage Library</a></li>';
                    $('#user-menu').html(html);
                }
            }
        });
    }

// convert soundcloud duration
	    function millisToMinutesAndSeconds(millis) {
	  var minutes = Math.floor(millis / 60000);
	  var seconds = ((millis % 60000) / 1000).toFixed(0);
	  return (minutes < 10 ? '0' : '') + minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
	}
// end

    function getPlaylistDetail(playlist_id) {
        var html="";
        $.ajax({
            url : "<?php echo  site_url().'/Playlist/getPlaylistUserItem/'; ?>"+playlist_id,
            type : "GET",
            success : function (response) {
                var json=JSON.parse(response);
                if(json.status){
                    $.each(json.data,function (k,v) {

						var string = "^[0-9]*$";
                      	if(!v.track_id.match(string)){
                            var from="youtube";
                           var icon = '<i class="fa fa-youtube-play" style="color:#bb0000"></i>';
                        }else if(v.track_id.match(string)){
	                       var from="soundcloud";
                           var icon = '<i class="fa fa-soundcloud" style="color:#ff3a00"></i>';
                        }else{
                          var icon = '<i class = "fa fa-cross"> </i>';
                        }

                        // var findSource=v.link.search("youtube");
                        // if(findSource){
                        //     var icon = "<i class='fa fa-youtube-play' style='color:#bb0000;'></i>";
                        // }else{
                        //     var icon = "<i class='fa fa-soundcloud' style='color:#ff3a00;'></i>";
                        // }


                        var title = v.title;
                        // console.log(title);
                        var genre = "";


                        var onclick = 'insertDB("'+v.track_id+'","'+from+'","'+title+'","'+genre+'","'+twitterImage+'","'+v.link+'",1)';
                        // html += "<li onclick='return "+onclick+"'>" +
                        //     "<a href='#'>" +
                        //     title +" <span style='float:right'> "+ from +"</span>"+
                        //     "</a></li>";

						 html += "<tr class='row-song' onclick='"+onclick+"'>"+
																"<td style='vertical-align:middle' align='center' width='50px'>"+icon+"</td>"+
																"<td class='song-content' style='color:#333'>"+title+"</td>"+
																"<td class='icon-playlist' width='50px' align='center'><i class='fa fa-play-circle'></i></td>"+
															"</tr>";

                    });
                    $("#playlist-"+playlist_id).html(html);
                }
            }
        });
    }


    // $('#savePlaylist').click(function () {
    //                 $.ajax({
    //                     url : "<?php echo  site_url().'/Home/addItem'; ?>",
    //                     type : "POST",
    //                     data : {
    //             	            "track_id": track_id,
				//         		"link": link,
				//         		"title": title,
				//         		"playlist_id":playlist_id,
    //                     },
    //                     success : function (response) {
    //                         alert("berhasil");
    //                     }
    //                 })
    //             });
</script>
<style type="text/css">

	.hover_green{
		color:#888;
	}
	 .hover_green:hover{
		color:#4cc130 ;
	}
</style>

<!-- MODAL START -->
<script type="text/javascript">
	function cek_select(){
		var selectBox = document.getElementById("selectBox");
	    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	    if(selectedValue=="BABA"){
	    	alert(selectedValue);
	    }
	}
</script>

<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="margin-top: 15%; width: 500px;">

	    <!-- Modal content-->
	    <div class="modal-content" style="width: 400px;">
	      <div class="modal-body">

	        <button type="button" class="close" data-dismiss="modal">&times;</button>

	      	<center>
				<h4>Add this song to your Library</h4>
	      		<br>
	      	<select class="form-control" id = "selectBox" onchange="cek_select()">
	      		<?php
					$id=$this->session->userdata('user_id');
					$getPlaylist=$this->UserPlaylist->getPlaylist($id);
					//echo$this->input->post('idCoba2');
					//var_dump($this->UserPlaylist->getPlaylist($id)) ;
						// var_dump($getPlaylist);
						// var_dump($getPlaylist) ;
	      		?>

	      		<?php for($i=0;$i<sizeof($getPlaylist);$i++){ ?>
	      		<option value="<?php echo $getPlaylist[$i]->playlist_id  ?>"    ><?php echo $getPlaylist[$i]->playlist_name; ?></option>
	      		<?php } ?>



	      	</select><br>
	      	<a href="https://jukebox5d.com/app/index.php/EditProfile"><button class="btn btn-danger" style="float: left;" id="savePlaylist2"> Don't have Library? Click here</button></a>
	      	<button class="btn btn-success" id="savePlaylist" style="float: right;">Save</button>
	      	<div style="clear: both;"></div>
	      	</center>
	      </div>
	    </div>

	  </div>
	</div>

<!-- MODAL END -->
