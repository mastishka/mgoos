<?php
	include_once ('../../database/config.php');
	include_once ('../../lib/utils.php');
	include ("crawler_helper.php");
	set_time_limit(0);
	header("Cache-Control: no-cache, must-revalidate");
	$objCHlpr = new CrawlerHelper();
	
	$mode = $_GET['mode'];
	
	/*
	#- Debug Code -#
	echo $mode;
	$objCHlpr->flushHard();
	*/
	
	switch($mode)
	{
		case 1:
			if(isset($_GET['asite']))
			{
				$url_arrived=$_GET['asite'];
				$objCHlpr->FlushString("update","Inside crawler");
				$objCHlpr->InvokeCrawler($url_arrived);
			}
			break;
		case 2:
			$objCHlpr->TruncateCraweldNonMp3Urls();
			$objCHlpr->FlushString("update","Table Truncated");
			break;
		case 3:
			$objCHlpr->ProcessCrawledMp3Urls();
			break;
		case 4:
			$objCHlpr->CrawledUrlStats();
			break;
		case 5:
			$objCHlpr->Reconciliation();
			break;
		default:
			exit(0);
	}
?>