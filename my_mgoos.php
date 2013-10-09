<?php
   include_once("lib/session_manager.php") ;
   include_once("lib/mgoos_config.php") ;
?>
<HTML>
	<HEAD>
		<TITLE>MGooS - Search muzic, Share muzic, Love muzic</TITLE>
        <link rel="stylesheet" type="text/css" href="./css/mgoos.css" />
		<script language='javascript' src='ajax.js'></script>
	</HEAD>
	<BODY>
		<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
		</script>
		<script type="text/javascript">
			//_uacct = "UA-2246912-3";
			//urchinTracker();
		</script>
		<!-- Header -->
		<TABLE WIDTH="100%" HEIGHT="600" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR ALIGN="CENTER">
			<!-- Header -->
				<?php				include_once(CMGooSConfig::MGOOS_ROOT."/lib/header.php?folder_level=0&page_id=".CMGooSConfig::HF_LOGIN_ID."&login=".CSessionManager::IsLoggedIn());
				//include_once(CMGooSConfig::MGOOS_ROOT."/lib/header.php?folder_level=0&aboutus=1&login=0&advance_search=1&home=1&disclaimer=1&tos=1");
				?>
			</TR>
			<TR>
				<TD>
					<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
						<TD>
							<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
								<TR ALIGN="CENTER">
									<TD><A HREF="index.php"><img src="images/mgoos_logo_ori.gif"  WIDTH="491" HEIGHT="151" BORDER="0" ALT="Search muzic, Share muzic, Love muzic"/></TD>
								</TR>
								<TR>
									<TD>
										<p class="indented"><A class='anchor' HREF="http://www.mgoos.com">MGooS</A> is the musical web-application which comprises of songs searching with advance searching, popular songs of last week, recent uploads, all time popular, upload songs, bookmarks. There is also option to send songs to friends. All genres and styles of music are covered here, ranging from the most commercially popular to the most obscure. They can email their wishes, messages in the form of song to their beloved ones via <A class='anchor' HREF="http://www.mgoos.com">MGooS</A> in just one click. They can even upload their own songs, make it private or public.<BR/><BR/><A class='anchor' HREF="http://www.mgoos.com">MGooS</A> likes to say <span class="boldfont" >“Search Audio, Share Audio, and Love Audio”</span> with us.<BR/><BR/>Our Mission Statement is:<BR/><BR/><span class="boldfont" >“To provide music lovers a compelling way to search and listen music online.”</span><BR/><BR/></p> 
									</TD>
								</TR>
								<TR ALIGN="CENTER">
									<TD><BR/><a class="anchor" href="http://www3.clustrmaps.com/counter/maps.php?url=http://mgoos.com" id="clustrMapsLink"><img src="http://www3.clustrmaps.com/counter/index2.php?url=http://mgoos.com" style="border:0px;" alt="Locations of visitors to this page" title="Locations of visitors to this page" id="clustrMapsImg" onError="this.onError=null; this.src='http://www2.clustrmaps.com/images/clustrmaps-back-soon.jpg'; document.getElementById('clustrMapsLink').href='http://www2.clustrmaps.com'" /></a><BR/><HR/></TD>
								</TR>
								<TR ALIGN="CENTER">
									<TD>
										<UL>
											<LI><span class="clrfont">After silence that which comes nearest to expressing the inexpressible is music - Aldous Huxley</span></LI>
										</UL>
									</TD>
								</TR>
								<TR ALIGN="CENTER">
									<TD><HR/></TD>
								</TR>
							</TABLE>
						</TD>
						<TD>
							<TABLE VALIGN="TOP" ALIGN="RIGHT" WIDTH="300" HEIGHT="600" BACKGROUND="images/search_back_300.jpg" BORDER="0" CELLSPACING="0" CELLPADDING="0">
								<TR ALIGN="CENTER" HEIGHT="50">
									<TD>
										<IMG SRC="images/my_mgoos.jpg" WIDTH="249" HEIGHT="49" BORDER="0" ALT="My MGooS">
									</TD>
								</TR>
								<TR ALIGN="CENTER"  height="50px">
									<TD>
										My own world of music.
									</TD>
								</TR>
								<TR ALIGN="CENTER" HEIGHT="100">
									<TD>
										<IFRAME WIDTH="250" HEIGHT="250" SRC="login/login_form.php" NAME="LOGIN_FRAME" ID="LOGIN_FRAME" SCROLLING="NO" MARGINWIDTH="0" MARGINHEIGHT="0" FRAMEBORDER="0" HSPACE="0" VSPACE="0"></IFRAME>
										<BR/>Click <A class="anchor" HREF="login/forgot.php">here</A> to retrieve your password.<BR/><A class="anchor" HREF="login/register.php">Register here!</A>
									</TD>
								</TR>
								<TR ALIGN="CENTER">
									<TD><HR WIDTH="100"/></TD>
								</TR>
								<TR ALIGN="CENTER" HEIGHT="70">
									<TD STYLE="padding:12pt">
										<span class="clrbold"> Music should strike fire from the heart of man, and bring tears from the eyes of woman.<BR/>- Ludwig Van Beethoven </span>
									</TD>
								</TR>
								<TR ALIGN="CENTER">
									<TD><HR WIDTH="100"/></TD>
								</TR>

							</TABLE>
						</TD>
					</TABLE>
				</TD>
			</TR>
            <TR>
				<?php								include_once(CMGooSConfig::MGOOS_ROOT."/lib/footer.php?folder_level=0&page_id=".CMGooSConfig::HF_LOGIN_ID."&login=".CSessionManager::IsLoggedIn()); 
				?>
			</TR>
		</TABLE>
	</BODY>
</HTML>