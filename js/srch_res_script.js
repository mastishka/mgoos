var SR = function()
{
	var bLoaded = false ;
	var searchTxt ;
	var curPage ;
	var ext ;
	var bPlayerHasItem = false ;
	var bLoggedIn = false ;	
	var playlist_id_ary ;
	var playlist_title_ary ;
	var selfName = "" ;
	var selfEmail = "" ;
	var hLoadAud ;
	var playme_id ;
	var playme_title ;
	var bPlayerLoaded = false;
	
	return {
		Inititalize : function() 
		{
			if(form = document.getElementById("SEARCH_BAR_TOP"))
			{
				this.addEvent(form, "submit", this.submitSearchTop);
			}
			else
			{
				form1 = document.getElementById("SEARCH_BAR_TOP_RADIO") ;
				this.addEvent(form1, "submit", this.submitSearchTopRadio);
			}
		},
		addEvent : function(obj, evType, fn) 
		{
			if (obj.addEventListener)
			{
				obj.addEventListener(evType, fn, false);
				return true;
			}
			else if (obj.attachEvent)
			{
				var r = obj.attachEvent("on"+evType, fn);
				return r;
			}
			else
			{
				return false;
			}
		},
		LoadAud : function() 
		{
			//if(this.bPlayerLoaded)
			{
				//alert('Test ID: '+this.playme_id+', Title: '+this.playme_title) ;
				//alert("loadaud");
				clearInterval(this.hLoadAud);
				if(this.playme_id)
				{
					
					while(EP_isLoaded('ep_player1')=="not_loaded")
					{
						setTimeout("SR.LoadAud()",1500);
						return;
					}
					//alert("trackload");
					//wimpy_addTrack(false,"load_aud.php?id="+this.playme_id,'',this.playme_title, '', '');
					//EP_addTracks("ep_player1", "<track><location>load_aud.php?id="+this.playme_id+"</location><title>"+this.playme_title+"</title></track>", 999);
					this.AddToPlaylistUrl(this.playme_id,this.playme_title);
					this.playme_id = "";
					this.playme_title = "";
					//EP_play('ep_player1');
				}
			}
			/*else
			{
				//wimpy_clearPlaylist();
				EP_clearPlaylist('ep_player1');
			}*/
		},
		setLoaded : function()
		{
			this.bLoaded = true ;
			this.Inititalize() ;
			
			document.SEARCH_BAR_TOP.srchtxt.focus() ;
			if(this.searchTxt)
			{
				document.SEARCH_BAR_TOP.srchtxt.value = this.searchTxt ;
			}
		},
		isLoaded : function()
		{
			return this.bLoaded ;
		},
		submitSearchTop : function(e)
		{
			if (e && e.preventDefault)
			{
			    e.preventDefault(); // DOM style
			}
			
			var queryStrTop = document.SEARCH_BAR_TOP.srchtxt.value;
			var extTop = document.SEARCH_BAR_TOP.ext.value;
			var url = "iframe_pages/tab_search_results.php?qry="+queryStrTop+"&pg=1&ext="+extTop;
			//var url = "iframe_pages/radio_search_results.php?qry="+queryStrTop+"&pg=1&ext="+extTop;
			window.frames['SEARCH_RESULTS'].location = encodeURI(url) ;
			
			return false ;
		},
		submitSearchTopRadio : function(e)
		{
			if (e && e.preventDefault)
			{
			    e.preventDefault(); // DOM style
			}
			
			var queryStrTop = document.SEARCH_BAR_TOP_RADIO.srchtxt.value;
			var extTop = document.SEARCH_BAR_TOP_RADIO.ext.value;
			var url = "iframe_pages/radio_search_results.php?qry="+queryStrTop+"&pg=1&ext="+extTop;
			//var url = "iframe_pages/radio_search_results.php?qry="+queryStrTop+"&pg=1&ext="+extTop;
			window.frames['SEARCH_RESULTS'].location = encodeURI(url) ;
			
			return false ;
		},
		AddToPlaylistUrl : function(id, title)
		{	
			if(this.playlist_id_ary == undefined && this.playlist_title_ary == undefined)
			{
				this.playlist_id_ary = new Array() ;
				this.playlist_title_ary = new Array() ;
			}
			
			var bIdNotExists = (this.playlist_id_ary.join(";").search(id) == -1 );
			document.getElementById("SAV_PLY_LST").disabled = false ;
			document.getElementById("CLR_PLY_LST").disabled = false ;
			document.getElementById("PLAYLIST").disabled    = false ;
			
			//if(bIdNotExists)
			//{
				this.playlist_id_ary.push(id) ;
				this.playlist_title_ary.push(title) ;
				
				var objSelOpt = document.getElementById("PLAYLIST");
				var optNode = document.createElement("option");
				var optAttrib = document.createAttribute("value") ;
				var optVal = document.createTextNode(title);
				EP_addTracks("ep_player1", "<track><location>load_aud.php?id="+id+"</location><title>"+title+"</title></track>", 999);
				optNode.setAttribute('value', id);
				optNode.appendChild(optVal);
				objSelOpt.appendChild(optNode);
			//}
			//else
			//	alert(title+" song already in playlist");
			
			if(this.bPlayerHasItem && bIdNotExists)
			{
				EP_play('ep_player1');
				//alert("Playlist has an Item") ;
				//wimpy_addTrack(false,"load_aud.php?id="+id,'',title, '', '');
				//alert("<track><location>load_aud.php?id="+id+"</location><title>"+title+"</title><creator>Track</creator></track>");
				//EP_addTracks("ep_player1", "<track><location>load_aud.php?id="+id+"</location><title>"+title+"</title></track>", 999);
			}
			else
			{
				//alert("Playlist don't have an Item") ;
				//wimpy_addTrack(true,"load_aud.php?id="+id,'',title, '', '');
				EP_play('ep_player1');
				this.bPlayerHasItem = true ;
				//alert("<track><location>load_aud.php?id="+id+"</location><title>"+title+"</title><creator>Track</creator></track>");
				//EP_addTracks("ep_player1", "<track><location>load_aud.php?id="+id+"</location><title>"+title+"</title><</track>", 999);
			}
			
		},
		AddToRadioUrl : function(id, title)
		{
			var poststr = "id=" + id + "&title=" + title;
			AJAX.MakePostRequest("ajax/addtoradio.php", poststr, this.callback_radio_song_added);
		},
		callback_radio_song_added : function()
		{
			var contents = AJAX.GetContents() ;
			//alert (contents);
		},
		OnPlNameChange : function(obj)
		{
			var objBtn = document.getElementById("BTN_SAV_PLST") ;
			
			if(obj.value.length > 0)
			{
				objBtn.disabled = false ;
			}
			else
			{
				objBtn.disabled = true ;
			}
		},
		OnClrPlaylist : function()
		{
			//alert("before clear");
			EP_stop('ep_player1');
			this.bPlayerHasItem = false ;
			document.getElementById("SAV_PLY_LST").disabled = true ;
			document.getElementById("CLR_PLY_LST").disabled = true ;
			document.getElementById("REMOVE_ITEM").disabled = true ;
			document.getElementById("PLAYLIST").disabled    = true ;
			
			var objPL = document.getElementById("PLAYLIST") ;
			for(var index = 0; index < parent.SR.playlist_id_ary.length; index++)
			{
				//alert(parent.SR.playlist_id_ary[index]);
				objPL.remove(2) ;	
			}
			if(objPL.length == 2)
			{
				document.getElementById("REMOVE_ITEM").disabled = true ;
			}
			
			if(parent.SR.playlist_id_ary)
			{
				delete parent.SR.playlist_id_ary ;
			}
			if(parent.SR.playlist_title_ary)
			{
				delete parent.SR.playlist_title_ary ;
			}
			EP_clearPlaylist('ep_player1');
			//alert("after clear");
			//wimpy_stop();
			//wimpy_clearPlaylist();
			//EP_stop('ep_player1');
			
			//alert("clearing");
		},
		SavePlaylist : function(bOverwrite)
		{
			if(parent.SR.playlist_id_ary)
			{
				document.getElementById("DIV_SAV_PL_FRM").style.display = "none" ;
				document.getElementById("DIV_SAV_PL_MSG").style.display = "block" ;
				//var playlist_str = parent.SR.playlist_id_ary.join(";");
				
				var poststr = "pl_name=" + encodeURI( document.FRM_SAV_PLST.PLY_LST_NAME.value ) +
							  "&overwrite=" + encodeURI(bOverwrite) +
							  "&playlist=" + encodeURI( parent.SR.playlist_id_ary.join(";") ) +
							  "&comments=" + encodeURI( document.FRM_SAV_PLST.PLY_LST_CMNTS.value );
				
				//alert(poststr) ;	  
				AJAX.MakePostRequest("ajax/sr_save_playlist.php", poststr, this.CallBack_SavePlaylist);
			}
		},
		RestorePlForm : function(bHide)
		{
			document.getElementById("DIV_SAV_PL_FRM").style.display = "block" ;
			document.getElementById("DIV_SAV_PL_MSG").style.display = "none" ;
			
			var objDiv = document.getElementById("DIV_SAV_PL_MSG") ;
			objDiv.innerHTML = "<IMG SRC=\"images/updating.gif\" WIDTH=\"16\" HEIGHT=\"16\" BORDER=\"0\"/><BR/><BR/>Saving please wait..." ;
			
			if(bHide)
			{
				document.FRM_SAV_PLST.PLY_LST_NAME.value = "";
				document.FRM_SAV_PLST.PLY_LST_CMNTS.value = "";
				this.OnSavePlaylist();
			}
		},
		CallBack_SavePlaylist : function()
		{
			var contents = AJAX.GetContents() ;
			//alert(contents) ;
			if(contents != false)
			{
				//alert(contents) ;
				var response_json = eval('(' + contents + ')') ;
				var objDiv = document.getElementById("DIV_SAV_PL_MSG") ;
				if(response_json.result.bResult == true)
				{
					objDiv.innerHTML = "<BR/>Playlist '"+response_json.result.szPLName+"' saved successfully!<BR/><BR/><INPUT TYPE=\"button\" VALUE=\"Hide\" OnClick=\"SR.RestorePlForm(true);\"/>" ;
				}
				else
				{
					if(response_json.result.bOverwrite)
					{
						objDiv.innerHTML = "<BR/><B>Error :</B> "+response_json.result.szErrMsg+".<BR/><BR/><INPUT TYPE=\"button\" VALUE=\"Overwrite\" OnClick=\"SR.SavePlaylist(1);\"/>&nbsp;&nbsp;<INPUT TYPE=\"button\" VALUE=\"Cancel\" OnClick=\"SR.RestorePlForm(false);\"/>" ;
					}
					else
					{
						objDiv.innerHTML = "<BR/><B>Error :</B> "+response_json.result.szErrMsg+"." ;
					}
				}
				//alert(contents) ;
			}
		},
		OnSavePlaylist : function()
		{
			//alert() ;
			if(this.bLoggedIn)
			{
				var frmStyle = document.getElementById("FORM_SAVE_PLY_LST").style ;
				var obj = document.getElementById("SAV_PLY_LST") ;
				
				if(frmStyle.display == "none")
				{
					frmStyle.display = "block" ;
					obj.disabled = true ;
				}
				else
				{
					frmStyle.display = "none" ;
					obj.disabled = false ;
				}
			}
			else
			{
				var url = "iframe_pages/tab_login.php";
				window.frames['SEARCH_RESULTS'].location = encodeURI(url);
			}
		},
		OnRemoveItem : function()
		{
			var objPL = document.getElementById("PLAYLIST") ;
			if(objPL.value != 0)
			{
				/*for(var index = 0; index < this.playlist_id_ary.length; index++)
				{
					if(this.playlist_id_ary[index] == objPL.value)
					{
						EP_removeTracks('ep_player1', [index]);
						this.playlist_id_ary.splice(index, 1);
						this.playlist_title_ary.splice(index, 1);
						break;
					}
				}*/
				//alert(objPL.value);
				EP_removeTracks('ep_player1', [objPL.selectedIndex-2]);
				//wimpy_clearPlaylist();				
				//EP_clearPlaylist('ep_player1');
				//EP_removeTracks('ep_player1', ar);
				objPL.remove(objPL.selectedIndex) ;
				if(objPL.length == 2)
				{
					this.bPlayerHasItem = false ;
					
					document.getElementById("SAV_PLY_LST").disabled = true ;
					document.getElementById("CLR_PLY_LST").disabled = true ;
					document.getElementById("REMOVE_ITEM").disabled = true ;
					document.getElementById("PLAYLIST").disabled    = true ;
				}
			}
		},
		OnSelectItem : function(obj)
		{
			if(obj.value != 0)
			{
				document.getElementById("REMOVE_ITEM").disabled = false ;
			}
			else
			{
				document.getElementById("REMOVE_ITEM").disabled = true ;
			}
		},
		ShowLoading:function()
		{
			document.getElementById('RESULT_NAV_TOP').innerHTML = "Loading..." ;
		}
	};
}();