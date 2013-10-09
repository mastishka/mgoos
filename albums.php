<?php
	// Start session
	include_once("lib/session_manager.php") ;
	include_once("lib/mgoos_config.php") ;
	include_once("lib/utils.php") ;
					
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url);
	
	if(array_key_exists("query",$query_str))
	{
		parse_str($query_str["query"]) ;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE>Album</TITLE>
		<LINK REL="stylesheet" TYPE="text/css" HREF="./css/mgoos.css" />
		<link rel="shortcut icon" HREF="images/mgoos.ico"/>
		<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
		<script type="text/javascript">
			function GetAlphabet()
			{
				<?php printf("return '%s' ;", $alb_strt) ; ?>
			}
		</script>
	</HEAD>
	<BODY>
		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
			</script>
			<script type="text/javascript">
			try {
			var pageTracker = _gat._getTracker("UA-2246912-10");
			pageTracker._trackPageview();
			} catch(err) {}
		</script>
		
		<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR ALIGN="CENTER">
				<?php
				include_once(CMGooSConfig::MGOOS_ROOT."/lib/header.php?folder_level=0&page_id=".CMGooSConfig::HF_NONE."&login=".CSessionManager::IsLoggedIn());
				?>
			</TR>
			<TR ALIGN="CENTER">
				<TD>
					<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0">
						<TR ALIGN="CENTER">
							<TD>
								<A HREF="index.php"><IMG SRC="images/mgoos_thumbnail.png" WIDTH="123" HEIGHT="61" BORDER="0" ALT=""/></A>
							</TD>
							<TD>
								<TABLE WIDTH="600" BACKGROUND="images/search_back.jpg" BORDER="0" CELLSPACING="0" CELLPADDING="0">
									<TR ALIGN="CENTER">
										<TD><IMG SRC="images/topcap.jpg" WIDTH="600" HEIGHT="41" BORDER="0" ALT=""/></TD>
									</TR>
									<TR ALIGN="CENTER">
										<TD>
											<FORM METHOD="GET" ACTION="search_results.php">
												<span class ="boldfont">Features : </span><A class="anchor" HREF="browse_album.php">Browse <?php echo($album_count)?> Albums</A>&nbsp;|&nbsp;<A class="anchor" HREF="load_popular.php">All Time Popular</A>&nbsp;|&nbsp;<A class="anchor" HREF="last_week_popular.php">Last Week Popular</A>&nbsp;&nbsp;<BR/><BR/>
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
												<INPUT TYPE="submit" VALUE="          Search MP3s          " SIZE="80" class="input"/><BR/>
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
													if(GetAlphabet() != String.fromCharCode(alphabet))
													{
														document.write("<a href =\"albums.php?alb_strt="+String.fromCharCode(alphabet)+"\">"+String.fromCharCode(alphabet)+"</a>&nbsp;") ;
													}
													else
													{
														document.write("<B>"+String.fromCharCode(alphabet)+"</B>&nbsp;") ;
													}
													alphabet++;
												}
												for(num = 1; num <= 9; num++)
												{
													if(GetAlphabet() != num)
													{
														document.write("<a href =\"albums.php?alb_strt="+num+"\">"+num+"</a>&nbsp;") ;
													}
													else
													{
														document.write("<B>"+num+"</B>&nbsp;") ;
													}
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
			<TR ALIGN="CENTER">
				<TD>
					<?php
						include_once("database/queries.php") ;
						include_once("database/config.php") ;
						
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						$objQM->ListAlphabet($alb_strt, 4) ;
					?>
				</TD>
			</TR>
			<TR ALIGN="CENTER">
				<?php
				include_once(CMGooSConfig::MGOOS_ROOT."/lib/footer.php?folder_level=0&page_id=".CMGooSConfig::HF_NONE."&login=".CSessionManager::IsLoggedIn());
				?>
			</TR>
		</TABLE>
	</BODY>
</HTML>
