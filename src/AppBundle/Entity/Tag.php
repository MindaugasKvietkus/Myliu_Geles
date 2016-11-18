<?php
namespace AppBundle\Entity;

class Tag {
	
	protected $test;
	
	public function getTest()
	{
		return $this->test;
	}
	
	public function setTest($test)
	{
		$this->test = $test;
		return $this;
	}
}