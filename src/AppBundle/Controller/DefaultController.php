
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Elasticsearch\ClientBuilder;

class DefaultController extends Controller
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
				'index' => 'myliu_geles_elasticsearch',
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
	
		return $this->render ( 'default/index.html.twig', array (
				'response' => $response
		) );
	}
	
	/**
	 * @Route("/rrrrrrrrrrrrrr{url_key}")
	 */
	
	public function getDocument($url_key){
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = [
				'index' => 'myliu_geles_elasticsearch',
				'type' => 'test',
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
	
	/**
	 * @Route("geles/puokstes", name="puokstes")
	 */
	
	public function listPuokstes(){
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = array(
				'index' => 'myliu_geles_elasticsearch',
				'type' => 'test',
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
		return $this->render('default/puokstes.html.twig', [
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
				'index' => 'myliu_geles_elasticsearch',
				'type' => 'test',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_category'=>'Gimtadienio puokštės'
								)
						)
				)
		);
		$response = $client->search($params);
		return $this->render('default/gimtadienio_puokstes.html.twig', [
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
				'index' => 'myliu_geles_elasticsearch',
				'type' => 'test',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_category'=>'Populiariausios gėlės'
								)
						)
				)
		);
		$response = $client->search($params);
		return $this->render('default/populiariausios.html.twig', [
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
				'index' => 'myliu_geles_elasticsearch',
				'type' => 'test',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_category'=>'Skintos gėlės'
								)
						)
				)
		);
		$response = $client->search($params);
		return $this->render('default/skintos_geles.html.twig', [
				'response' => $response,
		]);
	}
	
	/**
	 * @Route("geles/akcijos", name="akcijos")
	 */
	
	public function listAkcijos(){
		$hosts = array (
				'emtn.lt:9200'
		);
		$client = ClientBuilder::create ()->setHosts ( $hosts )->build ();
		$params = array(
				'index' => 'myliu_geles_elasticsearch',
				'type' => 'test',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_category'=>'Akcijos'
								)
						)
				)
		);
		$response = $client->search($params);
		return $this->render('default/akcijos.html.twig', [
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
				'index' => 'myliu_geles_elasticsearch',
				'type' => 'test',
				'body' => array(
						'query' => array(
								'match'=> array(
										'_category'=>'Rožės'
								)
						)
				)
		);
		$response = $client->search($params);
		return $this->render('default/rozes.html.twig', [
				'response' => $response,
		]);
	}
    
}
