<?php if(isset($flag) && $flag) { // ini buat template yg lama ?>
		
<?php } else { ?>
<body>
<!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top" style="z-index:2001">
      <div class="container">
        <div class="navbar-header">
        	
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">			
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="<?php echo $this->config->item("logo") ?>" width="110px"/></a>
          <span class="pull-right" style="font-size:16px;color:#fff;padding-top:17px;padding-right:10px"><marquee scrollamount="3"><?php echo ucfirst($this->session->userdata("user_location")); ?></marquee></span>
        </div>
        <div id="navbar" class="navbar-collapse collapse">          
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo site_url(); ?>/Home/index"><?php echo $this->config->item("mp") ?> <i class="fa fa-music pull-right"></i></a></li>
            <li><a href="<?php echo site_url(); ?>/Home/weeklytrends"><?php echo $this->config->item("wt") ?> <i class="fa fa-list-ol pull-right"></i></a></li>
            <li><a href="<?php echo site_url(); ?>/Home/recentsong"><?php echo $this->config->item("rs") ?> <i class="fa fa-history pull-right"></i></a></li>
			<li><a href="<?php echo site_url(); ?>/Home/chatlounge"><?php echo $this->config->item("cl") ?> <i class="fa fa-comments-o pull-right"></i></a></li>
			<li><a href="<?php echo site_url(); ?>/Home/mostrequest"><?php echo $this->config->item("mr") ?> <i class="fa fa-users pull-right"></i></a></li>
			<!--<li><a href="#"><?php echo $this->config->item("ht") ?> <i class="fa fa-info-circle pull-right"></i></a></li>
			<li><a href="#"><?php echo $this->config->item("pp") ?> <i class="fa fa-black-tie pull-right"></i></a></li>-->
			<li role="separator" class="divider"></li>
			<!--<li><a href="#">Limadigit <i class="fa fa-map-marker pull-right"></i></a></li>-->
			<li><a href="<?php echo site_url(); ?>/Home/editprofile"><?php echo $this->config->item("edit_profile") ?> <i class="fa fa-user pull-right"></i></a></li>
			<li><a href="<?php echo site_url() ?>/login/logout"><?php echo $this->config->item("sign_out") ?> <i class="fa fa-sign-out pull-right"></i></a></li>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>		
<?php
	}
?>