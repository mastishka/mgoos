///////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////
//                                                      ///////
//                      Wimpy JS                        ///////
//                     Version 2.0                      ///////
//                                                      ///////
//         by Mike Gieson <info@wimpyplayer.com>        ///////
//                                                      ///////
//        Available at http://www.wimpyplayer.com       ///////
//                 ©2002-2006 plaino                    ///////
//                                                      ///////
///////////////////////////////////////////////////////////////
//
// This product includes software developed by Macromedia, Inc.
// 
// Macromedia(r) Flash(r) JavaScript Integration Kit
// Portions noted as part of the JavaScript Integration Kit
// are Copyright (c) 2005 Macromedia, inc. All rights reserved.
// http://www.macromedia.com/go/flashjavascript/
// 
// Macromedia(r) Flash(r) JavaScript Integration Kit Created by:
// 
// Christian Cantrell
// http://weblogs.macromedia.com/cantrell/
// mailto:cantrell@macromedia.com
// 
// Mike Chambers
// http://weblogs.macromedia.com/mesh/
// mailto:mesh@macromedia.com
// 
// Macromedia
// 
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
////////////                                     ////////////
////////////              OPTIONS                ////////////
////////////                                     ////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//
// Refer to the "readme_wimpy_mp3_js.html" file for details.
//
wimpySwf = "swf/wimpy.swf";
theWidth = 300;
theHeight = 350;
theBkgdColor = "FFCC00";
// 
// You can use an external wimpyConfigs.xml file to set the remainder of the options
wimpyConfigFile = "";
// ... or set them here:
//
wimpySkin = "mgoos.xml";
trackPlays = "";
voteScript = "";
defaultImage = "";
startPlayingOnload = "";
shuffleOnLoad = "";
randomOnLoad = "";
displayDownloadButton = "";
startOnTrack = "";
autoAdvance = "";
popUpHelp = "";
scrollInfoDisplay = "";
infoDisplayTime = "";
bufferAudio = "";
theVolume = "";
limitPlaytime = "";
startupLogo = "";
//
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
////////////                                     ////////////
////////////    Advanced Usage (experts only!)   ////////////
////////////                                     ////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
// 
//
//
js_wimpy_returnOnComplete = "myReturnFunction";
var index;

