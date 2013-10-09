<?php
	// Start session
	include_once("lib/session_manager.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
	<?php
		include_once("database/queries.php") ;
		include_once("database/config.php") ;
		include_once("database/search_helper.php") ;
		include_once("lib/utils.php") ;
		include_once("lib/id3_info.php") ;
		
		$url = CUtils::curPageURL() ;
		$query_str=parse_url($url);// not to use.
		
		if(array_key_exists("query",$query_str))
		{
			parse_str($query_str["query"]) ;
		}
		//by:ripple date:16/09/09
		
		$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
		$file_count = $objQM->GetDBFileCount() ;
		$album_count = $objQM->GetDBAlbumCount() ;
		
		$strict = isset($strict) ? 1 : 0 ;

		//$count = 10 ; // We want to retrive $count top search elements.
		//$objSHAna = new CSearchHelper(CConfig::DB_ANALYTICS) ;
		//$top_search_element_ary = $objSHAna->GetTopSearchElement($count) ;
		
		//$objSHAud = new CSearchHelper(CConfig::DB_AUDIO) ;
		//$aud_choice_ary = $objSHAud->GetAudienceChoice($count) ;
		if(CSessionManager::GetReferredFrom() == CSessionManager::REF_FROM_PLAYME_PHP)
		{
			// $ref_mp3_id will have MP3 ID.
			parse_str(CSessionManager::GetReferredData());
			
			$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
			
			// ${'myvar'} = $myvar.
			$ref_title1 = $objQM->GetFieldValue(${CSessionManager::REF_DATA_MP3_ID}, "title") ;
			$ref_title = str_replace(" - Www.songs.pk","",$ref_title1);
		}
		else
		{
			$ref_title = $srchtxt ;

			if($pmode == 1)
			{
				// Set Reffered Information.
				CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_PLAYME_PHP) ;
				CSessionManager::SetReferredData(CSessionManager::REF_DATA_MP3_ID."=".$id) ;
			}
		}
	?>
    <link rel="stylesheet" type="text/css" href="./css/mgoos.css" />
	<script src="js/AC_OETags.js" language="javascript" type="text/javascript"></script>

	<script language="JavaScript" type="text/javascript">
			<!--
			// -----------------------------------------------------------------------------
			// Globals
			// Major version of Flash required
			var requiredMajorVersion = 10;
			// Minor version of Flash required
			var requiredMinorVersion = 0;
			// Minor revision of Flash required
			var requiredRevision = 0;
			// -----------------------------------------------------------------------------
		// -->
	</script>

	
		<TITLE>MGooS- <?php echo $ref_title; ?></TITLE>
		<script src="js/swfobject.js" type="text/javascript"></script>
		<script src="js/ep_player.js" type="text/javascript"></script>
		<script language='javascript' src='js/ajax.js'></script>
		<script language='javascript' src='js/srch_res_script.js'></script>
	</HEAD>
	<BODY onLoad="SR.setLoaded();">
		<SCRIPT language="JAVASCRIPT" type="text/javascript">
		<!--
			<?php
				$bLoggedIn = false ;
				if(CSessionManager::IsLoggedIn())
				{
					$bLoggedIn = true ;
					echo("SR.bLoggedIn = true ;") ;
				}
				else 
				{
					echo("SR.bLoggedIn = false ;") ;
				}
			?>
		//-->
		</SCRIPT>
		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
			<!-- <><><><><><><><><><><><><><><><><><><><><><><><><><><><><> -->
			<!-- Header {Start} -->
			<!-- 01 -->
			<TR ALIGN="CENTER">
				<?php
					include_once("lib/mgoos_config.php") ;
					include_once(CMGooSConfig::MGOOS_ROOT."/lib/header.php?folder_level=0&page_id=".CMGooSConfig::HF_SRCH_RSLT_ID."&login=".CSessionManager::IsLoggedIn()) ;	
				?>
			</TR>
			<!-- 02 -->
			<TR ALIGN="CENTER">
				
			</TR>
			<!-- Header {End} -->
			<!-- <><><><><><><><><><><><><><><><><><><><><><><><><><><><><> -->
			
			<!-- <><><><><><><><><><><><><><><><><><><><><><><><><><><><><> -->
			<!-- Top Search box {Start}-->
			<!-- 03 -->
			<TR ALIGN="CENTER">
				<TD>
					<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" NAME="TABLE_1_1">
						<TR ALIGN="CENTER" NAME="ROW_1">
							<TD WIDTH="160"><A class="anchor" HREF="index.php"><IMG SRC="images/mgoos_logo_s.jpg" WIDTH="148" HEIGHT="46" BORDER="0" ALT="Search muzic, Share muzic, Love muzic"/></A></TD>
							<TD WIDTH="600" BACKGROUND="images/search_back.jpg">
								<TABLE ALIGN="CENTER"  WIDTH="100%" CELLSPACING="0" CELLPADDING="0" BORDER="0">
									<TR ALIGN="CENTER">
										<TD><IMG SRC="images/topcap.jpg" WIDTH="600" HEIGHT="41" BORDER="0" ALT=""/></TD>
									</TR>
									<TR ALIGN="CENTER">
										<TD>
											<FORM METHOD="GET" NAME="SEARCH_BAR_TOP" ID="SEARCH_BAR_TOP">
												<INPUT TYPE="text" NAME="srchtxt" SIZE="50" BORDER="0" class="input"/>
												<SELECT NAME="ext">
													<OPTION VALUE="wild">Wild</OPTION>
													<OPTION VALUE="album">Album/Movie</OPTION>
													<OPTION VALUE="artist">Artist</OPTION>
													<OPTION VALUE="year">Year</OPTION>
													<OPTION VALUE="genre">Genre</OPTION>
													<OPTION VALUE="composer">Composer</OPTION>
													<OPTION VALUE="picturizedon">Picturized On</OPTION>
													<OPTION VALUE="lyrics">Lyrics</OPTION>
												</SELECT>&nbsp;&nbsp;
												<INPUT TYPE="submit" VALUE=" Search MP3s " SIZE="80" class="input"/><BR/><BR/>
												<span class ="boldfont">Features : </span><A class="anchor" HREF="internet_radio.php">Internet Radio</A>&nbsp;<sup><span class="tdnew">new!</span></sup>&nbsp;|&nbsp;<A class="anchor" HREF="iframe_pages/tab_search_results.php?browse_album=true&pg=A&pageno=1" TARGET="SEARCH_RESULTS">Browse <?php echo($album_count); ?> Albums</A>&nbsp;|&nbsp;<A class="anchor" HREF="iframe_pages/tab_search_results.php?loadpop=true&pg=1" TARGET="SEARCH_RESULTS">All Time Popular</A>&nbsp;<BR/>&nbsp;<A class="anchor" HREF="iframe_pages/tab_search_results.php?last_week_pop=true&pg=1" TARGET="SEARCH_RESULTS">Last Week Popular</A>&nbsp;|&nbsp;<A class="anchor" HREF="iframe_pages/tab_search_results.php?recent_uploads=true&pg=1" TARGET="SEARCH_RESULTS">Recent Uploads</A>&nbsp;|&nbsp;<A  class="anchor" HREF="http://www.orkut.com/Main#AppInfo?appId=486316678342" TARGET="_blank">MGooS Player at Orkut</A>&nbsp;
											</FORM>
										</TD>
									</TR>
									<TR ALIGN="CENTER"> 
										<TD>
											<FONT SIZE="2">
											<SPAN CLASS="boldfont">Album Listing:</SPAN>
											<SCRIPT TYPE="text/javascript">
												var alphabet = 65;
												for(var num = 0; num < 26; num++)
												{
													document.write("<a href =\"iframe_pages/tab_albums.php?alb_strt="+String.fromCharCode(alphabet)+"\" TARGET=\"SEARCH_RESULTS\">"+String.fromCharCode(alphabet)+"</a>&nbsp;") ;
													alphabet++;
												}
												for(num = 1; num <= 9; num++)
												{
													document.write("<a href =\"iframe_pages/tab_albums.php?alb_strt="+num+"\" TARGET=\"SEARCH_RESULTS\">"+num+"</a>&nbsp;") ;
												}
											</SCRIPT>
											</FONT>
										</TD>
									</TR>
									<TR ALIGN="CENTER">
										<TD><IMG SRC="images/bottom_line.jpg" WIDTH="600" HEIGHT="16" BORDER="0" ALT=""/></TD>
									</TR>				
								</TABLE>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<!-- Top Search box {Start}-->
			<!-- <><><><><><><><><><><><><><><><><><><><><><><><><><><><><> -->
			
			<!-- <><><><><><><><><><><><><><><><><><><><><><><><><><><><><> -->
			<!-- Search results description [Top] {Start} -->
			<!-- 04 -->
			<TR ALIGN="CENTER">
				<TD class ="tdcolor" ID="RESULT_DESCRP_TOP"> <span class ="boldfont"> Please Wait </span></TD>
			</TR>
			<!-- 05 -->
			<TR ALIGN="CENTER">
				<!-- PHP code [Start]-->
				<!-- Here put one select query based on search string and depending upon the count show pages to display.  -->
				<!-- select count(*) from [table] where [field] like %[search string (+ removed)]%-->
				<!-- PHP code [End]-->
				<TD class ="tdcolor" ID="RESULT_NAV_TOP">Searching...</TD>
			</TR>
			<!-- Search results description [Top] {End} -->
			<!-- <><><><><><><><><><><><><><><><><><><><><><><><><><><><><> -->
			<!-- <><><><><><><><><><><><><><><><><><><><><><><><><><><><><> -->
			<!-- Search results {Start} -->
			<!-- 06 -->
			<TR ALIGN="CENTER">
				<TD>
					<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
						<TR>
							<TD>
								<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
									<?php
									if(CSessionManager::IsLoggedIn())
									{
									?>
									<TR>
										<TD class="tbbar" ID="TOP_TAB_BAR"> 
											<A class="anchor" HREF="iframe_pages/tab_search_results.php" TARGET="SEARCH_RESULTS">Search Results</A>&nbsp;&nbsp;<A class="anchor" HREF="<?php echo("iframe_pages/tab_manage_aud.php"); ?>" TARGET="SEARCH_RESULTS">Manage Audio</A>&nbsp;&nbsp;<A class="anchor" HREF="<?php echo("iframe_pages/tab_points.php"); ?>" TARGET="SEARCH_RESULTS">My Points</A>&nbsp;&nbsp;<A class="anchor" HREF="<?php echo("iframe_pages/tab_profile.php"); ?>" TARGET="SEARCH_RESULTS">My Profile</A>&nbsp;&nbsp;<A class="anchor" HREF="<?php echo("iframe_pages/tab_suggest.php"); ?>" TARGET="SEARCH_RESULTS">Suggest</A>
										</TD>
									</TR>
									<?php
									}
									?>
									<TR>
										<TD ALIGN="TOP">
											<?php
												if(CSessionManager::GetReferredFrom() == CSessionManager::REF_FROM_PLAYME_PHP)
												{
													// $ref_mp3_id will have MP3 ID.
													parse_str(CSessionManager::GetReferredData());
													
													$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
													
													// ${'myvar'} = $myvar.
													$ref_title1 = $objQM->GetFieldValue(${CSessionManager::REF_DATA_MP3_ID}, "title") ;
													$ref_title = str_replace(" - Www.songs.pk","",$ref_title1);
													echo("<SCRIPT LANGUAGE=\"JavaScript\">\n") ;
													//echo("<!--\n") ;
													printf("SR.playme_id='%s';\n", ${CSessionManager::REF_DATA_MP3_ID}) ;
													printf("SR.playme_title='%s';\n", $ref_title) ;
													echo("SR.hLoadAud = setInterval(\"SR.LoadAud()\", 1000); \n") ;
													//echo("-->\n") ;
													echo("</SCRIPT>\n") ;
													//CSessionManager::SetCommand(CSessionManager::COMMAND_PLAY_FIRST) ;
													
													$myurl = "iframe_pages/tab_search_results.php?qry=" ;
													$myurl .= urlencode($ref_title) ;
													$myurl .= '&pg=1&ext=wild' ;
													
													if($strict)
													{
														$myurl .= '&strict=1' ;
													}
												}
												else if(CSessionManager::IsLoggedIn() && CSessionManager::GetReferredFrom() == CSessionManager::REF_FROM_MY_MGOOG_PHP)
												{
													$myurl = "iframe_pages/tab_manage_aud.php" ;
												}
												else if(CSessionManager::GetReferredFrom() == CSessionManager::REF_FROM_LOAD_POPULAR)
												{
													$myurl = "iframe_pages/tab_search_results.php?loadpop=true&pg=".$pg ;
												}
												else if(CSessionManager::GetReferredFrom() == CSessionManager::REF_FROM_BROWSE_ALBUM)
												{
													$myurl = "iframe_pages/tab_search_results.php?browse_album=true&pg=A&pageno=1" ;
												}
												else if(CSessionManager::GetReferredFrom() == CSessionManager::REF_FROM_RECENT_UPLOADS)
												{
													$myurl = "iframe_pages/tab_search_results.php?recent_uploads=true&pg=1" ;
												}
												else if(CSessionManager::GetReferredFrom() == CSessionManager::REF_FROM_LAST_WEEK_POPULAR)
												{
													$myurl = "iframe_pages/tab_search_results.php?last_week_pop=true&pg=1" ;
												}
												else
												{
													$myurl = "iframe_pages/tab_search_results.php?qry=" ;
													if(array_key_exists("query",$query_str))
													{		
														$myurl .= urlencode($srchtxt) ;
														$myurl .= '&pg=1&ext=' ;
														$myurl .= $ext ;
														
														if($strict)
														{
															$myurl .= '&strict=1' ;
														}
													}
												}
												// Reset Reffered From to NONE.
												CSessionManager::ResetRefferedFrom() ;
												
												echo('<IFRAME WIDTH="100%" HEIGHT="1100" SRC="') ;
												echo($myurl) ;
												echo('" NAME="SEARCH_RESULTS" ID="SEARCH_RESULTS" SCROLLING="YES" MARGINWIDTH="0" MARGINHEIGHT="0" FRAMEBORDER="0" HSPACE="0" VSPACE="0"></IFRAME>') ;
											?>
										</TD>
									</TR>
								</TABLE>
							</TD>
							<!--<TD WIDTH="150" VALIGN="TOP">
								<IFRAME WIDTH="150" HEIGHT="1100" SRC="iframe_pages/iframe_stats.php" NAME="STATISTICS" ID="STATISTICS" SCROLLING="NO" MARGINWIDTH="0" MARGINHEIGHT="0" FRAMEBORDER="0" HSPACE="0" VSPACE="0"></IFRAME>
							</TD>-->
							<TD WIDTH="300" BACKGROUND="images/left_rule.jpg" VALIGN="TOP">
								<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
									<TR ALIGN="CENTER">
										<TD>
											<INPUT TYPE="button" ID="SAV_PLY_LST" NAME="SAV_PLY_LST" onClick="SR.OnSavePlaylist();" VALUE="Save Playlist" DISABLED="true"/>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" ID="CLR_PLY_LST" NAME="CLR_PLY_LST" onClick="SR.OnClrPlaylist();" VALUE="Clear Playlist" DISABLED="true"/><BR/><BR/>
										</TD>
									</TR>
									<TR ALIGN="CENTER">
										<TD>
										<DIV ID="FORM_SAVE_PLY_LST" STYLE='display:none;'>
											<FIELDSET>
												<LEGEND>Save Playlist</LEGEND>
												<DIV ID="DIV_SAV_PL_FRM" STYLE="display:block">
													<FORM ID="FRM_SAV_PLST" NAME="FRM_SAV_PLST" style="text-align:center">
														<TABLE>
															<TR>
																<TD>Playlist Name:</TD> <TD><INPUT TYPE="text" NAME="PLY_LST_NAME" SIZE="30" OnKeyUp="SR.OnPlNameChange(this);" class="input"/></TD>
															</TR>
															<TR>
																<TD>Comments:</TD> <TD><INPUT TYPE="text" NAME="PLY_LST_CMNTS" SIZE="30" class="input"/></TD>
															</TR>
														</TABLE>
														<INPUT TYPE="button" ID="BTN_SAV_PLST" VALUE=" Save " OnClick="SR.SavePlaylist(0);" DISABLED="true"/>&nbsp;&nbsp;<INPUT TYPE="button" VALUE=" Cancel " OnClick="SR.OnSavePlaylist();"/>
													</FORM>
												</DIV>
												<DIV ID="DIV_SAV_PL_MSG" STYLE="display:none">
													<IMG SRC="images/updating.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/>Saving please wait...
												</DIV>
											</FIELDSET>
										</DIV>
										</TD>
									</TR>
									<TR ALIGN="CENTER">
										<TD>
											<SELECT NAME="PLAYLIST" ID="PLAYLIST" WIDTH="80" OnChange="SR.OnSelectItem(this);" DISABLED="true">
												<OPTION VALUE="0">Select to remove from playlist</OPTION>
												<OPTION VALUE="0">------------------------------</OPTION>
											</SELECT>
											<INPUT TYPE="button" ID="REMOVE_ITEM" NAME="REMOVE_ITEM" onClick="SR.OnRemoveItem();" VALUE="Remove" DISABLED="true"/>
										</TD>
									</TR>
									<TR ALIGN="CENTER">
										<TD>
										
										</TD>
									</TR>
									
									<TR ALIGN="CENTER">
										<TD HEIGHT="300">&nbsp;
											<div id="ep_container1">To view the MGooS MP3 Player please update your <a href="http://www.adobe.com/go/getflashplayer/" target="_blank">Flash Player</a>.</div>
	
											<script type="text/javascript" defer="defer">
												
												////////////////////////////////////////////////////////////////////////////
												var flashvars = {};
												flashvars.skin 		= 'skins/nobius_mk2/skin.xml';
												flashvars.playlist 	= 'playlist.xml';
												flashvars.autoplay 	= 'false';
												flashvars.volume 	= '80';
												flashvars.shuffle 	= 'false';
												flashvars.key 		= 'DOLR9TXUDSFOFMXO30EU';
												
												////////////////////////////////////////////////////////////////////////////
												var params = {};
												params.allowScriptAccess = 'always';
												
												////////////////////////////////////////////////////////////////////////////
												var attributes = {};
												attributes.id = 'ep_player1';
												
												////////////////////////////////////////////////////////////////////////////
												swfobject.embedSWF(
													'swf/ep_player.swf', 			// the location of the swf file
													'ep_container1', 			// the id of the div to print the player in 
													'300', '400', 				// the width and height of the player
													'10.0.0',					// the required flash version 
													false,						// we've disabled express-install to keep it simple
													flashvars,
													params,
													attributes
												);
											</script>
											
											<center>
											<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1 "></script><fb:like-box href="http://www.facebook.com/pages/MGooS/234851129862321 " height="329" width="292" show_faces="true" border_color="" stream="false" header="false"></fb:like-box>
											<iframe src="http://www.facebook.com/plugins/activity.php?site=beta.mgoos.com&amp;width=300&amp;height=300&amp;header=false&amp;colorscheme=light&amp;font&amp;border_color&amp;recommendations=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:300px;" allowTransparency="false"></iframe>
											</center>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<!-- Search results {End} -->
			<!-- <><><><><><><><><><><><><><><><><><><><><><><><><><><><><> -->
			
			<!-- 07 -->
			<TR ALIGN="CENTER">
				<?php
				 include_once(CMGooSConfig::MGOOS_ROOT."/lib/footer.php?folder_level=0&page_id=".CMGooSConfig::HF_SRCH_RSLT_ID."&login=".CSessionManager::IsLoggedIn());
				?>
			</TR>
			<!-- Footer {End}-->
			<!-- <><><><><><><><><><><><><><><><><><><><><><><><><><><><><> -->
		</TABLE>
	</BODY>
</HTML>