<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Test;
use AppBundle\Form\TestType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Tag;

class TestController extends Controller {
	
	/**
	 * @Route("/testas/")
	 */
	public function index(Request $request) {
		
		$test = new Test();				
		
		$elasticSearchData = array(
				'tags' => array('test 1', 'test 2', 'test 3')
		);
		
		foreach ($elasticSearchData['tags'] as $tagInfo){
			$tag = new Tag();
			$tag->setTest($tagInfo);
			$test->getTags()->add($tag);
		}		
		
		$form = $this->createForm('AppBundle\Form\TestType', $test);
		
		if($request->getMethod() === 'POST'){
			
			$form->handleRequest($request);
			
			var_dump($test->getTest());
			$tags = $test->getTags();
			
			foreach($tags as $tag){
				print_r($tag->getTest());
			}
			
		}
		
		return $this->render('default/test.html.twig', array(
				'form' => $form->createView(),
		));
	}
}