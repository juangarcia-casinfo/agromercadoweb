<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface ;

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
        $this->loadComponent('RequestHandler');
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

	if ($this->request->is('post')) 
	{
		$routers->request_type = "post";
		$routers->router_data = (object)$this->request->getData();
		
		//Subscribe to main channel to get the answer
		
		//Connect to XBAR and publish
		
		
		//Process the response
		
	}
	else
	{
		$routers->request_type = "normal";
		$routers->router_data = '';
	}
	
	$routers = json_decode('{ "location": "10001", "sub_topic": "my_contracts", "participant_access_code": "2DFWE4", "pov": "seller"  }');

        $this->set(compact('routers'));
        $this->viewBuilder()->setOption('serialize', ['routers']);  
    }
}
