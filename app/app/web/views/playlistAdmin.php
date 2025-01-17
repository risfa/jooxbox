<script src="<?php echo $this->config->item("socketjs") ?>" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/lib/js/typeahead.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/js/player.api.js"></script>

<script type="text/javascript">


		window.onerror = function(message, file, lineNumber) {

		  //return true;

		}

		var parameter = 0;

		var socket = io.connect('<?php echo $this->config->item("port_server_asli") ?>',{reconnection: true,});

		var username = '<?php echo $username; ?>';

		var userid = '<?php echo $id; ?>';

		var twitterImage = '<?php echo $image; ?>';

		var status = '<?php echo $status; ?>';

		var varLoc = '<?php echo $loc_id; ?>';

		var str, mostPlayed, recent, midHeight, mostRequest;

		var totalCountCreated = [];

		var lastInsert;

		var chat;
		
		var counterAds = 0;
		var timerCounterAds;
		var newSoundUrl,newSoundId,newTrackId,refreshInterval;
		var done = false;
		var globalResult;

		var delay = (function(){

									var timer = 0;

										return function(callback, ms){

											clearTimeout (timer);

											timer = setTimeout(callback, ms);

										};

								})();

		

		/*

		|--------------------------------------------------------------------------

		| Socket

		|--------------------------------------------------------------------------

		*/
		
		socket.on("nowPlaying",function(data) {
			// console.log(data);
				// console.log("stop");
				// clearInterval(timerCounterAds);
				clearInterval(refreshInterval);
				$("#frame").html('<iframe id="soundcloud_widget" width="100%" height="450" frameborder="no" style="float:left;display:none"></iframe><div id="player" style="display:none;"></div><label style="display:none;line-height:115px" id="waitForUser"></label>');
				globalResult = [];
				var result = JSON.parse(data);
				globalResult = result;
				// console.log(result);
				if(result[0] != null) {
					if(result[0]["twitter_image"] == "") {
						var image = "<?php echo $this->config->item("user_default"); ?>";
					} else {
						var image = "<?php echo base_url(); ?>assets/"+result[0]["twitter_image"];
					}
					$("#imageFirst").attr("src",image);
					$("#spanFirst").html(result[0]["title"]);
					$("#waitForUser").hide();
					newSoundUrl = result[0]['link'];
					newSoundId = result[0]['playlist_id'];
					newTrackId = result[0]['track_id'];
					var dislike = result[0]["dislike"];
					var like = result[0]["like"];
					var splitDislike = 0;
					var splitLike = 0;
					if(dislike !== null) {
						splitDislike = dislike.split("#");
						splitDislike.clean("");
						splitDislike = splitDislike.length;
					}
					// if(like !== null) {
						// splitLike = like.split("#");
						// splitLike.clean("");
						// splitLike = splitLike.length;
						// skip += splitLike
					// }
					
					// console.log(skip);
					if(splitDislike > 2) {
						updateSong(newSoundId);
					} else {
						if(result[0]['link'].match(/soundcloud/)) { //souncloud player
							// console.log('soundcloud');
							$("#player").hide();
							$("#soundcloud_widget").show();
							// var widget = SC.Widget(document.getElementById('soundcloud_widget'));
							$("#soundcloud_widget").attr("src","<?php echo $this->config->item("soundcloud_url") ?>"+newSoundUrl+"&show_user=false&show_artwork=false&liking=false&sharing=false&auto_play=true");
							delay(function(){
								// log = function (message) {
							 //          console.log(message)

							 //        };
								var widget = SC.Widget(document.getElementById('soundcloud_widget'));	
												 
    											// widget.bind(SC.Widget.Events.READY, log.bind(null, 'Ready!'));
    											// widget.bind(SC.Widget.Events.PLAY, log.bind(null, 'Playing!'));	


								if(result[0]["user_id"] != 0) {
									console.log("sc timer on");
									// $('.playButton').click(function(){
									// 			console.log('berhasil autoplay di soundcloud');
									// 		});
									// $(document).ready(function(){
									// 		delay(function(){
									

									// 				console.log('delay');
									// 		},15000);
									// })
									// timerCounterAds = setInterval(increment,1000);
								} else {
									console.log("sc timer clear (ads)");
									// counterAds = 0;
									// clearInterval(timerCounterAds);
								}
								widget.bind(SC.Widget.Events.FINISH, function() {
									$.ajax({
										url: "<?php echo site_url(); ?>/song/updateCounter?user_id="+result[0]["user_id"]+"&track_id="+result[0]["track_id"]+"&link="+result[0]["link"]+"&genre="+result[0]['genre']+"&title="+encodeURIComponent(result[0]["title"])+"&location="+varLoc+"&created="+result[0]["createby"],
										success: function(resp) {
											console.log('next song');
											
											socket.emit("jukeboxLocation", varLoc);
											updateSong(newSoundId);
											// console.log('disini');
										}
									});
									// delay(function(){	
										// getNewSong();
									// },500);
									// widget.load(newSoundUrl, {
										// auto_play: true,
										// show_artwork: false
									// });
									// widget.play();
								});
							},500);
						} else { //youtube player
							// console.log('youtube');
							$("#player").show();
							$("#soundcloud_widget").hide();
							var tag = document.createElement('script');
							
							tag.src = "<?php echo $this->config->item("youtube_url") ?>";
							var firstScriptTag = document.getElementsByTagName('script')[0];
							firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
							var player;
							done = false;
							doYT();
								refreshInterval = setInterval(function(){
									// socket.emit("getNowPlaying",{username: username, loc: varLoc});
									socket.emit('chat message', 'test');
									socket.emit("jukeboxLocation", varLoc);
									
								},3000)

							if(result[0]["user_id"] != 0) {
								// console.log("yt timer on");
								// timerCounterAds = setInterval(increment,1000);
							} else {
								// console.log("yt timer clear (ads)");
								// counterAds = 0;
								// clearInterval(timerCounterAds);
							}
						}
						$("#table").html(html);
					}
				} else {
					// console.log("stop2");
					// clearInterval(timerCounterAds);
					$("#imageFirst").attr("src","<?php echo $this->config->item("user_default"); ?>");
					$("#spanFirst").html("");
					$("#waitForUser").show();
					$("#soundcloud_widget").hide();
					$("#waitForUser").html("<?php echo $this->config->item("waiting_playlist_admin"); ?>");
					var html = "<tr><td colspan='3'><center><?php echo $this->config->item("empty_playlist_admin"); ?></center></td></tr>";
					$("#table").html(html);
					refreshInterval = setInterval(function(){
						socket.emit("getNowPlaying",{username: username, loc: varLoc});

						socket.emit("jukeboxLocation", varLoc);
						socket.emit('chat message', 'test');
						// socket.emit("getPlaylistAdmin",{loc: varLoc});
						// socket.emit("jukeboxLocation", varLoc);
						// socket.emit("getChatFileWeb",{username: username, loc: varLoc});

					},3000)
				}
			});

			socket.on('testing',function(data){
				console.log(data);
		});

			socket.on('nowPlaying2',function(data){
				console.log(data);

		});

		socket.on("playlist",function(data) {
			// console.log(data);
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

							skip += like;

						}

						if(y["dislike"] !== null) {

							var splitDislike = y["dislike"].split("#");

							splitDislike.clean("");

							dislike = splitDislike.length;

						}

						

						var from = "soundcloud";

						if(y["link"].match(/youtube/)) from = "youtube";

						

						var source = '<td class="buttonLayerTd" style=";border-right:1px solid #d2d2d2"><i class="fa fa-soundcloud" style="color:#ff7700"></i></td>';

						if(y["link"].match(/youtube/)) source = '<td class="buttonLayerTd" style=";border-right:1px solid #d2d2d2"><i class="fa fa-youtube-play" style="color:#DC143C;"></i></td>';

						

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

																	'<td class="buttonLayerTd" style="border-right:1px solid #d2d2d2"><i class="fa fa-share-alt  button-share-row" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->config->item("share_tooltip"); ?>" caption='+y["caption"]+' link="'+y["link"]+'"></i></td>'

																	+source+

																	'<td class="buttonLayerTd" id="dislike-'+y["playlist_id"]+'"  style=";border-right:1px solid #d2d2d2"><i class="fa fa-fast-forward button-skip-row" data-toggle="tooltip" data-placement="bottom" title="'+skip+'<?php echo $this->config->item("skip_tooltip"); ?>" onclick=\'likedislike('+y["playlist_id"]+','+userid+',"dislike",'+dislike+',"'+y["track_id"]+'","'+y["title"]+'","'+y["genre"]+'","'+twitterImage+'","'+from+'")\'></i> '+strdislike+'</td>'+

																	'<td class="buttonLayerTd" id="like-'+y["playlist_id"]+'" ><i class="fa fa-heart button-love-row" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->config->item("love_tooltip") ?>"  onclick=\'likedislike('+y["playlist_id"]+','+userid+',"like",'+like+',"'+y["track_id"]+'","'+y["title"]+'","'+y["genre"]+'","'+twitterImage+'","'+from+'")\'></i> '+strlike+'</td>'+

																'</tr>'+

															'</table>'+

														'</td>';

													

							if(y["like"] !== null || y["dislike"] !== null) {

								if(splitLike.indexOf(userid) != -1 || splitDislike.indexOf(userid) != -1) {

									//disabled button love sama skip

									button = '<td>'+

															'<table width="100%">'+

																'<tr>'+

																	'<td class="buttonLayerTd" style=";border-right:1px solid #d2d2d2"><i class="fa fa-share-alt button-share-row" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->config->item("share_tooltip"); ?>" caption='+y["caption"]+' link="'+y["link"]+'"></i></td>'

																	+source+

																	'<td class="buttonLayerTd" id="dislike-'+y["playlist_id"]+'" title="'+skip+'<?php echo $this->config->item("skip_tooltip"); ?>" style=";border-right:1px solid #d2d2d2"><i class="fa fa-fast-forward" data-toggle="tooltip" data-placement="bottom" title="'+skip+'<?php echo $this->config->item("skip_tooltip"); ?>" style="color:#00aeff"></i> '+strdislike+'</td>'+

																	'<td class="buttonLayerTd" id="like-'+y["playlist_id"]+'"><i class="fa fa-heart" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->config->item("love_tooltip") ?>" style="color:#dc143c"></i> '+strlike+'</td>'+

																'</tr>'+

															'</table>'+

														'</td>';

								}

							}
							
							dynamicTitle = y["title"];
							
							scrlsts();
							
							html += '<tr class="flagPlaylistId">'+

												'<td>'+

													'<table class="table-playlist">'+

														'<tr>'+

															'<td class="image-view-user" style="width:20%">'+

																'<a style="cursor:pointer;" onClick="'+"detailUser('"+y['user_id']+"','"+rank+"','"+medallink+"')"+'"><img src="'+image+'" width="100%" onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" class="img-circle '+rank+'"/></a>'+

															'</td>'+

															'<td class="view-user-detail" style="padding-right:0px">'+

																'<table class="table-playlist-detail">'+

																	'<tr>'+

																		'<td style="vertical-align:bottom"><b class="username-user" style="font-size:12px">'+y["createby"]+medal+'</b></td>';

														html += '<td align="right" style="vertical-align:middle;font-size:18px;padding:5px" rowspan="2"><i id="next" class="fa fa-times" style="cursor:pointer"></i></td>';

												html += '</tr>'+

																	'<tr>'+

																		'<td class="song-desc" style="font-size:12px;vertical-align:top">';

																			if(y["title"].length > 57) {

																				html += "<marquee width='92%'>"+y["title"]+"</marquee>"

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

															'<td class="listImage" style="width:20%">'+

																'<a style="cursor:pointer;" onClick="'+"detailUser('"+y['user_id']+"','"+rank+"','"+medallink+"')"+'"><img src="'+image+'" width="100%" onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" class="img-circle '+rank+'"/></a>'+

															'</td>'+

															'<td class="view-user-detail" style="padding-right:10px">'+

																'<table class="table-playlist-detail">'+

																	'<tr>'+

																		'<td style="vertical-align:bottom"><b class="username-user">'+y["createby"]+medal+'</b></td>';

														html += '<td rowspan="2" style="vertical-align:middle" align="right"> <i onclick="deleteMySong(\''+y["playlist_id"]+'\')" class="fa fa-times button-delete-row"></i></td>';

												html += '</tr>'+

																	'<tr>'+

																		'<td class="song-desc" style="font-size:12px;vertical-align:top">';

																			if(y["title"].length > 57) {

																				html += "<marquee width='92%'>"+y["title"]+"</marquee>"

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

					// console.log(html);

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
					
					$("#next").on("click",function() {
						updateSong(newSoundId);
					})

				} else {

					lastInsert = "";

					html = "<tr style='height:120px;'><td align='center'><?php echo $this->config->item("empty_playlist") ?></td></tr>";

					// html = "";

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

		
		function doYT() {
				window.player = new YT.Player('player', {
					height: '450',
					width: '100%',
					videoId: newTrackId,
					// playerVars: {
				 //        // autoplay: 1, // start automatically
				 //        controls: 1, // don't show the controls (we can't click them anyways)
				 //        modestbranding: 1, // show smaller logo
				 //        // loop: 1, // loop when complete
				 //        // playlist: newTrackId // required for looping, matches the video ID
				 //    },
					events: {
						'onReady': onPlayerReady,
						'onStateChange': onPlayerStateChange,
						'onError': onError
					}
				});
			}
			
			window.YT && doYT() || function(){
				var a=document.createElement("script");
				a.setAttribute("type","text/javascript");
				a.setAttribute("src","<?php echo $this->config->item("youtube_player_url"); ?>");
				a.onload=doYT;
				a.onreadystatechange=function(){
					if (this.readyState=="complete"||this.readyState=="loaded") doYT()
				};
				(document.getElementsByTagName("head")[0]||document.documentElement).appendChild(a)
			}();
			
			function onError(event) {
				stopVideo();
			}
			
			function onPlayerReady(event) {
        event.target.playVideo();
        // event.target.mute();
				// $(".ytp-button ytp-button-fullscreen-enter").trigger("click");
      }
			
      function onPlayerStateChange(event) {
				// console.log(event);
				if(event.data == 0) {
					$.ajax({
						url: "<?php echo site_url(); ?>/song/updateCounter?user_id="+globalResult[0]["user_id"]+"&track_id="+globalResult[0]["track_id"]+"&link="+globalResult[0]["link"]+"&genre="+globalResult[0]['genre']+"&title="+encodeURIComponent(globalResult[0]["title"])+"&location="+varLoc+"&created="+globalResult[0]["createby"],
						success: function(resp) {
							socket.emit("jukeboxLocation", varLoc);
							updateSong(newSoundId);
						}
					});
					// stopVideo();
				}
				// var duration = player.getDuration()*1000;
				// console.log(duration);
        if (event.data == YT.PlayerState.PLAYING && !done) {
          // setTimeout(stopVideo, 600000);
          done = true;
        }
      }
			
      function stopVideo() {
				updateSong(newSoundId);
      }
			
			function updateSong(id){
				// console.log("updatesong");
				// clearInterval(timerCounterAds);
				socket.emit("updateSong",{id: id, loc: varLoc});
				socket.emit("jukeboxLocation", varLoc);
			}
			
			Array.prototype.clean = function(deleteValue) {
				for (var i = 0; i < this.length; i++) {
					if (this[i] == deleteValue) {         
						this.splice(i, 1);
						i--;
					}
				}
				return this;
			};
			
			socket.on("getDislike",function(data) {
				var skip = 2;
				var result = JSON.parse(data);
				var dislike = result[0].dislike;
				var like = result[0].like;
				
				if(like !== null) {
					var split = like.split("#");
					split.clean("");
					like = split.length;
					skip += like;
				}
				
				if(dislike !== null) {
					var split = dislike.split("#");
					split.clean("");
					if(split.length > skip && newSoundId == result[0].playlist_id) {
						updateSong(newSoundId);
					}
				}
			});
			
			socket.on("connect",function() {
				socket.emit("adduser",{username: username +"(admin)", loc: varLoc, userid: varLoc});
				socket.emit("getNowPlaying",{username: username, loc: varLoc});
			});
			
			socket.on("disconnect",function() {
				socket.emit("leaveuser",{username: username, loc: varLoc});
			});
		
		function scrlsts() {
			// dynamicTitle = dynamicTitle.substring(1, dynamicTitle.length) + dynamicTitle.substring(0, 1);
			document.title = "\u25B6 " + dynamicTitle;
			// setTimeout("scrlsts()", 500);
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
		
		socket.on("mostRequest",function(data) {

			var result = JSON.parse(data);

			var html = "";

			var i = 1;

			mostRequest = new Array();

			if(result[0] != null) {

				$.each(result,function(x,y) {

					var image = "<?php echo $this->config->item("user_default"); ?>";

					if(isValidURL(y["twitter_image"])!=true){

						image='<?php echo base_url(); ?>assets/'+y["twitter_image"];;

					}

					if(i <= 3) {

						mostRequest[i] = y["username"];

					}

					if(i <= 5) {

						html += "<tr class='song-content'>";

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

						// console.log(image);

						html += "<td align='center'><img src='"+image+"' class='img-circle' width='20px'/></td>";

						html += "<td>"+i+".</td>";						

						html += "<td>"+y["username"]+"</td>";

						html += "<td align='center'><span class='badge' style='font-size:9px'>"+y["counter"]+"</span></td>";

						html += "</tr>";

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

		});

		

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
			
			$.each(result, function(x,y) {
				if(y != "flagFirstTime") {
				var date = new Date(y.created);

				var dd = date.getDate();

				var mm = date.getMonth()+1; //January is 0!

				var yyyy = date.getFullYear();

				var hours = date.getHours();

				var minutes = date.getMinutes();

				

				chat += '<div class="chat-row">';
				chat += '<div class="row" style="margin-left:0px;margin-right:0px">';
					if(isValidURL(y.images)!=true){

						y.images='<?php echo base_url(); ?>assets/'+y.images;

					}
					
					var chatUser = base64.decode(y.chat);
					
					var splitReply = chatUser.split("•♪•");
					
					if(splitReply.length > 2) {
						var addReply = "addReply('"+y.username+"','"+splitReply[2]+"')";
						if(y.username == username) {
							chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user" style="padding:2px 2px 2px 10px"><label class="direct-chat-text2" style="float:right" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b> <small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small><br/><div class="col-xs-12 box-reply2"><b class="title">'+splitReply[0]+'</b><br/><label class="chatText">'+window.emojiPicker.unicodeToImage(splitReply[1])+'</label></div>'+window.emojiPicker.unicodeToImage(splitReply[2])+'</label></div>';
							chat += '<div class="col-xs-1 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
						} else {
							chat += '<div class="col-xs-1 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
							chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user"><label class="direct-chat-text" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b><br/><div class="col-xs-12 box-reply2"><b class="title">'+splitReply[0]+'</b><br/><label class="chatText">'+window.emojiPicker.unicodeToImage(splitReply[1])+'</label></div>'+window.emojiPicker.unicodeToImage(splitReply[2])+'</label><br/><small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small></div>';
						}
					} else {
						var addReply = "addReply('"+y.username+"','"+chatUser+"')";
						if(y.username == username) {
							chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user" style="padding:2px 2px 2px 10px"><label class="direct-chat-text2" style="float:right" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b> <small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small><br/>'+window.emojiPicker.unicodeToImage(chatUser)+'</label><br/></div>';
							chat += '<div class="col-xs-1 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
						} else {
							chat += '<div class="col-xs-1 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
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

		

		Array.prototype.clean = function(deleteValue) {

			for (var i = 0; i < this.length; i++) {

				if (this[i] == deleteValue) {         

					this.splice(i, 1);

					i--;

				}

			}

			return this;

		};

		

		function deleteMySong(playlist_id) {

			if(confirm("Delete Your Song?")) {

				socket.emit("deleteMySong",{playlist_id: playlist_id, loc: varLoc});

			}

		}

		

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

					if(y.username != username) {

						// audio.play();

						Notification.requestPermission(function(permission){

							var notification = new Notification(y.username,{body: base64.decode(y.chat).replace(/<(?:.|\n)*?>/gm, ':emoticon:').replace(/&nbsp;/gi,' '),icon: y.images});

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

					var minutes = date.getMinutes();

					chat += '<div class="chat-row">';
					chat += '<div class="row" style="margin-left:0px;margin-right:0px">';

					var chatUser = base64.decode(y.chat);
					
					var splitReply = chatUser.split("•♪•");
					
					if(isValidURL(y.images)!=true){

						y.images='<?php echo base_url(); ?>assets/'+y.images;

					}
					
					if(splitReply.length > 2) {
						var addReply = "addReply('"+y.username+"','"+splitReply[2]+"')";
						if(y.username == username) {
							chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user" style="padding:2px 2px 2px 10px"><label class="direct-chat-text2" style="float:right" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b> <small class="chat-time" style="float:right">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small><br/><div class="col-xs-12 box-reply2"><b class="title">'+splitReply[0]+'</b><br/><label class="chatText">'+window.emojiPicker.unicodeToImage(splitReply[1])+'</label></div>'+window.emojiPicker.unicodeToImage(splitReply[2])+'</label></div>';
							chat += '<div class="col-xs-1 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
						} else {
							chat += '<div class="col-xs-1 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
							chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user"><label class="direct-chat-text" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b><br/><div class="col-xs-12 box-reply2"><b class="title">'+splitReply[0]+'</b><br/><label class="chatText">'+window.emojiPicker.unicodeToImage(splitReply[1])+'</label></div>'+window.emojiPicker.unicodeToImage(splitReply[2])+'</label><br/><small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small></div>';
						}
					} else {
						var addReply = "addReply('"+y.username+"','"+chatUser+"')";
						if(y.username == username) {
							chat += '<div onclick="'+addReply+'" class="col-xs-10 chat-user" style="padding:2px 2px 2px 10px"><label class="direct-chat-text2" style="float:right" data-toggle="tooltip" data-placement="top" title="Click for reply this message"><b class="title">'+y.username+'</b> <small class="chat-time">'+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small><br/>'+window.emojiPicker.unicodeToImage(chatUser)+'</label><br/></div>';
							chat += '<div class="col-xs-1 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
						} else {
							chat += '<div class="col-xs-1 img-user"><img onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="'+y.images+'" class="img-circle" width="100%"></div>';
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





		function getMostPlayed() {

			if(mostPlayed != "" && typeof(mostPlayed) != "undefined") {

				$("#table-tap").html("");

				$("#table-tap").append(mostPlayed);

			}

		}



		function getRecent() {

			if(recent != "" && typeof(recent) != "undefined") {

				$("#table-tap").html("");

				$("#table-tap").append(recent);

			}

		}

		

		function getLyrics(){

			$('#songLyrics').fadeIn();

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
				
				if(titleReply != "" && bodyReply != "") var str = titleReply + "•♪•" + bodyReply + "•♪•" + $("#post").html();

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



		function searchDisplay()

		{

			$('#search-icon').hide();

			$('#search-input').show();

			$("#inputsong").focus();

		}

		

		function unsearchDisplay()

		{

			$('#search-icon').show();

			$('#search-input').hide();

			$("#livesearch").html("");

		}



		function insert5Love(username,id,from,title,genre,img,link) {

			var data = {};

			data.username = username;

			data.userid = userid;

			data.id = id;

			data.from = from;

			data.title = title;

			data.genre = genre;

			data.loc = varLoc;

			data.img = encodeURIComponent(img);

			data.flag = 1;

			data.cap = "";
			
			data.link = link;

			socket.emit("insertSong",data);

			jukeboxLoc(varLoc);

			jukeboxRecent(username);

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



		function insertDB(id,from,title,genre,img,link,flag) {

			// kalo flag 0 dari recent song, kalo 1 dari mostplayed atau livesearch
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

						html: '<img width="70px" src="<?php echo $this->config->item("captions"); ?>"/><h2><?php echo $this->config->item("caption_title"); ?></h2><p class="lead emoji-picker-container"><input onkeyup="checkLength(this)" id="input-field-caption" type="email" class="form-control" placeholder="ex: This song reminds me of my ex :(" data-emojiable="true"></p><br/><p style="color:#888"><?php echo $this->config->item("empty_caption"); ?></p><label id="errCaption" style="color:red;display:none;"><?php echo $this->config->item("max_caption_text"); ?></label>',

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

							jukeboxLoc(varLoc);

							jukeboxRecent(username);

						}

					});

				}

			});
		}



		function likedislike(playlist_id,userid,option,total,track_id,title,genre,twitterImage,from,link) {

			socket.emit("likedislike",{playlist_id: playlist_id, userid: userid, option: option, loc: varLoc});

			if(option == "like" && total == 4) {

				// console.log(total);

				insert5Love(username,track_id,from,title,genre,twitterImage,link);

			}

			$('#like-'+playlist_id).prop('disabled','true');

			$('#dislike-'+playlist_id).prop('disabled','true');

		}



		function jukeboxRecent(username) {

			socket.emit("getRecentSong",{username: username, loc: varLoc});

		}



		function jukeboxLoc(loc) {

			socket.emit("jukeboxLocation", loc);

		}

		

		socket.on("whosLogin",function(data) {
			
			var result = JSON.parse(data);

			var html = "";

			var nomor = 1;
			
			for(var i=result.length-1;i>=0;i--) {
				
				var split = result[i].split('<?php echo $this->config->item("delimiter") ?>');
				
				var rank = "";

				var medallink = "";

				// if(mostRequest.indexOf(split[0]) == 1) {

					// medallink = "<?php echo $this->config->item("medal_gold"); ?>";

					// rank = "firstRank";

				// } else if(mostRequest.indexOf(split[0]) == 2) {

					// medallink = "<?php echo $this->config->item("medal_silver"); ?>";

					// rank = "secondRank";

				// } else if(mostRequest.indexOf(split[0]) == 3) {

					// medallink = "<?php echo $this->config->item("medal_bronze"); ?>";

					// rank = "thirdRank";

				// }else{

					// medallink = ""

					// rank = "";

				// }
				
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

		

		

		socket.on("connect",function() {

			socket.emit("adduser",{username: username, loc: varLoc, userid: userid})

			if(status == "admin") {

				socket.emit("getChatFileWeb",{username: username, loc: varLoc});

				socket.emit("getPlaylistAdmin",{loc: varLoc});

			} else if(status == "user") {

				socket.emit("getChatFileWeb",{username: username, loc: varLoc});

			}

		});

		

		function searchMusic() {

			$("a#search-icon").hover(function(){

				searchDisplay();

			})

		}

		function detailUser(id,rank,medal){

			$.ajax({

					url: '<?php echo site_url(); ?>/User/Profile?id='+id,

					success: function(resp){

						console.log(resp);

						var json=JSON.parse(resp);

						$('#userDetail-image').attr('src','<?php echo base_url(); ?>assets/'+json.data['twitter_image']);

						$('#userDetail-image').attr('class',rank);

						$('#userDetail-username').html(json.data['username']+"<img src='"+medal+"' class='img-circle' width='15px' style='margin-left:3px;'/>");

						$('#userDetail-music-genre').html(json.data['music_genre']);

						$('#userDetail-drink').html(json.data['drink']);

						$('#userDetail-food').html(json.data['food']);

						$('#userDetail-bio').html(json.data['bio']);

						$('#userDetail-hangout-place').html(json.data['hangout_place']);

						$('#detailUserModal').modal('show');

					}

			});

		}

		function changeDate(id) {

			var fromModal = $("#fromModal"+id).val();

			var toModal = $("#toModal"+id).val();

			console.log(fromModal);

			$.ajax({

				url: "<?php echo site_url(); ?>/ManagePlaylist/changeDate?id="+id+"&from="+encodeURIComponent(fromModal)+"&to="+encodeURIComponent(toModal),

				success: function(resp) {

					if(resp == 1) {

						$("#addsongadmin".id).modal("hide");

						$("div.modal-backdrop").remove();

						socket.emit("getPlaylistAdmin",{loc: varLoc});

					} else if(resp == 2 || resp == 0){

						alert("Error while update date")

					}

				}

			})

		}

			socket.on("managePlaylist",function(data) {
				console.log(data);

				$("#myPlaylist").html("<tr><th style='text-align:center'>No.</th><th>Name</th><th style='text-align:center'>From</th><th style='text-align:center'>To</th><th></th></tr>");

				var result = JSON.parse(data);

				if(result[0] != null) {

					var counter = 1;

					var html = "";

					var html2 = "";

					$.each(result,function(x,y) {

						var from = new Date(y["from_date"]);

						var dd = from.getDate();

						var mm = from.getMonth()+1; //January is 0!

						var yyyy = from.getFullYear();

						var fromDate = dd+" - "+mm+" - "+yyyy;

						var fromDate2 = mm+"/"+dd+"/"+yyyy;

						var to = new Date(y["to_date"]);

						var dd = to.getDate();

						var mm = to.getMonth()+1; //January is 0!

						var yyyy = to.getFullYear();

						var toDate = dd+" - "+mm+" - "+yyyy;

						var toDate2 = mm+"/"+dd+"/"+yyyy;

						var deletePlaylist = "deletePlaylist('"+y["playlist_daily_id"]+"')";

						html += '<tr>'+

											'<td style="text-align:center">'+counter+'</td>'+

											'<td>'+y["playlist_name"]+'</td>'+

											'<td>'+fromDate+'</td>'+

											'<td>'+toDate+'</td>'+

											'<td align="center">'+

												'<button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#addsongadmin'+y["playlist_daily_id"]+'"><i class="fa fa-pencil-square-o"></i> <?php echo $this->config->item("edit"); ?></button>'+

												' <button type="button" class="btn btn-xs btn-danger" onclick='+deletePlaylist+'><i class="fa fa-times"></i> <?php echo $this->config->item("remove"); ?></button>'+

											'</td>'+

										'</tr>';

						counter++;

						html2 += '<div class="modal fade" id="addsongadmin'+y["playlist_daily_id"]+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'+

												'<div class="modal-dialog" role="document">'+

													'<div class="modal-content">'+

														'<div class="modal-header" style="background-color:#00aeff;color:white">'+

															'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+

															'<h4 class="modal-title" id="myModalLabel" style="font-weight:700"><i class="fa fa-music"></i> '+y["playlist_name"]+'</h4>'+

														'</div>'+

														'<div class="modal-body">'+

															'<form class="form-inline" style="font-size:12px">'+

																'<div class="form-group">'+

																	'<label>From &nbsp;</label>'+

																	'<input onclick="getFromDate(\''+y["playlist_daily_id"]+'\')" id="fromModal'+y["playlist_daily_id"]+'" type="text" class="form-control" value="'+fromDate2+'" placeholder="Date">&nbsp;'+

																'</div>'+

																'<div class="form-group">'+

																	'<label>&nbsp; To &nbsp;</label>'+

																	'<input onclick="getToDate(\''+y["playlist_daily_id"]+'\')" id="toModal'+y["playlist_daily_id"]+'" type="text" class="form-control" value="'+toDate2+'" placeholder="Date">&nbsp;'+

																'</div>'+

																'&nbsp;<button type="button" class="btn btn-warning" onclick="changeDate(\''+y["playlist_daily_id"]+'\')">Change Date</button>'+

															'</form>'+

															'<hr>'+

															'<div class="input-group custom-search-form">'+

																'<input id="searchadmin'+y["playlist_daily_id"]+'" onkeyup="showResultAdmin(this.value,\''+y["playlist_name"]+'\',\''+y["playlist_daily_id"]+'\')" type="text" class="form-control" placeholder="Search here...">'+

																'<span class="input-group-btn">'+

																'<button class="btn btn-default" type="button">'+

																'<span class="glyphicon glyphicon-search"></span>'+

																'</button>'+

																'</span>'+

															'</div>'+

															'<div id="livesearchadmin'+y["playlist_daily_id"]+'" style="display: inline-block;position: absolute;z-index: 100;background:white;width: 95%;font-size:12px;max-height:450px;overflow-y:auto;box-shadow:0px 0px 10px #888"></div>'+

															'<table width="100%" class="table table-striped" style="font-size:12px;margin-top:15px" id="tableSong'+y["playlist_daily_id"]+'"></table>'+

														'</div>'+

													'</div>'+

												'</div>'+

											'</div>';

						socket.emit("getSongPlaylistDaily",{id: y["playlist_daily_id"], loc: varLoc});

					});

				} else {

					html = "<tr><td colspan='5' align='center' style='color:red;display:none'><?php echo $this->config->item("new_playlist"); ?></td></tr>";

				}

				$("#myPlaylist").append(html);

				$("#modalSong").html(html2);

			});

			

		function showResultAdmin(str,playlist_name,playlist_daily_id) {
			
			$("#livesearchadmin"+playlist_daily_id).html("");

			if(str == "") {

				$("#livesearchadmin"+playlist_daily_id).html("");

			} else if (str.length==0) {

				$("#livesearchadmin"+playlist_daily_id).html("");

				document.getElementById("livesearchadmin"+playlist_daily_id).style.border="0px";

				return;

			} else if (str.length > 3) {

				var html = "";

				delay(function(){				

					$.ajax({

						url: '<?php echo site_url(); ?>/LiveSearch/SearchAll?q='+str,

						success: function(resp){

							$("#livesearchadmin"+playlist_daily_id).html("");

							var result = JSON.parse(resp);

							$.each(result.data,function(x,y){

								var from = y.from;

								var title = y.title;

								var genre = y.genre;

								var onclick = 'insertDBAdmin(this.id,"'+from+'","'+title+'","'+genre+'","'+varLoc+'","'+playlist_name+'","'+playlist_daily_id+'","'+y.link+'")';

								if(y.from == 'soundcloud') {

									var css = 'btn-warning';

								} else {

									var css = 'btn-danger';

								}

								html += "<div class='box col-xs-12' id='"+y.track_id+"' style='border:1px solid #e5e5e5;padding:10px 8px 8px 8px;cursor:pointer' onclick='return "+onclick+"'><div class='col-xs-11' style='display:table-cell;vertical-align:middle'>"+title+"</div><div class='col-xs-1' style='text-align:center'><button class='overlay btn "+css+" btn-xs' style='border-radius:50%;display:table-cell;vertical-align:middle'><i class='fa fa-plus fa-1x'></i></button></div></div>";

							})

							$("#livesearchadmin"+playlist_daily_id).append(html);

						}

					});

				},500);

			}

		}

		function getFromDate(id) {

				$("#fromModal"+id).datepicker({

					defaultDate: $("#fromModal"+id).val(),

					changeMonth: true,

					numberOfMonths: 1,

					onClose: function( selectedDate ) {

						$( "#toModal" ).datepicker( "option", "minDate", selectedDate );

					}

				});

			}

			

		function getToDate(id) {

				$("#toModal"+id).datepicker({

					defaultDate: $("#toModal"+id).val(),

					changeMonth: true,

					numberOfMonths: 1,

					onClose: function( selectedDate ) {

						$( "#fromModal" ).datepicker( "option", "maxDate", selectedDate );

					}

				});

			}

			

		socket.on("songDaily",function(data) {

				var result = JSON.parse(data);

				var html = "";

				var counter = 1;

				var id = 0;

				$.each(result,function(x,y) {

					html += '<tr>'+

										'<td>'+counter+'</td>'+

										'<td>'+y["title"]+'</td>'+

										'<td>'+

											'<button type="button" class="btn btn-danger" onclick="deleteListPlaylist(\''+y["id_list_playlist_daily"]+'\',\''+y["playlist_daily_id"]+'\')"><i class="fa fa-minus"></i></button>'+

										'</td>'+

									'</tr>';

					counter++;

					id = y["playlist_daily_id"];

				});

				$("#tableSong"+id).html(html);

			});

		function deleteListPlaylist(id,playlist_daily_id) {

			var con = confirm("<?php echo $this->config->item("delete_song_admin"); ?>");

			if(con) {				

				$.ajax({

					url: "<?php echo site_url(); ?>/ManagePlaylist/deleteSongPlaylist?id="+id,

					success: function(resp) {

						if(resp == 0) {

							console.log("param ga lengkap");

						} else if(resp == 2) {

							console.log("gagal delete");

						} else if(resp == 1) {

							$("#searchadmin"+playlist_daily_id).html("");

							$("#livesearchadmin"+playlist_daily_id).html("");

							socket.emit("getSongPlaylistDaily",{id: playlist_daily_id, loc: varLoc});

							/*socket.emit("getSongPlaylistDaily",{id: playlist_daily_id, loc: loc});*/

						}

					}

				});

			} else {

				return false;

			}

		}

		

		function deletePlaylist(id) {

			var con = confirm("<?php echo $this->config->item("delete_playlist_admin"); ?>");

			if(con) {				

				$.ajax({

					url: "<?php echo site_url(); ?>/ManagePlaylist/delete?id="+id,

					success: function(resp) {

						if(resp == 0) {

							console.log("param ga lengkap");

						} else if(resp == 2) {

							console.log("gagal delete");

						} else if(resp == 1) {

							socket.emit("getPlaylistAdmin",{loc: varLoc});

						}

					}

				});

			} else {

				return false;

			}

		}

		

		function deleteSong(id) {

			var con = confirm("<?php echo $this->config->item("delete_song_admin"); ?>");

			if(con) {				

				$.ajax({

					url: "../api/deleteSong.php?id="+id,

					success: function(resp) {

						if(resp == 0) {

							console.log("param ga lengkap");

						} else if(resp == 2) {

							console.log("gagal delete");

						} else if(resp == 1) {

							socket.emit("getPlaylistAdmin",{loc: varLoc});

						}

					}

				});

			} else {

				return false;

			}

		}

		

		function insertDBAdmin(id,from,title,genre,loc,playlist_name,playlist_daily_id,link) {

			if (confirm('<?php echo $this->config->item("add_song_playlist_admin"); ?>')) {

				$.ajax({

					url: '<?php echo site_url(); ?>/ManagePlaylist/insertSong?id='+id+"&from="+from+"&title="+title+"&genre="+genre+"&loc="+loc+"&playlist_name="+playlist_name+"&playlist_daily_id="+playlist_daily_id+"&link="+link,

					success: function(resp){

						$("#livesearchadmin"+playlist_daily_id).html("");

						$("#searchadmin"+playlist_daily_id).val("");

						socket.emit("getSongPlaylistDaily",{id: playlist_daily_id, loc: loc});

					}

				})

			}else{

				return false;

			}

		}

		

		function validatePlaylist() {

			var playlist_name = $("#playlist_name").val();

			var from = $("#from").val();

			var to = $("#to").val();

			if(playlist_name == "") {

				console.log("playlist_name = kosong")//error

			} else if(from == "") {

				console.log("from = kosong")//error

			} else if(to == "") {

				console.log("to = kosong")//error

			} else {

				$.ajax({

					url: "<?php echo site_url(); ?>/ManagePlaylist/insert?playlist_name="+encodeURIComponent(playlist_name.replace(/'/g, "\\'"))+"&from="+encodeURIComponent(from)+"&to="+encodeURIComponent(to),

					success: function(resp) {

						if(resp == 0) {

							console.log("param ga lengkap");

						} else if(resp == 2) {

							console.log("gagal insert");

						} else if(resp == 1) {

							$("#playlist_name").val("");

							$("#from").val("");

							$("#to").val("");

							socket.emit("getPlaylistAdmin",{loc: varLoc});

							$("#addplaylistadmin").modal("hide");

						}

					}

				});

			}

		}

		

		function datePick() {

			$( "#from" ).datepicker({

				defaultDate: "",

				changeMonth: true,

				numberOfMonths: 1,

				onClose: function( selectedDate ) {

					$( "#to" ).datepicker( "option", "minDate", selectedDate );

				}

			});

			$( "#to" ).datepicker({

				defaultDate: "",

				changeMonth: true,

				numberOfMonths: 1,

				onClose: function( selectedDate ) {

					$( "#from" ).datepicker( "option", "maxDate", selectedDate );

				}

			});

		}

		

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
			
			$("#howto").click(function(){

				$('#myModal').modal('show');

			});
			
			
			
			 window.emojiPicker = new EmojiPicker({

		        emojiable_selector: '[data-emojiable=true]',

		        assetsPath: '<?php echo $this->config->item("emoji_path"); ?>',

		        popupButtonClasses: 'fa fa-smile-o'

		      });
		      window.emojiPicker.discover();
		      chat();
			  
			$("#inputsong").donetyping(function() {
				
				showResult(this.value);

			});

				$("#btnEmot").click(function() {

					$('[data-toggle=popover]').popover("toggle");

				})

				$('[data-toggle=popover]').popover({

						content: $('#myPopoverContent').html(),

						html: true

				})

				if(status == "admin") {

					$("#divPlaylist").css({"max-height":"455px"});

					datePick();

				}

				$("#inputsong").css({/*"text-indent":"-5000px",*/"display":"inline-block"});

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

		      window.emojiPicker = new EmojiPicker({

		        emojiable_selector: '[data-emojiable=true]',

		        assetsPath: '<?php echo $this->config->item("emoji_path"); ?>',

		        popupButtonClasses: 'fa fa-smile-o'

		      });

		    

		      window.emojiPicker.discover();

			setTimeout(function() {

				getMostPlayed();

			},1000);

			$('#post').keydown(function (event) {

				var keypressed = event.keyCode || event.which;

				if (keypressed == 13) {

					$("#buttonclick").trigger("click");

				}

			});

			

			jukeboxLoc(varLoc);

			jukeboxRecent(username);

			searchMusic();

			

			

		});

		function isValidURL(url){

		    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;



		    if(RegExp.test(url)){

		        return true;

		    }else{

		        return false;

		    }

		} 
		
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

											if(x != "err") {

												var from = y['from'];

												var title = y['title'];

												var genre = y['genre'];

												var onclick = 'insertDB("'+y["track_id"]+'","'+from+'","'+title+'","'+genre+'","'+twitterImage+'","'+y["link"]+'",1)';

												if(y['from'] == 'soundcloud') {

													var css = 'btn-info';

													var sourceLink = "<a href='"+y["permalink_url"]+"' target='blank'><i class='fa fa-soundcloud button-source-soundcloud-row' style='color:#ff3a00;font-size:16px'></i></a>"

												} else {

													var css = 'btn-info';

													var sourceLink = "<a href='https://www.youtube.com/watch?v="+y["track_id"]+"' target='blank'><i class='fa fa-youtube-play button-source-youtube-row' style='color:#bb0000;font-size:18px'></i></a>"

												}

												html += "<div class='box col-xs-12' style='border:1px solid #e5e5e5;padding:10px 8px 8px 8px;cursor:pointer'><div class='col-xs-1'><label align='right'>"+sourceLink+"</label></div><div class='col-xs-11' style='padding:0px' onclick='return "+onclick+"'><div class='col-xs-11 font-song-light' style='display:table-cell;vertical-align:middle;'>"+title+" </div><div class='col-xs-1' style='text-align:center'><button class='overlay btn "+css+" btn-xs' style='padding-left:7px;border-radius:50%;display:table-cell;vertical-align:middle'><i class='fa fa-play fa-1x'></i></button></div></div></div>";

											}

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
	</script>
<script src="<?php echo $this->config->item("socketjs") ?>" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/js/scroll.js"></script>
	
	<style>		
		
		.now-playing-desc
		{
			background-color:#404040;			
			padding:10px;
			color:#fff;
			vertical-align:middle;
			font-size:12px;
		}
		
		.no-padding{
			padding:0px;
		}
	</style>
	
</head>



<body style="padding-bottom:100px">

	

	<input type="hidden" id="username" value="<?php echo $this->session->userdata('user_username'); ?>"/>

    <!-- Fixed navbar -->

    <nav class="navbar navbar-default navbar-fixed-top">

      <div class="container">

        <div class="navbar-header">

          <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo $this->config->item("logoAdmin"); ?>" width="300px"/></a>

        </div>

        <div id="navbar">

          

          <ul class="nav navbar-nav navbar-right">            

            <li>

				<div id="search-gate">

					<input type="text" id="inputsong" class="search-box flagFocus" placeholder="Search song...">

					<label id="label-music" for="inputsong"><i class="fa fa-music search-icon"></i></label>

					<div id="livesearch" style="margin-left:14px;;position: absolute;z-index: 100;background:white;width: 93%;font-size:12px;max-height:462px;overflow-y:auto;box-shadow:0px 3px 8px #888">

				</div>

			</li>

			<li class="dropdown">

				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

					<img id="myImage" onError="this.onerror=null;this.src=\'<?php echo $this->config->item("user_default"); ?>\';" src="<?= (!filter_var($image, FILTER_VALIDATE_URL) === false)? $image : base_url().'assets/'.$image ?>" width="26px" class="img-circle"/> <span class="caret"></span>

				</a>

				<ul class="dropdown-menu">

                  <li><a href="<?php echo site_url(); ?>/EditProfile"><i class="fa fa-user"></i> <?php echo $this->config->item("edit_profile"); ?></a></li>                 

                  <li role="separator" class="divider"></li>                              

                  <li><a href="<?php echo site_url(); ?>/Login/logout"><i class="fa fa-sign-out"></i> <?php echo $this->config->item("sign_out"); ?></a></li>

                </ul>

			</li>

          </ul>

        </div><!--/.nav-collapse -->

      </div>

    </nav>



    <div class="container" height="100%">
		
		<div class="col-xs-12 no-padding">
			<div class="col-xs-8 no-padding" style="border-right:1px solid #2b2b2b">
			
				<div class="col-xs-12 header-menu-jukebox">
					<i class="fa fa-play"></i> Now Playing
				</div>

				
				<div class="col-xs-12 header-content-jukebox" style="padding:0px;z-index:100;border-bottom:none;overflow-y:auto">	
					<div id="frame" align="center" style="background-color:#000;color:#fff;padding:0px"></div>
				</div>
				
				<div class="col-xs-12 header-menu-jukebox">
					<i class="fa fa-cogs"></i> <?php echo $this->config->item("manage_playlist"); ?>
				</div>

			
				<div class="col-xs-12 header-content-jukebox" style="padding:0px;z-index:101;border-bottom:none;font-size:12px;border-top:none;">
					
					<button type="button" class="btn btn-info btn-block" style="border-radius:0px" data-toggle="modal" data-target="#addplaylistadmin"><i class="fa fa-plus"></i> <?php echo $this->config->item("add_playlist"); ?></button>
					<table width="100%" class="table table-striped" id="myPlaylist">

						<tr>
							<th style="text-align:center">No.</th>
							<th>Name</th>
							<th style="text-align:center">From</th>
							<th style="text-align:center">To</th>
							<th></th>
						</tr>

					</table>

					

				</div>
				
				<div class="col-xs-12 header-menu-jukebox" style="z-index:14">
					<i class="fa fa-comments-o"></i> <?php echo $this->config->item("cl") ?>
				</div>

				

				<div class="col-xs-12 header-content-jukebox" style="padding:0px;top:-1px;border-top:none;border-left:none;z-index:13;">											
					
					<div id="box-chat" style="max-height:230px;overflow-y:auto;min-height:287px;padding-top:15px"></div>
					
					<div class="col-xs-12">
						
						<br>
						
						<div id="replyChat" style="display:none;">
							<div class="col-xs-12 box-reply">
								<b id="titleReply" class="title"></b> <span class="pull-right"><i onclick="closeReply()" class="fa fa-times close-reply" aria-hidden="true"></i></span><br/>
								<label id="bodyReply" class="chatText"></label>
							</div>
						</div>
						
						<div class="input-group">
							<div class="lead emoji-picker-container">
								<input type="text" id="inputpost" class="form-control" placeholder="Chat here..." data-emojiable="true" data-emoji-input="unicode">	
							</div>
							
							<span class="input-group-btn">
								<button class="btn btn-info"  id="buttonclick" onclick="post()" type="button"><i class="fa fa-comments-o"></i></button>
							</span>

						</div><!-- /input-group -->

						<br>

					</div>

				</div>
				
			</div>
			
			<div class="col-md-4 no-padding">
				<div class="col-xs-12 header-menu-jukebox">
					<i class="fa fa-music"></i> <?php echo $this->config->item("community_playlist"); ?>
				</div>
				
				<div id="divPlaylist" class="col-xs-12 header-content-jukebox" style="padding:0px;z-index:100;border-bottom:none;overflow-y:auto">
					<table id="music-playlist" height="100%" width="100%" class="table table-hover playlist"></table>
				</div>
				
				<a href="#" onclick="mostplayed()">

					<div id="mostplayed" class="col-xs-6 header-menu-jukebox active-box border-none-right" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->config->item("weekly_chart_tooltip"); ?>">
						<span style="cursor:pointer;"><i class="fa fa-list-ol"></i> <?php echo $this->config->item("wt") ?></span>
					</div>

				</a>

				<a href="#" onclick="suggestion()">

					<div id="suggestion" class="col-xs-6 header-menu-jukebox border-none-right" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->config->item("recent_song"); ?>">
						<span style="cursor:pointer;"><i class="fa fa-history"></i> <?php echo $this->config->item("rs") ?></span>
					</div>

				</a>

				

				<div class="col-xs-12 header-content-jukebox" style="padding:0px;z-index:0;border-top:none;border-right:none">
						<table id="table-tap" class="table table-striped" style="margin-bottom:0px;border-top:none;"></table>
				</div>							

				

				<div class="col-xs-12 header-menu-jukebox"  style="border-left:none;border-right:none;border-bottom:1px solid #2b2b2b">
					<i class="fa fa-users"></i> <?php echo $this->config->item("ou") ?>
				</div>				

				

				<div class="col-xs-12 header-content-jukebox" style="padding:0px;border-top:none;border-left:none;max-height:167px;overflow-y:auto;">
					<table id="whosLogin" class="table table-striped table-hover" style="margin-bottom:0px;border-top:none;"></table>
				</div>

				<div class="col-xs-12 header-content-jukebox" style="padding:0px;z-index:0;border-top:none;border-right:none">
				</div>								
				

				<div class="col-xs-12 header-menu-jukebox" style="z-index:14;top:-2px;border-left:none;border-right:none">
					<i class="fa fa-users"></i> <?php echo $this->config->item("mr"); ?>
				</div>

				
				<div class="col-xs-12 header-content-jukebox" style="padding:0px;top:-3px;z-index:0;border-top:none;border-left:none">
					<table id="table-most-request" class="table table-striped" style="margin-bottom:0px;border-top:none;"></table>												
				</div>
			</div>
			
		</div>
		
		
		
			

			

			<div class="modal fade" id="addplaylistadmin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

				<div class="modal-dialog  modal-sm" role="document">

					<div class="modal-content">

						<div class="modal-header" style="background-color:#00aeff;color:white">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel" style="font-weight:700"><i class="fa fa-info-plus"></i> <?php echo $this->config->item("add_playlist"); ?></h4>
						</div>

						<div class="modal-body">

							<form>
								<div class="form-group">
									<label for="playlist_name"><?php echo $this->config->item("playlist_name") ?></label>
									<input id="playlist_name" type="text" class="form-control" placeholder="Playlist Name">
								</div>

								<div class="form-group">
									<label for="from"><?php echo $this->config->item("from_date"); ?></label>
									<input id="from" type="text" class="form-control" placeholder="yyyy-mm-dd">
								</div>

								<div class="form-group">
									<label for="to"><?php echo $this->config->item("to_date"); ?></label>
									<input id="to" type="text" class="form-control" placeholder="yyyy-mm-dd">
								</div>

								<button type="button" class="btn btn-default" onclick="validatePlaylist()"><?php echo $this->config->item("submit"); ?></button>

							</form>

						</div>				

					</div>

				</div>

			</div>

			

			<div id="modalSong"></div>

						
			
		
		
	</div>

	<!--/.fluid-container-->

