<?php if($isAndroid) { ?>
<div class="col-xs-12 alert appHeader fixed-header alert-dismissible" role="alert" style="margin-bottom:0px; border:none;border-radius:0px;">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<img src="<?php echo $this->config->item("logo_login_jukebox") ?>" width="25px"/><small> <?php echo $this->config->item("header_android_popup") ?></small> <a href="<?php echo $this->config->item("play_store_link") ?>" class="btn btn-xs btn-info pull-right">Get the App</a>
</div>
<?php } ?>
<div class="col-xs-12 header-menu-jukebox fixed-header">
	<i class="fa fa-comments-o"></i> <?php echo $this->config->item("cl") ?>
</div>

<div class="col-xs-12 header-content-jukebox" style="padding-top:15px;top:15px;border:none;">
	<center>
		<small style="color:#888">Download aplikasinya untuk fitur chat yang maksimal</small><br/>
		<a href="https://play.google.com/store/apps/details?id=com.limadigit.jukebox5dmusic"><img src="<?php echo base_url(); ?>assets/images/google-play.png" width="150px" style="margin-top:10px"/></a>
	</center>
	
	<!--<div id="loading" style="text-align: center;">
		<img src="<?php //echo $this->config->item("ajax_loader"); ?>"/>
	</div>
	
	<div id="box-chat" style="overflow-y:auto;margin-bottom:110px"></div>
	
	<div class="col-xs-12 bottom-chat" style="background-color:#fff;height:70px;">
		<br>
		<div class="input-group">
			<input id="post" type="text" class="form-control" placeholder="Chat here..." data-emoji-input="unicode">
			<span class="input-group-btn">
			<button id="buttonclick" onclick="post()" class="btn btn-info" type="button"><i class="fa fa-comments-o"></i></button>
			</span>
		</div>
		<br>
	</div>-->		
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
	var chat;
	
	/*
	|--------------------------------------------------------------------------
	| Socket
	|--------------------------------------------------------------------------
	*/
	socket.on("connect",function() {
		socket.emit("adduser",{username: username, loc: varLoc, userid: userid});
		socket.emit("getChatFileWeb",{username: username, loc: varLoc});
	});
	
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
	
	socket.on("getAllMessage", function(data) {
		$("#loading").hide();
		var result = JSON.parse(data);
		chat = "";
		$.each(result, function(x,y) {
			if(y != "flagFirstTime") {
				var date = new Date(y.created);
				var dd = date.getDate();
				var mm = date.getMonth()+1; //January is 0!
				var yyyy = date.getFullYear();
				var hours = (date.getHours()<10?'0':'') + date.getHours();
				var minutes = (date.getMinutes()<10?'0':'') + date.getMinutes();
				
				chat += '<div class="chat-row">';
				if(isValidURL(y.images)!=true){
					y.images='<?php echo base_url(); ?>assets/'+y.images;
				}
				chat += '<div class="col-xs-2 img-user"><img src="'+y.images+'" class="img-circle" width="100%"></div>';
				chat += '<div class="col-xs-10 chat-user"><span class="title">'+y.username+'</span><br><p>'+window.emojiPicker.unicodeToImage(base64.decode(y.chat))+'<br><small><i class="fa fa-clock-o"></i> '+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small></p></div>';
				chat += '</div>';
			}
		});
		$("div#box-chat").append(chat);
		$('html,body').animate({scrollTop: $('div#box-chat')[0].scrollHeight}, 2000);
	});
	
	socket.on('message2', function(data) {
		var result = JSON.parse(data);
		chat = "";
		var audio = new Audio("<?php echo $this->config->item("notif") ?>");
		$.each(result, function(x,y) {
			if( ('Notification' in window) ){
				if(y.username != username) {
					audio.play();
					Notification.requestPermission(function(permission){
						var notification = new Notification(y.username,{body: base64.decode(y.chat) ,icon: y.images});
						notification.onclick = function() { 
							window.focus(); this.cancel();
						};
						setTimeout(function(){
							notification.close(); //closes the notification
						},5000);
					});
				} 
			}
			
			var date = new Date(y.created);
			var dd = date.getDate();
			var mm = date.getMonth()+1; //January is 0!
			var yyyy = date.getFullYear();
			var hours = (date.getHours()<10?'0':'') + date.getHours();
			var minutes = (date.getMinutes()<10?'0':'') + date.getMinutes();
			if(isValidURL(y.images)!=true){
				y.images='<?php echo base_url(); ?>assets/'+y.images;
			}
			chat += '<div class="chat-row">';
			chat += '<div class="col-xs-2 img-user"><img src="'+y.images+'" class="img-circle" width="100%"></div>';
			chat += '<div class="col-xs-10 chat-user"><span class="title">'+y.username+'</span><br><p>'+window.emojiPicker.unicodeToImage(base64.decode(y.chat))+'<br><small><i class="fa fa-clock-o"></i> '+dd+'/'+mm+'/'+yyyy+' '+hours+':'+minutes+'</small></p></div>';
			chat += '</div>';
		});
		$("div#box-chat").append(chat);
		$('html,body').animate({scrollTop: $('div#box-chat')[0].scrollHeight}, 500);
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
	function post() {
		username = username;
		str = $("#post").val();
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
			today = yyyy+'/'+mm+'/'+dd+' '+hours+':'+minutes+':'+seconds;
			data.username = username;
			data.userid = userid;
			data.chat = base64.encode(str.replace(/'/g, "\\'"));
			data.image = twitterImage;
			data.time = today;
			data.loc = varLoc;
			socket.emit("message2",data);
			$("#inputpost").val("");
			$("#post").val("");
			$("#post").focus();
		}
	}
	
	/*
	|--------------------------------------------------------------------------
	| Function with Socket
	|--------------------------------------------------------------------------
	*/
	
	$(document).ready(function(){
		socket.emit("getRecentSong",{username: username, loc: varLoc});
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
	
	function isValidURL(url) {
		var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
		if(RegExp.test(url)) {
			return true;
		} else {
			return false;
		}
	}
</script>