function myReturnFunction(myReturnArg)
{
	if(typeof(myReturnArg) == "object")
	{
		// Put the returned array into a new variable so we can modify it
		var returnedArray = myReturnArg;

		// Remove the first element of the array and put it into a new 
		// variable so we can determine which action Wimpyjust performed.
		var myAction = returnedArray.shift();

		//alert(myAction) ;
		// Here we can fork out to different methods based on the name of the action 
		// that just occured. For the sake of this example, all of the returned function 
		// use do the same thing (printReturnedData), but for your needs, you can fork 
		// out to different functions.
		if(myAction == "getTrackInfo")
		{
			//alert("wimpy_getTrackInfo") ;
		}
		else if (myAction == "wimpy_returnPlaylistItem")
		{
			//alert("returnPlaylistItem");
		}
		else if (myAction == "trackDone")
		{
			//alert("trackDone") ;
		}
		else if (myAction == "wimpy_trackStarted")
		{
			if(index != 0 && index < SR.playlist_id_ary.length)
			{
				wimpy_loadAndPlay("load_aud.php?id="+SR.playlist_id_ary[index], '', SR.playlist_title_ary[index], '', '');
				index++
			}
			//alert("trackStarted") ;
			// call a php script with mp3 id, which will increase the rating.
		}
		else if (myAction == "wimpy_appendPlaylist")
		{
			//alert("wimpy_appendPlaylist") ;
			// call a php script with mp3 id, which will increase the rating.
		}
	}
	else
	{
		if(myReturnArg == "wimpy_clearPlaylist")
		{
			SR.bPlayerLoaded = true ;
			//alert("Player Loaded") ;
			if(SR.playlist_id_ary && SR.playlist_id_ary.length > 0)
			{
				index = 0;
				var playlist = new Array();
				
				wimpy_loadAndPlay("load_aud.php?id="+SR.playlist_id_ary[index], '', SR.playlist_title_ary[index], '', '');
				index++;
			}
		}
	}
}
//
// HINT: Add one slash to the line below (the line with the * ) to uncomment this entire section.
//
/*
//
// The variable "js_wimpy_returnOnComplete" is sent into Flash to 
// establish a the name of the function that Wimpy should "ping" after 
// successfully receiveing a JavaScript command.
//
// Set js_wimpy_returnOnComplete to the function name that Flash 
// will call upon successfully completing a previous JavaScript request.
//
// Example:
//
js_wimpy_returnOnComplete = "myReturnFunction";
//
// In this example, Wimpy will ping the function myReturnFunction.
//
function myReturnFunction(myReturnArg){

	// Wimpy will return either a "string" or "array" (object) in the 
	// myReturnArg argument. For most Wimyp javascript commands, Wimpy will 
	// not return any meaningful data, so Wimpy will only return the name of 
	// the function that it received so that you can verify that the javascript 
	// function actually made it to Wimpy and so you can differentiate between 
	// each response that Wimpy returns.

	// As mentioned earlier, most of the Wimpy Javascript functions don't return 
	// anything meaningfull, hense Wimpy only returns a "string" identifying the 
	// name of the function is was requested to perform. Functions such as 
	// wimpy_play, wimpy_stop, wimpy_gotoAndPlay (among others) only return the 
	// name of the function as a string.

	// Whereas with functions that return information that you can use, Wimpy 
	// will return an "array" (object), where the first index of the array (0) is
	// the name of the function that Wimpy was asked to perform. The remaining 
	// indexes in the array contain information about the requested track. All of 
	// the information that is available for the specified track is returned. Do 
	// for example, if you are using an XML playlist, and you ahve decided to 
	// include additioan <tags> for each <item> in the playlist, all of the tags 
	// sent in to Wimpy through the XML playlist will be returned.



	// Used during testing (it's a little annoying, but a little bit more 
	// trustworthy than re-writing <div> tags.
	//
	alert ("Wimpy returned: " + myReturnArg);


	// Here we check to see what kind of data-type is returned 
	// (either an array object or a string)
	if(typeof(myReturnArg) == "object"){

		// Put the returned array into a new variable so we can modify it
		var returnedArray = myReturnArg;

		// Remove the first element of the array and put it into a new 
		// variable so we can determine which action Wimpyjust performed.
		var myAction = returnedArray.shift();


		// Here we can fork out to different methods based on the name of the action 
		// that just occured. For the sake of this example, all of the returned function 
		// use do the same thing (printReturnedData), but for your needs, you can fork 
		// out to different functions.
		if(myAction == "wimpy_getTrackInfo"){
			printReturnedData(myAction, returnedArray);
		
		} else if (myAction == "wimpy_returnPlaylistItem"){
			printReturnedData(myAction, returnedArray);
		
		} else if (myAction == "wimpy_trackDone"){
			printReturnedData(myAction, returnedArray);
		
		} else if (myAction == "wimpy_trackStarted"){
			printReturnedData(myAction, returnedArray);
		}



	// If the returned argument is not an array (i.e. its a string or a number), and you would 
	// like something to occur based on the name of the function that Wimpy has just prossessed
	// you can do so here.

	// For this example, we've set up a system to load and play a pre-defined list of files 
	// (See "Example A Code" below). This example is set up to show you how you can leverage 
	// the "call and response" behaviour between Wimpy and Javascript when using the 
	// js_wimpy_returnOnComplete feature, so that you can monitor and interact between 
	// your web page, the user and Wimpy.
	
	// When the link entitled "Review next track (Example A)" is clicked, the wimpy_clearPlaylist 
	// function is invoked, which will clear the playlist. Once Wimpy returns the name of the 
	// function (indicating that the wimpy_clearPlaylist function is complete), a new track is 
	// loaded into the player using the loadAndPlay function.

	} else {

		if(myReturnArg == "wimpy_clearPlaylist"){
			
			alert ("The next item will now load and play");

			wimpy_loadAndPlay(
					myPlaylist[currentTrack][0], 
					myPlaylist[currentTrack][1], 
					myPlaylist[currentTrack][2], 
					myPlaylist[currentTrack][3], 
					myPlaylist[currentTrack][4]
				);

			currentTrack++
			
		}

	}
}

function printReturnedData(theActionName, theDataArray){
	var returnedData = "";
	returnedData += "<br>Action initiated: <b>"+theActionName+"</b><br><br>";
	for(i=0;i<theDataArray.length;i++){
		returnedData += "Array Item " + i + " : " + theDataArray[i]+"<br>";
	}
	writit(returnedData,"trackInfo");
}
function writit(text,id){
	if (document.getElementById) {
		x = document.getElementById(id);
		x.innerHTML = '';
		x.innerHTML = text;
	} else if (document.all) {
		x = document.all[id];
		x.innerHTML = text;
	} else if (document.layers) {
		x = document.layers[id];
		text2 = '<P CLASS="testclass">' + text + '</P>';
		x.document.open();
		x.document.write(text2);
		x.document.close();
	}
}
// Example A Code
currentTrack = 0;
myPlaylist = new Array();
myPlaylist[0] = new Array('example1.mp3', '', 'Track 1', '', '');
myPlaylist[1] = new Array('example2.mp3', '', 'Track 2', '', '');
myPlaylist[2] = new Array('example3.mp3', '', 'Track 3', '', '');
myPlaylist[3] = new Array('example4.mp3', '', 'Track 4', '', '');
//
//*/
//
// 
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
////////////                                     ////////////
////////////       Do not edit below here        ////////////
////////////                                     ////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
randNum = (Math.round((Math.random()*1000000)+1));
function makeWimpyPlayer(thePlaylist){
	thePlaylist = thePlaylist || "";
	var newlineChar = "\n";
	var bkgdColor;
	var tptBkgd_param;
	var writePlaylist;
	var altString;
	var queryString;
	var js2wimpy_param;
	var js2wimpy_embed;
	var flashCode = '';
	var flashVersion = "6,0,47,0";
	var myConfigs = "wimpySkin,trackPlays,voteScript,defaultImage,startPlayingOnload,shuffleOnLoad,randomOnLoad,displayDownloadButton,startOnTrack,autoAdvance,popUpHelp,scrollInfoDisplay,infoDisplayTime,bufferAudio,theVolume,js_wimpy_returnOnComplete,limitPlaytime,startupLogo";
	var AmyConfigs = myConfigs.split(",");
	var AprintConfigs = Array();
	for(i=0;i<AmyConfigs.length;i++){
		if(eval(AmyConfigs[i]) != ""){
			AprintConfigs[AprintConfigs.length] = AmyConfigs[i]+"="+eval(AmyConfigs[i]);
		}
	}
	myConfigs = AprintConfigs.join("&");
	randNum++;
	if(theBkgdColor == false || theBkgdColor == "false"){
		bkgdColor = "000000";
		tptBkgd_param = '<param name="wmode" value="transparent" />'+newlineChar;
		tptBkgd_embed = 'wmode="transparent" ';
	} else {
		if(theBkgdColor.substring(0,1) == "#"){
			theBkgdColor = theBkgdColor.substring(1,theBkgdColor.length)
		}
		bkgdColor = theBkgdColor
		tptBkgd_param = "";
		tptBkgd_embed = "";
	}
	if(thePlaylist){
		if(getExtension(thePlaylist) == "xml"){
			writePlaylist = "&forceXMLplaylist=yes&wimpyApp="+thePlaylist;
		} else {
			writePlaylist = "&playlist="+thePlaylist;
		}
	} else {
		writePlaylist = "";
	}
	if(wimpyConfigFile.length > 4){
		altString = '&wimpyConfigs='+wimpyConfigFile;
	} else {
		altString = "&"+myConfigs;
	}
	//
	myuid = new Date().getTime();
	wimpyProxy = new FlashProxy(myuid, wimpySwf);
	js2wimpy_param = '<param name="flashvars" value="lcId='+myuid+'"/>'+newlineChar;
	js2wimpy_embed = 'flashvars="lcId='+myuid+'" ';
	//
	queryString = wimpySwf +'?x='+randNum+altString+writePlaylist;
	//
	flashCode += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version='+flashVersion+'" width="'+theWidth+'" height="'+theHeight+'" name="wimpy'+randNum+'" id="wimpy'+randNum+'">'+newlineChar;
	flashCode += '<param name="movie" value="'+queryString+'" />'+newlineChar;
	flashCode += '<param name="loop" value="false" />'+newlineChar;
	flashCode += '<param name="menu" value="false" />'+newlineChar;
	flashCode += '<param name="quality" value="high" />'+newlineChar;
	flashCode += '<param name="scale" value="noscale" />'+newlineChar;
	flashCode += '<param name="salign" value="lt" />'+newlineChar;
	flashCode += '<param name="bgcolor" value="'+bkgdColor+'" />'+newlineChar;
	flashCode += tptBkgd_param;
	flashCode += js2wimpy_param;
	flashCode += '<embed src="'+queryString+'" width="'+theWidth+'" height="'+theHeight+'" bgcolor="'+bkgdColor+'" loop="false" menu="false" quality="high" scale="noscale" salign="lt" name="wimpy'+randNum+'" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" '+tptBkgd_embed+js2wimpy_embed+'/></object>'+newlineChar;
	document.write(flashCode);
	// Uncomment to trouble shoot the HTML code.
	//document.write('<div id="seeCode"><textarea name="textarea" id="textarea" cols="120" rows="15" wrap="VIRTUAL">'+flashCode+'</textarea></div>');
}

