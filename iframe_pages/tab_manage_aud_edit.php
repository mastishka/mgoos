<?php
	include_once("../lib/utils.php") ;
	include_once("../lib/id3_info.php") ;
	include_once("../database/queries.php") ;
			
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url); // will return array of url components.
	parse_str($query_str["query"]) ; // the query string will be parsed here.
	
	$objDB = new CQueryManager(CConfig::DB_AUDIO) ;
	$mp3_info = $objDB->GetMp3Info($id) ;
?>
<HTML>
	<HEAD>
		<TITLE></TITLE>
		<SCRIPT TYPE="text/javascript" LANGUAGE="javascript">
			function OnCancel()
			{
				var page = <?php echo($pg); ?> ;
				if (page == 1)
				{
					window.location = "tab_manage_aud_mymp3.php" ;
				}
				else if (page == 2)
				{
					window.location = "tab_manage_aud_upload.php" ;
				}
			}
		</SCRIPT>
	</HEAD>
	<BODY>
		<FIELDSET>
			<LEGEND>Edit details</LEGEND>
			<FORM ACTION="tab_manage_aud_edit_confirm.php" METHOD="POST">
				<TABLE BORDER="0">
					<TR>
						<TD>Title:</TD>
						<TD><INPUT TYPE="TEXT" NAME="title" VALUE="<?php echo($mp3_info->GetTitle()); ?>"/></TD>
					</TR>
					<TR>
						<TD>Artist:</TD>
						<TD><INPUT TYPE="TEXT" NAME="artist" VALUE="<?php echo($mp3_info->GetArtist()); ?>"/></TD>
					</TR>
					<TR>
						<TD>Album:</TD>
						<TD><INPUT TYPE="TEXT" NAME="album" VALUE="<?php echo($mp3_info->GetAlbum()); ?>"/></TD>
					</TR>
					<TR>
						<TD>Year:</TD>
						<TD><INPUT TYPE="TEXT" NAME="year" VALUE="<?php echo($mp3_info->GetYear()); ?>"/></TD>
					</TR>
					<TR>
						<TD>Composer:</TD>
						<TD><INPUT TYPE="TEXT" NAME="composer" VALUE="<?php echo($mp3_info->GetComposer()); ?>"/></TD>
					</TR>
					<TR>
						<TD>Picturized On:</TD>
						<TD><INPUT TYPE="TEXT" NAME="picturizedon" VALUE="<?php echo($mp3_info->GetPicturizedOn()); ?>"/></TD>
					</TR>
					<TR>
						<TD>Genre:</TD>
						<TD>
							<SELECT name="genre" id="genre">
								<?php
								{// Block Start
									$objDB->PrepareGenreOptions($mp3_info->GetGenre()) ;
								}// Block End
								?>
							</SELECT>
						</TD>
					</TR>
					<TR>
						<TD>Mood:</TD>
						<TD>
							<SELECT name="mood" id="mood">
								<?php
								{// Block Start
									$objDB->PrepareMoodOptions($mp3_info->GetMood());
								}// Block End
								?>
							</SELECT>
						</TD>
					</TR>
					<TR>
						<TD>Language:</TD>
						<TD>
							<SELECT name="language" id="language">
								<?php
								{// Block Start
									$objDB->PrepareLangOptions($mp3_info->GetLanguage());
								}// Block End
								?>
							</SELECT>
						</TD>
					</TR>
					<TR>
						<TD>Lyrics:</TD>
						<TD><TEXTAREA NAME="lyrics" ROWS="5" COLS="40"><?php echo($mp3_info->GetLyrics()); ?></TEXTAREA></TD>
					</TR>
				</TABLE>
				
				<!-- Hidden Fields : Start -->
				<INPUT type="hidden" name="id" value="<?php echo($id); ?>"/>
				<!-- Hidden Fields : End -->
				
				<INPUT type="submit" value="Save"/>&nbsp;<INPUT type="button" onclick="javascript: OnCancel();" value="Cancel"/>
			</FORM>
		</FIELDSET>
	</BODY>
</HTML>