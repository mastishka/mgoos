<?php
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<TITLE>Please wait...</TITLE>
		<SCRIPT LANGUAGE="JavaScript">
		<!--
			/*session_id = 0;
			function genHex()
			{
				colors = new Array(14) ;
				colors[0]="0" ;
				colors[1]="1" ;
				colors[2]="2" ;
				colors[3]="3" ;
				colors[4]="4" ;
				colors[5]="5" ;
				colors[5]="6" ;
				colors[6]="7" ;
				colors[7]="8" ;
				colors[8]="9" ;
				colors[9]="a" ;
				colors[10]="b" ;
				colors[11]="c" ;
				colors[12]="d" ;
				colors[13]="e" ;
				colors[14]="f" ;
				
				digit = new Array(5) ;
				color="" ;
				for (i=0;i<6;i++)
				{
					digit[i]=colors[Math.round(Math.random()*14)] ;
					color = color+digit[i] ;
				}

				return color;
			}*/
			function CheckForParent()
			{
				window.parent.location = "../swift_upload.php" ;
				//window.parent.location = "../search_results.php?ai="+genHex()+session_id+"" ;
			}
		//-->
		</SCRIPT>
	</HEAD>
	
	<BODY>
		<B>Verifying Login Details.<BR/>Please Wait...<BR/></B>
		<IMG SRC="images/updating.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="">
		<?php
			echo("<SCRIPT LANGUAGE=\"JavaScript\">") ;
			echo("session_id='".session_id()."';") ;
			echo("CheckForParent();") ;
			echo("</SCRIPT>") ;
		?>
	</BODY>
</HTML>
