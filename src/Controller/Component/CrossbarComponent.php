<?php
/*Cake PHP Custom Component for Casinfo
Author:		Juan Garcia
Date:		2019-03-25
Description:	This Component is used to create custom validation formats
File:			src/View/Helper/ValidationHelper.php
*/
namespace App\Controller\Component;

include 'vendor\thruway\autoload.php';


use Cake\Controller\Component;
use Thruway\ClientSession;
use Thruway\Connection;
use Psr\Log\NullLogger;
use Thruway\Logging\Logger;

Logger::set(new NullLogger());

class CrossbarComponent extends Component
{
	public string $wsAddress;
	public string $wsRealm;
	public string $wsMainTopic;
	public string $wsSessionId;
	public string $wsUniqueTopic;
	public string $status;
	public string $request_data;
	public string $response_data;


	/*
	Initialize the component
	*/
	public function initialize(array $rcvConfig = null): void
	{
		//debug($rcvConfig);
	
		if($rcvConfig!=null)
		{
			$this->wsAddress 		= $rcvConfig['address'];	
			$this->wsRealm 		= $rcvConfig['realm'];	
			$this->wsMainTopic 	= $rcvConfig['maintopic'];	
			$this->wsSessionId 	= $rcvConfig['sessionid'];	
			$this->wsUniqueTopic 	= $this->wsMainTopic.".".$this->wsSessionId;
			$this->status			= "idle";
			$this->request_data	= "";
			//$this->response_data	= null;			
		}
		else
		{
			$this->wsAddress 		= "";	
			$this->wsRealm 		= "";
			$this->wsMainTopic 	= "";
			$this->wsSessionId 	= "";
			$this->wsUniqueTopic	= "";
			$this->status			= "idle";
			$this->request_data	= "";
			//$this->response_data	= null;			
		}
		
	}
	

	/*
	This methods subscribe to the specified topic and get its answer form the WAMP Server
	*/
	public function subscribe($rcvTopic = null)
	{
		if($rcvTopic=="" || $rcvTopic==null)
		{
			$rcvTopic = $this->wsUniqueTopic;
		}
		else
		{
			$rcvTopic = $this->wsUniqueTopic.".".$rcvTopic;	
		}
		
	
		$subConn = new Connection(
		    [
		        "realm"   => $this->wsRealm,
		        "onClose" => $onClose,
		        "url"     => $this->wsAddress,
		    ]
		);


		$subConn->on(
		    'open',
		    function (ClientSession $session) use ($subConn, $rcvTopic)
		    {
		         //Subscription Event
		        $onEvent = function ($args) 
		        {
		            echo "Event {$args[0]}\n";
		            $subConn->close();
		        };

		        $session->subscribe($rcvTopic, $onEvent);		        
		    }
		);


		$subConn->open();			
	}
	

	/*
	This methods publish a message to the specified topic to WAMP Server
	*/
	public function publish($rcvTopic = null, $rcvMessage = "")
	{
		if($rcvTopic=="" || $rcvTopic==null)
		{
			$rcvTopic = $this->wsUniqueTopic;
		}
		else
		{
			$rcvTopic = $this->wsUniqueTopic.".".$rcvTopic;	
		}
		
		$msg = "";
		$onClose = function ($msg) 
		{
		    echo $msg;
		};
		
		
		$pubConn = new Connection(
		    [
		        "realm"   => $this->wsRealm,
		        "onClose" => $onClose,
		        "url"     => $this->wsAddress,
		    ]
		);


		$pubConn->on(
		    'open',
		    function (ClientSession $session) use ($pubConn, $rcvTopic, $rcvMessage)
		    {
		    	 //Publishing event
		    	 if($rcvMessage!="" && $rcvMessage!=null)
		    	 {
			    	 $session->publish($rcvTopic, [$rcvMessage], [], ["acknowledge" => true])->then(
			            function ()  use ($pubConn)
			            {
			            	  //$pubConn->close();
			                $msg = "Publish Acknowledged!\n";
			            },
			            function ($error) 
			            {
			                //$pubConn->close();
			                echo "Publish Error {$error}\n";
			            }
			        );
		    	 }
		    }
		);


		$pubConn->open();		
	}
	

	/*
	This methods publish and a message to the specified topic to WAMP Server
	*/
	public function publishSubscribe($rcvPubTopic = null, $rcvSubTopic = null, $rcvMessage = "")
	{
		$selfThis =& $this;

		
		//Validating the topics received
		if($rcvPubTopic=="" || $rcvPubTopic==null)
		{
			$rcvPubTopic = $this->wsUniqueTopic;
		}
		else
		{
			$rcvPubTopic = $this->wsUniqueTopic.".".$rcvPubTopic;	
		}
		
		
		if($rcvSubTopic=="" || $rcvSubTopic==null)
		{
			$rcvSubTopic = $this->wsUniqueTopic;
		}
		else
		{
			$rcvSubTopic = $this->wsUniqueTopic.".".$rcvSubTopic;	
		}
		
		$onClose = function ($msg)  use($selfThis)
		{
		    $selfThis->status = 'received';
		};
		
		
		$pubConn = new Connection(
		    [
		        "realm"   => $this->wsRealm,
		        "onClose" => $onClose,
		        "url"     => $this->wsAddress,
		    ]
		);


		$pubConn->on(
		    'open',
		    function (ClientSession $session) use ($pubConn, $rcvPubTopic, $rcvSubTopic, $rcvMessage, $selfThis)
		    {
		    	//Subscription events
		        $onEvent = function ($args) use ($pubConn, $selfThis)
		        {
		            //echo "Event {json_encode($args[0])}\n";
		            //$this->status = 'message_received';
		            $selfThis->response_data = $args[0]; 
		            $pubConn->close();
		        };

		        $session->subscribe($rcvSubTopic, $onEvent, ['match'=>'prefix']);			    	
		    
		    
		    	 //Publishing event
		    	 if($rcvMessage!="" && $rcvMessage!=null)
		    	 {
			    	 $session->publish($rcvPubTopic, [$rcvMessage], [], ["acknowledge" => true])->then(
			            function ()  use ($pubConn)
			            {
			            	  //$pubConn->close();
			                $msg = "Publish Acknowledged!\n";
			            },
			            function ($error) 
			            {
			                //$pubConn->close();
			                echo "Publish Error {$error}\n";
			            }
			        );
		    	 }
		    }
		);


		$pubConn->open();
	}
}
?>