<?php
declare(strict_types=1);

namespace App\Controller;

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
    public function index()
    {
        $routers = (object)array("cfg_data"=>'Welcome to main selection');

	if ($this->request->is('post')) 
	{
		$routers->request_type = "post";
		$routers->router_data = $this->request->getData();
	}
	else
	{
		$routers->request_type = "normal";
		$routers->router_data = '';
	}

        $this->set(compact('routers'));
    }
}
