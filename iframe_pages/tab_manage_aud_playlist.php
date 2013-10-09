<?php
	// Start session
	include_once("../lib/session_manager.php") ;
	include_once("../database/queries.php");
	$objDB = new CQueryManager(CConfig::DB_AUDIO) ;	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE>Playlist</TITLE>
		<script language='javascript' src='../js/ajax.js'></script>
		<script language="javascript" type="text/javascript">
			function OnRemovePlaylist(pid, name, pageno)
			{
				if(confirm("Are you sure you want to remove playlist: "+name+" ?" ))
				{
					window.location = "tab_manage_aud_rem_pl.php?pid="+pid+"&pg="+pageno;
				}
			}
			
			function OnLoadPlaylist(pid)
			{
				var poststr = "pid=" + encodeURI( pid );
				
				//alert(poststr) ;	  
				AJAX.MakePostRequest("../ajax/tmap_get_pl.php", poststr, this.CallBack_LoadPlaylist);
			}
			
			function CallBack_LoadPlaylist()
			{
				var contents = AJAX.GetContents() ;
				//alert(contents) ;
				if(contents != false)
				{
					//alert(contents) ;
					var response_json = eval('(' + contents + ')') ;
					//var objDiv = document.getElementById("DIV_SAV_PL_MSG") ;
					if(response_json.result.bResult == true)
					{
						
						if(parent.parent.SR.playlist_id_ary == undefined && parent.parent.playlist_title_ary == undefined)
						{
							parent.parent.SR.playlist_id_ary = new Array() ;
							parent.parent.SR.playlist_title_ary = new Array() ;
						}
						//parent.parent.SR.playlist_id_ary = response_json.result.playlist_id_list.split(";") ;
						//alert(parent.parent.SR.playlist_id_ary) ;
						//parent.parent.SR.playlist_title_ary = response_json.result.playlist_title_list.split(";") ;
						//alert(parent.parent.SR.playlist_title_ary) ;
						//parent.parent.wimpy_clearPlaylist();
						parent.parent.SR.playlist_id_ary.push(response_json.result.playlist_id_list.split(";"));						
						parent.parent.SR.playlist_title_ary.push(response_json.result.playlist_title_list.split(";"));
						//EP_clearPlaylist('ep_player1');
						parent.parent.SR.playlist_id_ary = (parent.parent.SR.playlist_id_ary.toString()).split(",");
						parent.parent.SR.playlist_title_ary = (parent.parent.SR.playlist_title_ary.toString()).split(",");
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
							//alert(parent.parent.SR.playlist_id_ary[i]);
							
							parent.parent.EP_addTracks("ep_player1", "<track><location>load_aud.php?id="+parent.parent.SR.playlist_id_ary[i]+"</location><title>"+parent.parent.SR.playlist_title_ary[i]+"</title></track>", 999);
							
							optNode.setAttribute('value', parent.parent.SR.playlist_id_ary[i]);
							optNode.appendChild(optVal);
							objSelOpt.appendChild(optNode);
						}
						parent.parent.EP_play('ep_player1');

					}
				}
			}
		</script>
	</HEAD>		
	<BODY>
		<FIELDSET>
			<LEGEND>My Playlists</LEGEND>
			<?php
				if(empty($pg))
				{
					$pg = 1 ;
				}
				$objDB-> GetUserPlayList(CSessionManager::GetUserId(), $pg);
			?>
		</FIELDSET>
	</BODY>
</HTML>
