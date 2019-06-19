<script src="<?php echo $this->config->item("socketjs") ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).parent().siblings().removeClass('open');
            $(this).parent().toggleClass('open');
        });
    });
</script>
<?php $this->load->view("scriptJs"); ?>
  <body style="background-color:#fff;background-size:cover;margin-bottom:140px">
	<div class="scroll-top-wrapper ">
		<span class="scroll-top-inner">
			<i class="fa fa-2x fa-arrow-circle-up"></i>
		</span>
	</div>
	<input type="hidden" id="username" value="<?php echo $this->session->userdata('user_username'); ?>"/>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">        
          <a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo $this->config->item("logo"); ?>" width="130px"/></a>
        </div>        
        <div id="navbar">                    
          <ul class="nav navbar-nav navbar-right">            
            <li>							
							<div id="search-gate">
								<input type="text" id="inputsong" class="search-box flagFocus" placeholder="Cari Lagu disini...">
								<label id="label-music" for="inputsong"><i class="fa fa-music search-icon"></i></label>
								<div id="livesearch" style="margin-left:14px;position: absolute;z-index: 100;background:white;width: 93%;font-size:12px;max-height:462px;overflow-y:auto;box-shadow:0px 3px 8px #888">
							</div>
			</li>
			<li style="font-size:16px;padding-top:4px;font-family: 'Lato', sans-serif;text-transform: uppercase;"><a href="<?php echo site_url(); ?>/place"><i class="fa fa-map-marker"></i> <?php echo ucfirst($this->session->userdata("user_location")); ?></a></li>
              <li class="dropdown" style="padding-top:5px;font-size:16px;padding-top:4px;font-family: 'Lato', sans-serif;text-transform: uppercase;">              	
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    Playlist
                  </a>
                  <ul class="dropdown-menu" id="user-menu">
                  </ul>
              </li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
					<img id="myImage" src="<?= (!filter_var($image, FILTER_VALIDATE_URL) === false)? $image : base_url().'assets/'.$image ?>" onError="this.onerror=null;this.src='<?php echo $this->config->item("user_default") ?>';" width="26px" class="img-circle"/> <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
                  <li><a href="<?php echo site_url(); ?>/EditProfile"><i class="fa fa-user"></i> <?php echo $this->config->item("edit_profile") ?></a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="<?php echo $user_logout; ?>"><i class="fa fa-sign-out"></i> <?php echo $this->config->item("sign_out") ?></a></li>
                </ul>
			</li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container" height="100%">
		<div id="sidebarLeft" class="col-xs-3 sidebar-sidebar transparent-box">			
				<a href="#" onclick="mostplayed()">
					<div id="mostplayed" class="col-xs-6 header-menu-jukebox active-box border-none-right" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->config->item("weekly_chart_tooltip"); ?>">
						<span style="cursor:pointer;"><i class="fa fa-list-ol"></i> <?php echo $this->config->item("wt") ?></span>
					</div>
				</a>
				<a href="#" onclick="suggestion()">
					<div id="suggestion" class="col-xs-6 header-menu-jukebox" style="border-right:1px solid #2b2b2b" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->config->item("recent_song"); ?>">
						<span style="cursor:pointer;"><i class="fa fa-history"></i> <?php echo $this->config->item("rs") ?></span>
					</div>
				</a>
				<div class="col-xs-12 header-content-jukebox" style="padding:0px;z-index:0;border-top:none;border-right:none">
						<table id="table-tap" class="table table-striped" style="margin-bottom:0px;border-top:none;"></table>
				</div>
				<div class="col-xs-12 header-menu-jukebox"  style="border-left:none;border-right:none;">
					<i class="fa fa-users"></i> <?php echo $this->config->item("ou") ?>
				</div>				
				<div class="col-xs-12 header-content-jukebox" style="padding:0px;border-top:none;border-left:none;max-height:167px;overflow-y:auto;">
					<table id="whosLogin" class="table table-striped table-hover" style="margin-bottom:0px;border-top:none;"></table>
				</div>
				<div class="col-xs-12 header-content-jukebox" style="padding:0px;z-index:0;border-top:none;border-right:none">
				</div>
		</div>
		<div class="col-xs-6 center-bar">
			<div class="col-xs-12 header-menu-jukebox fixed-header">
				<i class="fa fa-music"></i> <?php echo $this->config->item("mp") ?>
			</div>
			<div id="music-playlist-content" class="col-xs-12 header-content-jukebox" style="padding:0px;top:51px;z-index:100;border-bottom:none;box-shadow:0px 0px 10px #CFCFCF;">										
					<table id="music-playlist" height="100%" width="100%" class="table table-hover table-bordered playlist"></table>
			</div>			
		</div>
		<div id="sidebarRight" class="col-xs-3 sidebar-chat">
			<div class="col-xs-12 header-menu-jukebox" style="border-left:1px solid #2b2b2b;z-index:14">
				<i class="fa fa-comments-o"></i> <?php echo $this->config->item("cl") ?>
			</div>
			<div class="col-xs-12 header-content-jukebox" style="padding:0px;top:-1px;border-top:none;border-left:none;z-index:13;">											
				<div id="box-chat" data-type="original-input" style="height:300px;overflow-y:auto;min-height:230px;padding-top:10px">								
				</div>
				<div class="col-xs-12">
					<div id="myPopoverContent" style="display:none;max-height:500px;overflow-y:auto"></div>
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
						<button class="btn btn-info" id="buttonclick" type="button" onclick="post()"><i class="fa fa-paper-plane"></i></button>
					  </span>
					</div>
					<br>
				</div>
			</div>
			<div class="col-xs-12 header-menu-jukebox" style="z-index:14;top:-2px;border-left:none;border-right:none">
				<label data-toggle="tooltip" data-placement="top" title="<?php echo $this->config->item("most_request_tooltip"); ?>"><i class="fa fa-bars"></i> <?php echo $this->config->item("mr") ?></label>
			</div>
			<div class="col-xs-12 header-content-jukebox" style="padding:0px;top:-3px;z-index:0;border-top:none;border-left:none">
					<table id="table-most-request" class="table table-striped" style="margin-bottom:0px;border-top:none;"></table>												
			</div>		
		</div>
	</div>
	<!--detail user-->
  <style type="text/css">
      .dropdown-submenu>.dropdown-menu {
          top: 0;
          right: 100%;
          margin-top: -6px;
          margin-left: -1px;
          -webkit-border-radius: 0 6px 6px 6px;
          -moz-border-radius: 0 6px 6px;
          border-radius: 0 6px 6px 6px;
      }

      .dropdown-submenu:hover>.dropdown-menu {
          display: block;
      }

      .dropdown-submenu>a:after {
          display: block;
          content: " ";
          float: right;
          width: 0;
          height: 0;
          border-color: transparent;
          border-style: solid;
          border-width: 5px 0 5px 5px;
          border-left-color: #ccc;
          margin-top: 5px;
          margin-right: -10px;
      }

      .dropdown-submenu:hover>a:after {
          border-left-color: #fff;
      }

      .dropdown-submenu.pull-left {
          float: none;
      }

      .dropdown-submenu.pull-left>.dropdown-menu {
          left: -100%;
          margin-left: 10px;
          -webkit-border-radius: 6px 0 6px 6px;
          -moz-border-radius: 6px 0 6px 6px;
          border-radius: 6px 0 6px 6px;
      }
  </style>