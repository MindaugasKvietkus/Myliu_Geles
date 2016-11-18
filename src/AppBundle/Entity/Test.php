<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Test {
	
	protected $test;
	
	protected $tags;
	
	public function __construct()
	{
		$this->tags = new ArrayCollection();
	}
	
	public function getTest()
	{
		return $this->test;
	}
	
	public function setTest($test)
	{
		$this->test = $test;
		return $this;
	}
	
	public function SetTags($tags)
	{
		$this->tags = $tags;
		return $this;
	}
	
	public function getTags()
	{
		return $this->tags;
	}
}