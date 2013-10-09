<?php
	include_once("lib/mgoos_config.php") ;
	include_once("lib/session_manager.php");
?>

<HTML>
	<HEAD>
		<TITLE> Advance Search </TITLE>
		<link rel="stylesheet" type="text/css" href="./css/mgoos.css" />
		<link rel="shortcut icon" HREF="images/mgoos.ico"/>
		<META NAME="Generator" CONTENT="EditPlus">
		<META NAME="Author" CONTENT="">
		<META NAME="Keywords" CONTENT="">
		<META NAME="Description" CONTENT="">
			<script language="JavaScript">
                function validate_text() 
				{
					var albumname = document.getElementById("albumname").value;
					var title = document.getElementById("title").value;
					var starcast = document.getElementById("starcast").value;
					var genre = document.getElementById("genre").value;
					var year1 = document.getElementById("year1").value;
                    var year2 = document.getElementById("year2").value;

					if ( albumname == "" && title == "" && starcast == "" && genre == "None" && year1 == "None" && year2 == "None" )
					{
						alert("Entries must be filled out.");
						return false;
					}
					else 
					{
						return true;
					}
				}
			</script>
    </HEAD>
	
	<BODY>
		<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR ALIGN="CENTER">
				<!-- Header -->
				<?php					include_once(CMGooSConfig::MGOOS_ROOT."/lib/header.php?folder_level=0&page_id=".CMGooSConfig::HF_ADV_SRCH_ID."&login=".CSessionManager::IsLoggedIn());
				?>
			</TR>
			<TR>
				<TD>
					<p align="center"><A HREF="http://localhost/mgoos/index.php"><IMG SRC="images/mgoos_thumbnail.png" WIDTH="123" HEIGHT="61" BORDER="0" ALT=""/></A></p>
			      <form action="search_results.php?srchtxt=&ext=adsr" method="post" name="form">
					<p class="indented">
						<span class="boldfont">Album Name:</span>
						<input type="text" name="albumname" id="albumname" />
						&nbsp;&nbsp;&nbsp;Exact match:
						<input type="checkbox">
						<br/></br>
						<span class="boldfont">Title:</span>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="title" id="title" />
					    &nbsp;&nbsp;&nbsp;Exact match:
						<input type="checkbox">
						<br/></br>
						<span class="boldfont">Star Cast:</span>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="starcast" id="starcast"/>
						&nbsp;&nbsp;&nbsp;Exact match:
						<input type="checkbox">
						<br/></br>
						<span class="boldfont">Genre:</span>  
                        <select name="genre" id ="genre">
						  <?php
                           include_once("database/queries.php");
						   include_once("database/config.php") ;
						   $objQM = new CQueryManager(CConfig::DB_AUDIO);
						   $objQM->PrepareGenreOptions("None");
					      ?>
						 </select></br></br>
						 <span class="boldfont">Start Year:</span>
					     <select name="year1" id="year1">
						  <?php
						       printf("<option value=\"None\" selected=\"selected\">None</option>", $i,$i);
							for($i=1900;$i<=2010;$i++)
							{
								printf("<option value=\"%s\">%s</option>", $i,$i);
							}
                          ?>
						 </select>
						 &nbsp;<span class="boldfont">End Year:</span>
						 <select name="year2" id="year2">
						  <?php
								printf("<option value=\"None\" selected=\"selected\">None</option>", $i,$i);
						   for($i=1900;$i<=2010;$i++)
							{
								printf("<option value=\"%s\">%s</option>", $i,$i);
							}
	                     ?>
						 </select></br></br>
						 <INPUT TYPE="submit" VALUE="Search MP3s" SIZE="80" class="input" onclick = "return validate_text()"/>
					</p></form></BR>
				</TD>
			</TR>
			<TR>
				<?php					include_once(CMGooSConfig::MGOOS_ROOT."/lib/footer.php?folder_level=0&page_id=".CMGooSConfig::HF_ADV_SRCH_ID."&login=".CSessionManager::IsLoggedIn()); 
				?>
			</TR>
		</TABLE>
 </BODY>
</HTML>
