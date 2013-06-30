<head>

<style>
div#jp_container_N
{
//width:100px;
position:absolute;
right:25px;
}

.masterlist{
	position: absolute;
	width:30%;
}

.dirz{

font-style:italic;
}

.filez{

}

.dirz:hover{
background-color:rgba(230, 154, 23, 0.3);
}

.back:hover{
background-color:rgba(230, 154, 23, 0.3);
}
.filez:hover{
background-color:rgba(28, 76, 152, 0.3);
}

</style>



<link href="/CSS3MusicList/jPlayer24/skin/prettify-jPlayer.css" rel="stylesheet" type="text/css" />
<link href="/CSS3MusicList/jPlayer24/skin/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="/CSS3MusicList/jPlayer24/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="/CSS3MusicList/jPlayer24/add-on/jplayer.playlist.min.js"></script>


<script type="text/javascript">

$(document).ready(function(){

	//build jPlayer. This needs to be done first
	var myPlaylist = new jPlayerPlaylist({
			jPlayer: "#jquery_jplayer_N",
			cssSelectorAncestor: "#jp_container_N"
		}, 

		[], 

		{
			playlistOptions: {
				enableRemoveControls: true
			},
			swfPath: "/CSS3MusicList/jPlayer24/Jplayer.swf",
			supplied: "mp3",
			smoothPlayBar: true,
			keyEnabled: true,
			audioFullScreen: true
		});








//this code sets up the file browser

	//here is the starting dir for when you log on
	var startdir = '\/Applications\/MAMP\/htdocs\/CSS3MusicList\/audiofiles\/';
	var startdirstripped = '\/CSS3MusicList\/audiofiles\/';
	var rootdir='/';

	//set a hidden input to this value
	$('#currentdir').val(startdirstripped);
	$('#currentdirlong').val(startdir);

	$.post('/filestream/dirparser.php', { dir: startdir}, function(response) {
	    // log the response to the console
	    console.log("Response: "+response);
	    //hand this data off
	    printdir(response);
	});





	//need a function that will recieve JSON from dirparser.php.  It will then make a list of the directory and tack on links for functionality
	function printdir(dir){
		//console.log(dir);
		console.log(jQuery.parseJSON(dir));
		var dirty = jQuery.parseJSON(dir);

		//clear the list
		$('#filelist').empty();

		//parse through the json array and make an array of corresponding divs
		var filelist = [];
		$.each(dirty, function() {
			if(this.type=='mp3'){
				console.log(this.link);
				//filelist.push('<li class="file">'+this.link+'</li>');//LEFT OFF HERE
				filelist.push('<div class="filez">'+this.link+'</div>');
			}
			if(this.type=='dir'){
				console.log(this.link);
				//filelist.push('<li class="file">'+this.link+'</li>');//LEFT OFF HERE
				filelist.push('<div class="dirz">'+this.link+'</div>');
			}
		});

		//add a listing to go back
		if($('#currentdir').val()!=rootdir){
			filelist.push('<div class="back">..</div>');
		}

		console.log(filelist);

		$('#filelist').html(filelist);
	}






//need a function that will on click will add a file to jplayer playlist
//onclick of that class

	$("#filelist").on('click', 'div.filez', function() {
		//get the html of that class
		var addfile=$(this).html();
		var thedir=$('#currentdir').val();
		var location = thedir+addfile;

		myPlaylist.add({
			title: addfile,
			//artist:"The Stark Palace",
			mp3: location
			//poster: "http://www.jplayer.org/audio/poster/The_Stark_Palace_640x360.png"
		});
	});

	//when you click on a directory
	$("#filelist").on('click', 'div.dirz', function() {
		//get the html of that class
		var adddir=$(this).html();
		var curdirlong=$('#currentdirlong').val();
		var curdir=$('#currentdir').val();
		var location = curdirlong+adddir+'/';

		$('#currentdirlong').val(location);
		$('#currentdir').val(curdir+adddir+'/');

		senddir(location);
	});

	// when you click the back directory
	$("#filelist").on('click', 'div.back', function() {
		if($('#currentdir').val()!=rootdir){

			




			//get the html of that class
			var adddir=$(this).html();
			var curdirlong=$('#currentdirlong').val();
			//var curdir=$('#currentdir').val();
			var location = curdirlong+adddir+'/';



			var arrayOfStrings = curdirlong.split('/');


			var builddirlong='/';
			var builddir='/';

			for (var i=0; i < arrayOfStrings.length-2; i++){
				//print(arrayOfStrings[i] + " / ");
				if(i!=0){
					builddirlong=builddirlong+arrayOfStrings[i]+'/';
					//console.log(builddir);
				}
				if(i>3){
					builddir=builddir+arrayOfStrings[i]+'/';
					//console.log(builddir);
				}
			}
			console.log(builddirlong);
			console.log(builddir);


		




		$('#currentdirlong').val(builddirlong);
		$('#currentdir').val(builddir);

		senddir(location);
		}
		});


//send the content in the field to dirparser.  
//

function senddir(dirr){
	$.post('/filestream/dirparser.php', { dir: dirr}, function(response) {
	    // log the response to the console
	    console.log("Response: "+response);
	    //hand this data off
	    printdir(response);
	});
}




console.log(location);

});



