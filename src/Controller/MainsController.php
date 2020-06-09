<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Client\Request as ClientRequest;


/**
 * Main Menu Controller
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
    	//Main Menu controller, no data should be recieved by now
    
        $mains = (object)array("mydata"=>'Welcome to mains');

        
        //Getting the received data
        switch(strtolower($this->request->getMethod()))
        {
        	case "get":
			$mains->request_type = "get";
			$mains->request_data = (Object) $this->request->getQuery();
			
			if($mains->request_data=="" || count((array)$mains->request_data)==0)
			{
				$mains->request_data = "";
			}
        	break;
        	
        	case "post":
			$mains->request_type = "post";
			$mains->request_data = (Object)$this->request->getData();
			
			if($mains->request_data=="" || count((array)$mains->request_data)==0)
			{
				$mains->request_data = "";
			}			
        	break;
        	
        	default:
			$mains->request_type = "normal";
			$mains->request_data = '';        	
        }
        

        //Getting Back-End Data from request
        //TODO: START This must be a component to reuse
        if($mains->request_data!="")
        {
	        // Send a JSON request body.
	        $xbarEndpoint = Configure::read('arbecfg.xbar_endpoint');
	        $request_json_data = json_encode($mains->request_data);
	        
	        
	        $http = new Client();
	        $response = $http->post(
								$xbarEndpoint,
								$request_json_data,
								['type' => 'json']
							);

	        
	        //Processing the received data
	        //debug($response->getStringBody()); 
	        $rcvData = json_decode($response->getStringBody());
	        $rcvData = $rcvData->routers->response_data;
	        
	        //debug($rcvData->sub_topic);
	        
	        
	        //Check the mandatory values
	        $mandatory 		= ["location", "sub_topic"];
	        $mandatoryError 	= "";
	        
	        foreach($mandatory as $evalMandatory)
	        {
	        	if(!property_exists($rcvData, $evalMandatory))
	        	{
	        		if($rcvData[$evalMandatory]=="")
	        		{
		        		$mandatoryError = "The parameter ".$evalMandatory." is empty.";
	        		}
	        	}
	        	else
	        	{
	        		$mandatoryError = "The parameter ".$evalMandatory." does not exists.";
	        		break;
	        	}
	        }
	        
	        
	        if($mandatoryError!="")
	        {
		        //Checking the received data to redirect to the appropriate controller
		        $moduleTopicMatches = ["my_contracts"=>"Contratos", "my_accounting"=>"Contabilidads"];
		        
		        if(array_key_exists($rcvData->sub_topic, $moduleTopicMatches))
		        {
		        	//Redirect
		        	echo "Redirecting";	
		        	$this->redirect(['controller'=>'Contratos', 'action'=>'index', '?'=>$rcvData]);
		        }
		        else
		        {
		        	$mains->process_message = "There was no module found for the specified topic: ".$rcvData->sub_topic;
		        }
	        }
	        else
	        {
			$mains->process_message = $mandatoryError;     	
	        }
	        
        }
        //TODO: END This must be a component to reuse        


	$this->set('mains', $mains);
	
        // Specify which view vars JsonView should serialize.
        $this->viewBuilder()->setOption('serialize', ['mains']);        
    }
}
