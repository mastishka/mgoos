var TSR = function()
{
	var timerHandle ;
	var recordFound ;
	var queryStr ;
	var curPage ;
	var ext ;
	var strict = 0 ;
	var feature_type = 0; /* 1 = load popular,2= browse album, 3= last week popular, 4 = recent uploads */
	var loadpop = 0 ;
	var browse_album = 0 ;
	var bSendToFriend = false ;
	var bReportAbuse = false ;
	var url;
	
	return {
		UpdateResults : function() 
		{
			//alert(parent.SR.isLoaded());
			if(!parent.SR.isLoaded())
			{
				//alert('test continue') ;
				clearInterval(this.timerHandle) ;
				this.timerHandle = setInterval("TSR.UpdateResults()", 100) ;
			}
			else
			{
				//alert('test finish') ;
				clearInterval(this.timerHandle) ;
			}
			
			parent.SR.searchTxt = this.queryStr ;
			parent.SR.curPage = this.curPage ;
			parent.SR.ext = this.ext;
			
			
			
			//parent.document.SEARCH_BAR_TOP.srchtxt.value = this.queryStr;
			//parent.document.SEARCH_BAR_BOT.srchtxt.value = this.queryStr;
			
			var pageListingTDTop = parent.document.getElementById('RESULT_NAV_TOP') ;
			var resultDescriptionTop = parent.document.getElementById('RESULT_DESCRP_TOP') ;
			var search_result_link;// = "iframe_pages/tab_search_results.php?qry="+ this.queryStr+"&pg="+this.curPage+"&ext="+this.ext;
			var resultDescription = '';
			var pageDescription = '';
			
			if(this.feature_type ==1)
			{
				pageDescription = 'Found <B>'+this.recordFound+'</B> files while searching <B>All Time Popular</B>.' ;
				search_result_link = "iframe_pages/tab_search_results.php?loadpop=true&pg="+this.curPage;
			}
			else if(this.feature_type ==2)
			{
				pageDescription = 'Found <B>'+this.recordFound+'</B> albums starts with letter <B>'+this.curPage.toUpperCase()+'</B>.' ;
			}
			else if(this.feature_type ==3)
			{				
				pageDescription = 'Found <B>'+this.recordFound+'</B> audios while searching <B>Last Week Popular</B>.' ;
				search_result_link = "iframe_pages/tab_search_results.php?last_week_pop=true&pg="+this.curPage;
			}
			else if(this.feature_type ==4)
			{
				pageDescription = 'Found <B>'+this.recordFound+'</B> albums while searching through <B>Recent Uploads</B>.' ;
				search_result_link = "iframe_pages/tab_search_results.php?recent_uploads=true&pg="+this.curPage;
			}
			else if(this.feature_type ==5)
			{
				pageDescription = 'Currently <B>'+this.recordFound+'</B> in <B>Radio Playlist</B>.' ;
				search_result_link = "iframe_pages/radio_search_results.php?radio_playlist=true&pg="+this.curPage;
			}
			else
			{
				pageDescription = 'Found <B>'+this.recordFound+'</B> files while searching <B>'+this.ext+': '+this.queryStr+'</B>.' ;
				search_result_link =  "iframe_pages/tab_search_results.php?qry="+this.queryStr+"&pg="+this.curPage+"&ext="+this.ext;//"iframe_pages/tab_search_results.php?qry="+this.queryStr+"&pg="+this.curPage+"&ext="+this.ext;
			}
			
			resultDescription = '<B><EM>Results - </EM>&nbsp;&nbsp;'		
						
			if(this.feature_type == 2)
			{
				for(i = 65; i < 91; i++)
				{
					if(this.curPage.toUpperCase() != String.fromCharCode(i))
					{
						resultDescription += ' <A HREF="iframe_pages/tab_search_results.php?browse_album=true&pg='+String.fromCharCode(i)+'" TARGET="SEARCH_RESULTS">'+ String.fromCharCode(i) +'</A>&nbsp;';
					}
					else
					{
						resultDescription += ' &nbsp;' + String.fromCharCode(i) + '&nbsp;';
						search_result_link = "iframe_pages/tab_search_results.php?browse_album=true&pg="+ String.fromCharCode(i);
					}
				}
			}
			else
			{ 
			  resultDescription =   this.PreparePaging(this.url);			
			}
			pageListingTDTop.innerHTML = resultDescription ;			
			resultDescriptionTop.innerHTML = pageDescription ;			
			
			
			if(parent.document.getElementById("TOP_TAB_BAR"))
			{
				if(this.feature_type == 1 ||this.feature_type == 2 ||this.feature_type == 3 ||this.feature_type == 4 )
				{
					parent.document.getElementById("TOP_TAB_BAR").innerHTML="<A HREF= "+ search_result_link +" TARGET=\"SEARCH_RESULTS\">Search Results</A>&nbsp;&nbsp;<A HREF=\"iframe_pages/tab_manage_aud.php\" TARGET=\"SEARCH_RESULTS\">Manage Audio</A>&nbsp;&nbsp;<A HREF=\"iframe_pages/tab_points.php\" TARGET=\"SEARCH_RESULTS\">My Points</A>&nbsp;&nbsp;<A HREF=\"iframe_pages/tab_profile.php\" TARGET=\"SEARCH_RESULTS\">My Profile</A>&nbsp;&nbsp;<A HREF=\"iframe_pages/tab_suggest.php\" TARGET=\"SEARCH_RESULTS\">Suggest</A>" ;
				}
				else
				{
					parent.document.getElementById("TOP_TAB_BAR").innerHTML="<A HREF=\"iframe_pages/tab_search_results.php?qry="+this.queryStr+"&pg="+this.curPage+"&ext="+this.ext+"\" TARGET=\"SEARCH_RESULTS\">Search Results</A>&nbsp;&nbsp;<A HREF=\"iframe_pages/tab_manage_aud.php\" TARGET=\"SEARCH_RESULTS\">Manage Audio</A>&nbsp;&nbsp;<A HREF=\"iframe_pages/tab_points.php\" TARGET=\"SEARCH_RESULTS\">My Points</A>&nbsp;&nbsp;<A HREF=\"iframe_pages/tab_profile.php\" TARGET=\"SEARCH_RESULTS\">My Profile</A>&nbsp;&nbsp;<A HREF=\"iframe_pages/tab_suggest.php\" TARGET=\"SEARCH_RESULTS\">Suggest</A>" ;
				}
			}									
		},
		OnDownload : function(filepath, title)
		{
			//var filepath = "Saaiyaan.mp3" ;
			//var title = "Saaiyaan" ;
			//alert(encodeURI("download.php?title="+title+"&filepath="+filepath)) ;
			var w = 480, h = 340;

			if (document.all || document.layers) 
			{
				w = screen.availWidth;
				h = screen.availHeight;
			}
			
			var popW = 300, popH = 200 ;
			
			var leftPos = (w-popW)/2, topPos = (h-popH)/2 ;
			
			window.open(encodeURI("download.php?title="+title+"&filepath="+filepath), "Download", "toolbar=0, status=0, menubar=0, resizable=0, scrollbars=0, width=1, height=1, top="+topPos+", left="+leftPos) ;
		},
		CheckForParent : function()
		{
			if(window.parent.frames.length == 0)
			{
				startIndex = location.pathname.lastIndexOf("/") ;
				endIndex = location.pathname.lastIndexOf(".") ;
				subStr = location.pathname.substring(startIndex+1, endIndex) ;
				
				if(subStr == "tab_search_results")
				{
					startIndex = location.search.search("qry") ;
					subStr = location.search.substring(startIndex+4) ;
					endIndex = subStr.indexOf("&") ;
					
					qry = subStr.substring(0, endIndex) ;

					startIndex = location.search.search("ext") ;
					ext = location.search.substring(startIndex+4) ;
					
					location = "http://www.mgoos.com/search_results.php?srchtxt="+qry+"&ext="+ext ;
				}
			}

			return false;
		},
		CheckBeforeUpdateId3 : function() 
		{
			var ext = document.SHARE_FORM.MP3.value;
			ext = ext.substring(ext.length-3,ext.length);
			ext = ext.toLowerCase();
			if(ext != 'mp3') 
			{
				alert('You selected a .'+ext+
				  ' file; please select a .mp3 file instead!');
				return false; 
			}
			else
			{
				document.SHARE_FORM.submit() ;
				return true; 
			}
		},
		OnBookmark : function(entryIndex)
		{
			var objSTF = document.getElementById("STF_SPAN_"+entryIndex) ;
			//objSTF.innerHTML = "<IMG SRC='../images/updating.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Sending'>";
			
			var poststr = "listing_index=" + entryIndex +
						  "&aud_id=" + encodeURI( document.getElementById('STF_AUD_ID_'+entryIndex).value );
			
			// Initialize Ajax
			//alert(poststr);
			AJAX.MakePostRequest("../ajax/tsr_add_to_bookmarks.php", poststr, this.CallBack_AddToBookmark);
		},
		OnBtnClkSend : function(entryIndex,objbtn)
		{
			//alert(entryIndex);
			var objDivStyle = document.getElementById('STF_' + entryIndex).style;
			
			if (objDivStyle.display == 'block') 
			{														
				var objSTF = document.getElementById("STF_SPAN_"+entryIndex) ;
				//objSTF.innerHTML = "<IMG SRC='../images/updating.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Sending'>";
				
				var poststr = "user_name=" + encodeURI( document.getElementById('STF_NAME_'+entryIndex).value ) +
							  "&user_email=" + encodeURI( document.getElementById('STF_USER_EMAIL_'+entryIndex).value ) +
							  "&friend_name=" + encodeURI( document.getElementById('STF_FRIEND_NAME_'+entryIndex).value ) +
							  "&friend_email=" + encodeURI( document.getElementById('STF_FRIEND_EMAIL_'+entryIndex).value ) +
							  "&listing_index=" + entryIndex +
							  "&aud_id=" + encodeURI(document.getElementById('STF_AUD_ID_'+entryIndex).value );
				
				// Show Progress Indicator...
				var objSTF = document.getElementById("STF_SPAN_"+entryIndex) ;
				objSTF.innerHTML = "<BR/><IMG SRC=\"../images/updating.gif\" WIDTH=\"16\" HEIGHT=\"16\" BORDER=\"0\">&nbsp;&nbsp;Sending please wait..." ;
				
				// Initialize Ajax
				//alert(poststr);
				AJAX.MakePostRequest("../ajax/tsr_mail_to_friend.php", poststr, this.CallBack_SendToFriend);
			}
			
			// Mask it.
			return false;
		},
		OnBtnClkReport : function(entryIndex)
		{
			//alert(entryIndex);
			var objDivStyle = document.getElementById('REPORT_ABUSE_' + entryIndex).style;
			
			if (objDivStyle.display == 'block') 
			{
				var objRAS = document.getElementById("REPORT_ABUSE_SPAN_"+eval(response_json.nListingIndex));
				//objRAS.innerHTML = "<IMG SRC='../images/updating.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT='Reporting'><BR/>";
				
				var poststr = "name=" + encodeURI( document.getElementById("REPORT_ABUSE_NAME_"+entryIndex).value ) +
							  "&email=" + encodeURI( document.getElementById("REPORT_ABUSE_EMAIL_"+entryIndex).value ) +
							  "&abuse_type=" + encodeURI( document.getElementById("REPORT_ABUSE_OPTION_"+entryIndex).value ) + 
							  "&listing_index=" + entryIndex +
							  "&aud_id=" + encodeURI( document.getElementById("REPORT_ABUSE_AUD_ID_"+entryIndex).value );
				//alert(poststr);
				// Initialize Ajax
				AJAX.MakePostRequest("../ajax/tsr_report_abuse.php", poststr, this.CallBack_ReportAbuse);
			}
			
			// Mask it.
			return false;
		},
		Captcha : function(entryIndex)
		{
			//alert("hey");
			//var captcha_id = document.getElementById('Download_Captcha_'+entryIndex);
			var show_captcha_id = document.getElementById('Show_Captcha_'+entryIndex);
			var show_captcha_display_id = document.getElementById('Show_Captcha_'+entryIndex).style;
			show_captcha_display_id.display = 'block';
			//alert("hi");
			this.refreshCaptcha(entryIndex);
		},
		refreshCaptcha : function(entryIndex)
		{
			var img = document.images['captchaimg'+entryIndex];
			img.src = img.src.substring(0,img.src.lastIndexOf('?'))+'?rand='+Math.random()*1000;
		},
		OnSendToFriend : function(entryIndex)
		{
			//alert(arguments.length) ;
			var objUpdtLnk = document.getElementById('LISTING_LINK_'+entryIndex) ;
			
			var objDivStyleSTF = document.getElementById('STF_' + entryIndex).style;
			var objDivStyleRA  = document.getElementById('REPORT_ABUSE_' + entryIndex).style;
			
			if (objDivStyleSTF.display == 'none') 
			{
				this.bSendToFriend = true ;
				if(parent.SR.bLoggedIn)
				{
					objUpdtLnk.innerHTML = "Send to friend&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark("+entryIndex+")\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse("+entryIndex+")\">Report Abuse</A>";
				}
				else
				{
					objUpdtLnk.innerHTML = "Send to friend&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse("+entryIndex+")\">Report Abuse</A>";
				}
				
				//alert(parent.SR.selfName);
				if(parent.SR.selfName && parent.SR.selfEmail)
				{
					document.getElementById("STF_NAME_"+entryIndex).value = parent.SR.selfName ;
					document.getElementById("STF_USER_EMAIL_"+entryIndex).value = parent.SR.selfEmail ;
				}
				
				objDivStyleRA.display = 'none';
				objDivStyleSTF.display = 'block';
			}
			else
			{
				this.bSendToFriend = false ;
				if(parent.SR.bLoggedIn)
				{
					objUpdtLnk.innerHTML = "<A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('"+entryIndex+"');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark("+entryIndex+")\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse("+entryIndex+")\">Report Abuse</A>";
				}
				else
				{
					objUpdtLnk.innerHTML = "<A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('"+entryIndex+"');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse("+entryIndex+")\">Report Abuse</A>";
				}
				objDivStyleSTF.display = 'none';
				
				var aud_id = "" ;
				var selfName = "" ;
				var selfEmail = "" ;
				if(arguments.length > 1)
				{
					selfName = arguments[1] ;
					selfEmail = arguments[2] ;
					//alert(parent.SR.selfName);
					aud_id = arguments[3] ;
				}
				this.ShowUserSTF(entryIndex, selfName, selfEmail, aud_id) ;
			}
		},
		OnReportAbuse : function(entryIndex)
		{
			//alert(divIndex) ;
			var objUpdtLnk = document.getElementById('LISTING_LINK_'+entryIndex) ;
			
			var objDivStyleSTF = document.getElementById('STF_' + entryIndex).style;
			var objDivStyleRA  = document.getElementById('REPORT_ABUSE_' + entryIndex).style;
			
			if (objDivStyleRA.display == 'none') 
			{
				this.bReportAbuse = true ;
				if(parent.SR.bLoggedIn)
				{
					objUpdtLnk.innerHTML = "<A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('"+entryIndex+"');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark("+entryIndex+")\">Add to bookmarks</A>&nbsp;|&nbsp;Report Abuse";
				}
				else
				{
					objUpdtLnk.innerHTML = "<A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('"+entryIndex+"');\">Send to friend</A>&nbsp;|&nbsp;Report Abuse";
				}
				
				objDivStyleSTF.display = 'none';
				objDivStyleRA.display = 'block';
			}
			else
			{
				this.bReportAbuse = false ;
				if(parent.SR.bLoggedIn)
				{
					objUpdtLnk.innerHTML = "<A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('"+entryIndex+"');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark("+entryIndex+")\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse("+entryIndex+")\">Report Abuse</A>";
				}
				else
				{
					objUpdtLnk.innerHTML = "<A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('"+entryIndex+"');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse("+entryIndex+")\">Report Abuse</A>";
				}
				objDivStyleRA.display = 'none';
			}
		},
		ShowUserSTF : function(entryIndex, selfName, selfEmail, aud_id)
		{
			if(parent.SR.selfName == undefined && parent.SR.selfEmail == undefined)
			{
				parent.SR.selfName = selfName ;
				parent.SR.selfEmail = selfEmail ;
			}
			
			var objSTF = document.getElementById("STF_SPAN_"+entryIndex) ;
			objSTF.innerHTML = "<FORM NAME='UPDT_FORM_"+entryIndex+"' METHOD='POST' ACTION=''><TABLE><TR><TD>Your Name: </TD><TD><INPUT TYPE='text' ID='STF_NAME_"+entryIndex+"' NAME='name' VALUE='"+selfName+"' SIZE='40'  onBlur='TSR.CheckEmpty('"+ entryIndex+ "')' /><BR/></TD></TR><TR><TD>Your Email: </TD><TD><INPUT TYPE='text' ID='STF_USER_EMAIL_"+entryIndex+"' NAME='email' VALUE='"+selfEmail+"' SIZE='50' onBlur='TSR.CheckEmpty('"+ entryIndex+ "')'/><BR/></TD></TR><TR><TD>Friend's Name: </TD><TD><INPUT TYPE='text' ID='STF_FRIEND_NAME_"+entryIndex+"' NAME='fname' VALUE='' SIZE='40' onBlur='TSR.CheckEmpty('"+ entryIndex+ "')'/><BR/></TD></TR><TR><TD>Friend's Email: </TD><TD><INPUT TYPE='text' ID='STF_FRIEND_EMAIL_"+entryIndex+"' NAME='femail' VALUE='' SIZE='50' onBlur='TSR.CheckEmpty('"+ entryIndex+ "')'/><BR/></TD></TR></TABLE><INPUT TYPE='hidden' ID='STF_AUD_ID_"+entryIndex+"' NAME='aud_id' VALUE='"+aud_id+"'/><BR/><INPUT TYPE='button' disabled = \"true\" onClick=\"TSR.OnBtnClkSend('"+entryIndex+"',this);\" VALUE='Send' ID = 'STF_SEND_'"+entryIndex +"'/>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnSendToFriend('"+entryIndex+"');\" VALUE='Cancel'/></FORM></FIELDSET></SPAN></DIV>" ;
		},
		CallBack_SendToFriend : function()
		{
			var contents = AJAX.GetContents() ;
			//alert(contents) ;
			if(contents != false)
			{
				var response_json = eval('(' + contents + ')') ;
				
				if(response_json.result.bResult == true)
				{
					//alert(contents) ;
					var objDivStyle = eval('document.all.STF_' + response_json.result.nListingIndex + '.style');
					if (objDivStyle.display == 'block') 
					{
						var objSTF = document.getElementById("STF_SPAN_"+eval(response_json.result.nListingIndex)) ;
						objSTF.innerHTML = "Mail invite for audio <B>"+response_json.result.szTitle+"</B> has successfully sent to <B>"+response_json.result.szFriendName+"</B>. <BR/><BR/><INPUT TYPE='button' onClick=\"TSR.ShowUserSTF('" + response_json.result.nListingIndex + "','" + response_json.result.szUserName + "','" + response_json.result.szUserEmail + "','" + response_json.result.szAudId + "');\" VALUE='Send Another...'/>&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnSendToFriend('" + response_json.result.nListingIndex + "','" + response_json.result.szUserName + "','" + response_json.result.szUserEmail + "','" + response_json.result.szAudId + "');\" VALUE='Hide'/>" ;
					}
				}
			}
		},
		CallBack_ReportAbuse : function()
		{
			var contents = AJAX.GetContents() ;
			//alert(contents) ;
			if(contents != false)
			{
				var response_json = eval('(' + contents + ')') ;
				//alert(contents) ;
				if(response_json.result.bResult == true)
				{
					var objDivStyle = eval('document.all.REPORT_ABUSE_' + response_json.result.nListingIndex + '.style');
					if (objDivStyle.display == 'block') 
					{
						var objRAS = document.getElementById("REPORT_ABUSE_SPAN_"+response_json.result.nListingIndex) ;
						objRAS.innerHTML = "<INPUT TYPE='button' onClick=\"TSR.OnReportAbuse('%d');\" VALUE='Hide'/>" ;
					}
				}
			}
		},
		CallBack_AddToBookmark : function()
		{
			var contents = AJAX.GetContents() ;
			//alert(contents) ;
			if(contents != false)
			{
				var response_json = eval('(' + contents + ')') ;
				//alert(contents) ;
				if(response_json.result.bResult == true)
				{
					var objUpdtLnk = document.getElementById('LISTING_LINK_'+response_json.result.nListingIndex) ;
					objUpdtLnk.innerHTML = "<A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('"+response_json.result.nListingIndex+"');\">Send to friend</A>&nbsp;|&nbsp;<B>Added to Bookmarks!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse("+response_json.result.nListingIndex+")\">Report Abuse</A>";
				}
			}
		},		
		OnLoadAlbum : function(albumname)
		{
			var poststr = "qry=" + albumname;				
			AJAX.MakePostRequest("../ajax/sr_load_album.php", poststr, this.CallBack_LoadAlbum);
		},
        CallBack_LoadAlbum :function()
		{
			/*var tempid;
			var temptitle;
			this.tempid = new Array() ;
			this.temptitle = new Array() ;*/
			var contents = AJAX.GetContents();
			if(contents != false)
			{
				var response_json = eval('(' + contents + ')') ;
				//var objDiv = document.getElementById("DIV_SAV_PL_MSG") ;
				if(response_json.result.bResult == true)
				{
					if(parent.parent.SR.playlist_id_ary == undefined && parent.parent.playlist_title_ary == undefined)
					{
						parent.parent.SR.playlist_id_ary = new Array() ;
						parent.parent.SR.playlist_title_ary = new Array() ;
					}
					//parent.parent.SR.playlist_id_ary = response_json.result.album_songid_list.split(";");						
					//parent.parent.SR.playlist_title_ary = response_json.result.album_songtitle_list.split(";") ;
					//alert(response_json.result.album_songtitle_list);
					parent.parent.SR.playlist_id_ary.push(response_json.result.album_songid_list.split(";"));						
					parent.parent.SR.playlist_title_ary.push(response_json.result.album_songtitle_list.split(";"));
					//tempid = 
					//alert(parent.parent.SR.playlist_title_ary);
					parent.parent.SR.playlist_id_ary = (parent.parent.SR.playlist_id_ary.toString()).split(",");
					parent.parent.SR.playlist_title_ary = (parent.parent.SR.playlist_title_ary.toString()).split(",");
					//alert(parent.parent.SR.playlist_title_ary);
					//parent.parent.wimpy_clearPlaylist();
					//parent.parent.EP_clearPlaylist('ep_player1');
					
					parent.parent.document.getElementById("SAV_PLY_LST").disabled = false ;
					parent.parent.document.getElementById("CLR_PLY_LST").disabled = false ;
					parent.parent.document.getElementById("PLAYLIST").disabled    = false ;
					var objSelOpt = parent.parent.document.getElementById("PLAYLIST");
					for(var i = (objSelOpt.length-2); i < parent.parent.SR.playlist_id_ary.length; i++)
					{
						var objSelOpt = parent.parent.document.getElementById("PLAYLIST");
						var optNode = parent.parent.document.createElement("option");
						var optAttrib = parent.parent.document.createAttribute("value") ;
						var optVal = parent.parent.document.createTextNode(parent.parent.SR.playlist_title_ary[i]);							
						optNode.setAttribute('value', parent.parent.SR.playlist_id_ary[i]);
						optNode.appendChild(optVal);
						objSelOpt.appendChild(optNode);
						parent.parent.EP_addTracks("ep_player1", "<track><location>load_aud.php?id="+parent.parent.SR.playlist_id_ary[i]+"</location><title>"+parent.parent.SR.playlist_title_ary[i]+"</title></track>", 999);
					}
					parent.parent.EP_play('ep_player1');
				}
			}
		},			
		ToggleDiv:function(linkid)
		{
			var split_id_ary = new Array();
			split_id_ary = linkid.split("_");
			var numpart = split_id_ary[0];
			var operationpart = split_id_ary[1];
			var divelem = document.getElementById("div_details" + numpart);			
            var linkelem = 	document.getElementById(numpart + "_open");
			if(operationpart == "open")
			{
			 divelem.style.display ="inline";
			 linkelem.style.display ="none";
			}
			else if(operationpart == "close")
			{
 			 divelem.style.display ="none";
			 linkelem.style.display ="inline";
			}
		},
		PreparePaging:function(link)
		{		
			    var pageno = this.curPage;
			    var row_count = this.recordFound;
				var resultDescription = '';			
				var page_count = Math.ceil(row_count/10);
				var remainder =  pageno%20;
				
				if(remainder == 0)
				{
					remainder++;
				}
				
				var startoffset =  Math.floor(pageno/20)*remainder;							
				var endoffset =  Math.floor(pageno/20)*(remainder)  + 20;
				if(startoffset > 0)
				{
					startoffset = (startoffset + (5 - (startoffset%5))) ; 
					endoffset = (endoffset + (5 - (endoffset%5))) ;  
				}
				if(endoffset >= page_count )
				{
					endoffset = page_count;
				}
				if(pageno >= page_count)
				{
					pageno = page_count;
				}				
				if(pageno -1  != startoffset)
				{
					var prevPage = pageno - 1;
					if(this.strict == 1)
					{
					resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?qry='+this.queryStr+'&pg='+ prevPage + '&ext=' + this.ext +'&strict=true" TARGET="SEARCH_RESULTS">&lt;Prev</A></B>';
					}					
					//else if(this.loadpop ==1)
					else if(this.feature_type ==1)
					{
						resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?loadpop=true&pg='+ prevPage + '" TARGET="SEARCH_RESULTS">&lt;Prev</A> </B>';				
					}
					else if(this.feature_type ==3)
					{
						resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?last_week_pop=true&pg='+ prevPage + '" TARGET="SEARCH_RESULTS">&lt;Prev</A> </B>';
					}
					else if(this.feature_type ==4)
					{
						resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?recent_uploads=true&pg='+ prevPage + '" TARGET="SEARCH_RESULTS">&lt;Prev</A> </B>';
					}	
					else if(this.feature_type == 5)
					{
						resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?radio_playlist=true&pg='+ prevPage + '" TARGET="SEARCH_RESULTS">&lt;Prev</A> </B>';
					}
					else 
					{
						resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?qry='+this.queryStr+'&pg='+ prevPage + '&ext=' + this.ext +'" TARGET="SEARCH_RESULTS">&lt;Prev</A> </B>';
					}
				}
				else 
				{
					resultDescription +='<B><A>&lt;Prev</A></B> ';					
				}
				for(var i = startoffset +1; i <= endoffset; i++)
				{
					if(pageno !=i)
					{
						if(this.strict == 1)
							{
							resultDescription += '<A onClick="SR.ShowLoading()" HREF="'+link+'?qry='+this.queryStr+'&pg='+ i + '&ext=' + this.ext +'&strict=true" TARGET="SEARCH_RESULTS">' +i+ '</A>';
							}
							//else if(this.loadpop ==1)
							else if(this.feature_type ==1)
							{
								resultDescription += ' <B><A onClick="SR.ShowLoading()" HREF="'+link+'?loadpop=true&pg='+ i +'" TARGET="SEARCH_RESULTS">' +i+ '</A></B>';
							}
							else if(this.feature_type==3)
							{
								resultDescription += ' <B><A onClick="SR.ShowLoading()" HREF="'+link+'?last_week_pop=true&pg='+ i +'" TARGET="SEARCH_RESULTS">' +i+ '</A></B>';
							}
							else if(this.feature_type ==4)
							{
								resultDescription += ' <B><A onClick="SR.ShowLoading()" HREF="'+link+'?recent_uploads=true&pg='+ i +'" TARGET="SEARCH_RESULTS">' +i+ '</A></B>';
							}					
							else if(this.feature_type == 5)
							{		
								resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?radio_playlist=true&pg='+ i + '" TARGET="SEARCH_RESULTS">' +i+ '</A> </B>';
							}
							else
							{
								resultDescription += ' <B><A onClick="SR.ShowLoading()" HREF="'+link+'?qry='+this.queryStr+'&pg='+ i + '&ext=' + this.ext +'" TARGET="SEARCH_RESULTS">' +i+ '</A></B>';
							}
					}
					else
					{
						resultDescription +=' <B><A>' +i+ '</A></B>';
					}
				}
				var nextPage = pageno*1 + 1;
				if(pageno != page_count)
				{					
					if(this.strict == 1)
					{
					resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?qry='+this.queryStr+'&pg='+ nextPage+ '&ext=' + this.ext +'&strict=true" TARGET="SEARCH_RESULTS">Next &gt;</A> </B>';
					}
					//else if(this.loadpop==1)
					else if(this.feature_type==1)
					{
						resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?loadpop=true&pg='+ nextPage+ '" TARGET="SEARCH_RESULTS">Next &gt;</A> </B>';
					}
					else if(this.feature_type==3)
					{
						resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?last_week_pop=true&pg='+ nextPage+ '" TARGET="SEARCH_RESULTS">Next &gt;</A> </B>';
					}
					else if(this.feature_type==4)
					{
						resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?recent_uploads=true&pg='+ nextPage+ '" TARGET="SEARCH_RESULTS">Next &gt;</A> </B>';
					}
					else if(this.feature_type==5)
					{
						resultDescription += '<B> <A onClick="SR.ShowLoading()" HREF="'+link+'?radio_playlist=true&pg='+ nextPage+ '" TARGET="SEARCH_RESULTS">Next &gt;</A> </B>';
					}
					else
					{
						resultDescription += ' <B> <A onClick="SR.ShowLoading()" HREF="'+link+'?qry='+this.queryStr+'&pg='+ nextPage + '&ext=' + this.ext +'" TARGET="SEARCH_RESULTS">Next &gt;</A> </B>';
					}
				}
				else
				{
					resultDescription += '<B> <A>Next &gt;</A> </B>';
				}			
			return resultDescription;
		},
		CheckEmpty:function(entryIndex)
		{
				var user_name = document.getElementById('STF_NAME_'+entryIndex).value;
				var user_email = document.getElementById('STF_USER_EMAIL_'+entryIndex).value;
				var friend_name = document.getElementById('STF_FRIEND_NAME_'+entryIndex).value;
				var friend_email = document.getElementById('STF_FRIEND_EMAIL_'+entryIndex).value;
				var objbtn = document.getElementById('STF_SEND_'+entryIndex);				
				if(user_name!=''&& user_email !='' && friend_name!='' && friend_email != '')
					objbtn.disabled = false;		
				else
				   objbtn.disabled = true;
		}	
	}
}();