</script>
</head>



<body>



	<div class='masterlist' id='filelist'>
		<div class="filez">beans</div>
	</div>


<input type="hidden" id="currentdir"></input>
<input type="hidden" id="currentdirlong"></input>





<div id="jp_container_N" class="jp-video jp-video-270p">
			<div class="jp-type-playlist">
				<div id="jquery_jplayer_N" class="jp-jplayer" style="width: 480px; height: 270px;"><img id="jp_poster_0" src="http://www.jplayer.org/audio/poster/The_Stark_Palace_640x360.png" style="width: 480px; height: 270px; display: inline;"><audio id="jp_audio_0" preload="metadata" src="http://www.jplayer.org/audio/ogg/TSP-01-Cro_magnon_man.ogg"></audio><video id="jp_video_0" preload="metadata" style="width: 0px; height: 0px;"></video></div>
				<div class="jp-gui" style="">
					<div class="jp-video-play" style="display: none;">
						<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
					</div>
					<div class="jp-interface">
						<div class="jp-progress">
							<div class="jp-seek-bar" style="width: 100%;">
								<div class="jp-play-bar" style="width: 0%;"></div>
							</div>
						</div>
						<div class="jp-current-time">00:00</div>
						<div class="jp-duration">04:27</div>
						<div class="jp-controls-holder">
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
								<li><a href="javascript:;" class="jp-play" tabindex="1" style="">play</a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1" style="display: none;">pause</a></li>
								<li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
								<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute" style="">mute</a></li>
								<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute" style="display: none;">unmute</a></li>
								<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume" style="">max volume</a></li>
							</ul>
							<div class="jp-volume-bar" style="">
								<div class="jp-volume-bar-value" style="width: 80%;"></div>
							</div>
							<ul class="jp-toggles">
								<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen" style="">full screen</a></li>
								<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen" style="display: none;">restore screen</a></li>
								<li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle" style="">shuffle</a></li>
								<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off" style="display: none;">shuffle off</a></li>
								<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat" style="">repeat</a></li>
								<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off" style="display: none;">repeat off</a></li>
							</ul>
						</div>
						<div class="jp-title" style="display: none;">
							<ul>
								<li>Cro Magnon Man <span class="jp-artist">by The Stark Palace</span></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="jp-playlist">
					<ul style="display: block;"><li class="jp-playlist-current"><div><a href="javascript:;" class="jp-playlist-item-remove" style="">×</a><a href="javascript:;" class="jp-playlist-item jp-playlist-current" tabindex="1">Cro Magnon Man <span class="jp-artist">by The Stark Palace</span></a></div></li></ul>
				</div>
				<div class="jp-no-solution" style="display: none;">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>





</body>

