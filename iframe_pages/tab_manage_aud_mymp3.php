<?php
	// Start session
	include_once("../lib/session_manager.php") ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE></TITLE>
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
				<P><?php
					$msg_word_1 = "" ;
					$msg_word_2 = "" ;
					
					if($type == 1)
					{
						$msg_word_1 = "updated" ;
						$msg_word_2 = "updation" ;
					}
					else if($type == 1)
					{
						$msg_word_1 = "removed" ;
						$msg_word_2 = "removal" ;
					}
					
					if($update ==true)
					{
						echo("Song information ".$msg_word_1." for Title: '".$title."' !");
					}
					else
					{
						echo("Song information ".$msg_word_2." failed for Title: '".$title."' !");
					}  
				?></P>
				<INPUT TYPE="button" ONCLICK="OnHide();" VALUE=" Hide "/>
			</FIELDSET>
		</DIV>
		<BR/>
		<FIELDSET>
			<LEGEND>Today's Upload Summary</LEGEND>
			<?php
				include_once("../database/queries.php") ;
				include_once("../lib/id3_info.php");
				
				$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
				$objQM->PrepareTodayUploadSummary(CSessionManager::GetUserId()) ; // Parameter is hardcoded, should be a variable holding $user_id.
			?>
		</FIELDSET>
		<BR/>
		<FIELDSET>
			<LEGEND>My Songs</LEGEND>
			<?php
			if(empty($pg))
			{
			 $pg = 1;
			}
				$objQM->PrepareMP3Listing(CSessionManager::GetUserId(),$pg) ; // Parameter is hardcoded, should be a variable holding $user_id.
			?>
		</FIELDSET>
	</BODY>
</HTML>