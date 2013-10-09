/////////////////////////////////////////////////////////////
// EP Player v2 - JS API
// ----------------------------------------------------------
// Control functions
/////////////////////////////////////////////////////////////
var radio = 0;
var play_stat = 1;
function EP_get(id) {
	var el = document.getElementById(id);
	if(el && el.EP_isLoaded) {
		return el;
	} else {
		alert('\''+ id +'\' not found!');
		return;
	}
}

/////////////////////////////////////////////////////////////
function EP_isLoaded(id) {
	var el = document.getElementById(id);
	if(el.EP_isLoaded) {
		var err="loaded";
		return err;
	} else {
		var err="not_loaded";
		return err;
	}
}

/////////////////////////////////////////////////////////////
function EP_play(id) {
	if(play_stat == 0)
	{
		EP_playTrack(id, 99)
		play_stat = 1;
	}
	else
	{
		var p = EP_get(id);
		if(p) p.EP_play();
		play_stat = 1;
	}
}

/////////////////////////////////////////////////////////////
function EP_setVolume(id, v) {
	var p = EP_get(id);
	if(p) p.EP_setVolume(v);
}

/////////////////////////////////////////////////////////////
function EP_pause(id) {
	var p = EP_get(id); 
	if(p) p.EP_pause();
}

/////////////////////////////////////////////////////////////
function EP_stop(id) {
	var p = EP_get(id); 
	if(p) p.EP_stop();
}

/////////////////////////////////////////////////////////////
function EP_playPause(id) {
	var p = EP_get(id); 
	if(p) p.EP_playPause();
}

/////////////////////////////////////////////////////////////
function EP_prev(id) {
	play_stat = 1;
	var p = EP_get(id); 
	if(p) p.EP_prev();
}

/////////////////////////////////////////////////////////////
function EP_next(id) {
	play_stat = 1;
	var p = EP_get(id); 
	if(p) p.EP_next();
}

/////////////////////////////////////////////////////////////
function EP_setShuffle(id, v) {
	var p = EP_get(id); 
	if(p) p.EP_setShuffle(v);
}

/////////////////////////////////////////////////////////////
function EP_setRepeat(id, v) {
	var p = EP_get(id); 
	if(p) p.EP_setRepeat(v);
}

/////////////////////////////////////////////////////////////
function EP_setAutoPlay(id, v) {
	var p = EP_get(id); 
	if(p) p.EP_setAutoPlay(v);
}

/////////////////////////////////////////////////////////////
function EP_addTracks(id, xml, i) {
	var p = EP_get(id); 
	if(p) p.EP_addTracks([xml, i]);
}

/////////////////////////////////////////////////////////////
function EP_removeTracks(id, xml) {
	var p = EP_get(id); 
	if(p) p.EP_removeTracks(xml);
}

/////////////////////////////////////////////////////////////
function EP_loadPlaylist(id, f) {
	var p = EP_get(id); 
	if(p) p.EP_loadPlaylist(f);
}

/////////////////////////////////////////////////////////////
function EP_setPlaylist(id, xml, s) {
	var p = EP_get(id); 
	if(p) p.EP_setPlaylist(xml);
	if(s == true) EP_play(id);
}

/////////////////////////////////////////////////////////////
function EP_clearPlaylist(id) {
	var p = EP_get(id); 
	if(p) p.EP_clearPlaylist();
}

/////////////////////////////////////////////////////////////
function EP_playTrack(id, i) {
	var p = EP_get(id); 
	if(p) p.EP_playTrack(i);
}

/////////////////////////////////////////////////////////////
function EP_getCurrentTrackData(id) {
	var p = EP_get(id); 
	if(p) return p.EP_getCurrentTrackData();
	return new Object();
}

/////////////////////////////////////////////////////////////
function EP_getTrackData(id , i) {
	var p = EP_get(id); 
	if(p) return p.EP_getTrackData(i);
	return new Object();
}

/////////////////////////////////////////////////////////////
function EP_setSize(id, w, h) {
	var el = EP_get(id);
	if(el) {
		el.style.width = w;
		el.style.height = h;
	}
}

/////////////////////////////////////////////////////////////
// Callback functions
/////////////////////////////////////////////////////////////
function EP_onLoad(id) {
	// alert(id +': onLoad');
}

function EP_onPlay(id) {
	// alert(id +': onPlay');
	play_stat = 1;
}

/////////////////////////////////////////////////////////////
function EP_onStop(id) {
	//alert("HI");
	if(radio == 1)
	{
		AJAX.MakePostRequest("ajax/retrive_from_radio.php","",callback_play);
	}
	else
	{
		play_stat = 0;
	}

}

/////////////////////////////////////////////////////////////
function EP_onPause(id) {

}

/////////////////////////////////////////////////////////////
function EP_onNext(id) {
	play_stat = 1;
}

/////////////////////////////////////////////////////////////
function EP_onPrev(id) {

}

/////////////////////////////////////////////////////////////
function EP_RadioOn(id) {
	radio = 1;
	EP_onStop('ep_player1');
}

function EP_RadioOff(id) {
	radio = 0;
	EP_stop('ep_player1');
}

/////////////////////////////////////////////////////////////
function callback_play(){
	var contents = AJAX.GetContents() ;
	//alert(contents);
	if(contents != false)
	{
			//alert(contents) ;
			var response_json = eval('(' + contents + ')') ;
			if(response_json.result.bResult == true)
			{
				//alert(contents);
				//alert(response_json.result.id);
				//alert(response_json.result.title);
				play_stat = 1;
				EP_clearPlaylist('ep_player1');
				EP_addTracks("ep_player1", "<track><location>load_aud.php?id="+response_json.result.id+"</location><title>"+response_json.result.title+"</title></track>", 999);
				EP_play('ep_player1');
			}
	}
}