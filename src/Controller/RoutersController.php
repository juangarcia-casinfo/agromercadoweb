<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Core\Configure;

/**
 * Routers Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 * @method \App\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RoutersController extends AppController
{
	var $uses = array();
	/**
	 * Initialization method
	 *
	 * @return \Cake\Http\Response|null|void Renders view
	 */
	public function initialize(): void
	{
		parent::initialize();
		//$this->loadComponent('Security');

		//Xbar connection data
		$xbarAddress = Configure::read('appcfg.xbaraddress');
		$xbarRealm = Configure::read('appcfg.xbarrealm');
		$xbarMainTopic = Configure::read('appcfg.xbarmaintopic');
		$customerLocation = Configure::read('appcfg.customerlocation');

		$this->loadComponent('RequestHandler');
		$this->loadComponent('Crossbar', ['address'=>$xbarAddress, 'realm'=>$xbarRealm, 'maintopic'=>$xbarMainTopic, 'sessionid'=>$customerLocation]);
	}


	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|null|void Renders view
	 */     
	public function index()
	{
	$routers 		= (object)array("cfg_data"=>'Welcome to main selection');
	$contentType 	= $this->request->getHeader('Content-Type');
	$postProcessData = "";


	if ($this->request->is('post')) 
	{
		$routers->request_type = "post";


		if($contentType[0]=="application/json")
		{
			$routers->request_data = $this->request->input('json_decode');
			$postProcessData 		= $routers->request_data;
		}
		else
		{
			$routers->request_data = (object) $this->request->getData();
			$postProcessData		= $routers->request_data;
			$routers->request_data = json_encode($routers->request_data);
		}


		//Sending to xbar request		
		if($routers->request_data!="")
		{
			$this->Crossbar->publishSubscribe($routers->request_data->sub_topic, '', $routers->request_data);
			$routers->response_data = 	$this->Crossbar->response_data;
		}


		$routers->request_data = $postProcessData;
	}
	elseif ($this->request->is('get')) 
	{
		$routers->request_type = "get";
		$routers->request_data = $this->request->getQuery();


		//Sending xbar request		
		if(json_encode($routers->request_data)!="")
		{
			$this->Crossbar->publishSubscribe($routers->request_data->sub_topic, '', $routers->request_data);
			$routers->response_data = $this->Crossbar->response_data;
		}


		$routers->request_data = json_decode($routers->request_data);
	}
	else
	{
	$routers->request_type = "normal";
	$routers->request_data = '';
	}

	//Formatting the response to the output
	$routers->response_data = json_decode($routers->response_data);


	//Setting the results to the interfaces
	$this->set(compact('routers'));
	$this->viewBuilder()->setOption('serialize', ['routers']);  
	}
}