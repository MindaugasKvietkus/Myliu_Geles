<?php
namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elasticsearch\ClientBuilder;
use AppBundle\Form\FormType;
use Symfony\Component\Finder\SplFileInfo;

class AdminImportController extends Controller {
	
	protected $importData = array();
	
	protected $map;
	
	protected $dataFile;
	

	/**
	 * @Route ("/admin/import")
	 */
	
	public function getFile(){
	
		$this->dataFile = new SplFileInfo('C:\wamp64\www\test\test.csv', 'C:\wamp64\www\test\test.csv', 'C:\wamp64\www\test\test.csv');
	
		if(!$this->dataFile->getRealPath()){
			exit('Data file not found.');
		}
		$this->Import();
	}
	
	
	public function Import(){
		if (($handle = fopen($this->dataFile->getRealPath(), "r")) !== FALSE) {
	
			$lastSku = null;
	
			while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
	
				if(is_null($this->map)){
					$this->map = $data;
					continue;
				}
	
				$sku = $this->dataValue($data, 'sku');
				$_product_websites= $this->dataValue($data, '_product_websites');
				$description= $this->dataValue($data, 'description');
				$image= $this->dataValue($data, 'image');
				$meta_description= $this->dataValue($data, 'meta_description');
				$name= $this->dataValue($data, 'name');
				$short_description= $this->dataValue($data, 'short_description');
				$small_image= $this->dataValue($data, 'small_image');
				$thumbnail= $this->dataValue($data, 'thumbnail');
				$url_key= $this->dataValue($data, 'url_key');
				$url_path= $this->dataValue($data, 'url_path');
				$_media_image= $this->dataValue($data, '_media_image');
				$price= $this->dataValue($data, 'price');
				$_custom_option_row_title= $this->dataValue($data, '_custom_option_row_title');
				$_custom_option_row_price= $this->dataValue($data, '_custom_option_row_price');
				$_custom_option_row_sku= $this->dataValue($data, '_custom_option_row_sku');
				$_custom_option_row_sort= $this->dataValue($data, '_custom_option_row_sort');
	
	
				if(!empty($sku)){
	
					$lastSku = $sku;
	
					$this->importData[$sku] = array(
							'sku' => $sku,
							'_category_id' => array(),
							'_category' => array(),
							'_root_category'=>array(),
							'_product_websites'=>$_product_websites,
							'description'=>$description,
							'image'=>$image,
							'meta_description'=>$meta_description,
							'name'=>$name,
							'short_description'=>$short_description,
							'small_image'=>$small_image,
							'thumbnail'=>$thumbnail,
							'url_key'=>$url_key,
							'url_path'=>$url_path,
							'_media_image'=>$_media_image,
							'price'=>$price,
							'_custom_option_row_title'=>array(),
							'_custom_option_row_price'=>array(),
							'_custom_option_row_sku'=>array(),
							'_custom_option_row_sort'=>array(),
	
					);
				}else{
	
					$_category = $this->dataValue($data, '_category');
					$_root_category=$this->dataValue($data, '_root_category');
					$_custom_option_row_title= $this->dataValue($data, '_custom_option_row_title');
					$_custom_option_row_price= $this->dataValue($data, '_custom_option_row_price');
					$_custom_option_row_sku= $this->dataValue($data, '_custom_option_row_sku');
					$_custom_option_row_sort= $this->dataValue($data, '_custom_option_row_sort');
					
					
					if(!empty($_category)){
						array_push($this->importData[$lastSku]['_category'], $_category);
					}
					
					if(!empty($_category)){
						//aptvarko stringa su tarpais
						$categoryId = trim(array_search($_category, FormType::$categoriesMap));
						if(strlen($categoryId) > 0){
							array_push($this->importData[$lastSku]['_category_id'], (int)$categoryId);
						}
					}
	
					if(!empty($_root_category)){
						array_push($this->importData[$lastSku]['_root_category'], $_root_category);
					}
	
					if(!empty($_custom_option_row_title)){
						array_push($this->importData[$lastSku]['_custom_option_row_title'], $_custom_option_row_title);
					}
	
					if(!empty($_custom_option_row_price)){
						array_push($this->importData[$lastSku]['_custom_option_row_price'], $_custom_option_row_price);
					}
	
					if(!empty($_custom_option_row_sku)){
						array_push($this->importData[$lastSku]['_custom_option_row_sku'], $_custom_option_row_sku);
					}
	
					if(!empty($_custom_option_row_sort)){
						array_push($this->importData[$lastSku]['_custom_option_row_sort'], $_custom_option_row_sort);
					}
				}
			}
	
			fclose($handle);
		}
	
		$this->importToElastic();
		exit('done');
	}
	
	protected function importToElastic(){
	
		//print_r($productData);
		$hosts = [
				'emtn.lt:9200'
		];
		$client = ClientBuilder::create()->setHosts($hosts)->build();
		//$client = Elasticsearch\ClientBuilder::create ()->build ();
			
		foreach($this->importData as $sku => $productData){
	
			//print_r($productData);
			$params = [
					'index' => 'myliu_geles',
					'type' => 'elasticsearch',
					'id' => $productData['sku'],
					'body' => $productData
			];
				
			$result = $client->index ( $params );
		}
	}
	
	protected function dataValue(array $data, $column){
		$index = array_search($column, $this->map);
		return array_key_exists($index, $data) ? $data[$index] : null;
	}
	
	protected function getClient() {
		return ClientBuilder::create ()->setHosts ( array (
				'localhost:9200'
		) )->build ();
	}
}