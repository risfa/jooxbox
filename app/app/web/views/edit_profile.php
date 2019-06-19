<style>
	.btn span.glyphicon {    			
		opacity: 0;				
	}
	.btn.active span.glyphicon {				
		opacity: 1;				
	}
    #map {
        height: 300px;
    }
    .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 180px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }
    #target {
        width: 345px;
    }

    
</style>

</head>
  
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tagsinput.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/lib/js/jquery.form.min.js"></script>
  <script>
              <?php
              if($this->session->userdata('user_admin')){
              ?>
              function initAutocomplete() {
                  var map = new google.maps.Map(document.getElementById('map'), {
                      center: {lat: <?=$lat?>, lng: <?=$long?>},
                      zoom: 15,
                      // mapTypeId: 'roadmap'
                  });
                  // Create the search box and link it to the UI element.
                  var input = document.getElementById('pac-input');
                  var searchBox = new google.maps.places.SearchBox(input);
                  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                  var marker = new google.maps.Marker({
                      map: map,
                      draggable:true,
                  });
                  var pos = {
                      lat: <?=$lat?>,
                      lng: <?=$long?>
                  };
                  marker.setPosition(pos);
                  map.setCenter(pos);
                  document.getElementById("lat").value = marker.position.lat();
                  document.getElementById("long").value = marker.position.lng();
                  // Bias the SearchBox results towards current map's viewport.
                  map.addListener('bounds_changed', function() {
                      searchBox.setBounds(map.getBounds());
                  });

                  var markers = [];
                  // Listen for the event fired when the user selects a prediction and retrieve
                  // more details for that place.
                  searchBox.addListener('places_changed', function() {
                      var places = searchBox.getPlaces();

                      if (places.length == 0) {
                          return;
                      }

                      // Clear out the old markers.
                      markers.forEach(function(marker) {
                          marker.setMap(null);
                      });
                      markers = [];

                      // For each place, get the icon, name and location.
                      var bounds = new google.maps.LatLngBounds();
                      places.forEach(function(place) {
                          if (!place.geometry) {
                              console.log("Returned place contains no geometry");
                              return;
                          }

                          // Create a marker for each place.
                          markers.push(marker.setPosition(place.geometry.location));
                          document.getElementById("lat").value = marker.position.lat();
                          document.getElementById("long").value = marker.position.lng();
                          if (place.geometry.viewport) {
                              // Only geocodes have viewport.
                              bounds.union(place.geometry.viewport);
                          } else {
                              bounds.extend(place.geometry.location);
                          }
                      });
                      map.fitBounds(bounds);
                  });
                  marker.addListener("click",function() {
                      document.getElementById("lat").value = this.position.lat();
                      document.getElementById("long").value = this.position.lng();
                  });
                  marker.addListener("dragend",function() {
                      document.getElementById("lat").value = this.position.lat();
                      document.getElementById("long").value = this.position.lng();
                  });
              }

              function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                  infoWindow.setPosition(pos);
                  infoWindow.setContent(browserHasGeolocation ?
                      'Error: The Geolocation service failed.' :
                      'Error: Your browser doesn\'t support geolocation.');
              }
            <?php } ?>
              var playlist_number=1;
              var current_plname="";
              var current_plid="";
			$(document).ready(function(){
				var options = { 
					target:   '#output',   // target element(s) to be updated with server response 
					beforeSubmit:  beforeSubmit,  // pre-submit callback 
					uploadProgress: OnProgress,
					success:       afterSuccess,  // post-submit callback 
					resetForm: true        // reset the form after successful submit 
				};
					
				var max= 5;
				if( $("input[type=checkbox]:checked").length == max ){
					$("input[type=checkbox]").attr('disabled', 'disabled');
					$("input[type=checkbox]:checked").removeAttr('disabled');
				}else{
					$("input[type=checkbox]").removeAttr('disabled');
				}
				
				$('#MyUploadForm').submit(function() { 
					$(this).ajaxSubmit(options);
					// return false to prevent standard browser submit and page navigation 
					return false; 
				});
				
				$("input[type=checkbox]").change(function(){
					if( $("input[type=checkbox]:checked").length == max ){
						$("input[type=checkbox]").attr('disabled', 'disabled');
						$("input[type=checkbox]:checked").removeAttr('disabled');
					}else{
						$("input[type=checkbox]").removeAttr('disabled');
					}
				});
				// $("input[name=hangout_place]").tagsinput('items');
                $('#savePlaylist').click(function () {
                    $.ajax({
                        url : "<?php echo  site_url().'/Playlist/add'; ?>",
                        type : "POST",
                        data : {
                            name : $('#playlistName').val() ,
                        },
                        success : function (response) {
                            var json=JSON.parse(response);
                            if(json.status){
                                $('#modalPlaylist').modal('hide');
                                getPlaylist();
                            }else{
                                alert(response.message);
                            }
                        }
                    })
                });
                $(document).on('click','.del-playlist',function () {
                   var playlist_id=$(this).data('plid');
                   var is_delete=confirm("delete playlist?");
                   if(is_delete){
                       $.ajax({
                           url : "<?php echo  site_url().'/Playlist/delete'; ?>",
                           type : "POST",
                           data : {
                               playlist_id : playlist_id ,
                           },
                           success : function (response) {
                               var json=JSON.parse(response);
                               if(json.status){
                                   getPlaylist();
                               }else{
                                   alert(response.message);
                               }
                           }
                       })
                   }
                });
                $(document).on('click','.add-playlistItem',function () {
                    current_plid=$(this).data('plid');
                    current_plname=$(this).data('plname');
                    $("#modalSearchSong").modal('show');
                });
                $(document).on('click','.delete-itempl',function () {
                    var playlist_id=$(this).data('plid');
                    var link=$(this).data('pllink');
                    var is_delete=confirm("delete playlist item?");
                    if(is_delete){
                        $.ajax({
                            url : "<?php echo  site_url().'/Playlist/deleteItem'; ?>",
                            type : "POST",
                            data : {
                                playlist_id : playlist_id,
                                link : link
                            },
                            success : function (response) {
                                var json=JSON.parse(response);
                                if(json.status){
                                    getPlaylist();
                                }else{
                                    alert(response.message);
                                }
                            }
                        })
                    }
                });
                $(document).on('click','.edit-playlist',function () {
                    current_plid=$(this).data('plid');
                    current_plname=$(this).data('plname');
                    $('#playlistName-edit').val(current_plname);
                    $("#modalEditPlaylist").modal('show');
                });
                $('#song-search').on('change',function () {
                    var str=$(this).val();
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
                                $("#livesearch").html("");
                                var result = JSON.parse(resp);
                                var err = result.err;
                                if(err == "") {
                                    // console.log(1);
                                    $.each(result.data,function(x,y){
                                        //if(x != "err") {
                                        var from = y.from;
                                        var title = y.title;
                                        // console.log(title);
                                        var genre = y.genr;
                                        var onclick = 'addItem(\"'+y.track_id+'\",\"'+encodeURI(y.link)+'\",\"'+y.title+'\")';
                                        if(y['from'] === 'soundcloud') {
                                            var css = 'btn-info';
                                            var sourceLink = "<a href='"+y.link+"' target='blank'><i class='fa fa-soundcloud button-source-soundcloud-row' style='color:#ff3a00;font-size:16px'></i></a>"
                                        } else {
                                            var css = 'btn-info';
                                            var sourceLink = "<a href='"+y.link+"' target='blank'><i class='fa fa-youtube-play button-source-youtube-row' style='color:#bb0000;font-size:18px'></i></a>"
                                        }
                                        html += "<div class='box col-xs-12' style='border:1px solid #e5e5e5;padding:10px 8px 8px 8px;cursor:pointer'><div class='col-xs-1'><label align='right'>"+sourceLink+"</label></div><div class='col-xs-11' style='padding:0px' onclick='return "+onclick+"'><div class='col-xs-11 font-song-light' style='display:table-cell;vertical-align:middle;'>"+title+" </div><div class='col-xs-1' style='text-align:center'><button class='overlay btn btn-danger btn-xs' style='padding-left:7px;border-radius:50%;display:table-cell;vertical-align:middle'><i class='fa fa-plus fa-1x'></i></button></div></div></div>";
                                        //}
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
                });
                $('#save-editPlaylist').click(function () {
                    $.ajax({
                        url : "<?php echo  site_url().'/Playlist/update'; ?>",
                        type : "POST",
                        data : {
                            playlist_id : current_plid ,
                            name : $('#playlistName-edit').val()
                        },
                        success : function (response) {
                            var json=JSON.parse(response);
                            if(json.status){
                                getPlaylist();
                                $("#modalEditPlaylist").modal('hide');
                            }else{
                                alert(response.message);
                            }
                        }
                    })
                });
                getPlaylist();
			});
			function getPlaylist() {
                playlist_number=1;
                $.ajax({
                    url : "<?php echo  site_url().'/Playlist/getPlaylistUser'; ?>",
                    type : "GET",
                    success : function (response) {
                        var json=JSON.parse(response);
                        if(json.status){
                            var html="";
                            $.each(json.data,function (k,v) {
                                var row='<a role="button" data-toggle="collapse" data-parent="#accordion-'+v.playlist_id+'" href="#collapse-'+playlist_number+'" aria-expanded="true" aria-controls="collapse-'+playlist_number+'">'+
                                    '<div class="panel-heading user-playlist-box" role="tab" id="heading-'+playlist_number+'"  style="margin-bottom:5px">'+
                                    '<h4 class="panel-title">'+v.playlist_name+'</h4>'+
                                    '</div></a>'+'<div id="collapse-'+playlist_number+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'+playlist_number+'">'+
                                    '<div class="panel-body">'+
                                    '<table class="table table-striped" id="tbl-playlist-'+v.playlist_id+'">';
                               getPlaylistDetail(v.playlist_id,"tbl-playlist-"+v.playlist_id);
                                row+='</table>'+
                                    '<button class="btn btn-primary add-playlistItem" data-plid="'+v.playlist_id+'" data-plname="'+v.playlist_name+'"><i class="fa fa-plus"></i> Add Song</button> '+
                                    '<button class="btn btn-danger del-playlist" data-plid="'+v.playlist_id+'"><i class="fa fa-trash"></i> Delete Library</button> '+
                                    '<button class="btn btn-info edit-playlist" data-plid="'+v.playlist_id+'" data-plname="'+v.playlist_name+'"><i class="fa fa-trash"></i> Edit Library Name</button>'+
                                    '</div>'+
                                    '</div>';
                                html+=row;
                                playlist_number++;
                            });
                            $('#panel-playlist').html(html);
                        }
                    }
                });
            }
            function addItem(track_id,link,title) {
                $.ajax({
                    url : "<?php echo  site_url().'/Playlist/addItem'; ?>",
                    type : "POST",
                    data : {
                        playlist_id : current_plid ,
                        track_id : track_id,
                        link : decodeURI(link),
                        title : title
                    },
                    success : function (response) {
                        var json=JSON.parse(response);
                        if(json.status){
                            getPlaylist();
                            $("#modalSearchSong").modal('hide');
                        }else{
                            alert(response.message);
                        }
                    }
                });
            }
            function getPlaylistDetail(playlist_id,id) {
			    var num=1;
			    var html="";
                $.ajax({
                    url : "<?php echo  site_url().'/Playlist/getPlaylistUserItem/'; ?>"+playlist_id,
                    type : "GET",
                    success : function (response) {
                        var json=JSON.parse(response);
                        if(json.status){
                            $.each(json.data,function (k,v) {
                              var string = "^[0-9]*$";
                              if(!v.track_id.match(string)){
                                   
                                   var icon = '<i class="fa fa-youtube-play" style="color:#bb0000"></i>';
                                }else if(v.track_id.match(string)){
                                   var icon = '<i class="fa fa-soundcloud" style="color:#bb0000"></i>';
                                }else{
                                  var icon = '<i class = "fa fa-cross"> </i>';
                                }
                                html += '<tr class="row-song-playlist-user">' +
                                    '<td style="vertical-align: middle" align="center">'+icon+'</td>' +
                                    '<td class="song-content">' + num + '. ' + v.title + '</td>' +
                                    '<td class="icon-playlist" style="text-align: center">' +
//                                    '<button class="btn btn-xs btn-success"><i class="fa fa-play"></i> Play</button>'+
                                    '<button class="btn btn-warning btn-xs delete-itempl" data-plid="'+playlist_id+'" data-pllink="'+encodeURI(v.link)+'"><i class="fa fa-times"></i> Remove</button>' +
                                    '</td>' +
                                    '</tr>';
                                num++;
                            });
                           $("#"+id).html(html);
                        }
                    }
                });
            }
			function OnProgress(event, position, total, percentComplete)
			{
				//Progress bar
				// progressbar.width(percentComplete + '%') //update progressbar percent complete
				// statustxt.html(percentComplete + '%'); //update status text
				// if(percentComplete>50)
					// {
						// statustxt.css('color','#fff'); //change status text to white after 50%
					// }
				$("#back").hide();
				$("#save").hide();
				$("#changePassword").hide();
			}
			
			function afterSuccess(resp)
			{
				if(resp == 2) {
					$("#output").html("<?php echo $this->config->item("upload_failed"); ?>");
					$("#back").show();
					$("#save").show();
					$("#changePassword").show();
					$('#submit-btn').show(); //hide submit button
					$('#loading-img').hide(); //hide submit button
				} else {
					twitterImage = resp;
					$("#myImage").attr("src",twitterImage);
					$("#output").hide();
					$("#recentImage").attr("src",'<?php echo base_url(); ?>assets/'+resp);
					$("#back").show();
					$("#save").show();
					$("#changePassword").show();
					$('#submit-btn').show(); //hide submit button
					$('#loading-img').hide(); //hide submit button
				}
			}
			
			function beforeSubmit() {
			//check whether browser fully supports all File API
				if (window.File && window.FileReader && window.FileList && window.Blob) {
					if( !$('#imageInput').val()) { //check empty input filed 
						$("#output").html("Are you kidding me?");
						return false
					}
					var fsize = $('#imageInput')[0].files[0].size; //get file size
					var ftype = $('#imageInput')[0].files[0].type; // get file type
					//allow only valid image file types 
					switch(ftype) {
						case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
							break;
						default:
							$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
						return false
					}
					
					//Allowed file size is less than 1 MB (1048576)
					if(fsize>1048576) 
					{
						$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
						return false
					}
					
					//Progress bar
					// progressbox.show(); //show progressbar
					// progressbar.width(completed); //initial value 0% of progressbar
					// statustxt.html(completed); //set status text
					// statustxt.css('color','#000'); //initial color of status text
					
					$('#submit-btn').hide(); //hide submit button
					$('#loading-img').show(); //hide submit button
					$("#output").html("");  
				}
				else
				{
					//Output error to older unsupported browsers that doesn't support HTML5 File API
					$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
					return false;
				}
			}

			//function to format bites bit.ly/19yoIPO
			function bytesToSize(bytes) {
				var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
				if (bytes == 0) return '0 Bytes';
				var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
				return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
			}
			
			function validate() {
				var form = document.getElementById("formEditProfile");
				form.submit();
			}
  </script>
  <style>
	.input-file
	{
		width:300px;
		float:left;
	}
	
	body{
		padding-bottom:100px;
	}

	.user-playlist-box{
		background-color:#00aeff;
		border-radius: 0px 0px 0px 0px;
		color:white;
	}

	a:hover, a:focus{
		text-decoration: none;
	}
  </style>
  
  <body>
	
	<input type="hidden" id="username" value="Kang Hwan"/>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          
          <a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo $this->config->item("logo"); ?>" width="130px"/></a>
        </div>
        
        <div id="navbar">
          
          
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo site_url(); ?>"><div>&#8592; BACK TO HOME</div></a></li>                        
      			<li class="dropdown">
      				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
      					<img id="myImage" src="<?= (!filter_var($image, FILTER_VALIDATE_URL) === false)? $image : base_url().'assets/'.$image ?>" onError="this.onerror=null;this.src='<?php echo $this->config->item("user_default") ?>';" width="26px" class="img-circle"/> <span class="caret"></span>
      				</a>
      				<ul class="dropdown-menu">
                        <li><a href="<?php echo site_url(); ?>/EditProfile"><?php echo $this->config->item("edit_profile") ?></a></li>                 
                        <li role="separator" class="divider"></li>                              
                        <li><a href="<?php echo site_url(); ?>/login/logout"><?php echo $this->config->item("sign_out") ?></a></li>
                      </ul>
      			</li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container" height="100%">
		<div class="row">
		<div class="<?=($isAdmin)? "col-sm-6 col-sm-offset-3 " : "col-sm-5 col-sm-offset-1 "?>center-bar" style="padding-top:20px;padding-right:20px;">
				<div class="col-xs-12 header-menu-jukebox" style="text-align:left">
					<i class="fa fa-user"></i> &nbsp;&nbsp;<?php echo $this->config->item("profile") ?>
				</div>
					<br/>
					<br/>
					<br/>					
					<img id="recentImage" src="<?php echo base_url(); ?>assets/<?php echo $image; ?>" onError="this.onerror=null;this.src='<?php echo $this->config->item("user_default") ?>';" width="200px"/></center>
					<p class="help-block">Change Profile Picture</p>
					<p class="help-block" style="font-size:10px">Image Type allowed: Jpeg, Jpg, Png and Gif. | Maximum Size 1 MB</p>
					
						<form action="<?php echo site_url(); ?>/EditProfile/upload" onSubmit="return false" method="post" enctype="multipart/form-data" id="MyUploadForm">
							<div class="col-xs-9" style="padding:0;margin:0;">
								<input id="imageInput" name="image_file" type="file" class="form-control">
							</div>
							<div class="col-xs-3" style="padding:0;margin:0;">
							<button type="submit" class="btn btn-info" id="submit-btn">Upload</button>
							<img src="<?php echo $this->config->item("ajax_loader") ?>" id="loading-img" style="display:none;" alt="Please Wait"/>
							</div>
							<div id="output"></div>
							<br><br>
						</form>
					
					<br>
				<div class="col-xs-12">
					<form id="formEditProfile" action="<?php echo site_url(); ?>/EditProfile/process" method="post" class="form-horizontal" enctype="multipart/form-data">
						<?php if(isset($_GET['err'])){ ?>
						<div id="error" class="alert alert-danger" role="alert">
							<small id="cetak-error"><b><?php echo $_GET['err']; ?></b></small>
						</div>
						<?php } ?>
						
						<div class="form-group">
							<label><?php echo $this->config->item("username") ?></label>
							<input type="text" class="form-control" name="newUsername" value="<?php echo $username; ?>" placeholder="username">
						</div>
						<?php if($isAdmin) { ?>
						<div class="form-group">
							<label><?php echo $this->config->item("address") ?></label>
							<textarea id="address" name="address" class="form-control" placeholder="Address"><?php echo $address; ?></textarea>
						</div>
						<?php } ?>
						
						<div class="form-group">
							<label><?php echo $this->config->item("email") ?></label>
							<input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
						</div>
						
						<div class="form-group">
							<label><?php echo $this->config->item("about_title") ?></label>
							<textarea name="about" id="about" rows="6" class="form-control" placeholder="You're Bio"><?php echo $bio; ?></textarea>
						</div>										
						
						<div class="form-group">
							<label><?php echo $this->config->item("music_genre_title") ?></label>
							<div class="checkbox">
							<?php
								$i = 1;
								foreach($this->config->item("genre") as $val) { 
									$check = "";
									if(in_array($val,$music_genre)) $check = "checked";
									if($i == 1) {
										echo '<div class="col-xs-6">';
										echo '<label>';
						  				echo '<input type="checkbox" id="genre" name="genre[]" value="'.$val.'" '.$check.'/> '.$val;
										echo '</label><br/>';
									} else if($i == count($this->config->item("genre"))/2) {
										echo '<label>';
						  				echo '<input type="checkbox" id="genre" name="genre[]" value="'.$val.'" '.$check.'/> '.$val;
										echo '</label><br/>';
										echo "</div>";	
									} else {
										echo '<label>';
							  			echo '<input type="checkbox" id="genre" name="genre[]" value="'.$val.'" '.$check.'/> '.$val;
										echo '</label><br/>';
									}
									if($i == count($this->config->item("genre"))/2) $i = 0;
									$i++;
								} 
							?>
							</div>
						</div>
						
						<div class="form-group">
							<label><?php echo $this->config->item("food_title") ?></label>
							
							<input type="text" id="food" name="food" value='<?php echo $food; ?>' data-role="tagsinput" class="form-control" style="margin-top:15px" placeholder="ex: Nasi goreng,Nasi capcay">
						</div>
						
						<div class="form-group">
							<label><?php echo $this->config->item("drink_title") ?></label>
							<input type="text" id="drink" name="drink" class="form-control" value='<?php echo $drink; ?>' data-role="tagsinput" placeholder="ex: Es teh tawar,Es teh manis">
						</div>
						
						<div class="form-group">
							<label><?php echo $this->config->item("hangout_place_title") ?></label>
							<input type="text" id="hangout_place" name="hangout_place" class="form-control" data-role="tagsinput" value='<?php echo $hangout_place; ?>' placeholder="ex: Rotishop,Blackseed">
						</div>
	                    <?php
	                    if($this->session->userdata('user_admin')){
	                    ?>
	                    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
	                    <div id="map" class="latlongAdmin"></div><br/>
	                    <input type="hidden" id="lat" name="lat" class="form-control" placeholder="Latitude" value="<?=$lat?>"/>
	                    <input type="hidden" id="long" name="long" class="form-control" placeholder="Latitude" value="<?=$long?>"/>
	                    <?php } ?>
						<input type="hidden" name="userID" value="<?php echo $id; ?>"/>
						<center>
							<a href="<?php echo base_url(); ?>"><button id="back" type="button" class="btn btn-default">&#8592; Back</button></a>
							<button type="button" id="save" class="btn btn-info" onclick="validate()">Save Change</button>
						</center>
						
						<center>
							<small>
								<br>
								Do you want to change your password?<br> <a id="changePassword" href="#" data-toggle="modal" data-target="#changePass">Yes, change my password</a>.
								<br>
							</small>
						</center>
					</form>
				</div>
						
			<div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-sm" role="document">
				<div class="modal-content">
				  <form action="<?php echo site_url(); ?>/EditProfile/changePassword" method="post">
					  <div class="modal-header" style="background-color:#00aeff;color:white">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel" style="font-weight:700"><i class="fa fa-unlock-alt"></i> Change Password</h4>
					  </div>
					  <div class="modal-body">
						
						<div class="form-group">
							<label>Old Password</label>
							<input type="password" id="oldpass" name="oldpass" class="form-control" placeholder="Old Password" required />
						</div>
						<div class="form-group">
							<label>New Password</label>
							<input type="password" id="newpass" name="newpass" class="form-control" placeholder="New Password" required />
						</div>
						<div class="form-group">
							<label>Retype New Password</label>
							<input type="password" id="retype" name="retype" class="form-control" placeholder="Retype New Password" required />
						</div>						
					  </div>
					  <div class="modal-footer">
						<button type="submit" class="btn btn-info">Submit</button>						
					  </div>
				  </form>
				</div>
			  </div>
			</div>
			
		</div>
        <?php if(!$isAdmin) { ?>
		<div class="col-sm-5" style="padding-top:20px;">
			<div class="col-xs-12 header-menu-jukebox" style="text-align:left">
				<i class="fa fa-music"></i> &nbsp;&nbsp; User Library<?php //echo $this->config->item("user_playlist") ?>
			</div>
			<br/><br/>
			<br/>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" >

			  <!--Playlist 1-->
			  <div class="panel" id="panel-playlist">
			  </div>
			  <!--End Playlist 1-->
			</div>

			<button class="btn btn-default" data-toggle="modal" data-target="#modalPlaylist"><i class="fa fa-list"></i> Add Library</button>

			<div id="modalPlaylist" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content">
			    
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Add Library</h4>
			      </div>
			      <div class="modal-body">
			        <form>
			        	<div class="form-group">
					    	<label for="playlistName">Library Name</label>
					    	<input type="text" class="form-control" id="playlistName" placeholder="Playlist Name">
					    </div>
			        </form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary" id="savePlaylist">Submit</button>
			      </div>
			    </div>
			    
			  </div>
			</div>

			<div id="modalEditPlaylist" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content">
			    
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Edit Libarary Name</h4>
			      </div>
			      <div class="modal-body">
			        <form>
			        	<div class="form-group">
					    	<label for="playlistName">Edit Libarary Name</label>
					    	<input type="text" class="form-control" id="playlistName-edit" placeholder="Playlist Name">
					    </div>
			        </form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="button" class="btn btn-primary" id="save-editPlaylist">Submit</button>
			      </div>
			    </div>
			    
			  </div>
			</div>

			<div id="modalSearchSong" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Add Song</h4>
			      </div>
			      <div class="modal-body">
			        
			        	<div class="form-group" style="margin-bottom: 0px">
					    	<label for="song">Search Your Song</label>
					    	<input type="text" class="form-control" id="song-search" placeholder="Search your song here">
					    </div>

					<!--Search Song-->
					<div id="livesearch" style="position: absolute;z-index: 100;background:white;width: 95%;font-size:12px;max-height:462px;overflow-y:auto;box-shadow:0px 3px 8px #888">
			        </div>
			        <!--End Search Song-->
			      </div>			      
			    </div>
			    
			  </div>
			</div>
			
		</div>
        <?php } ?>
        </div>
	</div>
    <script async defer src="<?php echo $this->config->item("google_maps_script"); ?>"></script>

