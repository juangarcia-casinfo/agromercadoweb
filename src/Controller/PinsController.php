<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Reports Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 * @method \App\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PinsController extends AppController
{
    var $uses = array();
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $pins = (object)array("mydata"=>'Welcome to Pins');

	if ($this->request->is('post')) 
	{
		//debug($this);
		$pins->request_type = "post";
		$pins->router_data = json_decode($this->request->getData('router_data'));
	}
	else
	{
		$pins->request_type = "normal";
		$pins->router_data = '';
	}

        $this->set(compact('pins'));
    }

   
}
