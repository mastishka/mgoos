<?php
	// Start session
	include_once("lib/session_manager.php") ;
	include_once("lib/mgoos_config.php") ;
	
	$my_addr = $_SERVER['REMOTE_ADDR'] ;
?>
<HTML>
	<HEAD>
		<META NAME="google-site-verification" CONTENT="rx0H7sYlf98rOmqG6XivBjZH4cdVVcGlUCadlW3ZuhQ"/>
		<META name="y_key" content="24a9eb74f17bde6d"/>
		<META name="msvalidate.01" content="3908B0AE41CD5A6AD2BABB1B1E64666B" />
		<META NAME="description" content="Free mp3 music search & download. Top artists and hit music free for download. 1 million mp3 base">
		<META NAME="keywords" content="free music downloads, new music, top songs, mp3 music downloads, mp3 downloads, free mp3 downloads, free mp3 music, mp3 files, top charts, bollywood, tamil, hindi, telugu, actress, actors, music, hindi, songs, bhangra, mp3, movies, india, news, india, chat, business, cricket.Illayaraja, Rehman, Kishore Kumar, Sharukh, Salman, Amir, Amitabh, Mohammad, Rafi, Lata, Mangeshkar, Yesudas, Rajini, SPB, Yesudas, TMS, Gemini, chiru, chiranjeevi, nagarjuna, raaga, raga, Tamil, music, site, South, Indian, India, Sri, Lankan, Lanka, bollywood, Bollywood, songs, picutres, pics, Aishwarya, Rai, Kajol, Meena, Kamal, Hasan, Rajini Kanth, Prabu Deva, A.R. Rehman, Rahman, Rahuman, Tamil entertainment, actresses, actors, Tamil music, best, Hindi, Malayalam, Telungu, Kannada, Nadu, Andhra, chat, live, celebrities, free, Pradesh, Karnataka, Madras, Chennai, Bombay, Ooty, songs, Tamil, tamil, india, bollywood, Bollywood, Indian, south, South, Telugu, telugu, Andhra, pradesh, andhra, Pradesh, hindi, Hindi, Uttar, Delhi">

		<TITLE>MGooS - Search audio, Share audio, Love audio</TITLE>
		<LINK REL="stylesheet" TYPE="text/css" HREF="css/mgoos.css" />
		<link rel="shortcut icon" HREF="images/mgoos.ico"/>
		<SCRIPT LANGUAGE="JavaScript">
		<!--
			function SetFocus()
			{
				var input = document.getElementById('srchtxt');
				if(input!=null)
				{
					input.focus();
				}
				return true;				
			}
			
			function WriteAlbumsOffset()
			{
				var alphabet = 65 ;
				
				document.write("<SPAN CLASS=\"boldfont\">Albums:</SPAN>&nbsp;&nbsp;") ;
				
				for(var num = 0; num < 26; num++)
				{
					document.write("<a href =\"albums.php?alb_strt="+String.fromCharCode(alphabet)+"\">"+String.fromCharCode(alphabet)+"</a>&nbsp;");
					alphabet++;
				}
				for(num = 1; num <= 9; num++)
				{
					document.write("<a href =\"albums.php?alb_strt="+num+"\">"+num+"</a>&nbsp;");
					alphabet++;
				}
			}
		//-->
		</SCRIPT>
	</HEAD>
	<BODY OnLoad="SetFocus();">
		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
		</script>
		<script type="text/javascript">
			_uacct = "UA-2246912-3";
			urchinTracker();
		</script>
		<!-- Header -->
		<TABLE WIDTH="100%" HEIGHT="600" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR ALIGN="CENTER">
				<?php
					include_once("database/queries.php") ;
					include_once("database/config.php") ;
					include_once("database/search_helper.php") ;
					
					$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
					$file_count = $objQM->GetDBFileCount() ;
					$album_count = $objQM->GetDBAlbumCount() ;																				
					//echo($count);
					
					$count = 3 ; // We want to retrive $count top search elements.
					$objSH = new CSearchHelper(CConfig::DB_ANALYTICS) ;
					$top_search_element_ary = $objSH->GetTopSearchElement($count) ;
					include_once(CMGooSConfig::MGOOS_ROOT."/lib/header.php?folder_level=0&page_id=".CMGooSConfig::HF_HOME_ID."&login=".CSessionManager::IsLoggedIn());
				?>
			</TR>
			<TR>
				<TD>
					<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
						<TD>
							<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
								<TR ALIGN="CENTER">
									<TD><IMG SRC="images/mgoos_logo_ori.gif" WIDTH="491" HEIGHT="151" BORDER="0" ALT="Search muzic, Share muzic, Love muzic"/></TD>
								</TR>
								<TR ALIGN="CENTER">
									<TD>
										<TABLE WIDTH="600" BACKGROUND="images/search_back.jpg" BORDER="0" CELLSPACING="0" CELLPADDING="0">
											<TR ALIGN="CENTER">
												<TD><IMG SRC="images/topcap.jpg" WIDTH="600" HEIGHT="41" BORDER="0" ALT=""/></TD>
											</TR>
											<TR ALIGN="Center">
												<TD><span class="boldfont"> Top Search :</span> 
												<?php
													$i = 0 ;
													foreach($top_search_element_ary as $element)
													{
														printf("<A class='anchor' HREF=\"search_results.php?srchtxt=%s&ext=%s\">%s</A>", urlencode($element[0]), $element[1], $element[0]) ;
														$i++;
														
														if($i < $count)
														{
															echo(" | ") ;
														}
													}
												?><BR/><BR/>
												</TD>
											</TR>
											<TR ALIGN="CENTER">
												<TD>
													<FORM METHOD="GET" ACTION="search_results.php">
														<INPUT TYPE="text" NAME="srchtxt" id="srchtxt" SIZE="70" BORDER="0" class="input"/>
														<SELECT NAME="ext">
															<OPTION VALUE="wild">Wild</OPTION>
															<OPTION VALUE="album">Album/Movie</OPTION>
															<OPTION VALUE="artist">Artist</OPTION>
															<OPTION VALUE="year">Year</OPTION>
															<OPTION VALUE="genre">Genre</OPTION>
															<OPTION VALUE="composer">Composer</OPTION>
															<OPTION VALUE="picturizedon">Picturized On</OPTION>
															<OPTION VALUE="lyrics">Lyrics</OPTION>
														</SELECT><BR/>
														<INPUT TYPE="submit" VALUE="          Search MP3s          " SIZE="80" class="input"/><BR/><BR/>
														<span class ="boldfont">Features : </span><A class="anchor" HREF="internet_radio.php">Internet Radio</A>&nbsp;<sup><span class="tdnew">new!</span></sup>&nbsp;|&nbsp;<A class="anchor" HREF="browse_album.php">Browse <?php echo($album_count)?> Albums</A>&nbsp;|&nbsp;<A class="anchor" HREF="load_popular.php">All Time Popular</A>&nbsp;|&nbsp;<A class="anchor" HREF="last_week_popular.php">Last Week Popular</A>&nbsp;&nbsp;<BR/>&nbsp;<A class="anchor" HREF="recent_uploads.php">Recent Uploads</A>&nbsp;&nbsp;|&nbsp;<A  class="anchor" HREF="http://www.orkut.com/Main#AppInfo?appId=486316678342" TARGET="_blank">&nbsp;MGooS Player at Orkut</A>&nbsp;&nbsp;
														<!-- <INPUT TYPE="button" ONCLICK="OnPlayMe();" VALUE="          Play Me...          " SIZE="80"/> -->
													</FORM>
												</TD>
											</TR>
											<TR ALIGN="CENTER">
												<TD><FONT SIZE="2">
												<SCRIPT LANGUAGE="JavaScript">
												<!--
													WriteAlbumsOffset() ;
												-->
												</SCRIPT>
												</FONT>
												</TD>
											</TR>
											<TR ALIGN="CENTER">
												<TD>
												<br/><br/><iframe src="http://www.facebook.com/plugins/like.php?href=http://www.facebook.com/pages/MGooS/234851129862321" scrolling="no" frameborder="0" style="border:none; width:450px; height:80px"></iframe>	
												</TD>
											</TR>
											<TR ALIGN="CENTER">
												<TD><FONT SIZE="2">
												<?php
													/*
													include_once("database/config.php") ;
													include_once("lib/user_manager.php") ;
													
													$objUM = new CUserManager() ;
													$count = $objUM->GetUsersLoginCount() + rand(100,199) ; // Apply a random addition initially. 
													printf("At present we are serving %d logged-in users !", $count) ;
													*/
												?>
												</FONT><BR/><BR/>| <A class="anchor" HREF="advance_search.php">Advance Search</A> |<BR/><A class="anchor" HREF="aboutus.php">About Us</A> | <?php if(CSessionManager::IsLoggedIn()){ echo("<A class='anchor' HREF=\"login/logout.php\"><EM><span class='boldfont'>Logout</span></EM></A>"); } else { echo("<A class='anchor' HREF=\"my_mgoos.php\"><EM><span class='boldfont'>Login</span></EM></A>"); } ?> | <A class="anchor" HREF="http://groups.google.co.in/group/mgoos"TARGET="_blank">Forum</A> |&nbsp;<A class="anchor" HREF="disclaimer.php">Disclaimer</A> | <A class="anchor" HREF="tos.php">Terms of Service</A>
												</TD>
											</TR>
											<TR ALIGN="CENTER">
												<TD><FONT class="mastishka" >&copy; Copyright <?php echo(date("Y")); ?> Mastishka Inc.</FONT></TD>
											</TR>
											<TR ALIGN="CENTER">
												<TD><IMG SRC="images/bottom_line.jpg" WIDTH="600" HEIGHT="16" BORDER="0" ALT=""/></TD>
											</TR>
										</TABLE>
									</TD>
								</TR>
								<TR ALIGN="CENTER">
									<TD><BR/><a href="http://www3.clustrmaps.com/counter/maps.php?url=http://mgoos.com" id="clustrMapsLink"><img src="http://www3.clustrmaps.com/counter/index2.php?url=http://mgoos.com" style="border:0px;" alt="Locations of visitors to this page" title="Locations of visitors to this page" id="clustrMapsImg" onError="this.onError=null; this.src='http://www2.clustrmaps.com/images/clustrmaps-back-soon.jpg'; document.getElementById('clustrMapsLink').href='http://www2.clustrmaps.com'" /></a><BR/><HR/></TD>
								</TR>
							</TABLE>
						</TD>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</BODY>
</HTML>