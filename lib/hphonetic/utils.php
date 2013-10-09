<?php
	class CUtils
	{
		/*
		 * Generate and return a random string of specified length.
		 */
		static function GetRandString($length)
		{
			$str = "" ;
			
			for($index = 0; $index < $length; $index++)
			{
				$str .= chr(rand(33,255)) ;
			}
			
			return $str ;
		}
		
		/*
		 * Encode Mp3 file, adds MX as first two chars.
		 */
		static function EncodeMp3($filepath)
		{
			// --------------------------------------------------------
			// Increase the memory limit for complete file allocation.
			// Earlier 8 MB now 25 MB
			// --------------------------------------------------------
			ini_set("memory_limit","80M");
			// --------------------------------------------------------
			
			$temp_name = $filepath."_write" ;
			
			// Create a file with temp name.
			$to_write = fopen($temp_name, "xb") ;
			$filedata = file_get_contents($filepath, FILE_BINARY) ;
			
			// Write 2 chars MX into the file
			fputs($to_write, "MX".CUtils::GetRandString(50)) ;
			
			// Now write complete file to temp file.
			fwrite($to_write, $filedata) ;
			
			// Close file handle.
			fclose($to_write) ;
			
			// Delete uploaded file.
			unlink($filepath) ;
			
			// Rename encoded file.
			rename($temp_name, $filepath) ;
		}
		
		/*
		 * Decode Mp3 file, removes first two chars (MX) from file.
		 */
		static function DecodeAndDumpMp3($filepath)
		{
			// --------------------------------------------------------
			// Increase the memory limit for complete file allocation.
			// Earlier 8 MB now 25 MB
			// --------------------------------------------------------
			ini_set("memory_limit","25M");
			// --------------------------------------------------------
			
			echo(file_get_contents($filepath, FILE_BINARY, null, 52)) ;
		}
		
		/*
		 * Return percet of word match.
		 */
		static function CompWords($ary_in_srch, $ary_to_srch)
		{
			$index = 0;
			$count = count($ary_in_srch) ;

			foreach($ary_in_srch as $word_1)
			{
				foreach($ary_to_srch as $word_2)
				{
					if(strcmp($word_1, $word_2) == 0)
					{
						$index++ ;
					}
				}
			}

			return ($index*100/$count) ;
		}
		
		/*
		 * For input 3 it will give 3+2+1, for 4 => 4+3+2+1 etc.
		 */
		static function SumUpto($count)
		{
			$sum = 0 ;
			
			for(; $count > 0; $count--)
			{
				$sum += $count ;
			}
			
			return $sum ;
		}
		
		/*
		 * Find words (param:2 array) in string (param:1).
		 */
		static function FindAndHighLight($str, $arrToFind)
		{
			if(is_numeric($str))
			{
				foreach($arrToFind as $word)
				{
					$str =  preg_replace("/\b$word\b/i", "<FONT COLOR='#FF3300'>".ucwords(strtolower($word))."</FONT>", $str) ;
				}
				return $str ;
			}
			
			$metaphone_str = CUtils::GetMetaphone($str) ;
			
			foreach($arrToFind as $word)
			{
				if (true)//(!function_exists('str_ireplace')) 
				{
					//$str =  preg_replace("/\b$word\b/i", "<FONT COLOR='#FF3300'>".ucwords(strtolower($word))."</FONT>", $str) ;
					$metaphone_str =  preg_replace("/\b".metaphone($word)."\b/i", "##R007##", $metaphone_str) ;
				}
				else
				{
					$metaphone_str = str_ireplace($word, "<FONT COLOR='#FF3300'>".ucwords(strtolower($word))."</FONT>", $str);
				}
			}
			
			$meta_ary = str_word_count($metaphone_str, 1, "#07") ;
			$str_ary  = str_word_count($str, 1) ;
			
			$index = 0 ;
			$str = "" ;
			foreach ($meta_ary as $meta_word)
			{
				if(strcasecmp($meta_word, "##R007##") == 0)
				{
					$str .= "<FONT COLOR='#FF3300'>".$str_ary[$index]."</FONT> " ;
				}
				else 
				{
					$str .= $str_ary[$index]." " ;
				}
				$index++ ;
			}
			return $str ;
		}
		
		/*
		 * Return corresponding metaphone string.
		 */
		static function GetMetaphone($str)
		{
			$word_ary = str_word_count($str, 1) ;
			$meta_str = "" ;
			
			foreach ($word_ary as $word)
			{
				$meta_str .= metaphone($word)." " ;
			}
			
			return $meta_str;
		}
		
		
		
		static function ProcessHindiPhonetic($word)
		{
			/* Eliminate Double Characters */
			$word=strtolower($word);
			$k=1;
			$word1="D";	
			$n=strlen($word);
			$word1[0]=$word[0];
			for($i=1;$i<=($n-1);$i++)
			{
				if($word[$i]!='e' && $word[$i]!='o')
				{
					if($word[$i]==$word[$i-1]);
					else $word1[$k++]=$word[$i];
				}
				else $word1[$k++]=$word[$i];
			}
			
			
			
			/* Process the word */
			
			$word=$word1;
			$n=strlen($word);
			$result="S";
			$k=0;
			//if($word[0]=='e') $word[0]='i';
			if($word=="mein" || $word=="main")
			{
				$result="me";
			}
			else if($word=="hain" || $word=="hai")
			{
				$result="he";
			}
			else if ($word=="hun" || $word=="hoon")
			{
				$result="hu";
			}
			else 
			{
			for($i=0;$i<(strlen($word)+1);$i++)
			{
                                switch($word[$i])
                                                {
                                                    case 'a' :
																if($i==0)
																{
																	//$result[$k++]='a';
															
																	if($word[$i+1]=='e')
                                                                    {
																		//echo Hello;
                                                                         $result[$k++]='e';
                                                                         $i++;
                                                                    }
																	else if($word[$i+1]=='i')
                                                                    {
                                                                                      if($i+2==$n)
                                                                                      {
                                                                                                         $result[$k++]='a';
                                                                                                         $result[$k++]='i';
                                                                                                         $i++;
                                                                                      }
                                                                                      else 
                                                                                      {
                                                                                           $result[$k++]='e';
                                                                                           $i++;
                                                                                      }
                                                                    }
                                                                    else if($word[$i+1]=='y' && $i+2==$n)
                                                                    {
                                                                         $result[$k++]='a';
                                                                         $result[$k++]='i';
                                                                         $i++;
                                                                    }
                                                                    
                                                                    else if($word[$i+1]=='u')
                                                                    {
                                                                         $result[$k++]='o';
                                                                         $i++;
                                                                    }
																	else if($i+1==$n)
																	{
																		$result[$k++]='a';
																	}
																	else $result[$k++]='a';
																}
																else 
																{
																if($word[$i+1]=='e')
                                                                    {
																		//echo Hello;
                                                                         $result[$k++]='e';
                                                                         $i++;
                                                                    }
																	else if($word[$i+1]=='i')
                                                                    {
                                                                                      if($i+2==$n)
                                                                                      {
                                                                                                         $result[$k++]='a';
                                                                                                         $result[$k++]='i';
                                                                                                         $i++;
                                                                                      }
                                                                                      else 
                                                                                      {
                                                                                           $result[$k++]='e';
                                                                                           $i++;
                                                                                      }
                                                                    }
                                                                    else if($word[$i+1]=='y' && $i+2==$n)
                                                                    {
                                                                         $result[$k++]='a';
                                                                         $result[$k++]='i';
                                                                         $i++;
                                                                    }
                                                                    
                                                                    else if($word[$i+1]=='u')
                                                                    {
                                                                         $result[$k++]='o';
                                                                         $i++;
                                                                    }
																	else if($i+1==$n)
																	{
																		$result[$k++]='a';
																	}
																}
                                                                    break;
                                                                   
                                                    case 'b' : $result[$k++]='b'; break;
                                                    case 'c' : $result[$k++]='c'; break;
                                                    case 'd' : $result[$k++]='d'; break;
                                                    case 'e' :              if($i==0)
																			{
																				$result[$k++]='i';
																			}
                                                                             else if($word[$i+1]=='e')
                                                                             {
                                                                                               if($word[$i+2]=='y');
                                                                                               else $result[$k++]='i';
                                                                                               $i++;
                                                                             }
                                                                             else if($word[$i+1]=='i' && $word[$i+2]=='n')
                                                                             {
                                                                                              $result[$k++]='e';
                                                                                              $i=$i+2;
                                                                             }
                                                                             else if($word[$i+1]=='i')
                                                                             {
                                                                                  $result[$k++]='i';
                                                                                  $i++;
                                                                             }
                                                                             else $result[$k++]='e'; 
																			
                                                                             break;
                                                                 
                                                    case 'f' : $result[$k++]='f'; break;
                                                    case 'g' : if($word[$i+1]=='h')
																{
																	$result[$k++]='g';
																	$i++;
																}
																else $result[$k++]='g'; break;
                                                    case 'h' : 
                                                                
                                                                if($i+1==$n && ($word[$i-1]=='a' || $word[$i-1]=='e' || $word[$i-1]=='g' || $word[$i-1]=='j' || $word[$i-1]=='u'));
                                                                else $result[$k++]='h';
                                                                break;
                                                                
                                                    case 'i' : if($word[$i+1]=='y') ;
                                                               
                                                               else $result[$k++]='i'; break;
                                                    case 'j' : if($word[$i+1]=='h')
																{
																	$result[$k++]='j';
																	$i++;
																}
																else $result[$k++]='j'; break;
                                                    case 'k' : $result[$k++]='k'; break;
                                                    case 'l' : $result[$k++]= 'l'; break;
                                                    case 'm' : $result[$k++]='m'; break;
                                                    case 'n' : $result[$k++]='n'; break;
                                                    case 'o' :if($word[$i+1]=='n' && $i==$n-2)
															{
																$result[$k++]='o';
																$i++;
															}
                                                            else if($word[$i+1]=='w' || $word[$i+1]=='v' || $word[$i+1]=='u')
                                                             {
                                                                               
                                                                               $result[$k++]='o';
                                                                               $i++;
                                                             }
                                                             else if($word[$i+1]=='o')
                                                             {
                                                                  if($word[$i-1]=='r' && ($word[$i-2]=='m' || $word[$i-2]=='n' || $word[$i-2]=='v' || $word[$i-2]=='b' || $word[$i-2]=='g' || $word[$i-2]=='k'))
                                                               {
                                                                    $result[$k++]='i';
                                                               }
                                                               else               $result[$k++]='u';
                                                                              $i++;
                                                             }   
                                                             else $result[$k++]='o'; break;
                                                    case 'p' : 
                                                               if ($word[$i+1]=='h')
                                                               {
                                                                                 $result[$k++]='f';
                                                                                 $i++;
                                                               }
                                                               else $result[$k++]='p';
                                                               break;
                                                               
                                                    case 'q' : $result[$k++]='k'; break;
                                                    case 'r' : $result[$k++]='r'; break;
                                                    case 's' : if($word[$i+1]=='h')
																{
																	$result[$k++]='s';
																	$i++;
																}
																else $result[$k++]='s'; break;
                                                    case 't' : if($word[$i+1]=='h')
																{
																	$result[$k++]='t';
																	$i++;
																}
																else $result[$k++]='t'; break;
                                                    case 'u' : 
                                                         if($word[$i-1]=='r' && ($word[$i-2]=='m' || $word[$i-2]=='n' || $word[$i-2]=='v' || $word[$i-2]=='b' || $word[$i-2]=='g' || $word[$i-2]=='k'))
                                                               {
                                                                    $result[$k++]='i';
                                                               }
                                                               else $result[$k++]='u'; break;            
                                                    case 'v' : $result[$k++]='v'; break;
                                                    case 'w' : $result[$k++]='v'; break;
                                                    case 'x' : 
                                                                $result[$k++]='k';
                                                                $result[$k++]='s';
                                                                break;
                                                                
                                                   case 'y' : 
                                                               if($i==strlen($word)-1)
                                                               $result[$k++]='i';
                                                               else $result[$k++]='y';
                                                               break;
                                                   case 'z' :  if($word[$i+1]=='h')
																{
																	$result[$k++]='g';
																	$i++;
																}
																else $result[$k++]='j'; break;
                                                   case '1' : $result[$k++]='1'; break;
												   case '2' : $result[$k++]='2'; break;
												   case '3' : $result[$k++]='3'; break;
												   case '4' : $result[$k++]='4'; break;
												   case '5' : $result[$k++]='5'; break;
												   case '6' : $result[$k++]='6'; break;
												   case '7' : $result[$k++]='7'; break;
												   case '8' : $result[$k++]='8'; break;
												   case '9' : $result[$k++]='9'; break;
												   case '0' : $result[$k++]='0'; break;
												   default : ;
                                                }
                                }
			}
                                return $result;
		}
			 
		
		static function GetHindiPhonetic($str)
		{
			$word_arr = str_word_count($str, 1,0123456789) ;
			$meta_str = "";
			
			foreach ($word_arr as $word)
			{
				$meta_str .= CUtils::ProcessHindiPhonetic($word)." " ;
//				$meta_str .= exec ("C:\purav.exe ".$word);
			}
			//$meta_str = str_word_count($meta_str,1);
			return $meta_str;
		}	
		
		
		
		/* 
		 * Redirect to a different page. Path to file with reference to host (root) is required.
		 */
		static function Redirect($filepath)
		{
			$host  = $_SERVER['HTTP_HOST'] ;
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\') ;
			//echo("http://".$host.$uri."/".$filepath) ;
			header("Location: http://".$host.$uri."/".$filepath) ;
		}
		
		/*
		 * Rertieve Current Page URL.
		 */
		static function curPageURL() 
		{
			$pageURL = 'http';
			if ($_SERVER["HTTPS"] == "on")
			{
				$pageURL .= "s";
			}
			$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") 
			{
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
			}
			else
			{
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			}
			return $pageURL;
		}
		
		/**
		 * Generates a Universally Unique IDentifier, version 4.
		 *
		 * RFC 4122 (http://www.ietf.org/rfc/rfc4122.txt) defines a special type of Globally
		 * Unique IDentifiers (GUID), as well as several methods for producing them. One
		 * such method, described in section 4.4, is based on truly random or pseudo-random
		 * number generators, and is therefore implementable in a language like PHP.
		 *
		 * We choose to produce pseudo-random numbers with the Mersenne Twister, and to always
		 * limit single generated numbers to 16 bits (ie. the decimal value 65535). That is
		 * because, even on 32-bit systems, PHP's RAND_MAX will often be the maximum *signed*
		 * value, with only the equivalent of 31 significant bits. Producing two 16-bit random
		 * numbers to make up a 32-bit one is less efficient, but guarantees that all 32 bits
		 * are random.
		 *
		 * The algorithm for version 4 UUIDs (ie. those based on random number generators)
		 * states that all 128 bits separated into the various fields (32 bits, 16 bits, 16 bits,
		 * 8 bits and 8 bits, 48 bits) should be random, except : (a) the version number should
		 * be the last 4 bits in the 3rd field, and (b) bits 6 and 7 of the 4th field should
		 * be 01. We try to conform to that definition as efficiently as possible, generating
		 * smaller values where possible, and minimizing the number of base conversions.
		 *
		 * @copyright   Copyright (c) CFD Labs, 2006. This function may be used freely for
		 *              any purpose ; it is distributed without any form of warranty whatsoever.
		 * @author      David Holmes <dholmes@cfdsoftware.net>
		 *
		 * @return  string  A UUID, made up of 32 hex digits and 4 hyphens.
		 */
	
		static function uuid() 
		{
			// The field names refer to RFC 4122 section 4.1.2
			
			return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
			    mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
			    mt_rand(0, 65535), // 16 bits for "time_mid"
			    mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
			    bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			        // 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
			        // (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
			        // 8 bits for "clk_seq_low"
			    mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node" 
				); 
		}
		
		static function PreparePaging($pageno,$row_count,$href,$pid,$browsealbum)
		{
			$pg = "?pg";
			if($row_count > 10)
			{
			if($browsealbum)
			{
			$pg = "pageno";
			}
				$page_count = ceil($row_count/10);
				$remainder =  $pageno%10;
				
				if($remainder == 0)
				{
					$remainder++;
				}
				
				$startoffset =  floor($pageno/10)*$remainder;							
				$endoffset =  floor($pageno/10)*($remainder)  + 10;
				if($startoffset > 0)
				{
					$startoffset = ($startoffset + (5 - ($startoffset%5))) ; 
					$endoffset = ($endoffset + (5 - ($endoffset%5))) ;  
				}
				if($endoffset >= $page_count )
				{
					$endoffset = $page_count;
				}
				if($pageno >= $page_count)
				{
					$pageno = $page_count;
				}
				if($pageno -1 != $startoffset)
				{
					printf("<B><A HREF=\"%s".$pg."=%d&pid=%s\">&lt; Prev</A>&nbsp;&nbsp;&nbsp;",$href,$pageno-1,$pid);
				}
				else 
				{
					printf("<B><A >&lt; Prev</A>&nbsp;&nbsp;&nbsp;");
				}
				for($i = $startoffset; $i < $endoffset; $i++)
				{
					if($pageno-1 !=$i)
					{
						printf("<A HREF=\"%s".$pg."=%d&pid=%s\">%d</A>&nbsp;&nbsp;",$href,$i+1,$pid, $i+1) ;
					}
					else
					{
						printf("<A>%d</A>&nbsp;&nbsp;",$i+1) ;
					}
				}
				if($pageno != $endoffset)
				{
					printf("&nbsp;&nbsp;<A HREF=\"%s".$pg."=%d&pid=%s\">Next &gt;</A></B></BR>",$href,$pageno+1,$pid);
				}
				else
				{
					printf("&nbsp;&nbsp;<A>Next &gt;</A></B></BR>");	
				}
			}
		}
	}
?>