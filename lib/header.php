<TD class ="tdcolor">
	<?php
		include_once("../database/config.php") ;
		include_once("../database/queries.php") ;
		include_once("utils.php") ;
		include_once("mgoos_config.php") ;

		$url = CUtils::curPageURL() ;
		$query_str=parse_url($url);// not to use.
		$root = "";

		parse_str($query_str["query"]) ;
			if($folder_level)
			 {
			    //Root level
				$root = "../";
			 }

			if($page_id == CMGoosConfig::HF_HOME_ID)
			 {
				echo("<span class ='boldfont'>Home </span>&nbsp;|&nbsp;");
			 }
			else
			 {
				echo("<A class='anchor' HREF=\"".$root."index.php\"><EM><span class ='boldfont'>Home </span></EM></A>&nbsp;|&nbsp;");	
			 }
			if($page_id == CMGoosConfig::HF_ABT_US_ID)
			 {
				echo("<span class ='boldfont'>About Us</span>");
			 }
			else
			 {
				echo("<A class='anchor' HREF=\"".$root."aboutus.php\"><EM><span class='boldfont'>About Us</span></EM></A>");
			 }
			if($page_id == CMGoosConfig::HF_LOGIN_ID)
			 {
				echo("&nbsp;|&nbsp;<span class ='boldfont'>Login </span>&nbsp;");
			 }
			else
			 {
			     if($login)
				 {
					echo("&nbsp;|&nbsp;<A class='anchor' HREF=\"".$root."login/logout.php\"><EM><span class ='boldfont'>Logout</span></EM></A>&nbsp;");
				 }
				 else
				 {
					 // HREF=\"".$root."my_mgoos.php\"
					echo("&nbsp;|&nbsp;<A class='anchor' HREF='my_mgoos.php' OnClick = 'return clicker(1);'><EM><span class ='boldfont'>Login</span></EM></A>&nbsp;");
				 }
			  }
		    
			if($page_id == CMGoosConfig::HF_ADV_SRCH_ID)
			 {
				echo("&nbsp;|&nbsp;<span class ='boldfont'>Advance Search
				</span>&nbsp;");
			 }
			else
			 {
				echo("&nbsp;|&nbsp;<A class='anchor' HREF=\"".$root."advance_search.php\"><EM><span class ='boldfont'>Advance Search</span></EM></A>&nbsp;");
			 }
			 ?>

             | <A class="anchor" HREF="http://groups.google.co.in/group/mgoos" TARGET="_blank"><EM><span class ='boldfont'>Forum</span></EM></A>


			 <?php
			if($page_id == CMGoosConfig::HF_DISCLAIMER_ID)
			 {
				echo("&nbsp;|&nbsp;<span class ='boldfont'>Disclaimer</span>&nbsp;");
			 }
			else
			 {
				echo("&nbsp;|&nbsp;<A class='anchor' HREF=\"".$root."disclaimer.php\"><EM><span class ='boldfont'>Disclaimer</span></EM></A>&nbsp;");
			 }
			 if($page_id == CMGoosConfig::HF_TOS_ID)
			 {
				echo("&nbsp;|&nbsp;<span class ='boldfont'>Terms of Service </span>&nbsp;");
			 }
			else
			 {
				echo("&nbsp;|&nbsp;<A class='anchor' HREF=\"".$root."tos.php\"><EM><span class ='boldfont'>Terms of Service</span></EM></A>&nbsp;");
			 }
			 $objQM = new CQueryManager(CConfig::DB_AUDIO) ;
			 $file_cnt = $objQM->GetDBFileCount() ;
		?><BR/>
		<em>Searching through <?php echo(floor($file_cnt*2.25)); ?> audio files and increasing...</em>
 </TD>