<?php

class CMp3
{
	private $url;
	private $status;
	private $source;
	public $mp3_count;

	public function __construct($arr)
	{
		$this->url=$arr['url'];
		$this->source=$arr['source'];
		$this->status=$arr['status'];
		$this->mp3_count=0;
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
	public function GetSource()
	{
		return $this->source;
	}
	public function SetSource($url)
	{
		$this->source = $source;
	}
	public function GetCount()
	{
		return $this->mp3_count;
	}
}

?>