function getExtension(theFilename){
	return unescape(theFilename).split("/").pop().split(".").pop().toLowerCase();
}
function wimpy_play(){
	wimpyProxy.call('js_wimpy_play');
}
function wimpy_stop(){
	wimpyProxy.call('js_wimpy_stop');
}
function wimpy_pause(){
	wimpyProxy.call('js_wimpy_pause');
}
function wimpy_next(){
	wimpyProxy.call('js_wimpy_next');
}
function wimpy_prev(){
	wimpyProxy.call('js_wimpy_prev');
}
function wimpy_gotoTrack(trackNumber){
	wimpyProxy.call('js_wimpy_gotoTrack', trackNumber);
}
function wimpy_clearPlaylist(){
	wimpyProxy.call('js_wimpy_clearPlaylist');
}
function wimpy_appendPlaylist(trackOrPlaylist, theFile, theArtist, theTitle, theHyperlink, theGraphic){
	wimpyProxy.call('js_wimpy_appendPlaylist', trackOrPlaylist, theFile, theArtist, theTitle, theHyperlink, theGraphic);
}
function wimpy_loadAndPlay(theFile, theArtist, theTitle, theHyperlink, theGraphic){
	wimpyProxy.call('js_wimpy_loadAndPlay', theFile, theArtist, theTitle, theHyperlink, theGraphic);
}
function wimpy_appendMultipleTracks(theFileList, theGroupTitle, theHyperlink, theGraphic){
	wimpyProxy.call('js_wimpy_appendMultipleTracks', theFileList, theGroupTitle, theHyperlink, theGraphic);
}
// These functions return an array, and require you to use js_wimpy_returnOnComplete. 
function wimpy_getTrackInfo(){
	wimpyProxy.call('js_wimpy_getTrackInfo');
}
function wimpy_returnPlaylistItem(trackNumber){
	wimpyProxy.call('js_wimpy_returnPlaylistItem', trackNumber);
}


