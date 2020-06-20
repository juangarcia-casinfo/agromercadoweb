/**********************************************************************
Author:			Juan Garcia
Date Created:		2020-03-01
Last Modified:		2020-03-01
Description:		Publish and Subscribe Methods and formatting
**********************************************************************/

//Declaring variables
var qData = "";
var to = 0;
var dataArr = [];
var wsAddress = 'ws://127.0.0.1:8080/ws';										//WAMP Webservice address
var realmName = 'realm1';				   								//WAMP realm
var mainTopic = 'ec.agromercado';												//Main Topic
var isDebug = true;

//Loading WAMP server connection
//NOTE: Two objects are required as it cannot subscribe and publish at the same time with the same object
var ws = new autobahn.Connection({	url: wsAddress, realm: realmName });
var wsp = new autobahn.Connection({ url: wsAddress, realm: realmName });		//Duplicates the object for publishing


//Loading WAMP reader
ws.onopen = function(session, details)
{
	console.log("Connected");

	//Subscribing to a topic and receive events
	function on_counter(args)
	{
	    var msg = args[0];
	    console.log("Received Message: " + msg);

	    if(msg!="" || msg==null)
	    {
	    	readAction(msg);													//NOTE: This calls the previous created functions
	    }
	    else
	    {
	    	console.log('No message was received!');
	    }
	}

	session.subscribe(mainTopic, on_counter).then(
	        function (sub)
	        {
	            console.log('subscribed to topic');
	        },
	        function (err)
	        {
	            console.log('failed to subscribe to topic', err);
	        }
	);
}

//Loading WAMP publisher
wsp.onopen = function(session, details)
{
	//This is just an init for the publishing object
}


//Closing WAMP actions
ws.onclose = function(reason, details)
{
    console.log("Connection lost(Subscribe): " + reason);
}

wsp.onclose = function()
{
	console.log("Connection lost(Publish):" + reason);
}


//Function that process and creates the table
function readAction(rcvParams)
{
	var msPH = document.getElementById('wampdata');
	var tblData = '';
	var loData = '';
	var btnData = '<input type="button" name="|BTNNAME|" id="|BTNNAME|" value="|VALUE|" class="|CLASSNAME|" onclick="javascript: startPublishMsgAction(\'|MESSAGE|\');">';
	var tmpBtn = "";
	var tmpDateTime = "";
	var tmpClass = "";
	var htmlStr = "";
	var htmlLogStr = '';
	var origMsg = "";
	var tmpDataArr = [];
	var tmpLogData = "";
	var tmpMsg = "";


	rcvParams = rcvParams.trim();
	origMsg = rcvParams;
	clearReadQ();


	if(isDebug)
	{
		console.log('Received Data: ');
		console.log(rcvParams);
	}


	if(rcvParams!="")
	{
		tmpDateTime = new Date();
		rcvParams = JSON.parse(rcvParams);


		if(rcvParams.scene!="" && rcvParams.scene!=undefined)
		{
			rcvParams.rcv_date = tmpDateTime;
			rcvParams.origmsg = origMsg;
			rcvParams.active = 1;
			dataArr.unshift(rcvParams);


			if(isDebug)
			{
				console.log('Scene processing...');
				console.log(rcvParams);
			}

			//Set JSON String into the hidden variable and do the post to the next control
			$('#router_form').attr('action', ('/agromercado/' + rcvParams.scene));
			$('#router_data').attr('value', rcvParams.origmsg);
			//$('#router_send').click();
			$('#router_form').submit();
		}
	}
}

function clearReadQ()
{
	$('#router_form').attr('action', '/agromercado/routers');
	$('#router_data').value = '';
	dataArr = [];
}


//Publishing functions
function startPublishMsg(rcvSubTopic)
{
	var pubChannel = $('#qqchannel').val();
	var pubMsg = new Array();

	for(ic=1;ic<5;ic++)
	{
		if($('#qqmessage' + ic).val()!='')
		{
			pubMsg.push($('#qqmessage' + ic).val());
		}
	}

	console.log(pubMsg);

	//Cleaning previous execs
	$('#wamppublishdata').html('');


	if(pubChannel=="")
	{
		pubChannel = mainTopic;
	}

	for(pc=0;pc<pubMsg.length;pc++)
	{
		if(pubMsg[pc]!="" || pubMsg[pc]!=undefined)
		{
			wsp.session.publish(pubChannel, [pubMsg[pc]]);
			$('#wamppublishdata').html($('#wamppublishdata').html() + '<br />Data sent to queue for message #' + (pc + 1));
		}
		else
		{
			$('#wamppublishdata').html('No data to be published');
			$('#wamppublishdata').focus();
		}
	}

}


//Publishing functions
function startPublishMsgAction(rvMsg, rcvSubTopic)
{
	var pubChannel = "";
	var pubMsg = rvMsg;


	if(pubChannel=="")
	{
		pubChannel = mainTopic + rcvSubTopic;
	}

	if(pubMsg!="")
	{
		pubMsg = pubMsg.replace(/\$DBLQT\$/g, '"');
		wsp.session.publish(pubChannel, [pubMsg]);


		if(isDebug)
		{
			console.log('<br />Published on channel: ');
			console.log(pubChannel);
			console.log('<br />Data sent to queue');
			console.log(pubMsg);
		}
	}
	else
	{
		if(isDebug)
		{
			console.log('No data to be published');
		}

	}
}
