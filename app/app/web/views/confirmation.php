<style>
	/*.alert-message
	{
			margin: 20px 0;
			padding: 20px;
			border-left: 3px solid #eee;
	}
	.alert-message h4
	{
			margin-top: 0;
			margin-bottom: 5px;
	}
	.alert-message p:last-child
	{
			margin-bottom: 0;
	}
	.alert-message code
	{
			background-color: #fff;
			border-radius: 3px;
	}
	.alert-message-success
	{
			background-color: #F4FDF0;
			border-color: #3C763D;
	}
	.alert-message-success h4
	{
			color: #3C763D;
	}
	.alert-message-danger
	{
			background-color: #fdf7f7;
			border-color: #d9534f;
	}
	.alert-message-danger h4
	{
			color: #d9534f;
	}
	.alert-message-warning
	{
			background-color: #fcf8f2;
			border-color: #f0ad4e;
	}
	.alert-message-warning h4
	{
			color: #f0ad4e;
	}
	.alert-message-info
	{
			background-color: #f4f8fa;
			border-color: #5bc0de;
	}
	.alert-message-info h4
	{
			color: #5bc0de;
	}
	.alert-message-default
	{
			background-color: #EEE;
			border-color: #B4B4B4;
	}
	.alert-message-default h4
	{
			color: #000;
	}
	.alert-message-notice
	{
			background-color: #FCFCDD;
			border-color: #BDBD89;
	}
	.alert-message-notice h4
	{
			color: #444;
	}*/
	
	.videoWrapper {
		position: relative;
		padding-bottom: 56.25%; /* 16:9 */
		padding-top: 25px;
		height: 0;
	}
	.videoWrapper iframe {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
	}
	
	.navbar-default
	{
		background: #00aeff;
		color: #fff;
	}

</style>


<body>
	<div class="container">
<br/>

	
	<!-- Main component for a primary marketing message or call to action -->
	<div class="col-xs-12">
	<div class="jumbotron" style="padding:20px">
	
		<h2>Selamat!</h2>
		<p>
			
			
			Anda kini menjadi bagian dari komunitas musik Jukebox-5D!
			Tonton video tutorial di bawah ini untuk mengetahui informasi lebih lanjut mengenai cara penggunaan Jukebox-5D.
			Jika Anda memiliki pertanyaan, saran, atau keluhan, hubungi kami di explore@limadigit.com 
		
			<div class="videoWrapper">
				<!-- Copy & Pasted from YouTube -->
				<iframe width="100%" src="<?php echo $this->config->item("video_tutorial") ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<br/>
						
			
		</p>
		<a class="btn btn-lg btn-info" href="http://5dapps.com/music/" role="button">Go to login now &raquo;</a>
	</div>
	</div>
	

</div> <!-- /container -->
