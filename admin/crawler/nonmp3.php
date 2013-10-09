<?php

class CNonMp3
{
	private $url;
	private $status;
	public $nonmp3_count;

	public function __construct($arr)
	{
		$this->url=$arr['url'];
		$this->status=$arr['status'];
		$this->nonmp3_count=0;
	}
	
	public function GetUrl()
	{
		return $this->url;
	}
	public function SetUrl($url)
	{
		$this->url = $url;
	}
	public function GetStatus()
	{
		return $this->status;
	}
	public function SetStatus($status)
	{
		$this->status = $status;
	}
	public function PrintAll()
	{
		echo $this->url."\n";
		echo $this->status."\n";
	}
	public function GetCount()
	{
		return $this->nonmp3_count;
	}
}

?>