<?php
namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elasticsearch\ClientBuilder;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Variables;
use AppBundle\Form\FormType;

class InsertUpdateController extends Controller {
	
	
	/**
	 * @Route("/admin/form", name="form")
	 */
	
	public function insert(Request $request){
		
		$insert = new Variables();		
		$form = $this->createForm('AppBundle\Form\FormType', $insert);		
		
		if($request->getMethod() === 'POST'){
			
			$form->handleRequest($request);
			
			if($form->isValid()){
				$category = array();
				foreach ($insert->_category_id as $categoryID){
					//$key= array_search($categoryID, array_flip(FormType::$categoriesMap));
					array_push($category, array_search($categoryID, array_flip(FormType::$categoriesMap)));
				}
				$client = $this->getClient ();
				$params = array (
						'index' => 'myliu_geles',
						'type' => 'elasticsearch',
						'id' => $insert->sku,
						'body' => array (
								'sku' => $insert->sku,
								'_category_id' => $insert->_category_id,
								'_category' => $category,
								'_product_websites'=> $insert->_product_websites,
								'description' => $insert->description,
								'image' => $insert->image,
								'meta_description' => $insert->meta_description,
								'name' => $insert->name,
								'short_description' => $insert->short_description,
								'small_image' => $insert->small_image,
								'thumbnail' => $insert->thumbnail,
								'url_key' => $insert->url_key,
								'url_path' => $insert->url_path,
								'_media_image' => $insert->_media_image,
								'price' => $insert->price,
								'_custom_option_row_title' => array(
										'0' => $insert->didesnes_default_dydis_0,
										'1' => $insert->dideles_default_dydis_1,
										'2' => $insert->ltu_didesnes_dydis_2,
										'3' => $insert->ltu_dideles_dydis_3,
										'4' => $insert->en_didesnes_dydis_4,
										'5' => $insert->en_dideles_dydis_5,
										'6' => $insert->ru_didesnes_dydis_6,
										'7' => $insert->ru_dideles_dydis_7,
								),
								'_custom_option_row_price' => array(
										'0' => $insert->didesnes_default_kaina_0,
										'1' => $insert->dideles_default_kaina_1,
										'2' => $insert->ltu_didesnes_kaina_2,
										'3' => $insert->ltu_dideles_kaina_3,
										'4' => $insert->en_didesnes_kaina_4,
										'5' => $insert->en_dideles_kaina_5,
										'6' => $insert->ru_didesnes_kaina_6,
										'7' => $insert->ru_dideles_kaina_7,
								)
						));
				$response = $client->index ( $params );
				return $this->redirectToRoute ( 'form' );
			}
		}
		
		return $this->render('admin/form.html.twig', array(
				'form' => $form->createView()
		));
	}
	
	
	/**
	 * @Route("/admin/form/{sku}", name="update")
	 */
	public function update(Request $request, $sku){
		
		$client = $this->getClient ();
		$params = array(
				'index' => 'myliu_geles',
				'type' => 'elasticsearch',
				'id' => $sku
		);
		$response = $client->get($params);
		$rezult = $response ['_source'];
		//print_r($rezult['_category']);
		$insert = new Variables();
		$insert->sku = $rezult['sku'];
		$insert->_category_id = $rezult['_category_id'];
		$insert->_product_websites = $rezult['_product_websites'];
		$insert->description = $rezult['description'];
		$insert->image = $rezult['image'];
		$insert->meta_description = $rezult['meta_description'];
		$insert->name = $rezult['name'];
		$insert->short_description = $rezult['short_description'];
		$insert->small_image = $rezult['small_image'];
		$insert->thumbnail = $rezult['thumbnail'];
		$insert->url_key = $rezult['url_key'];
		$insert->url_path = $rezult['url_path'];
		$insert->_media_image = $rezult['_media_image'];
		$insert->price = $rezult['price'];
		// DEFAULT DYDIS
		if (!empty($rezult['_custom_option_row_title'][0])){
			$insert->didesnes_default_dydis_0 = $rezult['_custom_option_row_title'][0];
		}else {
			$insert->didesnes_default_dydis_0 = '';
		}
		if (!empty($rezult['_custom_option_row_price'][0])){
			$insert->didesnes_default_kaina_0 = $rezult['_custom_option_row_price'][0];
		}else {
			$insert->didesnes_default_kaina_0 = '';
		}
		// DEFAULT KAINA
		if (!empty($rezult['_custom_option_row_title'][1])){
			$insert->dideles_default_dydis_1 = $rezult['_custom_option_row_title'][1];
		}else {
			$insert->dideles_default_dydis_1 = '';
		}
		if (!empty($rezult['_custom_option_row_price'][1])){
			$insert->dideles_default_kaina_1 = $rezult['_custom_option_row_price'][1];
		}else {
			$insert->dideles_default_kaina_1 = '';
		}
		// LT DYDIS DIDESNE
		if (!empty($rezult['_custom_option_row_title'][2])){
			$insert->ltu_didesnes_dydis_2 = $rezult['_custom_option_row_title'][2];
		}else{
		if (!empty($rezult['_custom_option_row_title'][0])){
			$insert->ltu_didesnes_dydis_2 = $rezult['_custom_option_row_title'][0];
		}else {
			$insert->ltu_didesnes_dydis_2 = '';
		}
		}
		// LT KAINA DIDESNES
		if (!empty($rezult['_custom_option_row_price'][2])){
			$insert->ltu_didesnes_kaina_2 = $rezult['_custom_option_row_price'][2];
		}else{
			if (!empty($rezult['_custom_option_row_price'][0])){
				$insert->ltu_didesnes_kaina_2 = $rezult['_custom_option_row_price'][0];
			}else {
				$insert->ltu_didesnes_kaina_2 = '';
			}
		}
		// LT DYDIS DIDELES
		if (!empty($rezult['_custom_option_row_title'][3])){
			$insert->ltu_dideles_dydis_3 = $rezult['_custom_option_row_title'][3];
		}else{
			if (!empty($rezult['_custom_option_row_title'][1])){
				$insert->ltu_dideles_dydis_3 = $rezult['_custom_option_row_title'][1];
			}else {
				$insert->ltu_dideles_dydis_3 = '';
			}
		}
		// LT KAINA DIDELES
		if (!empty($rezult['_custom_option_row_price'][3])){
			$insert->ltu_dideles_kaina_3 = $rezult['_custom_option_row_price'][3];
		}else{
			if (!empty($rezult['_custom_option_row_price'][1])){
				$insert->ltu_dideles_kaina_3 = $rezult['_custom_option_row_price'][1];
			}else {
				$insert->ltu_dideles_kaina_3 = '';
			}
		}
		// EN DYDIS DIDESNE
		if (!empty($rezult['_custom_option_row_title'][4])){
			$insert->en_didesnes_dydis_4 = $rezult['_custom_option_row_title'][4];
		}else{
		if (!empty($rezult['_custom_option_row_title'][0])){
			$insert->en_didesnes_dydis_4 = $rezult['_custom_option_row_title'][0];
		}else {
			$insert->en_didesnes_dydis_4 = '';
		}
		}
		// EN KAINA DIDESNES
		if (!empty($rezult['_custom_option_row_price'][4])){
			$insert->en_didesnes_kaina_4 = $rezult['_custom_option_row_price'][4];
		}else{
			if (!empty($rezult['_custom_option_row_price'][0])){
				$insert->en_didesnes_kaina_4 = $rezult['_custom_option_row_price'][0];
			}else {
				$insert->en_didesnes_kaina_4 = '';
			}
		}
		
		// EN DYDIS DIDELES
		if (!empty($rezult['_custom_option_row_title'][5])){
			$insert->en_dideles_dydis_5 = $rezult['_custom_option_row_title'][5];
		}else{
			if (!empty($rezult['_custom_option_row_title'][1])){
				$insert->en_dideles_dydis_5 = $rezult['_custom_option_row_title'][1];
			}else {
				$insert->en_dideles_dydis_5 = '';
			}
		}
		// EN KAINA DIDELES
		if (!empty($rezult['_custom_option_row_price'][5])){
			$insert->en_dideles_kaina_5 = $rezult['_custom_option_row_price'][5];
		}else{
			if (!empty($rezult['_custom_option_row_price'][1])){
				$insert->en_dideles_kaina_5 = $rezult['_custom_option_row_price'][1];
			}else {
				$insert->en_dideles_kaina_5 = '';
			}
		}
		
		// RU DYDIS DIDESNE
		if (!empty($rezult['_custom_option_row_title'][6])){
			$insert->ru_didesnes_dydis_6 = $rezult['_custom_option_row_title'][6];
		}else{
			if (!empty($rezult['_custom_option_row_title'][0])){
				$insert->ru_didesnes_dydis_6 = $rezult['_custom_option_row_title'][0];
			}else {
				$insert->ru_didesnes_dydis_6 = '';
			}
		}
		// RU KAINA DIDESNES
		if (!empty($rezult['_custom_option_row_price'][6])){
			$insert->ru_didesnes_kaina_6 = $rezult['_custom_option_row_price'][6];
		}else{
			if (!empty($rezult['_custom_option_row_price'][0])){
				$insert->ru_didesnes_kaina_6 = $rezult['_custom_option_row_price'][0];
			}else {
				$insert->ru_didesnes_kaina_6 = '';
			}
		}
		
		// RU DYDIS DIDELES
		if (!empty($rezult['_custom_option_row_title'][7])){
			$insert->ru_dideles_dydis_7 = $rezult['_custom_option_row_title'][7];
		}else{
			if (!empty($rezult['_custom_option_row_title'][1])){
				$insert->ru_dideles_dydis_7 = $rezult['_custom_option_row_title'][1];
			}else {
				$insert->ru_dideles_dydis_7 = '';
			}
		}
		// RU KAINA DIDELES
		if (!empty($rezult['_custom_option_row_price'][7])){
			$insert->ru_dideles_kaina_7 = $rezult['_custom_option_row_price'][7];
		}else{
			if (!empty($rezult['_custom_option_row_price'][1])){
				$insert->ru_dideles_kaina_7 = $rezult['_custom_option_row_price'][1];
			}else {
				$insert->ru_dideles_kaina_7 = '';
			}
		}
		
		$form = $this->createForm('AppBundle\Form\FormType', $insert, array(
				'method' => 'POST'
		));
		
		if($request->getMethod() === 'POST'){
			$form->handleRequest($request);
			$category = array();
			foreach ($insert->_category_id as $categoryID){
				//$key= array_search($categoryID, array_flip(FormType::$categoriesMap));
				array_push($category, array_search($categoryID, array_flip(FormType::$categoriesMap)));
			}
			$client = $this->getClient ();
			$params = array (
					'index' => 'myliu_geles',
					'type' => 'elasticsearch',
					'id' => $insert->sku,
					'body' => array (
							'doc' => array (
									'sku' => $insert->sku,
									'_category_id' => $insert->_category_id,
									'_category' => $category,
									'description' => $insert->description,
									'image' => $insert->image,
									'meta_description' => $insert->meta_description,
									'name' => $insert->name,
									'short_description' => $insert->short_description,
									'small_image' => $insert->small_image,
									'thumbnail' => $insert->thumbnail,
									'url_key' => $insert->url_key,
									'url_path' => $insert->url_path,
									'_media_image' => $insert->_media_image,
									'price' => $insert->price,
									'_custom_option_row_title' => array(
											'0' => $insert->didesnes_default_dydis_0,
											'1' => $insert->dideles_default_dydis_1,
											'2' => $insert->ltu_didesnes_dydis_2,
											'3' => $insert->ltu_dideles_dydis_3,
											'4' => $insert->en_didesnes_dydis_4,
											'5' => $insert->en_dideles_dydis_5,
											'6' => $insert->ru_didesnes_dydis_6,
											'7' => $insert->ru_dideles_dydis_7
									),
									'_custom_option_row_price' => array(
											'0' => $insert->didesnes_default_kaina_0,
											'1' => $insert->dideles_default_kaina_1,
											'2' => $insert->ltu_didesnes_kaina_2,
											'3' => $insert->ltu_dideles_kaina_3,
											'4' => $insert->en_didesnes_kaina_4,
											'5' => $insert->en_dideles_kaina_5,
											'6' => $insert->ru_didesnes_kaina_6,
											'7' => $insert->ru_dideles_kaina_7
									)
							)
					)
			);
			//pertvarko key masyve
			try{
				$params['body']['doc']['_category'] = array_values($params['body']['doc']['_category']);
				$response = $client->update ( $params );
			}catch(\Exception $e){
				print_r($params);
				exit;
			}
			
			return $this->redirectToRoute ( 'list' );
		}
		
		return $this->render('admin/form_single.html.twig', array(
				'form' => $form->createView(),
				'sku' => $sku,
				'rezult' => $rezult
		));
	}
	
	protected function getClient() {
		return ClientBuilder::create ()->setHosts ( array (
				'emtn.lt:9200'
		) )->build ();
	}
}