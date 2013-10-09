<?php
	include_once("utils.php") ;
	
	class CId3Info
	{
		private $id ;
		private $filepath ;
		private $artist ;
		private $album ;
		private $title ;
		private $genre ;
		private $mood ;
		private	$filesize ;
		private $bitrate ;
		private	$duration_sec ;
		private $language ;
		private	$status ; // 0 : Private, 1 : Public, 2: Issued Private
		private $lyrics ;
		private $composer ;
		private $picturizedon ;
		private $year ;
		private	$user_id ;
		private $provider ;
		
		public function  __construct($post_ary)
		{
			
			/*echo("<pre>") ;
			print_r($post_ary) ;
			echo("</pre>") ;*/
			
			
			if(empty($post_ary['id']))
			{
				$this->id 		= CUtils::uuid() ;
			}
			else 
			{
				$this->id 		= $post_ary['id'] ;
			}
			$this->filepath 	= $post_ary['filepath'] ;
			$this->artist 		= $post_ary['artist'] ;
			$this->album 		= $post_ary['album'];
			$this->title 		= $post_ary['title'] ;
			$this->genre 		= $post_ary['genre'] ;
			$this->mood 		= $post_ary['mood'] ;
			$this->filesize 	= $post_ary['filesize'] ;
			$this->bitrate 		= $post_ary['bitrate'] ;
			$this->duration_sec = $post_ary['duration_sec'] ;
			$this->language 	= $post_ary['language'] ;
			$this->status 		= $post_ary['status'] ; // 0 : Public, 1 : Friends, 2: Private
			$this->lyrics 		= $post_ary['lyrics'] ;
			$this->composer 	= $post_ary['composer'] ;
			$this->picturizedon = $post_ary['picturizedon'] ;
			$this->year 		= $post_ary['year'] ;
			$this->user_id 		= $post_ary['user_id'] ;
			$this->provider		= $post_ary['provider'] ;
		}
		
		public function GetID()
		{
			return $this->id ;
		}
		public function SetID($id)
		{
			$this->id = $id ;
		}
		
		public function GetFilePath()
		{
			return $this->filepath ;
		}
		public function SetFilePath($filepath)
		{
			$this->filepath = $filepath ;
		}
		
		public function GetArtist()
		{
			return $this->artist ;
		}		
		public function SetArtist($artist)
		{
			$this->artist = $artist ;
		}
		
		public function GetAlbum()
		{
			return $this->album ;
		}		
		public function SetAlbum($album)
		{
			$this->album = $album ;
		}
		
		public function GetTitle()
		{
			return $this->title ;
		}		
		public function SetTitle($title)
		{
			$this->title = $title ;
		}
		
		public function GetGenre()
		{
			return $this->genre ;
		}		
		public function SetGenre($genre)
		{
			$this->genre = $genre ;
		}
		public function GetMood()
		{
			if($this->mood==null)
				$this->mood = "";
			return $this->mood ;
			
		}
		public function SetMood($mood)
		{
			$this->mood = $mood;
		}
		
		public function GetFileSize()
		{
			return $this->filesize ;
		}
		public function SetFileSize($filesize)
		{
			$this->filesize = $filesize ;
		}
		
		public function GetBitRate()
		{
			return $this->bitrate ;
		}
		public function SetBitRate($bitrate)
		{
			$this->bitrate = $bitrate ;
		}
		
		public function GetDurationSec()
		{
			return $this->duration_sec ;
		}
		public function SetDurationSec($duration_sec)
		{
			$this->duration_sec = $duration_sec ;
		}
		
		public function GetLanguage()
		{
			return $this->language ;
		}		
		public function SetLanguage($language)
		{
			$this->language = $language ;
		}
		
		public function GetStatus() // 0 : Public, 1 : Friends, 2: Private
		{
			return $this->status ;
		}
		public function SetStatus($status) // 0 : Public, 1 : Friends, 2: Private
		{
			$this->status = $status ;
		}
		
		public function GetLyrics()
		{
			return $this->lyrics ;
		}		
		public function SetLyrics($lyrics)
		{
			$this->lyrics = $lyrics ;
		}
		
		public function GetComposer()
		{
			return $this->composer ;
		}		
		public function SetComposer($composer)
		{
			$this->composer = $composer ;
		}
		
		public function GetPicturizedOn()
		{
			return $this->picturizedon ;
		}		
		public function SetPicturizedOn($picturizedon)
		{
			$this->picturizedon = $picturizedon ;
		}
		
		public function GetYear()
		{
			return $this->year ;
		}		
		public function SetYear($year)
		{
			$this->year = $year ;
		}
		
		public function GetUserId()
		{
			return $this->user_id ;
		}
		public function SetUserId($user_id)
		{
			$this->user_id = $user_id ;
		}
		
		public function GetProvider()
		{
			return $this->provider ;
		}
		public function SetProvider($provider)
		{
			$this->provider = $provider ;
		}
	}
?>