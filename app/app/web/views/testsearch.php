<!DOCTYPE html>
<html lang="en">

    <body>
        <header>
            <h1 class="w100 text-center"><a href="index.html">YouTube Viral Search</a></h1>
        </header>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="#">
                    <p><input type="text" id="search" placeholder="Type something..." autocomplete="off" class="form-control" /></p>
<!--                     <p><input type="submit" value="Search" class="form-control btn btn-primary w100"></p> -->
                    <p><button  type="submit" class="form-control btn btn-primary w100 button-click">Search</button></p>
                </form>
                <div id="results"></div>
            </div>
        </div>
        
        <!-- scripts -->
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://apis.google.com/js/client.js?onload=init"></script>
        <script src="https://apis.google.com/js/api.js"></script>
        <script>

        	function test(){
        		alert('just test');

        	}

        	$(".button-click").click(function(){
    		alert("The paragraph was clicked.");

    		var apiKey = 'AIzaSyDFnN_CK-jCumGpyJViKZwlCvBGPm1fQFw';
    		gapi.client.setApiKey(apiKey);
   			 gapi.client.load('youtube', 'v3', function() {
       		  alert('BABA');
    		var request = gapi.client.youtube.search.list({
            part: "snippet",
            type: "video",
            q: encodeURIComponent($("#search").val()).replace(/%20/g, "+"),
            maxResults: 5
       });


       request.execute(function(response){
        var result = response.result.items;
        $.each(result.items, function(index, item){

        	$("#results").append(item.id.videoId + " - " + item.snippet.title + "<br>");

        });

       });


    		}); 



				});

         </script>
        

      
    </body>
</html>

