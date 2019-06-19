<body>
<div class="container">
    <div class="form-signin">
        <div class="col-lg-12 boxT">
            <center><img src="<?php echo $this->config->item("logo_login_jukebox"); ?>" width="100px" />
                <br/>
                <br/>
                <input type="hidden" id="lat" name="lat"/>
                <input type="hidden" id="long" name="long"/>
                <small style="font-family: 'Lato', sans-serif;font-size:10px;"><i><?php echo $this->config->item("subtitle") ?></i> </small></center>
            <br>
            <center><a target="_blank" href='<?php echo $this->config->item("play_store_link") ?>'><img alt='undefined' width="150px" src='<?php echo $this->config->item("google_play_logo"); ?>'/></a></center>
            <br>
            <center><label id="error" style="color:red;display:none;"></label></center>
            <div class="panel panel-default" id="boxLocation" style="display:none;">
                <div class="panel-heading"><i class="fa fa-unlock-alt"></i> <?php echo $this->config->item("choose_admin"); ?> <i class="fa fa-refresh pull-right" style="cursor:pointer" onclick="getLocationOnReady()"></i></div>
                <div class="panel-body" id="boxAllLocation" style="background-color:transparent;max-height:155px;overflow-y:auto">
                </div>

            </div>

            <div id="loading" style="text-align: center;">
                <img src="<?php echo $this->config->item("ajax_loader"); ?>"/>
            </div>

            <center id="cancelPlay" style="display:none;"><small><?php echo $this->config->item("cancel_play"); ?> <a href="<?php echo site_url(); ?>/login/logout"><?php echo $this->config->item("sign_out"); ?></a></small></center>
        </div>
    </div>
</div>
</body>
