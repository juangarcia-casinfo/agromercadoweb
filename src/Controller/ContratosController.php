<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Client\Request as ClientRequest;

/**
 * Reports Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 * @method \App\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContratosController extends AppController
{
    var $uses = array();
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $contratos = (object)array("mydata"=>'Welcome to Contratos');

	if ($this->request->is('get')) 
	{
		//debug($this);
		$contratos->request_type = "get";
		$contratos->request_data = json_decode(json_encode($this->request->getQuery()));
	}
	else
	{
		$contratos->request_type = "normal";
		$contratos->request_data = '';
	}
	
	//debug(gettype($contratos->request_data));

        $this->set(compact('contratos'));
    }

   
    /**
     * List the contract detail method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function details()
    {
    	//Main Menu controller, no data should be recieved by now
    
        $contrato = (object)array("mydata"=>'Detalle del contrato');

        
        //Getting the received data
        switch(strtolower($this->request->getMethod()))
        {
        	case "get":
			$contrato->request_type = "get";
			$contrato->request_data = (Object) $this->request->getQuery();
			
			if($contrato->request_data=="" || count((array)$contrato->request_data)==0)
			{
				$contrato->request_data = "";
			}
			
        	break;
        	
        	case "post":
			$contrato->request_type = "post";
			$contrato->request_data = (Object)$this->request->getData();
        	break;
        	
        	default:
			$contrato->request_type = "normal";
			$contrato->request_data = '';        	
        }
        

        //Getting Back-End Data from request
        //TODO: START This must be a component to reuse
        if($contrato->request_data!="")
        {
	        // Send a JSON request body.
	        $xbarEndpoint = Configure::read('arbecfg.xbar_endpoint');
	        $request_json_data = json_encode($contrato->request_data);
	        
	        
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
		        $moduleTopicMatches = ["my_contracts"=>"contratos", "contract"=>"details", "my_accounting"=>"contabilidads"];
		        
		        if(array_key_exists($rcvData->sub_topic, $moduleTopicMatches))
		        {
		        	//Redirect
		        	//echo "Redirecting";	
		        	//$this->redirect(['controller'=>'Contratos', 'action'=>'index', '?'=>$rcvData]);
		        	$contrato->response_data = $rcvData;
		        }
		        else
		        {
		        	$contrato->process_message = "There was no module found for the specified topic: ".$rcvData->sub_topic;
		        }
	        }
	        else
	        {
			$contrato->process_message = $mandatoryError;     	
	        } 
	    }
	    
	    $this->set(compact('contrato'));
    }   
}
