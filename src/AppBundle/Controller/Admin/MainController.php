<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elasticsearch\ClientBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MainController extends Controller {	
	
	/**
	 * @Route("/admin/list", name="list")
	 */
	public function index() {
		$client = $this->getClient ();
		$params = array (
				'index' => 'myliu_geles',
				'body' => array (
						'query' => array (
								'match' => array (
										'_product_websites' => 'myliugeles_lt' 
								) 
						) 
				),
				'size' => 10000
		);
		$response = $client->search ( $params );
		return $this->render ( 'admin/admin_list.html.twig', array (
				'response' => $response 
		) );
	}
	
	/**
	 * @Route("/admin/form/delete/{sku}", name="delete")
	 */
	public function deleteForm($sku) {
		$client = $this->getClient ();
		$params = [ 
				'index' => 'myliu_geles',
				'type' => 'elasticsearch',
				'id' => $sku 
		];
		$response = $client->delete ( $params );
		print_r ( $response );
		return $this->redirectToRoute ( 'form' );
	}

	/**
	 * @Route("/admin/sku/name/category")
	 * 
	 * @method ("POST")
	 */
	public function paieskaBendra(Request $request) {
		header ( 'Cache-Control: no-cache, must-revalidate' );
		header ( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
		header ( 'Content-type: application/json' );
		
		$client = $this->getClient ();
		
		$sku = trim ( $request->get ( 'sku' ) );
		$name = trim ( $request->get ( 'name' ) );
		$category = trim ( $request->get ( 'category' ) );
		
		$query = array();
		
		if (!empty($sku)){
			array_push($query, array (
					'regexp' => array (
							'sku' => ".*".$sku.".*"
					)
			));
		}
		if (!empty($name)){
			array_push($query, array (
					'regexp' => array (
							'name' => ".*".$name.".*"
					)
			));
		}
		if (!empty($category)){
			array_push($query, array (
					'regexp' => array (
							'_category' => ".*".$category.".*"
					)
			));
		}
		/*
		if (empty ( $sku ) &&  empty ( $name ) && empty ( $category )){
			$client = $this->getClient ();
			$query = $client->search ( array (
					'index' => 'myliu_geles',
                    'type' => 'elasticsearch',
					'body' => array (
							'query' => array (
									'match' => array (
											'_product_websites' => 'myliugeles_lt'
									)
							)
					),
					'size' => 100
			));
			//$response = $client->search ( $params );
		}
		*/
		$query = $client->search ( array (
				'index' => 'myliu_geles',
				'type' => 'elasticsearch',
				'size' => 1000,
				'body' => array (
						'query' => array (
								'bool' => array (
										'must' => $query
								)
								 
						),
						'filter' => array (
								'term' => array (
										'_product_websites' => 'myliugeles_lt' 
								) 
						) 
			)
		) );
		
		if ($query ['hits'] ['total'] >= 1) {
			exit ( json_encode ( array (
					'content' => $this->renderView ( 'admin/paieska.html.twig', array (
							'response' => $query 
					) ) 
			) ) );
		}
	}
	protected function getClient() {
		return ClientBuilder::create ()->setHosts ( array (
				'emtn.lt:9200' 
		) )->build ();
	}
}