<?php
	if(!isset($_COOKIE['cmsadmin_jukebox_username']) && !isset($_COOKIE['cmsadmin_jukebox_access'])) {
		header("location:index.php");
	}
?>
<title>Jukebox 5D Admin Panel</title>
<link rel="icon" href="https://jukebox5d.com/app/assets/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="assets/css/jquery-ui.css">
<link rel="stylesheet" href="assets/css/jquery.dataTables.min.css">
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
<style>
	body { font-size: 62.5%; }
	label, input { display:block; }
	input.text { margin-bottom:12px; width:95%; padding: .4em; }
	fieldset { padding:0; border:0; margin-top:25px; }
	h1 { font-size: 1.2em; margin: .6em 0; }
	div#users-contain { width: 350px; margin: 20px 0; }
	div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
	div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
	.ui-dialog .ui-state-error { padding: .3em; }
	.validateTips { border: 1px solid transparent; padding: 0.3em; }
</style>
<script type="text/javascript">
	var delay = (function(){
		var timer = 0;
		return function(callback, ms){
			clearTimeout (timer);
			timer = setTimeout(callback, ms);
		};
	})();

	$(function() {
		$( "#datepicker" ).datepicker();
		getAllAdmin();
		var location_now = "";
    var dialog, form,
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      name = $( "#name" ),
      location = $( "#location" ),
      password = $( "#password" ),
      allFields = $( [] ).add( name ).add( location ).add( password ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
          min + " and " + max + "." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name, "username", 3, 16 );
      valid = valid && checkLength( location, "location", 3, 80 );
      valid = valid && checkLength( password, "password", 5, 16 );
 
      valid = valid && checkRegexp( name, /^[a-zA-Z]+$/i, "Username may consist of a-z and must begin with a letter." );
      valid = valid && checkRegexp( location, /^[a-zA-Z]+$/i, "Location may consist of a-z and must begin with a letter." );
      valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
 
      if ( valid ) {
				addAdmin(name.val(),location.val(),password.val());
        // dialog.dialog( "close" );
      }
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
      modal: true,
      buttons: {
        "Create an account": addUser,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
    $( "#create-user" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });
		
		$( "#logout" ).button().on( "click", function() {
      window.location.href = "logout.php";
    });
		
		// function addAdmin(name,loc,pass) {
			// $.ajax({
				// url: "addAdmin.php?name="+encodeURIComponent(name)+"&loc="+encodeURIComponent(loc)+"&pass="+encodeURIComponent(pass),
				// success: function(resp){
					// var result = JSON.parse(resp);
					// var html = "<table border='1'><tr><th>Username</th><th>Location</th></tr>";
					// $.each(result, function(x,y) {
						// html += "<tr><td>"+y['username']+"</td><td>"+y['location']+"</td></tr>";
					// });
					// html += "</table>";
					// $("#tableAdmin").html(html);
					// dialog.dialog("close");
				// }
			// });
		// }
		
		function getAllAdmin(){
			$('#tableAdmin').DataTable( {
        "ajax": 'api/getAllAdmin.php',
				"columnDefs": [
					{"className": "dt-center", "targets": "_all"}
				],
				"columns": [
					{"data" : "last_login"},
					{"data" : "location"},
					{"data" : "email"},
					{"data" : "address"},
					{"data" : "type"},
				],
				"sorting": [[0, "desc"]]
			});
		}
  });

	// function show_playlist(loc) {
		// $.ajax({
			// url: "get_playlist.php?loc="+encodeURIComponent(loc),
			// success: function(resp) {
				// $("#boxplaylist").show();
				// $("#playlist").show();
				// $("#searchDiv").show();
				// $("#loc").show();
				// $("#loc").html("<h2>"+loc+"</h2>")
				// $("#playlist").html("<table id='tablePlaylist' border='1'></table>")
				// var result = JSON.parse(resp);
				// if(result['count'] != 0) {
					// var html = "<table border='1'><tr><th>Title</th><th>From</th><th>Date</th><th>Action</th></tr>"
					// $.each(result,function(x,y){
						// if(x != "count") {
							// var songDelete = 'deleteSong('+y['playlist_daily_id']+',"'+loc+'")';
							// html += "<tr><td>"+y['title']+"</td><td>"+y['from']+"</td><td>"+y['date']+"</td><td><button onclick='"+songDelete+"'>Delete</button></td></tr>"
						// }
					// });
					// html += "</table>";
					// $("#tablePlaylist").html(html);
				// } else {
					// $("#tablePlaylist").html("<tr><th>Action</th></tr><tr><td>"+result[0]['err']+"</td></tr>")
				// }
			// }
		// })
	// }
	
	// function deleteSong(id,loc) {
		// $.ajax({
			// url: "delete_song.php?id="+id,
			// success: function(resp) {
				// alert(resp);
				// show_playlist(loc);
			// }
		// });
	// }
	
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
					url: 'livesearchadmin.php?q='+str,
					success: function(resp){
						$("#livesearch").html("");
						var result = JSON.parse(resp);
						$.each(result,function(x,y){
							var from = y['from'];
							var title = y['title'];
							var genre = y['genre'];
							var location_from_h2 = $("div#loc h2").html();
							var onclick = 'insertDB(this.id,"'+from+'","'+title+'","'+genre+'","'+location_from_h2+'")';
							if(y['from'] == 'soundcloud') {
								var css = 'background:yellow;';
							} else {
								var css = 'background:red;';
							}
							html += "<div class='box' style='border:1px solid #e5e5e5;padding:8px'>"+title+" &nbsp;&nbsp;<button class='overlay btn btn-xs' style="+css+" id='"+y['track_id']+"' onclick='return "+onclick+"'>Insert into playlist<i class='fa fa-music'></i></button></div>";
						})
						$("#livesearch").append(html);
					}
				});
			},500);
		}
	}
	
	// function insertDB(id,from,title,genre,loc) {
		// var date = $("#datepicker").val();
		// if(date == "") {
			// alert("Invalid Date");
		// } else {			
			// if (confirm('Are you sure you want to insert song?')) {
				// $.ajax({
					// url: 'insert_song_admin.php?id='+id+"&from="+from+"&title="+title+"&genre="+genre+"&loc="+loc+"&date="+encodeURIComponent(date),
					// success: function(resp){
						// alert(resp);
						// $("#livesearch").html("");
						// $("#search").val("");
						// show_playlist(loc);
					// }
				// })
			// }else{
				// return false;
			// }	
		// }
	// }
	
</script>
<div style="float:left;clear:both;margin-bottom:10px;">
	<!--<button id="create-user">Create new user</button>-->
	<button id="logout">Logout</button>
</div>

<!--<div id="dialog-form" title="Create new user">
  <p class="validateTips">All form fields are required.</p>
	<form>
		<fieldset>
			<label>Username : admin</label><br/>
			<label for="name">Name</label>
			<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="text ui-widget-content ui-corner-all">
			<label for="location">Location</label>
			<input type="text" name="location" id="location" class="text ui-widget-content ui-corner-all">
			<input type="button" tabindex="-1" style="position:absolute; top:-1000px">
		</fieldset>
		</form>
</div>-->

<table id="tableAdmin" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Last Login</th>
			<th>Location Name</th>
			<th>Email</th>
			<th>Address</th>
			<th>Type</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Last Login</th>
			<th>Location Name</th>
			<th>Email</th>
			<th>Address</th>
			<th>Type</th>
		</tr>
	</tfoot>
</table>