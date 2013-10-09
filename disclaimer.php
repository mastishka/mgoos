<?php
	include_once("lib/mgoos_config.php") ;
	include_once("lib/session_manager.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE> Disclaimer </TITLE>
		<link rel="stylesheet" type="text/css" href="./css/mgoos.css" />
		<link rel="shortcut icon" HREF="images/mgoos.ico"/>
		<META NAME="Generator" CONTENT="EditPlus">
		<META NAME="Author" CONTENT="">
		<META NAME="Keywords" CONTENT="">
		<META NAME="Description" CONTENT="">
	</HEAD>
	
	<BODY>
		<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR ALIGN="CENTER">
				<!-- Header -->
				<?php				include_once(CMGooSConfig::MGOOS_ROOT."/lib/header.php?folder_level=0&page_id=".CMGooSConfig::HF_DISCLAIMER_ID."&login=".CSessionManager::IsLoggedIn());
				?>
			</TR>
			<TR>
				<TD>
					<p align="center"><A HREF="http://localhost/mgoos/index.php"><IMG SRC="images/mgoos_thumbnail.png" WIDTH="123" HEIGHT="61"  BORDER="0" ALT=""/></A></p>
					<p class="heading">Disclaimer</p>
 <p class="indented"><A class='anchor' HREF="http://www.mgoos.com">MGOOS</A> DISCLAIMS ALL WARRANTIES, EXPRESS OR IMPLIED, INCLUDING, WITHOUT LIMITATION, FOR NONINFRINGEMENT, MERCHANTABILITY AND FITNESS FOR ANY PURPOSE.<A class='anchor' HREF="http://www.mgoos.com">MGOOS</A> SHALL HAVE NO DIRECT, CONSEQUENTIAL, SPECIAL, INDIRECT, EXEMPLARY, PUNITIVE, OR OTHER LIABILITY WHETHER IN CONTRACT, TORT OR ANY OTHER LEGAL THEORY, UNDER THIS AGREEMENT, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH LIABILITY AND NOTWITHSTANDING ANY FAILURE OF ESSENTIAL PURPOSE OF ANY LIMITED REMEDY. IN THE EVENT THAT THE FOREGOING IS NOT ENFORCEABLE, <A class='anchor' HREF="http://www.mgoos.com">MGOOS</A>'s AGGREGATE LIABILITY UNDER THIS AGREEMENT IS LIMITED .</p></BR>
				</TD>
			</TR>
			<TR>
				<?php					include_once(CMGooSConfig::MGOOS_ROOT."/lib/footer.php?folder_level=0&page_id=".CMGooSConfig::HF_DISCLAIMER_ID."&login=".CSessionManager::IsLoggedIn()); 
				?>
			</TR>
		</TABLE>
 </BODY>
</HTML>