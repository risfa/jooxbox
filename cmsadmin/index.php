<title>Jukebox 5D Admin Panel</title>
<link rel="icon" href="https://jukebox5d.com/app/assets/images/favicon.ico" type="image/x-icon">
<script type="text/javascript" src="assets/js/jquery.min.js"></script>
<script type="text/javascript">
	$(window).ready(function(){
		$("#submit").click(function(){
			Login();
		});
		
		$('#password').bind("keypress",function(e){
			if(e.keyCode == 13){
				Login();
			}
		});					
	});
	
	function Login(){
		$.ajax({
			url : "api/login.php?username="+encodeURIComponent($('#username').val())+"&password="+encodeURIComponent($('#password').val()),
			error : function(){
				alert("Connection Error !");
			},
			success : function(data){
				if(data == "OK"){
					window.location = "home.php";
				}else{
					alert(data);
				}
			}
		});
	}
</script>
<form autocomplete="off">
	<div title="Username" data-rel="tooltip">
		<input autofocus class="input-large span10" name="username" id="username" type="text" />
	</div>
	<div title="Password" data-rel="tooltip">
		<input class="input-large span10" name="password" id="password" type="password" />
	</div>
	<button type="button" class="btn btn-primary" id="submit">Login</button>
</form>