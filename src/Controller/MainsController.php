<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Reports Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 * @method \App\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MainsController extends AppController
{
    var $uses = array();
    /**
    * Initializing method
    *
    * @return \Cake\Http\Response|void
    */
    public function initialize(): void
    {
    	parent::initialize();
    	$this->loadComponent('RequestHandler');
    }     
    
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $mains = (object)array("mydata"=>'Welcome to mains');

	if ($this->request->is('post')) 
	{
		//debug($this);
		$mains->request_type = "post";
		$mains->router_data = json_decode($this->request->getData('router_data'));
	}
	else
	{
		$mains->request_type = "normal";
		$mains->router_data = '';
	}

        //$this->set(compact('mains'));
        //$this->set('_serialize', ['mains']);
	$this->set('mains', $mains);
        // Specify which view vars JsonView should serialize.
        $this->viewBuilder()->setOption('serialize', ['mains']);        
    }
}
