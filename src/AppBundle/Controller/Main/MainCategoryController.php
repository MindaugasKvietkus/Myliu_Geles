<?php

namespace AppBundle\Controller\Main;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elasticsearch\ClientBuilder;

class MainCategoryController extends Controller
{

	/**
	 * @Route("geles/akcijos", name="akcijos")
	 */

	public function listAkcijos(){
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = array(
				'index' => 'myliu_geles',
				'type' => 'elasticsearch',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_category'=>'Akcijos'
								)
						)
				)
		);
		$response = $client->search($params);
		return $this->render('Main/akcijos.html.twig', [
				'response' => $response,
		]);
	}
	
	/**
	 * @Route("geles/gimtadienio_puokstes", name="gimtadienio_puokstes")
	 */
	
	public function listGimtadienioPuokstes(){
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = array(
				'index' => 'myliu_geles',
				'type' => 'elasticsearch',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_category'=>'Gimtadienio puokštės'
								)
						)
				)
		);
		$response = $client->search($params);
		return $this->render('Main/gimtadienio_puokstes.html.twig', [
				'response' => $response,
		]);
	}
	
	/**
	 * @Route("geles/populiariausios", name="populiariausios")
	 */
	
	public function listPopuliariausios(){
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = array(
				'index' => 'myliu_geles',
				'type' => 'elasticsearch',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_category'=>'Populiariausios gėlės'
								)
						)
				)
		);
		$response = $client->search($params);
		return $this->render('Main/populiariausios.html.twig', [
				'response' => $response,
		]);
	}
	
	/**
	 * @Route("geles/puokstes", name="puokstes")
	 */
	
	public function listPuokstes(){
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = array(
				'index' => 'myliu_geles',
				'type' => 'elasticsearch',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_product_websites'=>'myliugeles_lt'
								)
						)
				)
		);
		//print_r($products);
		$response = $client->search($params);
		return $this->render('Main/puokstes.html.twig', [
				'response' => $response,
		]);
	}
	
	/**
	 * @Route("geles/rozes", name="rozes")
	 */
	
	public function listRozes(){
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = array(
				'index' => 'myliu_geles',
				'type' => 'elasticsearch',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_category'=>'Rožės'
								)
						)
				)
		);
		$response = $client->search($params);
		return $this->render('Main/rozes.html.twig', [
				'response' => $response,
		]);
	}
	
	/**
	 * @Route("geles/skintos_geles", name="skintos_geles")
	 */
	
	public function listSkintosGeles(){
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = array(
				'index' => 'myliu_geles',
				'type' => 'elasticsearch',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_category'=>'Skintos gėlės'
								)
						)
				)
		);
		$response = $client->search($params);
		return $this->render('Main/skintos_geles.html.twig', [
				'response' => $response,
		]);
	}
}