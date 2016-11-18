<?php

namespace AppBundle\Controller\Main;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elasticsearch\ClientBuilder;

class MainIndexController extends Controller
{
	/**
	 * @Route("/", name="homepage")
	 */

	public function showallDocument() {
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = array(
				'index' => 'myliu_geles',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_product_websites' => 'myliugeles_lt'
								)
						)
				),
				'size' => 100000,

		);
		$response = $client->search ( $params );

		//print_r($response);

		return $this->render ( 'Main/index.html.twig', array (
				'response' => $response
		) );
	}
}