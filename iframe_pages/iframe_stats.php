<HTML>
	<HEAD>
		<TITLE></TITLE>
		<SCRIPT language="javascript">
			var count = 300 ;
			var timerHandle = setInterval("UpdateSeconds()", 1000) ;
			
			function UpdateSeconds()
			{
				document.getElementById("TIME_TO_UPDATE").innerHTML = count ;
				
				count-- ;
				if(count == 0)
				{
					clearInterval(timerHandle) ;
					window.location = window.location ;
				}
			}
			function SetSearchtext(srchtext)
			{
				var topbar =  parent.document.getElementById("SEARCH_BAR_TOP");				
				topbar.srchtxt.value= srchtext;				
			}
		</SCRIPT>		
	</HEAD>
	<BODY>
		<?php
			include_once("../database/config.php") ;
			include_once("../database/search_helper.php") ;
			
			$count = 10 ; // We want to retrive $count top search elements.
			$objSHAna = new CSearchHelper(CConfig::DB_ANALYTICS) ;
			$top_search_element_ary = $objSHAna->GetTopSearchElement($count) ;
			
			$objSHAud = new CSearchHelper(CConfig::DB_AUDIO) ;
			$aud_choice_ary = $objSHAud->GetAudienceChoice($count) ;
		?>
		<TABLE WIDTH="150" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR>
				<TD ALIGN="CENTER">
					<FIELDSET>
						<LEGEND><B><FONT COLOR="#FF9900">Next Update</FONT></B></LEGEND>
						<FONT SIZE="2">Will be in <SPAN ID="TIME_TO_UPDATE">300</SPAN> Seconds.</FONT>
					</FIELDSET>
				</TD>
			</TR>
			<TR>
				<TD>
					<FIELDSET>
						<LEGEND><B><FONT COLOR="#FF9900">Top Search</FONT></B></LEGEND>
						<FONT SIZE="2">
						<?php
							$i = 0 ;
							foreach($top_search_element_ary as $element)
							{
								printf("<A Href=\"tab_search_results.php?qry=%s&pg=1&ext=%s\"  TARGET=\"SEARCH_RESULTS\" onClick =\"SetSearchtext('%s') \" >%s</A>", urlencode($element[0]), $element[1],$element[0], $element[0]) ;
								$i++;
								
								if($i < $count)
								{
									echo("<BR/>") ;
								}
							}
						?>
						</FONT>
					</FIELDSET>
				</TD>
			</TR>
			<TR>
				<TD>
					<FIELDSET>
						<LEGEND><B><FONT COLOR="#FF9900">Today's Popular</FONT></B></LEGEND>
						<FONT SIZE="2">
						<?php
							$i = 0 ;
							foreach($top_search_element_ary as $element)
							{
								printf("<A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=%s\" TARGET=\"SEARCH_RESULTS\"  onClick =\"SetSearchtext('%s')\">%s</A>", urlencode($element[0]), $element[1], $element[0], $element[0]) ;
								$i++;
								
								if($i < $count)
								{
									echo("<BR/>") ;
								}
							}
						?>
						</FONT>
					</FIELDSET>
				</TD>
			</TR>
			<TR>
				<TD>
					<FIELDSET>
						<LEGEND><B><FONT COLOR="#FF9900">Audience Choice</FONT></B></LEGEND>
						<FONT SIZE="2">
						<?php
							$i = 0 ;
							foreach($aud_choice_ary as $element)
							{
								printf("* <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\" TARGET=\"SEARCH_RESULTS\">%s</A>&nbsp;:&nbsp;<A HREF =\"javascript:; \" onClick=\"parent.SR.AddToPlaylistUrl('%s','%s');SetSearchtext('%s')\">%s</A>", urlencode($element[0]), $element[0], $element[2], $element[1], $element[0], $element[1]) ;
								$i++;
								
								if($i < $count)
								{
									echo("<BR/>") ;
								}
							}
						?>
						</FONT>
					</FIELDSET>
				</TD>
			</TR>
		</TABLE>
	</BODY>
</HTML>