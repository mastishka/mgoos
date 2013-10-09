<?php
	// Start session
	include_once("../lib/session_manager.php") ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE> Search Results </TITLE>
		<SCRIPT TYPE="text/javascript" LANGUAGE="javascript">
			function OnHide()
			{
				var objDivStyle = document.all.MESSAGE.style ;
				if(objDivStyle.display == 'block')
				{
					objDivStyle.display = 'none' ;
				}
			}
		</SCRIPT>
	</HEAD>
	<BODY>
		<?php 
			include("../lib/utils.php") ;
			
			$url = CUtils::curPageURL() ;
			$query_str = parse_url($url); // will return array of url components.
			parse_str($query_str["query"]) ; // the query string will be parsed here.
		?>
		<DIV id="MESSAGE" style="display:<?php if(!empty($update)){echo("block");} else {echo("none");}  ?>">
			<FIELDSET>
				<LEGEND>Notification Message</LEGEND>
				<P><?php if($update ==true){echo("Song Title: '".$title."' uploaded successfull!");} else {echo("Song Title: '".$title."' upload failed!");}  ?></P>
				<INPUT TYPE="button" ONCLICK="OnHide();" VALUE=" Hide "/>
			</FIELDSET>
		</DIV>
		<BR/>
		<FORM ID="form1" ACTION="../donn/upload_mp3.php" METHOD="post" ENCTYPE="multipart/form-data">
			<FIELDSET>
				<LEGEND>Song File Upload</LEGEND>
				<INPUT TYPE="file" NAME="Filedata" ACCEPT="audio/mpeg"/> (MP3 file, Max 20 MB)<BR/><BR/>
				<INPUT TYPE="submit" VALUE="Upload" />
			</FIELDSET>
		</FORM>
		<BR/>
		<FIELDSET>
			<LEGEND>Today's Upload Details</LEGEND>
			<?php
				include_once("../database/queries.php") ;
				include_once("../lib/id3_info.php");
				
				$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
				
				if(empty($pg))
				{
				  $pg = 1;
				 }
				$objQM->PrepareTodayUploadDetails(CSessionManager::GetUserId(),$pg) ;
			?>
		</FIELDSET>
	</BODY>
</HTML>