/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////
/*
The following code is part of the Flash / JavaScript Integration Kit:
http://www.macromedia.com/go/flashjavascript/
*/
function Exception(name, message){
    if (name)
        this.name = name;
    if (message)
        this.message = message;
}
Exception.prototype.setName = function(name){
    this.name = name;
}
Exception.prototype.getName = function(){
    return this.name;
}
Exception.prototype.setMessage = function(msg){
    this.message = msg;
}
Exception.prototype.getMessage = function(){
    return this.message;
}
function FlashProxy(uid, proxySwfName){
    this.uid = uid;
    this.proxySwfName = proxySwfName;
    this.flashSerializer = new FlashSerializer(false);
}
FlashProxy.prototype.call = function(){
    if (arguments.length == 0)
    {
        throw new Exception("Flash Proxy Exception",
                            "The first argument should be the function name followed by any number of additional arguments.");
    }
    var qs = 'lcId=' + escape(this.uid) + '&functionName=' + escape(arguments[0]);
    if (arguments.length > 1)
    {
        var justArgs = new Array();
        for (var i = 1; i < arguments.length; ++i)
        {
            justArgs.push(arguments[i]);
        }
        qs += ('&' + this.flashSerializer.serialize(justArgs));
    }
    var divName = '_flash_proxy_' + this.uid;
    if(!document.getElementById(divName))
    {
        var newTarget = document.createElement("div");
        newTarget.id = divName;
        document.body.appendChild(newTarget);
    }
    var target = document.getElementById(divName);
    var ft = new FlashTag(this.proxySwfName, 1, 1);
    ft.setVersion('6,0,65,0');
    ft.setFlashvars(qs);
    target.innerHTML = ft.toString();
	//document.getElementById("textarea").value = divName;
}
FlashProxy.callJS = function(){
    var functionToCall = eval(arguments[0]);
    var argArray = new Array();
    for (var i = 1; i < arguments.length; ++i)
    {
        argArray.push(arguments[i]);
    }
    functionToCall.apply(functionToCall, argArray);
}
function FlashSerializer(useCdata){
    this.useCdata = useCdata;
}
FlashSerializer.prototype.serialize = function(args){
    var qs = new String();

    for (var i = 0; i < args.length; ++i)
    {
        switch(typeof(args[i]))
        {
            case 'undefined':
                qs += 't'+(i)+'=undf';
                break;
            case 'string':
                qs += 't'+(i)+'=str&d'+(i)+'='+escape(args[i]);
                break;
            case 'number':
                qs += 't'+(i)+'=num&d'+(i)+'='+escape(args[i]);
                break;
            case 'boolean':
                qs += 't'+(i)+'=bool&d'+(i)+'='+escape(args[i]);
                break;
            case 'object':
                if (args[i] == null)
                {
                    qs += 't'+(i)+'=null';
                }
                else if (args[i] instanceof Date)
                {
                    qs += 't'+(i)+'=date&d'+(i)+'='+escape(args[i].getTime());
                }
                else // array or object
                {
                    try
                    {
                        qs += 't'+(i)+'=xser&d'+(i)+'='+escape(this._serializeXML(args[i]));
                    }
                    catch (exception)
                    {
                        throw new Exception("FlashSerializationException",
                                            "The following error occurred during complex object serialization: " + exception.getMessage());
                    }
                }
                break;
            default:
                throw new Exception("FlashSerializationException",
                                    "You can only serialize strings, numbers, booleans, dates, objects, arrays, nulls, and undefined.");
        }

        if (i != (args.length - 1))
        {
            qs += '&';
        }
    }

    return qs;
}
FlashSerializer.prototype._serializeXML = function(obj){
    var doc = new Object();
    doc.xml = '<fp>'; 
    this._serializeNode(obj, doc, null);
    doc.xml += '</fp>'; 
    return doc.xml;
}
FlashSerializer.prototype._serializeNode = function(obj, doc, name){
    switch(typeof(obj))
    {
        case 'undefined':
            doc.xml += '<undf'+this._addName(name)+'/>';
            break;
        case 'string':
            doc.xml += '<str'+this._addName(name)+'>'+this._escapeXml(obj)+'</str>';
            break;
        case 'number':
            doc.xml += '<num'+this._addName(name)+'>'+obj+'</num>';
            break;
        case 'boolean':
            doc.xml += '<bool'+this._addName(name)+' val="'+obj+'"/>';
            break;
        case 'object':
            if (obj == null)
            {
                doc.xml += '<null'+this._addName(name)+'/>';
            }
            else if (obj instanceof Date)
            {
                doc.xml += '<date'+this._addName(name)+'>'+obj.getTime()+'</date>';
            }
            else if (obj instanceof Array)
            {
                doc.xml += '<array'+this._addName(name)+'>';
                for (var i = 0; i < obj.length; ++i)
                {
                    this._serializeNode(obj[i], doc, null);
                }
                doc.xml += '</array>';
            }
            else
            {
                doc.xml += '<obj'+this._addName(name)+'>';
                for (var n in obj)
                {
                    if (typeof(obj[n]) == 'function')
                        continue;
                    this._serializeNode(obj[n], doc, n);
                }
                doc.xml += '</obj>';
            }
            break;
        default:
            throw new Exception("FlashSerializationException",
                                "You can only serialize strings, numbers, booleans, objects, dates, arrays, nulls and undefined");
            break;
    }
}
FlashSerializer.prototype._addName= function(name){
    if (name != null)
    {
        return ' name="'+name+'"';
    }
    return '';
}
FlashSerializer.prototype._escapeXml = function(str){
    if (this.useCdata)
        return '<![CDATA['+str+']]>';
    else
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;');
}
function FlashTag(src, width, height){
    this.src       = src;
    this.width     = width;
    this.height    = height;
    this.version   = '7,0,14,0';
    this.id        = null;
    this.bgcolor   = 'ffffff';
    this.flashVars = null;
}
FlashTag.prototype.setVersion = function(v){
    this.version = v;
}
FlashTag.prototype.setId = function(id){
    this.id = id;
}
FlashTag.prototype.setBgcolor = function(bgc){
    this.bgcolor = bgc;
}
FlashTag.prototype.setFlashvars = function(fv){
    this.flashVars = fv;
}
FlashTag.prototype.toString = function(){
    var ie = (navigator.appName.indexOf ("Microsoft") != -1) ? 1 : 0;
    var flashTag = new String();
    if (ie)
    {
        flashTag += '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ';
        if (this.id != null)
        {
            flashTag += 'id="'+this.id+'" ';
        }
        flashTag += 'codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version='+this.version+'" ';
        flashTag += 'width="'+this.width+'" ';
        flashTag += 'height="'+this.height+'">';
        flashTag += '<param name="movie" value="'+this.src+'"/>';
        flashTag += '<param name="quality" value="high"/>';
        flashTag += '<param name="bgcolor" value="#'+this.bgcolor+'"/>';
        if (this.flashVars != null)
        {
            flashTag += '<param name="flashvars" value="'+this.flashVars+'"/>';
        }
        flashTag += '</object>';
    }
    else
    {
        flashTag += '<embed src="'+this.src+'" ';
        flashTag += 'quality="high" '; 
        flashTag += 'bgcolor="#'+this.bgcolor+'" ';
        flashTag += 'width="'+this.width+'" ';
        flashTag += 'height="'+this.height+'" ';
        flashTag += 'type="application/x-shockwave-flash" ';
        if (this.flashVars != null)
        {
            flashTag += 'flashvars="'+this.flashVars+'" ';
        }
        if (this.id != null)
        {
            flashTag += 'name="'+this.id+'" ';
        }
        flashTag += 'pluginspage="http://www.macromedia.com/go/getflashplayer">';
        flashTag += '</embed>';
    }
    return flashTag;
}
FlashTag.prototype.write = function(doc){
    doc.write(this.toString());
}
