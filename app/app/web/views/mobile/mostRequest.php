<?php if($isAndroid) { ?>
<div class="col-xs-12 alert appHeader fixed-header alert-dismissible" role="alert" style="margin-bottom:0px; border:none;border-radius:0px;">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<img src="<?php echo $this->config->item("logo_login_jukebox") ?>" width="25px"/><small> <?php echo $this->config->item("header_android_popup") ?></small> <a href="<?php echo $this->config->item("play_store_link") ?>" class="btn btn-xs btn-info pull-right">Get the App</a>
</div>
<?php } ?>
<div class="col-xs-12 header-menu-jukebox fixed-header">
	<i class="fa fa-users"></i> <?php echo $this->config->item("mr") ?>
</div>

<div class="col-xs-12 header-content-jukebox" style="padding:0px;top:15px;border-bottom:none">
	<table class="table table-striped" style="margin-bottom:65px;border-top:none;border-bottom:none" id="table-most-request">
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
	var chat;
	
	/*
	|--------------------------------------------------------------------------
	| Socket
	|--------------------------------------------------------------------------
	*/
	socket.on("connect",function() {
		socket.emit("adduser",{username: username, loc: varLoc, userid: userid});
	});
	
	socket.on("mostRequest",function(data) {
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
				html += "<tr class='song-content'>";
				if(i == 1){
					html += "<td class='icon-playlistMusic'><img src='<?php echo $this->config->item("medal_gold"); ?>' class='img-circle' width='20px'/></td>";
				}
				else if(i == 2)
				{
					html += "<td class='icon-playlistMusic'><img src='<?php echo $this->config->item("medal_silver"); ?>' class='img-circle' width='20px'/></td>";
				}
				else if(i == 3){
					html += "<td class='icon-playlistMusic'><img src='<?php echo $this->config->item("medal_bronze"); ?>' class='img-circle' width='20px'/></td>";
				}
				else{
					html += "<td class='icon-playlistMusic'></td>";
				}
				
				html += 
						"<td><span class='badge' style='font-size:9px'>"+y["counter"]+"</span></td>"+
						"<td class='song-content' style='padding:10px'>"+y["username"]+"</td>"+
						"<td class='icon-playlistMusic'><img src='"+image+"' class='img-circle' width='30px'/></td>"+
					"</tr>";
				i++;
			});
		} else {
			html = "<tr class='song-content'><td colspan='4' align='center' style='color:red;font-weight:bold;font-size:13px;'><?php echo $this->config->item("king_queen"); ?></td></tr>"
		}
		$("#table-most-request").html("");
		$("#table-most-request").html(html);
	})
	
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
	
	/*
	|--------------------------------------------------------------------------
	| Function with Socket
	|--------------------------------------------------------------------------
	*/
	
	$(document).ready(function(){
		socket.emit("jukeboxLocation", varLoc);
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
	
	function isValidURL(url) {
		var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
		if(RegExp.test(url)) {
			return true;
		} else {
			return false;
		}
	}
</script>