<TD class ="tdcolor">
	<?php
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
				echo("&nbsp;|&nbsp;<A class='anchor' HREF=\"".$root."my_mgoos.php\"><EM><span class ='boldfont'>Login</span></EM></A>&nbsp;");
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
		?>
	<BR/> <FONT class="tdcolor" >&copy; Copyright <?php echo(date("Y")); ?> Mastishka Inc.</FONT>
</TD>