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
     * Index method
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

    /*
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

         $this->Security->setConfig('validatePost', false);
    }
    */    
     
    public function index()
    {
        $routers = (object)array("cfg_data"=>'Welcome to main selection');
        //$this->Crossbar->publishSubscribe('', 'Welcome to bagdag');

	if ($this->request->is('post')) 
	{
		$routers->request_type = "post";
		$routers->request_data = (object) $this->request->getData();
		
		if(json_encode($routers->request_data)!="")
		{
			$this->Crossbar->publishSubscribe('', $routers->request_data);
			$routers->response_data = 	$this->Crossbar->response_data;
		}
		
	}
	elseif ($this->request->is('get')) 
	{
		$routers->request_type = "get";
		$routers->request_data = $this->request->getQuery('json_data');
		
		if(json_encode($routers->request_data)!="")
		{
			$this->Crossbar->publishSubscribe('', $routers->request_data);
			$routers->response_data = $this->Crossbar->response_data;
		}
		
	}
	else
	{
		$routers->request_type = "normal";
		$routers->request_data = '';
	}

	$routers->request_data = json_decode($routers->request_data);
	$routers->response_data = json_decode($routers->response_data);

	
	//$routers->response_data = json_decode('{ "location": "10001", "sub_topic": "my_contracts", "participant_access_code": "2DFWE4", "pov": "seller"  }');

        $this->set(compact('routers'));
        $this->viewBuilder()->setOption('serialize', ['routers']);  
    }
}