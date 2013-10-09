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
	<script type="text/javascript" src="../js/swfupload.js"></script>
	<script type="text/javascript" src="../js/swfupload.queue.js"></script>
	<script type="text/javascript" src="../js/swfupload.speed.js"></script>
	<script type="text/javascript" src="../js/swfupload.handlers.js"></script>
	<script type="text/javascript">
		var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "../swf/swfupload.swf",
				upload_url: "upload_mp3.php",
				file_size_limit : "100 MB",
				file_types : "*.mp3",
				file_types_description : "MP3 Files",
				file_upload_limit : 100,
				file_queue_limit : 0,

				debug: false,

				// Button settings
				button_image_url: "../images/XPButtonSelectMp3.png",
				button_width: "138",
				button_height: "22",
				button_placeholder_id: "spanButtonPlaceHolder",
				
				moving_average_history_size: 40,
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_dialog_complete_handler: fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				upload_error_handler : uploadError,
				
				custom_settings : {
					tdFilesQueued : document.getElementById("tdFilesQueued"),
					tdFilesUploaded : document.getElementById("tdFilesUploaded"),
					tdErrors : document.getElementById("tdErrors"),
					tdCurrentSpeed : document.getElementById("tdCurrentSpeed"),
					tdAverageSpeed : document.getElementById("tdAverageSpeed"),
					tdMovingAverageSpeed : document.getElementById("tdMovingAverageSpeed"),
					tdTimeRemaining : document.getElementById("tdTimeRemaining"),
					tdTimeElapsed : document.getElementById("tdTimeElapsed"),
					tdPercentUploaded : document.getElementById("tdPercentUploaded"),
					tdSizeUploaded : document.getElementById("tdSizeUploaded"),
					tdProgressEventCount : document.getElementById("tdProgressEventCount"),
					tdErrorDescription : document.getElementById("tdErrorDescription"),
					tdErrorCode : document.getElementById("tdErrorCode")
				}
			};

			swfu = new SWFUpload(settings);
	     };
	</script>
</head>
<body>
<H2><p align="Center"> MGooS Admin - MP3 Files Upload<p></H2>

<div id="content">
	<b>Upload MP3&nbsp;&nbsp;<a href="deploy_mp3.php"><u>Deploy MP3</u></a></b>
	<h2>Swift Upload</h2>
	<form id="form1" action="swift_upload.php" method="post" enctype="multipart/form-data">
		<p>This section uploads mp3 files with utmost speed.</p>

		<div style="width: 61px; height: 22px; margin-bottom: 10px;">
			<span id="spanButtonPlaceHolder"></span>
		</div>

		<table cellspacing="0">
			<tr>
				<td>
					<table cellspacing="0">
						<tr>
							<td>Files Queued:</td>
							<td id="tdFilesQueued"></td>
						</tr>			
						<tr>
							<td>Files Uploaded:</td>
							<td id="tdFilesUploaded"></td>
						</tr>
						<tr>
							<td>Errors:</td>
							<td id="tdErrors"></td>
						</tr>
						<tr>
							<td>Error Description:</td>
							<td id="tdErrorDescription"></td>
						</tr>
						<tr>
							<td>Error Code:</td>
							<td id="tdErrorCode"></td>
						</tr>
					</table>
				</td>
				<td>
					<table cellspacing="0">
						<tr>
							<td>Current Speed:</td>
							<td id="tdCurrentSpeed"></td>
						</tr>			
						<tr>
							<td>Average Speed:</td>
							<td id="tdAverageSpeed"></td>
						</tr>			
						<tr>
							<td>Moving Average Speed:</td>
							<td id="tdMovingAverageSpeed"></td>
						</tr>			
						<tr>
							<td>Time Remaining</td>
							<td id="tdTimeRemaining"></td>
						</tr>			
						<tr>
							<td>Time Elapsed</td>
							<td id="tdTimeElapsed"></td>
						</tr>			
						<tr>
							<td>Percent Uploaded</td>
							<td id="tdPercentUploaded"></td>
						</tr>			
						<tr>
							<td>Size Uploaded</td>
							<td id="tdSizeUploaded"></td>
						</tr>			
						<tr>
							<td>Progress Event Count</td>
							<td id="tdProgressEventCount"></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>
