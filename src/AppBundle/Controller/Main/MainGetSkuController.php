<?php

namespace AppBundle\Controller\Main;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elasticsearch\ClientBuilder;

class MainGetSkuController extends Controller
{
	
	/**
	 * @Route("/{url_key}")
	 */
	
	public function getDocument($url_key){
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = [
				'index' => 'myliu_geles',
				'type' => 'elasticsearch',
				'body' => array (
						'query' => array (
								'bool' => array (
										'must' => [
												array (
														'match_phrase_prefix' => array (
																'url_key' => $url_key
														)
												),
										]
								)
									
						)
						)
		];
		$response = $client->search( $params );
		$rezult = $response['hits']['hits'];
		foreach ($rezult as $value){
		}
		//print_r($value['_source']);
		$rezult1=$value['_source'];
		return $this->render ( 'default/index_single.html.twig',
				array(
						'url_key' => $url_key,
						'rezult' =>$rezult1
				));
		
	}
}