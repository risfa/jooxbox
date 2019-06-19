<script src="<?php echo base_url(); ?>assets/lib/js/typeahead.min.js"></script>
<script src="<?php echo base_url(); ?>assets/lib/js/player.api.js"></script>
<script src="<?php echo $this->config->item("socketjs") ?>" type="text/javascript"></script>
		<script type="text/javascript">
			window.onerror = function(){
				// return true;
			}
			
			var counterAds = 0;
			var timerCounterAds;
			var delay = (function(){
				var timer = 0;
					return function(callback, ms){
						clearTimeout (timer);
						timer = setTimeout(callback, ms);
					};
			})();
			var varLoc = '<?php echo $id; ?>';
			// io.set('transports', ['websocket', 'polling']);
			var socket = io.connect('<?php echo $this->config->item("port_server") ?>');
			// var socket = io.connect('http://zuka.5dapps.com/', {transports: ['websocket']});

			var username = '<?php echo $username; ?>';
			var newSoundUrl,newSoundId,newTrackId,refreshInterval;
			var done = false;
			var globalResult;
			

					// setInterval(function() {


					// 		socket.emit("updateSong",{id: id, loc: varLoc});
					// }, 1000);


			socket.on("nowPlaying",function(data) {
				console.log(data);
				// console.log("stop");
				// clearInterval(timerCounterAds);
				clearInterval(refreshInterval);
				// $("#frame").html('<iframe id="soundcloud_widget" width="100%" height="120" frameborder="no" style="float:left;display:none"></iframe><div id="player" style="display:none;"></div><label style="display:none;" id="waitForUser"></label>');
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
					
					if(result.length > 1) {
						var source = "<?php echo $this->config->item("soundcloud"); ?>";
						if(result[1]["link"].match(/youtube/)) source = "<?php echo $this->config->item("youtube"); ?>";
						if(result[1]["twitter_image"] == "") {
							var image = "<?php echo $this->config->item("user_default"); ?>";
						} else {
							var image = "<?php echo base_url(); ?>assets/"+result[1]["twitter_image"];
						}
						var html = '<tr style="background-color:#f5f5f5;color:#888">'+														
												'<td style="vertical-align:middle;text-align:center;border-right:1px solid #888"><?php echo $this->config->item("next_song"); ?> <i class="fa fa-step-forward"></i></td>'+
												'<td style="vertical-align:middle;padding:10px;"><img class="img-circle" src="'+image+'" width="50px"/> '+result[1]["title"]+'</td>'+
												'<td style="vertical-align:middle"><img src="'+source+'" width="50px"/></td>'+
											'</tr>';
					} else {
						var html = '<tr style="background-color:#f5f5f5;color:#888">'+
												'<td style="vertical-align:middle;text-align:center;border-right:1px solid #888"><?php echo $this->config->item("next_song"); ?> <i class="fa fa-step-forward"></i></td>'+
												'<td colspan="2" style="vertical-align:middle;padding:10px;"><center><?php echo $this->config->item("empty_playlist_admin"); ?></center></td>'+														
											'</tr>';
					}
					// console.log(skip);
					if(splitDislike > 2) {
						updateSong(newSoundId);
					} else {
						if(result[0]['link'].match(/soundcloud/)) { //souncloud player
							// console.log('soundcloud');
							$("#player").hide();
							$("#soundcloud_widget").show();
							// var widget = SC.Widget(document.getElementById('soundcloud_widget'));
							$("#soundcloud_widget").attr("src","<?php echo $this->config->item("soundcloud_url") ?>"+newSoundUrl+"&show_artwork=false&liking=false&sharing=false&auto_play=true");
							
							delay(function(){
								var widget = SC.Widget(document.getElementById('soundcloud_widget'));
								if(result[0]["user_id"] != 0) {
									// console.log("sc timer on");
									// timerCounterAds = setInterval(increment,1000);
								} else {
									// console.log("sc timer clear (ads)");
									// counterAds = 0;
									// clearInterval(timerCounterAds);
								}
								widget.bind(SC.Widget.Events.FINISH, function() {
									$.ajax({
										url: "<?php echo site_url(); ?>/song/updateCounter?user_id="+result[0]["user_id"]+"&track_id="+result[0]["track_id"]+"&link="+result[0]["link"]+"&genre="+result[0]['genre']+"&title="+result[0]["title"]+"&location="+varLoc+"&created="+result[0]["createby"],
										success: function(resp) {
											socket.emit("jukeboxLocation", varLoc);
											updateSong(newSoundId);
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
					},3000)
				}
			})

			function showResult(str){
				$("#livesearch").html("");
				if(str == "") {
					$("#livesearch").html("");
				} else if (str.length==0) {
					$("#livesearch").html("");
					document.getElementById("livesearch").style.border="0px";
					return;
				} else if (str.length > 3) {
					var html = "";
					delay(function(){				
						$.ajax({
							url: '<?php echo site_url(); ?>/livesearch?q='+str,
							success: function(resp){
								$("#livesearch").html("");
								var result = JSON.parse(resp);
								$.each(result,function(x,y){
									var from = y['from'];
									var title = y['title'];
									var genre = y['genre'];
									var onclick = 'insertDB(this.id,"'+from+'","'+title+'","'+genre+'")';
									if(y['from'] == 'soundcloud') {
										var css = 'btn-warning';
									} else {
										var css = 'btn-danger';
									}
									html += "<div class='box col-xs-12' id='"+y['track_id']+"' style='border:1px solid #e5e5e5;padding:10px 8px 8px 8px;cursor:pointer' onclick='return "+onclick+"'><div class='col-xs-11' style='display:table-cell;vertical-align:middle'>"+title+"</div><div class='col-xs-1' style='text-align:center'><button class='overlay btn "+css+" btn-xs' style='padding-left:7px;border-radius:50%;display:table-cell;vertical-align:middle'><i class='fa fa-play fa-1x'></i></button></div></div>";
								})
								$("#livesearch").append(html);
							}
						});
					},500);
				}
			}
			
			function insertDB(id,from,title,genre) {
				if (confirm('Are you sure you want to insert song?')) {
					if($("#tags").val() != "" ){
						var tag = $("#tags").val();
					} else {
						var tag = "";
					}
					if(typeof(tag) == "undefined") tag = "";
					
					$.ajax({
						url: '<?php echo site_url(); ?>/Song/insert?id='+id+"&from="+from+"&title="+title+"&genre="+genre+"&tag="+encodeURIComponent(tag),
						success: function(resp){
							alert(resp);
							$("#livesearch").html("");
							$("#search").val("");
							$("#tags").val("");
						}
					})
				}else{
					return false;
				}	
			}
			
			function doYT() {
				window.player = new YT.Player('player', {
					height: '390',
					width: '640',
					videoId: newTrackId,
					// playerVars: {
			  //       // autoplay: 1, // start automatically
					// controls: 0, // don't show the controls (we can't click them anyways)
			  //       modestbranding: 1, // show smaller logo
			  //       loop: 1, // loop when complete
			  //       playlist: newTrackId // required for looping, matches the video ID
			  //   	},
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
      //   	player.mute();
    		// player.playVideo();
					// $(".ytp-button ytp-button-fullscreen-enter").trigger("click");
      }
			
      function onPlayerStateChange(event) {
				// console.log(event);
				if(event.data == 0) {
					$.ajax({
						url: "<?php echo site_url(); ?>/song/updateCounter?user_id="+globalResult[0]["user_id"]+"&track_id="+globalResult[0]["track_id"]+"&link="+globalResult[0]["link"]+"&genre="+globalResult[0]['genre']+"&title="+globalResult[0]["title"]+"&location="+varLoc+"&created="+globalResult[0]["createby"],
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
						$("#next").trigger("click");
					}
				}
			});

			socket.on("test2",function(data) {
				console.log(data);
			});
			
			


					socket.on("connect",function() {
						socket.emit("adduser",{username: username +"(admin)", loc: varLoc, userid: varLoc});
						socket.emit("getNowPlaying",{username: username, loc: varLoc});
						socket.emit('test',{username: username, loc: varLoc})

					});
			
			socket.on("disconnect",function() {
				socket.emit("leaveuser",{username: username, loc: varLoc});
			});
			
			$(document).ready(function() {
				$("#inputsong").css({"text-indent":"-5000px","display":"inline-block"});
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
				
				searchMusic();
				
				$("#next").on("click",function(){					
					updateSong(newSoundId);					
				});
			});
			
			
		//NEW FUNCTION
		
		function increment(id){
			// counterAds++;
			// console.log(counterAds);
			// if(varLoc == 116) {
				// if(counterAds == 1200) {
					// var data = {};
					// data.username = "sponsor";
					// data.userid = "0";
					// data.id = "290029416";
					// data.from = "soundcloud";
					// data.title = "Iklan Jukebox 5D";
					// data.genre = "";
					// data.loc = varLoc;
					// data.img = "images/jukebox-admin.png";
					// data.cap = "";
					// data.flag = 0;
					// data.link = "https://soundcloud.com/dickagtr/iklan-jukebox-5d";
					// socket.emit("insertSong",data);
					// counterAds = 0;
				// }
			// }
		}
		
		function searchDisplay()
		{
			$('#search-icon').hide();
			$('#search-input').show();
			$("#inputsong").focus();
		}
		
		function searchMusic() {
			$("a#search-icon").hover(function(){
				searchDisplay();
			})
		}

		function newPopup(url) {
			var left = (screen.width/2)-(800/2);
			var top = (screen.height/2)-(500/2);
			popupWindow = window.open(url,'popUpWindow','height=570,width=800,fullscreen=yes, top='+top+', left='+left+'')
			
		}
			
		</script>
		<style>
			div.box button.overlay
			{
				display:none;
			}

			div.box:hover button.overlay
			{
				display:block;   
			}
			
			.now-playing
			{
				background-color:#404040;
				border-top-left-radius:6px;
				padding:10px;
				text-align:center;
				font-size:20px;
				color:#fff;
				border-right:1px solid #fff;
				
			}
			
			.now-playing-desc
			{
				background-color:#404040;
				border-top-right-radius:6px;
				padding:10px;
				color:#fff;
				vertical-align:middle;
				font-size:12px;
			}
			
						
			
		</style>
	</head>
	<body style="padding-top:100px">
		
		<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <!-- The mobile navbar-toggle button can be safely removed since you do not need it in a non-responsive implementation -->
          <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo $this->config->item("logo") ?>" width="130px"/></a>

          <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo $this->config->item("logo") ?>" width="130px"/></a>
        </div>
        <!-- Note that the .navbar-collapse and .collapse classes have been removed from the #navbar -->
        <div id="navbar">
          <ul class="nav navbar-nav navbar-right">            
            <li></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					<img id="myImage" src="<?= (!filter_var($image, FILTER_VALIDATE_URL) === false)? $image : base_url().'assets/'.$image ?>" width="26px" class="img-circle"/> <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo site_url(); ?>/EditProfile"><i class="fa fa-user"></i> <?php echo $this->config->item("edit_profile") ?></a></li>                 
					<li><a href="#" onclick="newPopup('<?php echo site_url(); ?>/ManagePlaylist')"><i class="fa fa-cog"></i> <?php echo $this->config->item("manage_playlist"); ?></a></li>                 
					<li role="separator" class="divider"></li>
					<li><a href="<?php echo $user_logout; ?>"><i class="fa fa-sign-out"></i> <?php echo $this->config->item("sign_out") ?></a></li>
				</ul>
			</li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

      
		<div class="container">
				<br>
				<div class="col-xs-8 col-xs-offset-2">
					<div class="col-xs-3 now-playing">
						<?php echo $this->config->item("now_playing"); ?> <i class="fa fa-play"></i>
					</div>
					<div class="col-xs-9 now-playing-desc">
						<img id="imageFirst" class="img-circle" src="<?php echo $this->config->item("user_default"); ?>" width="28px"/>
						<span id="spanFirst"></span>
					</div>
				</div>
				<div class="col-xs-8 col-xs-offset-2" align="center">
					<div id="frame" class="panel-body" align="center"></div>
				</div>
				<br>
				<div class="col-xs-8 col-xs-offset-2">
					<button id="next" class="btn btn-lg btn-info btn-block" style="border-top-right-radius:0px;border-top-left-radius:0px"><?php echo $this->config->item("skip_text"); ?></button>
					<br>
				</div>
				<br>				
				<div class="col-xs-8 col-xs-offset-2">
					<table id="table" class="table"></table>
				</div>
    </div>