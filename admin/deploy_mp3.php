<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head>
		<title>MGooS Admin</title>
		<link href="../css/speed_upload.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
			table table td {
				width: 250px;
				white-space: nowrap;
				padding-right: 5px;
			}
			table table tr:nth-child(2n+1) {
				background-color: #EEEEEE;
			}
			table table td:first-child {
				font-weight: bold;
			}
			table table td:nth-child(2) {
				text-align: right;
				font-family: monospaced;
			}
		</style>
		<script language='javascript' src='js/swfobject.js'></script>
		<script language='javascript' src='js/wimpy.js'></script>
		<script language='javascript' src='../js/ajax.js'></script>
		<script language='javascript'>
			var count = 0 ;
			var elements = 0 ;
			
			function GetRow(index)
			{
				var poststr = "row=" + encodeURI(index);
				
				//alert(poststr) ;	  
				AJAX.MakePostRequest("get_row_mp3_info.php", poststr, CallBack_GetRow);
			}
			
			function CallBack_GetRow()
			{
				var contents = AJAX.GetContents() ;
				var file = "" ;
				//alert(contents) ;
				if(contents != false)
				{
					var response_json = eval('(' + contents + ')') ;
					var mood;
					
					if(response_json.result.bResult == true)
					{
						elements = response_json.result.elements;
						file = response_json.result.file;
						document.getElementById("title").value = response_json.result.title ;
						document.getElementById("artist").value = response_json.result.artist ;
						document.getElementById("album").value = response_json.result.album ;
						document.getElementById("year").value = response_json.result.year ;
						document.getElementById("composer").value = response_json.result.composer ;
						document.getElementById("picturizedon").value = response_json.result.picturizedon ;
						
						genre = document.getElementById("genre_"+response_json.result.genre) ;
						if(genre != null)
						{
							genre.value = response_json.result.genre ;
							genre.selected = "selected" ;
							genre.innerHTML = response_json.result.genre ;
						}
						
						mood = document.getElementById("mood_"+response_json.result.mood) ;
						if(mood != null)
						{
							mood.value = response_json.result.mood ;
							mood.selected = "selected" ;
							mood.innerHTML = response_json.result.mood ;
						}
						
						lang = document.getElementById("language");
						if(lang != null)
						{
							lang.value = response_json.result.language ;
							lang.selected = "selected" ;
							lang.innerHTML = response_json.result.language ;
						}
						
						document.getElementById("lyrics").value = response_json.result.lyrics ;
						document.getElementById("filesize").value = response_json.result.filesize ;
						document.getElementById("bitrate").value = response_json.result.bitrate ;
						document.getElementById("duration_sec").value = response_json.result.duration_sec ;
					}
				}
			}
			
			function OnPrev()
			{
				count--;
				GetRow(count);
			}
			
			function OnNext()
			{
				count++;
				GetRow(count);
			}			
		</script>
	</head>
	<body>
		<?php
			include("../database/queries.php");
			$objDB = new CQueryManager(CConfig::DB_AUDIO) ;
		?>
		<p align="Center"><H2>MGooS Admin - MP3 Files Upload</H2><BR/><b><a href="swift_upload.php"><u>Upload MP3</u></a>&nbsp;&nbsp;Deploy MP3</b><BR/></p>
		<div id="content">
		<h2>Edit & Deploy MP3</h2>
		<TABLE BORDER="0">
			<TR>
				<TD>
					<FIELDSET>
						<LEGEND>Please confirm details about uploaded file<BR/><a href="javascript:;" onclick="return OnPrev();">&lt;&lt; Prev</a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="return OnNext();">Next &gt;&gt;</a><BR/><a href="">Add To Playlist</a></LEGEND>
						<FORM  ID="upload" name="upload" ACTION="upload_mp3_confirm.php" METHOD="POST">
							<TABLE BORDER="0">
								<TR>
									<TD><b>Title:</b><BR/></TD>
									<TD><INPUT ID="title" TYPE="TEXT" NAME="title" VALUE="" onblur="checkForEmpty(this);">&nbsp;&nbsp;<IMG ID="title_cr" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="title_wr" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><br/></TD>
								</TR>
								<TR>
									<TD><b>Artist:</b><BR/></TD>
									<TD><INPUT ID="artist" TYPE="TEXT" NAME="artist" VALUE="" onblur="checkForEmpty(this);">&nbsp;&nbsp;<IMG ID="artist_cr" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="artist_wr" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><br/></TD>
								</TR>
								<TR>
									<TD><b>Album:</b><BR/></TD>
									<TD><INPUT ID="album" TYPE="TEXT" NAME="album" VALUE="" onblur="checkForEmpty(this);"/>&nbsp;&nbsp;<IMG ID="album_cr" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="album_wr" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><br/></TD>
								</TR>
								<TR>
									<TD><b>Year:</b><BR/></TD>
									<TD><INPUT TYPE="TEXT" NAME="year" ID="year" VALUE=""/><br/></TD>
								</TR>
								<TR>
									<TD><b>Composer:</b><BR/></TD>
									<TD><INPUT TYPE="TEXT" NAME="composer" ID="composer" VALUE=""/><br/></TD>
								</TR>
								<TR>
									<TD><b>Picturized On:</b><BR/></TD>
									<TD><INPUT TYPE="TEXT" NAME="picturizedon" ID="picturizedon" VALUE=""/><br/></TD>
								</TR>
								<TR>
									<TD><b>Genre:</b><BR/></TD>
									<TD>
										<SELECT id="genre" name="genre" id="genre" onblur="checkForEmpty(this);">
											<option value="">----Select----</option>
											<?php
											{// Block Start
												$objDB->PrepareGenreOptions("");
											}// Block End
											?>
										</SELECT>&nbsp;&nbsp;<IMG ID="genre_cr" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="genre_wr" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><br/>
									</TD>
								</TR>
								<TR>
									<TD><b>Mood:</b><BR/></TD>
									<TD>
										<SELECT name="mood" id="mood">
										<option value="">----Select----</option>
											<?php
											{// Block Start
												$objDB->PrepareMoodOptions("");
											}// Block End
											?>
										</SELECT>&nbsp;&nbsp;<IMG ID="mood_cr" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="mood_wr" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><br/>
									</TD>
								</TR>
								<TR>
								<TR>
									<TD><b>Language:</b><BR/></TD>
									<TD>
										<SELECT id="language" name="language" id="language" onblur="checkForEmpty(this);">
											<?php
											{// Block Start
												$objDB->PrepareLangOptions("");
											}// Block End
											?>
										</SELECT>&nbsp;&nbsp;<IMG ID="language_cr" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="language_wr" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><br/></TD>
								</TR>
								<TR>
									<TD><b>Available for:</b><BR/></TD>
									<TD>Me only: <INPUT TYPE="radio" NAME="status" VALUE="0">&nbsp;&nbsp;&nbsp;&nbsp;Everyone: <INPUT TYPE="radio" NAME="status" VALUE="1" CHECKED="checked"><br/></TD>
								</TR>
								<TR>
									<TD><b>Lyrics:</b></TD>
									<TD><TEXTAREA id="lyrics" NAME="lyrics" ROWS="5" COLS="40" onblur="checkForEmpty(this);"></TEXTAREA></TD>
								</TR>
							</TABLE>
							
							<!-- Hidden Fields : Start -->
							<INPUT type="hidden" id="file" name="file" value=""/>
							<INPUT type="hidden" id="filesize" name="filesize" value=""/>
							<INPUT type="hidden" id="bitrate" name="bitrate" value=""/>
							<INPUT type="hidden" id="duration_sec" name="duration_sec" value=""/>
							<INPUT type="hidden" name="user_id" value="<?php echo("user_id"); ?>"/>
							<!-- Hidden Fields : End -->
							
							<INPUT type="submit"  value="Deploy" OnClick="return validateUserForm();"/>
						</FORM>
					</FIELDSET>
				</TD>
				<TD>
					<div id="wimpyTarget">You need to upgrade your Flash Player</div>
					<script language="JavaScript" >
						makeWimpyPlayer("blank.xml");
						GetRow(0);
					</script>
				</TD>
			</TR>
		</TABLE>
		</div>
	</body>
</html>
